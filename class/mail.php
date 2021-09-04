<?php

class Mail
{
    public function __construct($oData)
    {
        $this->oData = $oData;
    }

    // enriches mail template with info
    public function compose_mail($message_template, $aInfo)
    {
        /* Uses a template to formulate message with correct info
         *
         * @param message_template String Template for the message
         * @param Array $aInfo:
         *    Contains the info that will enrich the mail template
         *
     	 * @return  array [message => x, subject => x]
         *     Message body and subject of the e-mail
         */
        $indicator = "&";
        foreach ($aInfo as $key => $value) {
            $message_template = str_replace($indicator.$key, $value, $message_template);
        }
        return $message_template;
    }

    private function compose_header($aUser)
    {
        $header['MIME-Version'] = '1.0';
        $header['Content-type'] = 'text/plain; charset=utf-8';
        $header['X-Mailer'] = 'PHP/'.phpversion();
        #$header['To'] = $aUser['forename'].' '.$aUser['surname'].'<'.$aUser['email'].'>';
        $header['From'] = $this->oData->oLang->library_info['ADMIN_NAME'].' <'.$this->oData->oLang->library_info['ADMIN_MAIL'].'>';
        $header['Reply-To'] = $this->oData->oLang->library_info['ADMIN_NAME'].' <'.$this->oData->oLang->library_info['ADMIN_MAIL'].'>';
        return $header;
    }


    //used for debugging, alternative for mail
    public function print_mail($aUser, $subject, $message)
    {
        $header = $this->compose_header($aUser);
        $output = "";
        if (is_array($header)) {
            $output.= "Header:<br>";
            foreach ($header as $key=>$value) {
                $output .= htmlentities($key.": ".$value)."<br>";
            }
        } else {
            echo "Header: ".str_replace("\n", "<br>", htmlentities($header))."<br>";
        }
        echo "To: ".htmlentities($aUser['email'])."<br>";
        echo "Subject: ".$subject."<br><br>";
        echo "Message: ".str_replace("\n", "<br>", htmlentities($message))."<br>";
        return false;
    }

    public function send_mail($aUser, $subject, $message)
    {
        /* Params:
         *	  $aUser: Contains all information about the reciever
         *	  $subject: Subject of the message
         *	  $message: Message to send
         */
        $header = $this->compose_header($aUser);
        $to = $aUser['email'];
        $message = wordwrap($message, 70, "\r\n");
        $success =  mail($to, $subject, $message, $header);
        if ($success) {
            $this->log_mail($to, $aUser['user_ID'], $subject);
        }
        return $success;
    }

    private function log_mail($email, $user_ID, $issue)
    {
        $fLog = fopen(MODULE_PATH.$this->oData->settings['path_mail_log'], 'a+');
        fwrite($fLog, '['.date("Y-m-d H:i:s").']: To: "'.$email.'" with user_ID: "'.$user_ID.'" because of: "'.$issue.'"'."\n");
        fclose($fLog);
    }
}
