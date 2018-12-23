<?php

class Presence extends Data{
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
	
	function get_status($UID){
		$aFields = array(
			'checkout_time' => '0000-00-00 00:00:00'
		);
		if(isset($UID)){
			$aFields ['UID'] = $UID;
		}
		$pResult = $this->select_rows(TABLE_PRESENCE, $aFields);

	}








}
