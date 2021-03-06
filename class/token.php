<?php
class Token
{
    public function __construct($oData)
    {
        $this->data = $oData;
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
        $tokens = $this->oData->select_rows(TABLE_TOKEN, $aFields);
        foreach ($tokens as $token_ID=>$token) {
            if (($token['used'] == false) and password_verify($token, $token['token_hash'])) {
                return $token['token_ID'];
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
            $token .= $keyspace[random_int(0, $max)];
        }
        return $token;
    }

    public function send_token_to_user($user_ID, $token)
    {
        /* Sends the token to the user
         *
         * @param int $user_ID ID of the user that will recieve the mail
         * @param string $token Token that the user will recieve
         *
         * @return bool True if successful, else false
         */
        $oUser = new User($this->oData);
        $aUser = $oUser->get_user($user_ID);

        //add all neccessary information for the mail
        $aInfo = array();
        $aInfo['FORENAME'] = $aUser['forename'];
        $aInfo['SURNAME'] = $aUser['surname'];
        $aInfo['TOKEN'] = $token;
        $aInfo['ADMIN_TEAM'] = $this->oData->oLang->library_info['ADMIN_NAME'];
        $aInfo['LIBRARY_URL'] = $this->oData->oLang->library_info['URL'];
        $aInfo['MAIL_REMINDER_INTERVAL'] = $this->oData->settings['mail_reminder_interval'];

        $message_template = $this->oData->oLang->texts['password_reset_token_message'];
        $subject_template = $this->oData->oLang->texts['password_reset_subject'];

        $oMail = new Mail($oData);
        $arr = $oMail->compose_mail($message_template, $subject_template, $aInfo);
        $subject = $arr["subject"];
        $message = $arr["message"];
        return $send_mail($aUser, $subject, $message);
    }

    public function send_store_token($user_ID)
    {
        //generate a random token
        $token = $this->generate_token();
        $creation_dts = date("Y-m-d H:i:s");

        // store the token in the database
        $aFields['token_hash'] = $this->oData->hash_password($token);
        $aFields['user_ID'] = $user_ID;
        $aFields['creation_date'] = $creation_dts;
        $this->oData->store_data(TABLE_TOKEN, $aFields);

        // Send token to user
        $this->send_token_to_user($user_ID, $token);
    }
}

?>

