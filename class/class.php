<?php
class Data {
	function __construct(){
		date_default_timezone_set('Europe/Berlin');
		$this->link_database();
		$this->read_variables();
		if ((substr($this->r_ac, -5) != 'plain') and (substr($this->r_ac, -3) != 'bot')){
			$this->set_session($this->r_ac);
		}
		$this->status = $this->get_status();
		$this->settings = $this->get_settings(); 
	}
	#returns true if sombody is checked in in the library
	function get_status($UID = NULL){
		$aFields = array(
			'checkout_time' => '0000-00-00 00:00:00'
		);
		if(isset($UID)){
			$aFields['UID'] = $UID;	
		}
		return (-1 != $this->select_row(TABLE_PRESENCE, $aFields));
	}

	function get_settings(){
		return parse_ini_file(__DIR__."/../config/settings.ini");

	}
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
	      		$this->error .= ENTER_USER_IDENTIFICATION;
	      }
	      $this->r_ac = "logi";
		   //logi is short for login
         //dont forget to call the action in your controller
         return;
      	}

	if((isset($this->r_login_user_info)) and ($this->r_login_user_info!="")) {
		    $sUser=str_replace("%","",$this->r_login_user_info); //never allow the wildcard in the username
		    if((isset($this->r_login_password)) and ($this->r_login_password!="")) {
		     	$sPassword=md5(strrev(trim($this->r_login_password)));
		        $aUser=$this->em_get_user($this->r_login_user_info, $sPassword); //retrieve the user from the database, using pw-hash and username
			if (!$aUser) {
		      		session_destroy();
				$this->error = WRONG_LOGIN;
				$this->r_ac="logi";
                 		return;
              		}
			else {
		        	 $_SESSION['user_ID']=$aUser['user_ID'];
		       		 $_SESSION['admin']=$aUser['admin'];
			}
		     }
		     else{
		     	$this->error .= ENTER_PASSWORD; 
	      		$this->r_ac = "logi";
		     	return;
		     }

	}
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
   function select_rows($sTable,$aFields = array(),$aOrder = array()) {
      //selects multiple rows from the database 
      //returns resultset 
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
         $sOrder=" order by";
         foreach($aOrder as $value) {
            if($i>0) {
               $sOrder.=",";
            }   
            $sOrder.=" ".$value;
            $i++;
         }
      }      
		  $sQuery="SELECT * FROM ".$sTable.$sConditions.$sOrder;
		  $this->last_query[]=$sQuery;
		  return $this->databaselink->query($sQuery);
   }

   function change_language($language){
	$_SESSION['language']=$language;
   }
   
   function check_ID_loan($ID){
		if (($this->select_row(TABLE_BOOKS, array ('book_ID' => $ID, 'lent' => 1)) == -1) and ($this->select_row(TABLE_MATERIAL, array ('material_ID' => $ID, 'lent' => 1)) == -1)){
		   $error_message= "";
	   	}
		else
		{
			$error_message = '<br>'.IS_ALREADY_LENT;
	   	}
	   return $error_message;
   }

   function check_type(){
	   if(isset($this->r_type)){
		return;
	}
	else{
		return PLEASE_GIVE_TYPE;
	}
   }
   //checks if an E-MAil Adress is already used
   function check_email_used(){
		$aFields = array('email' => $this->r_email);
		$aResult = $this->select_row(TABLE_USER, $aFields); 
		if($aResult == -1){
			return FALSE;
		}
		else{
			return TRUE;
			//return $aResult['user_ID'];
		}
   
   }
   //returns String containing "" or an error message
   function check_input(){
	   $error="";
		if(isset($this->r_user_ID)){
			if (($this->r_user_ID != "") and (!is_numeric($this->r_user_ID))){
				$error .= GIVE_NUMBER_AS_USER_ID;	
			}
		}
			
		if(isset($this->r_book_ID)){
			if (trim($this->r_book_ID) == ""){
				$error .= GIVE_BOOK_ID;
			}
		}

		if(isset($this->r_email)){
			if (!is_string(filter_var($this->r_email, FILTER_VALIDATE_EMAIL))){
				$error .= GIVE_VALID_E_MAIL_ADRESS;
			}
			
			if ((!isset($this->r_user_ID)) or ($this->r_user_ID =="")){
				if($this->check_email_used()){
					$error .= E_MAIL_ALREADY_IN_USE;
				}
			}

		}
		if(isset($this->r_password)){
			if (strlen($this->r_password)<4) {
				$error .= PASSWORD_TO_SHORT;	
			}
		}
		if(isset($this->r_title)){
			if ("" ==$this->r_title){
				$error .= ENTER_BOOK_TITLE;
			}
		}

		if(isset($this->r_author)){
			if ("" == $this->r_author){
				$error .= ENTER_BOOK_AUTHOR;	
			}
		}
		if(isset($this->r_location)){
			if ($this->location ==""){
				$error .= ENTER_LOCATION;	
			}
		}

		return $error;
   }
	function check_ID_exists($ID){
		if (($this->select_row(TABLE_BOOKS, array ('book_ID' => $ID)) == -1) and ($this->select_row(TABLE_MATERIAL, array ('material_ID' => $ID)) == -1)){
			return ID_DOES_NOT_EXIST;
		}
	}
	function check_user_exists($user_ID){
		if ($this->select_row(TABLE_USER, array ('user_ID' => $user_ID)) == -1){
			return USER_DOES_NOT_EXIST;
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
		if ((isset($this->r_number)) and ($this->r_number>1)){
			for ($i=0; $i<=$this->r_number; $i++){
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
	function get_user (){
		$aUser= array();
		$aFields= array();
		if((isset($this->r_user_ID)) and ($this->r_user_ID!= "")){$aFields["user_ID"] = $this->r_user_ID;}
		if((isset($this->r_forename)) and ($this->r_forename!= "")){$aFields["forename" ]= $this->r_forename;}
		if((isset($this->r_surname)) and ($this->r_surname != "")){$aFields["surname"] = $this->r_surname;}
		if((isset($this->r_email)) and ($this->r_email!= "")){$aFields["email"] = $this->r_email;}
		if((isset($this->r_UID)) and ($this->r_UID!= "")){$aFields["UID"] = $this->r_UID;}
		if((isset($this->r_language)) and ($this->r_language!= "")){$aFields["language"] = $this->r_email;}
		
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
				'pickup_date' => date("Y-m-d H:i:s"),
				'return_date' => NULL,
				'returned' => NULL,
				'last_reminder' => date("Y-m-d"),

			);
		$this->ID=$this->store_data(TABLE_LOAN, $aFields, FALSE, FALSE);
		
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
		//einfügen, dass das Buch als verliehen eingetragen  wird
		$aLoan = $this->get_loan();
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
	
	function get_loan (){
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
		if((isset($this->r_user_ID)) and ($this->r_user_ID!= "")){$aFields["user_ID"] = $this->r_user_ID;}
		if((isset($this->r_loan_ID)) and ($this->r_loan_ID!= "") and ($this->r_loan_ID!=NULL)){$aFields["loan_ID"] = $this->r_loan_ID;}
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
		return $stats;
	}
	function send_reminder($aRow){
	
		$oUser = new User;
		$oUser->r_user_ID= $aRow['user_ID'];
		$aUser = $oUser->get_user()[$aRow['user_ID']];
		$to = $aUser['email'];
		include ('language/'.$aUser["language"].'/mail.php');
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
		
		$subject = '[Ausleihe '.$aRow['loan_ID'].']'.YOUR_LOANS_AT_THE.' '.LIBRARY_NAME;
		$message = 
			HELLO." ".$aUser['forename']." ".$aUser['surname'].",\r\n".
			YOU_HAVE_LENT."\r\n\r\n";
		
		if ($aRow['type'] == 'book'){
			$message.=
				TITLE.': '.$aBook['title']."\r\n".
				AUTHOR.': '.$aBook['author']."\r\n";
		}
		if ($aRow['type'] == 'material'){
			$message.=
				NAME.': '.$aMaterial['name']."\r\n";
		}
		$message .=
			LOAN_ON.': '.$aRow['pickup_date']."\r\n\r\n".
			CONDITIONS_OF_LOAN.' '.
			SHOW_LOANS_ONLINE."\r\n\r\n".
			GREETINGS."\r\n".
			TEAM."\r\n\r\n".
			FUTHER_INFORMATION;
		$issue = "Reminder on loan ".$aRow['loan_ID'];
		$this->log_mail($aUser['email'], $aRow['user_ID'], $issue);
	
		return mail($to, $subject, $message, MAIL_HEADER);

	}

	function log_mail($email, $user_ID, $issue){
		$fLog = fopen(__DIR__."/../".$this->settings['path_mail_log'], 'wb');
		fwrite($fLog, '['.date("Y-m-d H:i:s").']: To: "'.$email.'" with user_ID: "'.$user_ID.'" because of: "'.$issue.'"'."\n");
		fclose($fLog);

	}

}
include ("class/presence.php");

	
	
?>
