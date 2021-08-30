<?php

class Acess
{
    public function __construct($oData)
    {
        $this->oData = $oData;
        return;
    }
	
	public function get_acess(int $acess_id = null, int $user_ID = null)
    {
        /*
		To-Do:
		Show right fields
        params:
            int $acess_ID:
                Filters loans by ID of loan (unique therfor will return only one)
            int $user_ID:
                Filters loans by ID of user
        returns: Associative array with complete acess Information (acess_ID as keys)
        */
        $aFields= array();
        $query = "
	SELECT user.user_ID, CONCAT(user.forename,' ',user.surname) AS user_name, user.UID, acess.UID, acess.timestamp, acess.key_available, acess.acess_ID
	FROM ".TABLE_USER." user, ".TABLE_ACESS." acess
	LEFT JOIN user
		ON user.user_ID=acess.user_ID";
        $restrictions = array();
        if (isset($loan_ID)) {
            $restrictions["acess.acess_ID"] = $acess_ID;
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
        $sort = " ORDER BY acess_ID DESC;";
        $query .= $sort;
		var_dump($query);
        $this->p_result = $this->oData->databaselink->query($query);
		if (! $this->p_result){
			return NULL;
		}
		else{
			
			while ($aRow=mysqli_fetch_assoc($this->p_result)) {
				$aAcess[$aRow['acess_ID']] = $aRow;
			}				
			return aAcess;
		}
    }
	
	public function check_acess($UID = null, $acess_key = null, $key_available = false){
		if($acess_key == ACESS_KEY){
			#Store query
			$aFields = array(
                'UID' => $UID,
                'key_available' => $key_available
			);
			$this->oData->store_data(TABLE_ACESS, $aFields, false, NULL); 
			return true;
		}
		else{
			return false;
		}
	}
	
}
