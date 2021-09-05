<?php
class Loan
{
    public function __construct($oData)
    {
        $this->oData = $oData;
    }
    public function save_loan($loan_ID = null, $ID=null, $type=null, $user_ID=null, $pickup_date=null, $return_date= null, $returned = null)
    {
        /*
        Params:
        $loan_ID = NULL
                ID of the loan.
        $ID = NULL
                ID of the item.
        $type = NULL
            Book or material
        $user_ID:int
        	Id of the user that has the loan
        $pickup_date = NULL
                Date on that the loan was picked up
        $return_date = NULL
                Date on that the loan was returned
        $returned = NULL
                Whether the loan was returned (True if returned)

        Returns:
            True if succensful, else False
        */
        $aFields = array(
                'ID' => $ID,
                'type' => $type,
                'user_ID' => $user_ID
        );
        if (isset($loan_ID)) {
            $aFields['loan_ID'] = $loan_ID;
        }
        if ((isset($return_date)) and (""!= $return_date)) {
            $aFields['return_date'] = $return_date;
        }
        if ((isset($pickup_date)) and (""!= $pickup_date)) {
            $aFields['pickup_date'] = $pickup_date;
            $aFields['last_reminder'] = $pickup_date;
        } else {
            $aFields['pickup_date'] = date("Y-m-d");
            $aFields['last_reminder'] = date("Y-m-d");
        }
        if ((isset($return_date)) and (""!= $return_date)) {
            $aFields['return_date'] = $return_date;
        } else {
            $aFields['return_date'] = "0000-00-00";
        }
        $this->ID=$this->oData->store_data(TABLE_LOAN, $aFields, 'loan_ID', $loan_ID);

        $aFields = array(
            'lent' => 1
        );
        if ($type=="book") {
            $this->oData->store_data(TABLE_BOOKS, $aFields, 'book_ID', $ID);
        }
        if ($type=="material") {
            $this->oData->store_data(TABLE_MATERIAL, $aFields, 'material_ID', $ID);
        }
    }

    public function return_loan($loan_ID)
    {
        /*
        Params:
        $loan_ID = NULL
                ID of the loan.
     */
        $aLoans= $this->get_loan($loan_ID);
        $aLoan = $aLoans[$loan_ID];
        $aFields = array(
            'return_date' => date("Y-m-d H:i:s"),
            'returned' => 1
        );
        $this->ID=$this->oData->store_data(TABLE_LOAN, $aFields, 'loan_ID', $loan_ID);

        $aFields = array(
        'lent' => 0
    );

        if ($aLoan['type']=='book') {
            $this->oData->store_data(TABLE_BOOKS, $aFields, 'book_ID', $aLoan['ID']);
        }
        if ($aLoan['type']=='material') {
            $this->oData->store_data(TABLE_MATERIAL, $aFields, 'material_ID', $aLoan['ID']);
        }
    }

    public function get_loan(int $loan_ID = null, int $user_ID = null, $book_ID = null, $material_ID = null, bool $returned = null)
    {
        /*
        params:
            int $loan_ID:
                Filters loans by ID of loan (unique therfor will return only one)
            int $user_ID:
                Filters loans by ID of user
            int $book_ID:
                Filters loans by ID of book
            int $material_ID:
                Filters loans by ID of a material
        returns: Associative array with complete loan Information (loan_ID as keys)
        */
        $aFields= array();
        $query = "
	SELECT user.user_ID, CONCAT(user.forename,' ',user.surname) AS user_name, loan.loan_ID, loan.ID, loan.type, loan.pickup_date, loan.return_date, books.title AS book_name, material.name AS material_name
	From loan
	LEFT JOIN user
		ON user.user_ID=loan.user_ID
	LEFT JOIN books
		ON books.book_ID=loan.ID
	LEFT JOIN material
		ON material.material_ID=loan.ID";
        $restrictions = array();
        if (isset($loan_ID)) {
            $restrictions["loan.loan_ID"] = $loan_ID;
        }
        if ((isset($user_ID)) and ($user_ID!= "")) {
            $restrictions["user.user_ID"] = $user_ID;
        }
        if ((isset($book_ID)) and ($book_ID!= "")) {
            $restrictions["loan.ID"] = $book_ID;
        }
        if ((isset($material_ID)) and ($material_ID!= "")) {
            $restrictions["loan.ID"] = $material_ID;
        }
        $i = 0;
        $sCondition = "";
        foreach ($restrictions as $key=>$value) {
            if ($i >0) {
                $sCondition .= " AND ";
            } else {
                $sCondition .= " WHERE ";
            }
            $sCondition .= $key."='".$value."'";
            $i++;
        }
        $query .= $sCondition;
        $sort = " ORDER BY loan_ID DESC;";
        $query .= $sort;
        $this->p_result = $this->oData->databaselink->query($query);
		if (! $this->p_result){
			return NULL;
		}
		else{
			
			while ($aRow=mysqli_fetch_assoc($this->p_result)) {
				$aLoan[$aRow['loan_ID']] = $aRow;
			}				
			return aLoan;
		}
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
    public function set_loan_mails_send()
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
            return $stats;
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
        $this->set_loan_mails_send();
        return $stats;
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
		$message_template = $this->oData->oLang->texts['loan_reminder_message'];
		$subject_template = $this->oData->oLang->texts['loan_reminder_subject'];
		
		$oMail = new Mail($this->oData);
        $arr = $oMail->compose_mail($message_template, $subject_template, $aInfo);
        $subject = $arr["subject"];
        $message = $arr["message"];
		#$subject = str_replace("&LABEL", $aInfo['LABEL'], $subject);
		var_dump($subject);
		var_dump($message);
        return $oMail->send_mail($aUser, $subject, $message);
		
    }
}
