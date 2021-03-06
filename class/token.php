<?php
class Token
{
    public function __construct($oData)
    {
        $this->oData = $oData;
    }

    public function check_token($user_ID, $token)
    {
        /* Checks if this token exists and is unused for $user_ID
         *
         * @param int $user_ID The user for whom the token will be checked
         * @param String $token The unencrypted token to check
         *
         * @return int $token_ID: Returns token_ID or -1 if not found
         */
        $aFields['user_ID'] = $user_ID;
        $valid_tokens = $this->oData->select_rows(TABLE_TOKEN, $aFields);
        foreach ($valid_tokens as $token_ID=>$valid_token) {
            if (DEBUG) {
                echo "Token:<br>";
                var_dump($valid_token);
            }
            if (($valid_token['used'] == false) and password_verify($token, $valid_token['token_hash'])) {
                return $valid_token['token_ID'];
            }
        }
        return -1;
    }

    public function mark_token_used($token_ID)
    {
        /* Marks a token used
         *
         * @param int Token ID
         *
         * @return True if succesful, else false
         */
        $aFields['used'] = true;

        $this->oData->store_data(TABLE_TOKEN, $aFields, 'token_ID', $token_ID);
    }

    private function generate_token($length = null)
    {
        /* Generates a secure random token via a CSPRNG
         *
         * @return string The unencrypted token
         */

        $keyspace = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        if (!(isset($length))) {
            $length = $this->oData->settings['minimum_pw_length'];
        }
        $token = '';
        $max = strlen($keyspace);
        for ($i = 0; $i < $length; ++$i) {
            $token .= $keyspace[random_int(0, $max-1)];
        }
        return $token;
    }

    private function send_token_to_user($aUser, $token)
    {
        /* Sends the token to the user
         *
         * @param int $user_ID ID of the user that will recieve the mail
         * @param string $token Token that the user will recieve
         *
         * @return bool True if successful, else false
         */

        //add all neccessary information for the mail
        if (DEBUG) {
            echo "Sendig token to ".$aUser['forename']." ".$aUser['surname']."<br>";
        }
        $aInfo = array();
        $aInfo['FORENAME'] = $aUser['forename'];
        $aInfo['SURNAME'] = $aUser['surname'];
        $aInfo['TOKEN'] = $token;
        $aInfo['ADMIN_TEAM'] = $this->oData->oLang->library_info['ADMIN_NAME'];
        $aInfo['LIBRARY_URL'] = BASE_URL;
        $aInfo['LIBRARY_NAME'] = $this->oData->oLang->library_info['LIBRARY_NAME'];
        $aInfo['MAIL_REMINDER_INTERVAL'] = $this->oData->settings['mail_reminder_interval'];

        $message_template = $this->oData->oLang->texts['password_reset_token_message'];
        $subject_template = $this->oData->oLang->texts['password_reset_subject'];

        $oMail = new Mail($this->oData);
        $arr = $oMail->compose_mail($message_template, $subject_template, $aInfo);
        $subject = $arr["subject"];
        $message = $arr["message"];
        //$oMail->print_mail($aUser, $subject, $message);
        return $oMail->send_mail($aUser, $subject, $message);
    }

    public function send_store_token($aUser)
    {
        // if no token was generated in a certain timeframe
        // the user will recieve a token which is stored in the database
        // and can be used to reset the password
        $now = date_create();

        $aFields = ["user_ID" => $aUser['user_ID']];
        $aToken = $this->oData->select_row(TABLE_TOKEN, $aFields);
        if (DEBUG) {
            echo "Previous issued token for the user:<br>";
            var_dump($aToken);
        }
        if ($aToken != -1) {
            $last = date_create($aToken['creation_date']);
            if (DEBUG) {
                echo "<br>Now: ".date_format($now, 'Y-m-d H:i:s')." <br>";
                echo "Last: ".date_format($last, 'Y-m-d H:i:s')." <br>";
            }
            $interval = date_diff($now, $last);
            if (DEBUG) {
                echo "Interval ".$interval->format('Hours %h:%i<br>')."<br>";
            }
            $min_token_interval = new DateInterval("PT".$this->oData->settings['minimum_token_hours']."H");
            if (DEBUG) {
                echo "Min interval ".$min_token_interval->format('Hours %h:%i<br>')."<br>";
            }
            $next_time = $last->add($min_token_interval);
            $min = (int) $this->oData->settings['minimum_token_hours'];
            if (DEBUG) {
                echo "<br>Hours since last ".$interval->h."token was issued <br>";
                echo "Minimum interval between two token: $min hours<br>";
            }
            if ($interval->h < $min) {
                $this->oData->error[] = "You have to wait until ".$next_time->format("d-m-Y H:i")." before you can generate a new reset token.";
                return false;
            }
        }

        //generate a random token
        $token = $this->generate_token();

        // store the token in the database
        $aNewToken['token_hash'] = $this->oData->hash_password($token);
        $aNewToken['user_ID'] = $aUser['user_ID'];
        $aNewToken['creation_date'] = $now->format("Y-m-d H:i:s");
        $aNewToken['used'] = false;

        if (DEBUG) {
            echo "<br>Storing the token:<br>";
            var_dump($aNewToken);
        }

        //There will only ever be one token for each user
        $id = $this->oData->store_data(TABLE_TOKEN, $aNewToken, 'user_ID', $aNewToken['user_ID']);
        if ($id == -1) {
            $this->oData->error[] = "Couldn't store token in database";
            return false;
        }

        // Send token to user
        if (!$this->send_token_to_user($aUser, $token)) {
            $this->oData->error[] = "Couldn't send e-mail to user";
        }
        return true;
    }
}

?>

