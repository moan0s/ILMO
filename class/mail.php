<?php

class Mail
{
    public function __construct($oData)
    {
        $this->oData = $oData;
    }

    // enriches mail template with info
    public function compose_mail($message_template, $subject_template, $aInfo)
    {
        /* Uses a template to formulate message and subject with correct info
         *
         * @param message_template String Template for the message
         * @param subject_template String Template for the subject
         * @param Array $aInfo:
         *    Contains the info that will enrich the mail template
         *
     	 * @return  array [message => x, subject => x]
         *     Message body and subject of the e-mail
         */
        $indicator = "&";
        foreach ($aInfo as $key => $value) {
            $message_template = str_replace($indicator.$key, $value, $message_template);
            $subject_template = str_replace($indicator.$key, $value, $subject_template);
        }
        return ['message' => $message_template, 'subject' => $subject_template];
    }

    //used for debugging, alternative for mail
    public function print_mail($to, $subject, $message, $header)
    {
        echo "Header: ".$header."<br>";
        echo "To: ".$to."<br>";
        echo "Subject: ".$subject."<br><br>";
        echo "Message: ".str_replace("\r\n", "<br>", $message)."<br>";
        return false;
    }

    public function send_mail($aUser, $subject, $message)
    {
        /* Params:
         *	  $aUser: Contains all information about the reciever
         *	  $subject: Subject of the message
         *	  $message: Message to send
         */
        $to = $aUser['email'];
        $header[] = 'MIME-Version: 1.0';
        $header[] = 'Content-type: text/plain; charset=utf-8';
        $header[] = 'X-Mailer: PHP/'.phpversion();

        $header[] = 'To: '.$aUser['forename'].' '.$aUser['surname'].'<'.$aUser['email'].'>';
        $header[] = 'From: '.$this->oData->oLang->library_info['ADMIN_NAME'].' <'.$this->oData->oLang->library_info['ADMIN_MAIL'].'>';
        $message = wordwrap($message, 70, "\r\n");
        $success =  mail($to, $subject, $message, implode("\r\n", $header));
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
