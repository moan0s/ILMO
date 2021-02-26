<?php

class Mail
{
    public function __construct($oData)
    {
        $this->oData = $oData;
    }

    //void-> array(ID=loan_ID) of array(all loan  information)
    //gets all loans from the database that are not returned
    public function get_unreturned_loans()
    {
        $aFields = array('returned' => '0');
        $this->p_result = $this->oData->select_rows(TABLE_LOAN, $aFields);

        while ($aRow=mysqli_fetch_assoc($this->p_result)) {
            $aLoan[$aRow['loan_ID']] = $aRow;
        }
        return $aLoan;
    }

    //void->bool
    //returns bool that indicates if the mails for this day were send
    public function check_if_mail_send()
    {
        $aFields = array('issue' => 'mail');
        $aMail_log = $this->oData->select_row(TABLE_LOG, $aFields);
        $date_last_mails_send = $aMail_log['date'];
        return ($date_last_mails_send == date("Y-m-d"));
    }

    //logs that the mails for one day were send
    public function set_mails_send()
    {
        $aFields = array(
                'date' => date("Y-m-d")
            );
        $this->oData->store_data(TABLE_LOG, $aFields, 'issue', 'mail');
    }
    //int $loan_ID + date $date -> void
    //sets 'last' remminder in TABLE_LOAN to the given date
    public function set_last_reminder($loan_ID, $date)
    {
        $aFields = array(
                'last_reminder' => $date
            );
        $this->oData->store_data(TABLE_LOAN, $aFields, 'loan_ID', $loan_ID);
    }

    //string in format date(YYYY-mm-dd) -> bool
    //returns true if a reminder is neccessary
    public function reminder_necessary($pickup_date, $last_reminder, $reminder_interval)
    {
        if ($last_reminder=='0000-00-00') {
            $last_reminder = $pickup_date;
        }
        $today = new DateTime("today");
        $interval = $today->diff(new DateTime($last_reminder));
        return ($interval->days > $reminder_interval);
    }

    // Send all mails of today and returns stats
    // If the mail reminder setting is 0 no mails are sent
    public function send_todays_mails()
    {
        $stats = array(
            'successful' => 0,
                   'failed' => 0,
            'total' => 0);
        $m_interval = $this->oData->settings['mail_reminder_interval'];
        if ($m_interval==0) {
            return stats;
        }

        $aUnreturnedLoans = $this->get_unreturned_loans();
        foreach ($aUnreturnedLoans as $loan_ID => $aRow) {
            if ($this->reminder_necessary($aRow['pickup_date'], $aRow['last_reminder'], $m_interval)) {
                $stats['total']++;
                if ($this->send_reminder($aRow)) {
                    $this->set_last_reminder($aRow['loan_ID'], date("Y-m-d"));
                    $stats['successful']++;
                } else {
                    $stats['failed']++;
                }
            }
        }
        $this->set_mails_send();
        return $stats;
    }

    // enriches mail template with info
    private function compose_mail($aInfo)
    {
        /* Args:
         * Array $aInfo:
         *    Contains the info that will enrich the mail template
         *
         * Returns:
         *  String $text
         *     Message body of the e-mail
         */
        $text = $this->oData->oLang->texts['loan_reminder_message'];
        foreach ($aInfo as $key => $value) {
            $text = str_replace("&".$key, $value, $text);
        }
        return $text;
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
    public function send_reminder($aLoan)
    {
        $oUser = new User($this->oData);
        $aUser = $oUser->get_user($aLoan['user_ID'])[$aLoan['user_ID']];
        $to = $aUser['email'];
        $this->oData->oLang->set_language($aUser['language']);
        if ($aLoan['type'] == 'book') {
            $oBook = new Book($this->oData);
            $oBook->book_ID = $aLoan['ID'];
            $aBook = $oBook->get_book_itemized($aLoan['ID'])[$aLoan['ID']];
            $label = $aBook['title'];
        }
        if ($aLoan['type'] == 'material') {
            $oMaterial = new Material($this->oData);
            $aMaterial = $oMaterial->get_material_itemized($aLoan['ID'])[$aLoan['ID']];
            $label = $aMaterial['name'];
        }
        // construct aInfo array
        $aInfo = array();
        $aInfo['FORENAME'] = $aUser['forename'];
        $aInfo['SURNAME'] = $aUser['surname'];
        $aInfo['LABEL'] = $label;
        $aInfo['ID'] = $aLoan['ID'];
        $aInfo['PICKUP_DATE'] = $aLoan['pickup_date'];
        $aInfo['LIBRARY_URL'] = $this->oData->oLang->library_info['URL'];
        $aInfo['ADMIN_TEAM'] = $this->oData->oLang->library_info['ADMIN_NAME'];
        $aInfo['LIBRARY_NAME'] = $this->oData->oLang->library_info['LIBRARY_NAME'];
        $aInfo['MAIL_REMINDER_INTERVAL'] = $this->oData->settings['mail_reminder_interval'];
        $message = $this->compose_mail($aInfo);

        $subject = $this->oData->oLang->texts['loan_reminder_subject'];
        $subject = str_replace("&LABEL", $aInfo['LABEL'], $subject);

        $issue = "Reminder on loan ".$aLoan['loan_ID'];
        $this->log_mail($aUser['email'], $aLoan['user_ID'], $issue);


        $header[] = 'MIME-Version: 1.0';
        $header[] = 'Content-type: text/plain; charset=utf-8';
        $header[] = 'X-Mailer: PHP/'.phpversion();

        $header[] = 'To: '.$aUser['forename'].' '.$aUser['surname'].'<'.$aUser['email'].'>';
        $header[] = 'From: '.$this->oData->oLang->library_info['ADMIN_NAME'].' <'.$this->oData->oLang->library_info['ADMIN_MAIL'].'>';
        //return $this->print_mail($to, $subject, $message, implode("\r\n", $header));
        return mail($to, $subject, $message, implode("\r\n", $header));
    }

    public function log_mail($email, $user_ID, $issue)
    {
        $fLog = fopen(MODULE_PATH.$this->oData->settings['path_mail_log'], 'a+');
        fwrite($fLog, '['.date("Y-m-d H:i:s").']: To: "'.$email.'" with user_ID: "'.$user_ID.'" because of: "'.$issue.'"'."\n");
        fclose($fLog);
    }
}
