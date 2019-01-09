<?php

class Presence extends Data{
	//todo ist to check if UID and timstamp is okay
	function save_presence(){
		$aFields = array(
			'UID' => $this->r_UID,
			'checkin_time' => $this->r_checkin_time,
			'checkout_time' => $this->r_checkout_time
		);
		$this->store_data(TABLE_PRESENCE, $aFields);

	}
	function set_status($UID, $status){
		if ($status==0){
			$aFields = array(
				'UID' => $UID
			);
		$this->store_data(TABLE_PRESENCE, $aFields, null, null);
		}
		if ($status == 1){
			$timestamp = date("Y-m-d H:i:s");
			$sql_statement = "UPDATE ".TABLE_PRESENCE." SET `checkout_time` = '".$timestamp."' WHERE `UID` = '".$UID."' and checkout_time = '0000-00-00 00:00:00';";
			$this->sql_statement($sql_statement);
		}
	}

	function is_present($aRow){
		return $aRow['checkout_time'] == '0000-00-00 00:00:00';

	}
	//returns all past and present attendences
	function get_presence($UID = null, $presence_ID = null){
		if(isset($UID)){
			$aFields['UID'] = $UID;
		}
		if(isset($presence_ID)){
			$aFields['presence_ID'] = $presence_ID;
		}	
		$oUser = new User;
		$this->all_user = $oUser->get_user_by_UID();
		$pResult = $this->select_rows(TABLE_PRESENCE, $aFields);
 		while($aRow=mysqli_fetch_assoc($pResult)){
				$aPresence[$aRow['presence_ID']] = $aRow;
 		}
		return $aPresence;
	
	}
	//returns current presences, if wanted for only one UID
	function get_current_presence($UID = null){
		$aFields = array(
			'checkout_time' => '0000-00-00 00:00:00'
		);
		if(isset($UID)){
			$aFields ['UID'] = $UID;
		}
		$pResult = $this->select_rows(TABLE_PRESENCE, $aFields);
 		while($aRow=mysqli_fetch_assoc($pResult)){
	 		$aPresence[$aRow['presence_ID']] = $aRow;
 		}
		return $aPresence;
	}

	#returns true if sombody is checked in in the library
	function get_status(){
		$aFields = array(
			'checkout_time' => '0000-00-00 00:00:00'
		);
		return is_null($this->select_rows(TABLE_PRESENCE, $aFields));
	}


	function delete_presence ($presence_ID){
		$aFields = array ( 
			'presence_ID' => $presence_ID
		);
		return $this->delete_rows(TABLE_PRESENCE, $aFields);

	}



}
