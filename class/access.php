<?php

class access
{
    public function __construct($oData)
    {
        $this->oData = $oData;
        return;
    }
	
	public function get_access(int $access_id = null, int $user_ID = null, int $UID = null)
    {
        /*
		To-Do:
		Show right fields
        params:
            int $access_ID:
                Filters loans by ID of loan (unique therfor will return only one)
            int $user_ID:
                Filters loans by ID of user
			int $UID:
                Filters loans by UID of user
        returns: Associative array with complete access Information (access_ID as keys)
        */
        $aFields= array();
        $query = "
			SELECT user.user_ID, CONCAT(user.forename,' ',user.surname) AS user_name, user.UID, access.UID, access.timestamp as TIMESTAMP, access.key_available, access.access_ID
			FROM ".TABLE_access." access
			LEFT JOIN ".TABLE_USER." AS user
				ON user.UID=access.UID";
        $restrictions = array();
        if (isset($loan_ID)) {
            $restrictions["access.access_ID"] = $access_ID;
        }
        if ((isset($user_ID)) and ($user_ID!= "")) {
            $restrictions["user.user_ID"] = $user_ID;
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
        $sort = " ORDER BY access_ID DESC;";
        $query .= $sort;
        $this->p_result = $this->oData->databaselink->query($query);
		if (! $this->p_result){
			return NULL;
		}
		else{
			
			while ($aRow=mysqli_fetch_assoc($this->p_result)) {
				$aaccess[$aRow['access_ID']] = $aRow;
			}				
			return $aaccess;
		}
    }
	
	public function check_access($UID = null, $access_key = null, $key_available = false){
		if($access_key == access_KEY){
			$oFields = array(
					'UID' => $UID,
					'key_available' => $key_available
				);
			$this->oData->store_data(TABLE_access, $oFields, false, NULL);
			$aFields= array();
			$aFields['UID'] = $UID;
			$row = $this->oData->select_row(TABLE_USER, $aFields);
			if($row == -1 or $row['access'] == 0){
				#UID not known or no access permission for this UID
				return false;
			}
			else
			{
				#access permission
				return true;
			}
		}
		else{
			return false;
		}
	}
	
}
