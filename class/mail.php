<?php

class Mail extends Data {
	//void->bool
	//returns bool that indicates if the mails for this day were send 
	function check_if_mail_send(){
		$aFields = array('issue' => 'mail');
		$aMail_log = $this->select_row(TABLE_LOG, $aFields);
		$date_last_mails_send = $aMail_log['date'];
		return ($date_last_mails_send == date("Y-m-d"));

	}
	//logs that the mails for one day were send
	function set_mails_send(){
		$aFields = array(
				'date' => date("Y-m-d")
			);
		$this->store_data(TABLE_LOG, $aFields, 'issue', 'mail');

	}
	//int $loan_ID + date $date -> void
	//sets 'last' remminder in TABLE_LOAN to the given date
	function set_last_reminder($loan_ID, $date){
		$aFields = array(
				'last_reminder' => $date
			);
		$this->store_data(TABLE_LOAN, $aFields, 'loan_ID', $loan_ID);

	}
	//void-> array(ID=loan_ID) of array(all loan  information)
	//gets all loans from the database that are not returned 
	function get_unreturned_loans() {
		$aFields = array('returned' => '0');	
		$this->p_result = $this->select_rows(TABLE_LOAN, $aFields);
		
		while($aRow=mysqli_fetch_assoc($this->p_result)){
			$aLoan[$aRow['loan_ID']] = $aRow;
		}
		return $aLoan;
	}
	//string in format date(YYYY-mm-dd) -> bool
	//checks if the last reminder was send more than 90 days before
	function reminder_necessary($last_reminder){
		if((isset($this->settings['mail_reminder_interval'])) and (0 != $this->settings['mail_reminder_interval'])){
			if ($last_reminder=='0000-00-00'){
				return true;
			}
			$today = new DateTime("today");
			$interval = $today->diff(new DateTime($last_reminder));
			return ($interval->days > $this->settings['mail_reminder_interval']); 

		}
	}

	function send_todays_mails() {
		$stats = array(
			'successful' => 0,
		       	'failed' => 0,
			'total' => 0);
		$aUnreturnedLoans = $this->get_unreturned_loans();
		foreach($aUnreturnedLoans as $loan_ID => $aRow){
			if ($this->reminder_necessary($aRow['last_reminder'])){
				$stats['total']++;
				if($this->send_reminder($aRow)){
					$this->set_last_reminder($aRow['loan_ID'], date("Y-m-d"));
					$stats['successful']++;
				}
				else{
					$stats['failed']++;
				}
			}
		}
		$this->set_mails_send();
		return $stats;
	}
	function send_reminder($aRow){
	
		$oUser = new User;
		$oUser->r_user_ID= $aRow['user_ID'];
		$aUser = $oUser->get_user()[$aRow['user_ID']];
		$to = $aUser['email'];
		$this->oLang->set_language($aUser['language']);
		if ($aRow['type'] == 'book'){
			$oBook = new Book;
			$oBook->r_book_ID = $aRow['ID'];
			$aBook = $oBook->get_book_itemized()[$aRow['ID']];
		}
		if ($aRow['type'] == 'material'){
			$oMaterial = new Material;
			$oMaterial->r_material_ID = $aRow['ID'];
			$aMaterial = $oMaterial->get_material_itemized()[$aRow['ID']];
		}
		
		$subject = '['.$this->oLang->texts['LOAN'].' '.$aRow['loan_ID'].']'.$this->oLang->texts['YOUR_LOANS_AT_THE'].' '.$this->oLang->library_info['LIBRARY_NAME'];
		$message = 
			$this->oLang->texts['HELLO']." ".$aUser['forename']." ".$aUser['surname'].",\r\n".
			$this->oLang->texts['YOU_HAVE_LENT']."\r\n\r\n";
		
		if ($aRow['type'] == 'book'){
			$message.=
				$this->oLang->texts['TITLE'].': '.$aBook['title']."\r\n".
				$this->oLang->texts['AUTHOR'].': '.$aBook['author']."\r\n";
		}
		if ($aRow['type'] == 'material'){
			$message.=
				$this->oLang->texts['NAME'].': '.$aMaterial['name']."\r\n";
		}
		$message .=
			$this->oLang->texts['LENT_ON'].': '.$aRow['pickup_date']."\r\n\r\n".
			$this->oLang->texts['CONDITIONS_OF_LOAN'].' '.
			$this->oLang->texts['SHOW_LOANS_ONLINE']."\r\n\r\n".
			$this->oLang->texts['GREETINGS']."\r\n".
			$this->oLang->texts['TEAM']."\r\n\r\n".
			$this->oLang->texts['FUTHER_INFORMATION'];
		$issue = "Reminder on loan ".$aRow['loan_ID'];
		$this->log_mail($aUser['email'], $aRow['user_ID'], $issue);
		
		
		$header[] = 'MIME-Version: 1.0';
		$header[] = 'Content-type: text/plain; charset=utf-8';
		$header[] = 'X-Mailer: PHP/'.phpversion();
		
		$header[] = 'To: '.$aUser['forename'].' '.$aUser['surname'].'<'.$aUser['email'].'>';
		$header[] = 'From: '.$this->oLang->library_info['ADMIN_NAME'].' <'.$this->oLang->library_info['ADMIN_MAIL'].'>';
		return mail($to, $subject, $message, implode("\r\n", $header));

	}

	function log_mail($email, $user_ID, $issue){
		$fLog = fopen(MODULE_Path.$this->settings['path_mail_log'], 'a+');
		fwrite($fLog, '['.date("Y-m-d H:i:s").']: To: "'.$email.'" with user_ID: "'.$user_ID.'" because of: "'.$issue.'"'."\n");
		fclose($fLog);

	}

}

