<?php
include ("class/lang.php");
class Data {
	function __construct(){
		$this->settings = $this->get_settings();
		$this->link_database();
		$this->em_check_database();
		$this->read_variables();
		$this->oLang = new Lang;
		if(isset($_SESSION['language'])){
			$this->oLang->set_language($_SESSION['language']);
		}
		else{
			$this->oLang->set_language($this->settings['default_language']);

		}
		if ((substr($this->r_ac, -5) != 'plain') and (substr($this->r_ac, -3) != 'bot')){
			$this->set_session($this->r_ac);
		}
		date_default_timezone_set($this->settings['timezone']);
	}
	
	#parses settings in an array
	#returns array
	function get_settings(){
		return parse_ini_file(__DIR__."/../config/settings.ini");
	}

	#parses given data in json and outputs them
	function output_json($data){
		header('Content-Type: application/json');
		echo json_encode($data);
	}

   function read_variables() {
      //reads all GET and POST variables into the object, addslashing both
      if (count($_POST)) {
	      foreach ($_POST as $key => $val){
            	$key=addslashes("r_".$key);
		if (is_array($val)) { 
			for ($z=0;$z<count($val);$z++) { 
				$val[$z]=addslashes($val[$z]);
			}
		}
		else {
			$val=addslashes($val);
		}
            $this->$key=$val;
         }
      }
      if (count($_GET)) {
	      foreach ($_GET as $key => $val){
            	$key=addslashes("r_".$key);
             	if (is_array($val)) {
                	for ($z=0;$z<count($val);$z++) {
                	$val[$z]=addslashes($val[$z]);
                	}
             	}
             	else {
                	$val=addslashes($val);
             	}
             	
		$this->$key=$val;
         }
      }
   }//end of function read variables
   

	function link_database() {  
      $this->databaselink = new mysqli(DB_HOST,DB_USER,DB_PW,DB_DATABASE);
      $this->databaselink->set_charset('utf8');
      if ($this->databaselink->connect_errno) {
         	return "Datenbank nicht erreichbar: (" . $this->databaselink->connect_errno . ") " . $this->databaselink->connect_error;
      }
      	else{
      		$this->databasename=DB_DATABASE;
      		$this->databaselink->query("SET SQL_MODE = '';");
		return True;
	}
	}
	//Stores the Database on a distant SFTP-Server
	//returns true if successful
	function backup_database(){
		return True;
	}
   
   function set_session($action = NULL){
	   //Variables set via the read_variables: action (i.e. "logout" ), user, pwd
	   if (isset($action)){
		if($action=="logo") { //logo is short for logout (action are alwas 4 characters long)
         		$_SESSION['username']="";
			$_SESSION['admin']=0;
			session_destroy();
         		return;
      		}
	   }
      if((!isset($_SESSION['user_ID'])) and ((!isset($this->r_login_user_info)) or ($this->r_login_user_info==""))){
	      if($action == "strt"){
	      		$this->error .= $this->oLang->texts['ENTER_USER_IDENTIFICATION'];
	      }
	      $this->r_ac = "logi";
         return;
      	}

	if((isset($this->r_login_user_info)) and ($this->r_login_user_info!="")) {
		    $sUser=str_replace("%","",$this->r_login_user_info); //never allow the wildcard in the username
		    if((isset($this->r_login_password)) and ($this->r_login_password!="")) {
		     	$sPassword=md5(strrev(trim($this->r_login_password)));
		        $aUser=$this->em_get_user($this->r_login_user_info, $sPassword); //retrieve the user from the database, using pw-hash and username
			if (!$aUser) {
		      		session_destroy();
				$this->error = $this->oLang->texts['WRONG_LOGIN'];
				$this->r_ac="logi";
                 		return;
              		}
			else {
		        	 $_SESSION['user_ID']=$aUser['user_ID'];
		       		 $_SESSION['admin']=$aUser['admin'];
			}
		     }
		     else{
		     	$this->error .= $this->oLang->texts['ENTER_PASSWORD']; 
	      		$this->r_ac = "logi";
		     	return;
		     }

	}
   }

    function em_check_database() {
	/*
	params:
		None
	returns:
		None
	This function compares the database structure to a predefined structure which is saved in db_array_config.php
	and adds missing structures. Makes installation+updates easy
	*/
	$aTable=array();
      	//Alle Tabellen in Array lesen, inklusive aller Eigenschaften
	$result=$this->databaselink->query("show tables from ".DB_DATABASE);
	while($row = $result->fetch_array(MYSQLI_BOTH)){ 
		$aTable[]=$row[0];
	}
	$aData=array();
	$database_structure_path = __DIR__."/../config/db_array.inc.php";
	include($database_structure_path);
	foreach($aData as $table=>$fields){
		if(!in_array($table,$aTable)) {
			//Add table to database
			$mCounter=0;
			$sCommand="CREATE TABLE IF NOT EXISTS `".$table."` (";
			foreach($fields as $fieldname=>$properties){
				$extra = "";
				if($mCounter==0) {
					$key="KEY `".$fieldname."` (`".$fieldname."`)";
				}
				if($properties["size"]!="") { 
					$size="(".$properties["size"].")";
				}
				else {
					$size="";
				}
				if((isset($properties["unique"])) and ($properties['unique']==true)) { 
					$unique="UNIQUE KEY `".$fieldname."_2` (`".$fieldname."`),";}
				else {
					$unique="";
				}
				if((isset($properties["extra"])) and ($properties != "")){
					$extra = $properties['extra'];
				}
				$sCommand .= "`".$fieldname."` ".$properties["type"].$size." ".$properties["standard"]." ".$extra.",";
				$mCounter++;
			
			}
			$sCommand.=$unique.$key.") ENGINE=InnoDB ;";
			$this->last_query[]=$sCommand;
			$updateresult=$this->databaselink->query($sCommand);
		}
		else {
			//Felder checken und Tabelle updaten
			$resultField=$this->databaselink->query("show fields from ".DB_DATABASE.".".$table);
			while($aRowF = $resultField->fetch_array(MYSQLI_BOTH)){ 
				$aTableFields[]=$aRowF[0];
			}
			foreach($fields as $fieldname=>$properties) {
				if(!in_array($fieldname,$aTableFields)) {
					if((isset($properties["size"]) and ($properties['size']!=""))) { 
						$size="(".$properties["size"].")";
					}
					else {
						$size="";
					}
					$sCommand="ALTER TABLE `".$table."` ADD `".$fieldname."` ".$properties["type"].$size." ".$properties["standard"];
					$this->last_query[]=$sCommand;
					$updateresult=$this->databaselink->query($sCommand);
				}
			}
		}
		unset($aTableFields);
		unset($aFields);
		unset($properties);
	}
	unset($aData);
    }
   function em_get_user($sUser, $sPassword) { 
	   if(isset($sUser)){
		   if(strpos($sUser,"@")>0) {
			   $aFields=array("email"=>$sUser,"password"=>$sPassword);
		   }
		   else{
			$aFields=array("user_ID"=>$sUser,"password"=>$sPassword);
		   }	  
		   $aResult=$this->select_row(TABLE_USER,$aFields);
		   if($aResult["user_ID"]>0) {
			   return $aResult;
		   }
	   }              
	   return False;   
   }

   function store_data($sTable,$aFields,$sKey_ID,$mID) {
      //updates or inserts data
      //returns ID or -1 if fails
	   $i=0; $returnID = 0;
	   
	if(($mID>0) or ($mID!="") or ($mID != null)) {
	      //search for it
         $aCheckFields=array($sKey_ID=>$mID);
         $aRow=$this->select_row($sTable,$aCheckFields);
         $returnID=$aRow[$sKey_ID];
      }
      if(($returnID>0) or ($returnID!="")) {
         $sQuery="update ".$sTable." set ";
         foreach($aFields as $key=>$value) {
            $sQuery.=$key."='".$value."'";
            $i++;
            if($i<count($aFields)) {
               $sQuery.=",";
            }
         }      
         $sQuery.=" where ".$sKey_ID."='".$mID."'";
         $mDataset_ID=$returnID;
      }
      else {   
	 $sKeys = "";  $sValues = "";   
	 $sQuery="insert into ".$sTable." (";
         foreach($aFields as $sKey=>$value) {
            $sKeys.=$sKey;
            $sValues.="'".$value."'";
            $i++;
            if($i<count($aFields)) {
               $sKeys.=",";
               $sValues.=",";
            }
         }      
         $sQuery.=$sKeys.") values (".$sValues.")";
      }
      $this->last_query[]=$sQuery; 
      if ($pResult = $this->databaselink->query($sQuery)) {
         if(($returnID>0) or ($returnID!="")) {
            return $returnID;
         }
         else {
            return $this->databaselink->insert_id;
         }
      }
      else {
         return -1;
      }                
   }
   function delete_data($sTable,$sKey_ID,$mID) {
      //deletes data specified by id
      //returns 1 or -2 if fails, -1 if no id is given
      if($mID>0) {
         $sQuery="delete from ".$sTable." where ".$sKey_ID." = '".$mID."'";
         $this->last_query[]=$sQuery; 
         if ($pResult = $this->databaselink->query($sQuery)) {
            return 1;
         }
         else {
            return -2;
         }
      }
      else {
         return -1;
      }                
   }   
   function delete_rows($sTable,$aFields) {
      //deletes multiple rows from the database 
      //returns 1 if ok, -1 if fails 
      $i = 0;
      if($aFields==false) {unset($aFields);}
      if(isset($aFields)) {
         foreach($aFields as $key=>$value) {
            if($i>0) {
               $sConditions.=" and ";
            }
            else {
               $sConditions=" WHERE";
            }      
            $sConditions.=" ".$key."='".$value."'";
            $i++;
         }   
      }   
		  $sQuery="DELETE FROM ".$sTable.$sConditions;
		  $this->last_query[]=$sQuery;
		  return $this->databaselink->query($sQuery);
   } 
   function select_row($sTable,$aFields) {
      //selects a single row from the database 
      //returns array or -1
      $i = 0; $sConditions="";
      foreach($aFields as $key=>$value) {
         if($i>0) {
            $sConditions.=" and ";
         }   
         $sConditions.=" ".$key."='".$value."'";
         $i++;
      }   
		  $sQuery="SELECT * FROM ".$sTable." WHERE".$sConditions;
		  $pResult=$this->databaselink->query($sQuery);
		  $this->last_query[]=$sQuery;
		  $mNumber=$pResult->num_rows;
		  if($mNumber>0) {
		     return $pResult->fetch_array(MYSQLI_BOTH);
		  }
      else {
         return -1; 
      }
   }
   function select_rows(String $sTable, Array $aFields = array(), Array $aOrder = array()) {
	/*
	params:
		String $sTable:
			Table from which to select the rows
		Array $aFields:
			Array of filters that allow to select only some rows
			e.g. $aFields = array("user" => "AnyUsername")
		Array $aOrder:
			Array where the values determins the colums for which to sort
			An minus in the colum string indicates a descending order
        returns:
		resultset
	Selects multiple rows from the database
	*/
	$i = 0; $sConditions=""; $sOrder = "";
	if($aOrder==false) {unset($aOrder);}
	if($aFields==false) {unset($aFields);}
	if(isset($aFields)) {
		foreach($aFields as $key=>$value) {
			if($i>0) {
				$sConditions.=" and ";
			}
			else {
				$sConditions=" WHERE";
			}
		$sConditions.=" ".$key."='".$value."'";
		$i++;
		}
	}
	$i = 0;
	if(isset($aOrder)){
		$sOrder=" ORDER BY ";
		foreach($aOrder as $value) {
			if($i>0) {
				$sOrder.=",";
			}
			$minuspos = strpos($value, "-");
			if(is_int($minuspos)){
				$sOrder.= " ".str_replace("-", "", $value)." DESC ";
				$i++;
			}
			else{
				$sOrder.=" ".$value;
				$i++;
			}
		}
	}
	$sQuery = "SELECT * FROM ".$sTable.$sConditions.$sOrder;
	$this->last_query[] = $sQuery;
	return $this->databaselink->query($sQuery);
   }

   function check_ID_loan($ID){
		if (($this->select_row(TABLE_BOOKS, array ('book_ID' => $ID, 'lent' => 1)) == -1) and ($this->select_row(TABLE_MATERIAL, array ('material_ID' => $ID, 'lent' => 1)) == -1)){
		   $error_message= "";
	   	}
		else
		{
			$error_message = '<br>'.$this->oLang->texts['IS_ALREADY_LENT'];
	   	}
	   return $error_message;
   }

   function check_type(){
	   if(isset($this->r_type)){
		return;
	}
	else{
		return $this->oLang->texts['PLEASE_GIVE_TYPE'];
	}
   }
   //checks if an E-MAil Adress is already used
   function check_email_used($email){
		$aFields = array('email' => $email);
		$aResult = $this->select_row(TABLE_USER, $aFields); 
		if($aResult == -1){
			return FALSE;
		}
		else{
			return TRUE;
		}
   }
   //returns String containing "" or an error message
   function check_user_ID($user_ID){
   	if((!isset($user_ID)) and ($user_ID=="")){
		return $this->oLang->texts['ENTER_USER_ID']; 
	   }
	elseif (!is_numeric($user_ID)){
		return $this->oLang->texts['GIVE_NUMBER_AS_USER_ID'];	
	}
	else {
		return "";
	}
   }
   
   function check_email($email){
	if (!is_string(filter_var($email, FILTER_VALIDATE_EMAIL))){
		$error .= $this->oLang->texts['GIVE_VALID_E_MAIL_ADRESS'];
	}
	if($this->check_email_used()){
		return $this->oLang->texts['E_MAIL_ALREADY_IN_USE'];
	}
   }
   function check_password($password){
    	if (strlen($password)<4) {
		return $this->oLang->texts['PASSWORD_TO_SHORT'];	
	}

   }
   function check_book_title($title){
	if ("" == $title){
		return $this->oLang->texts['ENTER_BOOK_TITLE'];
	}
   }	   
   function check_author($author){
	   if("" == $author){
		   return $this->oLang->texts['ENTER_BOOK_AUTHOR'];
	   }
   }
   function check_location($location){
	   if ("" == $location){
		   return $this->oLang->texts['ENTER_LOCATION'];
	   }
   }  
   function check_date($date){
	if(!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$date)){
		return $this->oLang->texts['ENTER_VALID_DATE_IN_FORMAT_YYYY_MM_DD'];	
	}
   }

	function check_ID_exists($ID){
		if (($this->select_row(TABLE_BOOKS, array ('book_ID' => $ID)) == -1) and ($this->select_row(TABLE_MATERIAL, array ('material_ID' => $ID)) == -1)){
			return $this->oLang->texts['ID_DOES_NOT_EXIST'];
		}
	}
	function check_user_exists($user_ID){
		if ($this->select_row(TABLE_USER, array ('user_ID' => $user_ID)) == -1){
			return $this->oLang->texts['USER_DOES_NOT_EXIST'];
		}
	}
	function get_view($Datei) {
	         ob_start();  //startet Buffer
		 include($Datei);  
		 $Ausgabe=ob_get_contents();  //Buffer wird geschrieben
		 ob_end_clean();  //Buffer wird gelöscht
		 return $Ausgabe;
    }

	function show_this(){
		//only for debugging
		echo "<pre>";
		print_r ($this);
		echo"</pre>";

	}

     	function sql_statement($sQuery) {
         //selects multiple rows from the database 
         //returns resultset 
		$this->last_query[]=$sQuery;
	
               // return mysql_query($sQuery,$this->databaselink);
                return $this->databaselink->query($sQuery);
	} 

}  

class Open extends Data{
	function get_open(){
		$aOpen = array();
		$aFields = array();
		
		$this->p_result = $this->select_rows(TABLE_OPEN, $aFields);
		while($aRow=mysqli_fetch_assoc($this->p_result)){
			$aOpen[$aRow['day']] = $aRow;
		}
		return $aOpen;
	}

	function save_open(){
		foreach($this->settings['opening_days'] as $day){
			$fieldS="r_".$day."_s";
			$fieldE="r_".$day."_e";
			$fieldN="r_".$day."_n";
			$aFields = array (
				'day' => $day,
				'start' => $this->$fieldS,
				'end' => $this->$fieldE,
				'notice' => $this->$fieldN
			);
			$xy = $this->store_data(TABLE_OPEN,$aFields,"day",$day);
			unset($aFields);
		}
	}

}

class Material extends Data{
function get_material_itemized (){
		$aMaterial= array();
		$aFields= array();
		if((isset($this->r_material_ID)) and ($this->r_material_ID!= "")){$aFields["material_ID"] = $this->r_material_ID;}
		if((isset($this->r_name)) and ($this->r_name= "")){$aFields["name" ]= $this->r_name;}
		$this->p_result = $this->select_rows(TABLE_MATERIAL, $aFields);
		while($aRow=mysqli_fetch_assoc($this->p_result)){
			$aMaterial[$aRow['material_ID']] = $aRow;
		}
		
		return $aMaterial;

	}
	function get_material(){
	$sQuery="SELECT 
	B1.name as name,
	B1.location as location,
	count(*) as number,
	(
	   select  count(*) as available from ".TABLE_MATERIAL." B2 where lent=0 and name=B1.name 
	      ) as available 
	     FROM `".TABLE_MATERIAL."` B1
	     group by name";
	
	$this->p_result = $this->sql_statement($sQuery);
	while($aRow=mysqli_fetch_assoc($this->p_result)){
		$aMaterial[$aRow['name']] = $aRow;
		
	}
		
	return $aMaterial;


	}	
	function save_material(){
		$aFields = array(
			'name' => $this->r_name,
			'location' => $this->r_location,
			'lent' => null		
		);
		if ((isset($this->r_number)) and ($this->r_number>1)){
			for ($i=1; $i<=$this->r_number; $i++){
				$aFields['material_ID'] = $this->r_material_ID." ".$i;
				$this->ID=$this->store_data(TABLE_MATERIAL, $aFields, FALSE, FALSE);
			}
			
		}
		else{
			$aFields['material_ID'] = $this->r_material_ID;
			$this->ID=$this->store_data(TABLE_MATERIAL, $aFields, 'material_ID',$this->r_material_ID);
		}
				
	}
	function delete_material(){
		$aFields = array (
			'material_ID' => $this->r_material_ID
		);
		$this->removed=$this->delete_rows(TABLE_MATERIAL, $aFields);
	}
	function return_material($material_ID){
		$aFields = array(
			'loan' => 0		
		);

		$this->id = $this->store_data(TABLE_MATERIAL, $aFields, 'material_ID',$material_ID);
	return $ID;
	
	}

}

class Book extends Data {
	function get_book_itemized (){
		$aBook= array();
		$aFields= array();
		if((isset($this->r_book_ID)) and ($this->r_book_ID!= "")){$aFields["book_ID"] = $this->r_book_ID;}
		if((isset($this->r_title)) and ($this->r_title= "")){$aFields["title" ]= $this->r_title;}
		
		$this->p_result = $this->select_rows(TABLE_BOOKS, $aFields);
		while($aRow=mysqli_fetch_assoc($this->p_result)){
			$aBook[$aRow['book_ID']] = $aRow;
		}
		
		return $aBook;

	}
	function get_book(){
	$sQuery="SELECT 
	B1.title as title,
	B1.author as author,
	B1.location as location,
	count(*) as number,
	(
	   select  count(*) as available from ".TABLE_BOOKS." B2 where lent=0 and title=B1.title 
	      ) as available 
	     FROM `".TABLE_BOOKS."` B1
	     group by title";
	$this->p_result = $this->sql_statement($sQuery);
	while($aRow=mysqli_fetch_assoc($this->p_result)){
		$aBook[$aRow['title']] = $aRow;
	}
		
	return $aBook;


	}	
	function save_book(){
		$aFields = array(
			'title' => $this->r_title,
			'author' => $this->r_author,
			'location' => $this->r_location,
			'lent' => null		
		);
		if ((isset($this->r_number)) and ($this->r_number>0)){
			for ($i=0; $i<$this->r_number; $i++){
				if ($i<26){
					$aFields['book_ID'] = $this->r_book_ID." ".chr(97+$i);
				}
				else{
					$aFields['book_ID'] = $this->r_book_ID." ".chr(97+(int)($i/26)).chr(96+$i%26);
				}
				$this->ID=$this->store_data(TABLE_BOOKS, $aFields, FALSE, FALSE);
			}
				
		}
		else{
			$aFields['book_ID'] = $this->r_book_ID;
			$this->ID=$this->store_data(TABLE_BOOKS, $aFields, 'book_ID',$this->r_book_ID);
		}
				
	}
	function delete_book(){
		$aFields = array (
			'book_ID' => $this->r_book_ID
		);
		$this->removed=$this->delete_rows(TABLE_BOOKS, $aFields);
	}
	function return_book($book_ID){
		$aFields = array(
			'lent' => 0		
		);

		$this->id = $this->store_data(TABLE_BOOKS, $aFields, 'book_ID',$book_ID);
	return $ID;
	
	}


}
class User extends Data {
	function save_user(){
		$aFields = array(
			'forename' => $this->r_forename,
			'surname' => $this->r_surname,
			'email' => $this->r_email,
			'UID' => $this->r_UID,
			'language' => $this->r_language,
			'password' => md5(strrev($this->r_password)),
			'admin' => $this->r_admin
		);
		if ((isset($this->r_user_ID))and ($this->r_user_ID != "")){
			$this->ID=$this->store_data(TABLE_USER, $aFields, 'user_ID' , $this->r_user_ID);
		}
		else{
			$this->ID=$this->store_data(TABLE_USER, $aFields, NULL , NULL);
		}
	}
	function delete_user(){
		$aFields = array (
			'user_ID' => $this->r_user_ID
		);
		$this->removed=$this->delete_rows(TABLE_USER, $aFields);
	}
	function get_user ($user_ID = NULL, $forename = NULL, $surname = NULL, $email = NULL, $UID = NULL, $language = NULL){
		$aUser= array();
		$aFields= array();
		if((isset($user_ID)) and ($user_ID!= "")){
			$aFields["user_ID"] = $user_ID;
		}
		if((isset($forename)) and ($forename!= "")){
			$aFields["forename" ]= $forename;
		}
		if((isset($surname)) and ($surname != "")){
			$aFields["surname"] = $surname;
		}
		if((isset($email)) and ($email!= "")){
			$aFields["email"] = $email;
		}
		if((isset($UID)) and ($UID!= "")){
			$aFields["UID"] = $UID;
		}
		if((isset($this->oLang->language)) and ($language!= "")){
			$aFields["language"] = $language;
		}
		
		$this->p_result = $this->select_rows(TABLE_USER, $aFields);
		while($aRow=mysqli_fetch_assoc($this->p_result)){
			$aUser[$aRow['user_ID']] = $aRow;
		}
		
		return $aUser;
	}
	function get_user_by_UID (){
		$aUser= array();
		$aFields= array();
		
		$this->p_result = $this->select_rows(TABLE_USER, $aFields);
		while($aRow=mysqli_fetch_assoc($this->p_result)){
			$aUser[$aRow['UID']] = $aRow;
		}
		
		return $aUser;
	}


}

class Loan extends Data {
	function save_loan(){
		$aFields = array(
				'ID' => $this->r_ID,
				'type' => $this->r_type,
				'user_ID' => $this->r_user_ID,
				'return_date' => NULL,
				'returned' => NULL,

			);
			if((isset($this->r_pickup_date)) and ( ""!= $this->r_pickup_date)){
				$aFields['pickup_date'] = $this->r_pickup_date;
				$aFields['last_reminder'] = $this->r_pickup_date;
			}
			else{
				$aFields['pickup_date'] = date("Y-m-d");
				$aFields['last_reminder'] = date("Y-m-d");
			}
			if((isset($this->r_return_date)) and ( ""!= $this->r_return_date)){
				$aFields['return_date'] = $this->r_return_date;
			}
			else{
				$aFields['return_date'] = "0000-00-00";
			}
		$this->ID=$this->store_data(TABLE_LOAN, $aFields, 'loan_ID', $this->r_loan_ID);
		
		$aFields = array(
			'lent' => 1
		);
		if($this->r_type=="book"){
			$this->store_data(TABLE_BOOKS, $aFields, 'book_ID', $this->r_ID);
		}
		if($this->r_type=="material"){
			$this->store_data(TABLE_MATERIAL, $aFields, 'material_ID', $this->r_ID);
		}
	
	}
	
	function return_loan(){
		$aLoans= $this->get_loan(NULL, NULL, NULL);
		$aLoan = $aLoans[$this->r_loan_ID];
		$aFields = array(
			'return_date' => date("Y-m-d H:i:s"),
			'returned' => 1
		);	
		$this->ID=$this->store_data(TABLE_LOAN, $aFields, 'loan_ID', $this->r_loan_ID);
		
		$aFields = array(
		'lent' => 0
	);
		if ($aLoan['type']=='book'){ 
			$this->store_data(TABLE_BOOKS, $aFields, 'book_ID', $this->r_ID);
		}
		if ($aLoan['type']=='material'){
			$this->store_data(TABLE_MATERIAL, $aFields, 'material_ID', $this->r_ID);
		}

	}
	
	function get_loan ($loanID = NULL, $userID = NULL, $bookID = NULL){
		//needs: String loan_ID returns: Associative array with complete loan Information
		//create an array containig loan_ID
		$aFields= array();
		
		$oUser = new User;
		$oBook = new Book;
		$oMaterial = new Material;	
		$oBook->r_book_ID = NULL;
		$oMaterial->r_material_ID = NULL;
		$this->all_user = $oUser->get_user();
		$this->all_book = $oBook->get_book_itemized();
		$this->all_material = $oMaterial->get_material_itemized();
		if((isset($userID)) and ($userID!= "")){$aFields["user_ID"] = $this->r_user_ID;}
		if((isset($loanID)) and ($loanID!= "")){$aFields["loan_ID"] = $this->r_loan_ID;}
		$this->p_result = $this->select_rows(TABLE_LOAN, $aFields);
		while($aRow=mysqli_fetch_assoc($this->p_result)){
			$aLoan[$aRow['loan_ID']] = $aRow;
		}
		
		return $aLoan;
	} 


}

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
		$fLog = fopen(__DIR__."/../".$this->settings['path_mail_log'], 'a+');
		fwrite($fLog, '['.date("Y-m-d H:i:s").']: To: "'.$email.'" with user_ID: "'.$user_ID.'" because of: "'.$issue.'"'."\n");
		fclose($fLog);

	}

}

include ("class/presence.php");
	
	
?>
