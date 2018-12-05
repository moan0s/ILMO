<?php
class Data {
	function __construct(){
		date_default_timezone_set('Europe/Berlin');
		$this->link_database();
		$this->read_variables();
		if (substr($this->r_ac, -5) != 'plain'){
			$this->set_session();
		}
		$this->opening_days = array ("monday", "tuesday", "wednesday", "thursday", "friday");
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
         echo "Datenbank nicht erreichbar: (" . $this->databaselink->connect_errno . ") " . $this->databaselink->connect_error;
      }
      $this->databasename=DB_DATABASE;
      $this->databaselink->query("SET SQL_MODE = '';");
   }
   
   function set_session(){
      //never forget: session_start(); is the first line in the index.php.!!
	   //Variables set via the read_variables: action (i.e. "logout" ), user, pwd
	   if (isset($this->r_ac)){
		if($this->r_ac=="logo") { //logo is short for logout (action are alwas 4 characters long)
         		$_SESSION['username']="";
			$_SESSION['admin']=0;
			session_destroy();
         		return;
      		}
	   }
      if((!isset($_SESSION['user_ID'])) and ((!isset($this->r_login_user_info)) or ($this->r_login_user_info==""))){
	      if($this->r_ac == "strt"){
	      		$this->error .= ENTER_USER_IDENTIFICATION;
	      }
	      $this->r_ac = "logi";
		   //logi is short for login
         //dont forget to call the action in your controller
         return;
      	}

	if((isset($this->r_login_user_info)) and ($this->r_login_user_info!="")) {
		    $this->sUser=str_replace("%","",$this->r_login_user_info); //never allow the wildcard in the username
		    if((isset($this->r_login_password)) and ($this->r_login_password!="")) {
		     	$this->sPassword=md5(strrev(trim($this->r_login_password)));
		        $aUser=$this->em_get_user(); //retrieve the user from the database, using pw-hash and username
              		$mNumber=$aUser["user_ID"];
              		if ($mNumber<1) {
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
   function em_get_user() { 
      if(isset($this->sUser)){
         if(strpos($this->sUser,"@")>0) {
             $aFields=array("email"=>$this->sUser,"password"=>$this->sPassword);
         }
         else {    
            $aFields=array("user_ID"=>$this->sUser,"password"=>$this->sPassword);
         }   
         $aResult=$this->select_row(TABLE_USER,$aFields);
         if($aResult["user_ID"]>0) {
              return $aResult;
        }
      }              
      return -1;   
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

   //checks whether a book is already lend
   //returns String containing "" or an error message
   function check_ID_lend($ID){
		if (($this->select_row(TABLE_BOOKS, array ('book_ID' => $ID, 'lend' => 1)) == -1) and ($this->select_row(TABLE_STUFF, array ('stuff_ID' => $ID, 'lend' => 1)) == -1)){
		   $error_message= "";
	   	}
		else
		{
			$error_message = '<br>'.IS_ALREADY_LEND;
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
				$error .= "Bitte gib eine Zahl als Benutzer-ID ein<br>";	
			}
		}
			
		if(isset($this->r_book_ID)){
			if (trim($this->r_book_ID) == ""){
				$error .= "Bitte gib eine Bücher-ID ein<br>";	
			}
		}

		if(isset($this->r_email)){
			if (!is_string(filter_var($this->r_email, FILTER_VALIDATE_EMAIL))){
				$error .= "Bitte gib eine gültige E-Mail Adresse ein<br>";	
			}
			
			if ((!isset($this->r_user_ID)) or ($this->r_user_ID =="")){
				if($this->check_email_used()){
					$error .= "Diese E-Mail Adresse ist schon registriert. Bitte melde dich mit dieser an oder erstelle ein neues Konto mit einer anderen E-Mail Adresse";
				}
			}

		}
		if(isset($this->r_password)){
			if (strlen($this->r_password)<4) {
				$error .= "Bitte wähle ein Passwort, das 4 oder mehr Zeichen hat<br>";	
			}
		}
		if(isset($this->r_title)){
			if ("" ==$this->r_title){
				$error .= "Bitte gib einen Titel ein<br>";	
			}
		}

		if(isset($this->r_author)){
			if ("" == $this->r_author){
				$error .= "Bitte gib einen Autor an<br>";	
			}
		}
		if(isset($this->r_location)){
			if ($this->location ==""){
				$error .= "Bitte gib einen Standort an<br>";	
			}
		}

		return $error;
   }
	function check_ID_exists($ID){
		if (($this->select_row(TABLE_BOOKS, array ('book_ID' => $ID)) == -1) and ($this->select_row(TABLE_STUFF, array ('stuff_ID' => $ID)) == -1)){
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
		foreach($this->opening_days as $day){
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

class Stuff extends Data{
function get_stuff_itemized (){
		$aStuff= array();
		$aFields= array();
		if((isset($this->r_stuff_ID)) and ($this->r_stuff_ID!= "")){$aFields["stuff_ID"] = $this->r_stuff_ID;}
		if((isset($this->r_name)) and ($this->r_name= "")){$aFields["name" ]= $this->r_name;}
		$this->p_result = $this->select_rows(TABLE_STUFF, $aFields);
		while($aRow=mysqli_fetch_assoc($this->p_result)){
			$aStuff[$aRow['stuff_ID']] = $aRow;
		}
		
		return $aStuff;

	}
	function get_stuff(){
	$sQuery="SELECT 
	B1.name as name,
	B1.location as location,
	count(*) as number,
	(
	   select  count(*) as available from ".TABLE_STUFF." B2 where lend=0 and name=B1.name 
	      ) as available 
	     FROM `".TABLE_STUFF."` B1
	     group by name";
	
	$this->p_result = $this->sql_statement($sQuery);
	while($aRow=mysqli_fetch_assoc($this->p_result)){
		$aStuff[$aRow['name']] = $aRow;
		
	}
		
	return $aStuff;


	}	
	function save_stuff(){
		$aFields = array(
			'name' => $this->r_name,
			'location' => $this->r_location,
			'lend' => null		
		);
		if ((isset($this->r_number)) and ($this->r_number>1)){
			for ($i=1; $i<=$this->r_number; $i++){
				$aFields['stuff_ID'] = $this->r_stuff_ID." ".$i;
				$this->ID=$this->store_data(TABLE_STUFF, $aFields, FALSE, FALSE);
			}
			
		}
		else{
			$aFields['stuff_ID'] = $this->r_stuff_ID;
			$this->ID=$this->store_data(TABLE_STUFF, $aFields, 'stuff_ID',$this->r_stuff_ID);
		}
				
	}
	function delete_stuff(){
		$aFields = array (
			'stuff_ID' => $this->r_stuff_ID
		);
		$this->removed=$this->delete_rows(TABLE_STUFF, $aFields);
	}
	function return_stuff($stuff_ID){
		$aFields = array(
			'lend' => 0		
		);

		$this->id = $this->store_data(TABLE_STUFF, $aFields, 'stuff_ID',$stuff_ID);
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
	count(*) as anzahl,
	(
	   select  count(*) as verfuegbar from ".TABLE_BOOKS." B2 where lend=0 and title=B1.title 
	      ) as verfuegbar 
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
			'lend' => null		
		);
		if ((isset($this->r_number)) and ($this->r_number>1)){
			for ($i=1; $i<=$this->r_number; $i++){
				$aFields['book_ID'] = $this->r_book_ID." ".chr(96+$i);
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
			'lend' => 0		
		//	'book_ID' => $this->r_book_ID
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
		
		$this->p_result = $this->select_rows(TABLE_USER, $aFields);
		while($aRow=mysqli_fetch_assoc($this->p_result)){
			$aUser[$aRow['user_ID']] = $aRow;
		}
		
		return $aUser;
	}

}

class Lend extends Data {
	function save_lend(){
		//einfügen, dass das Buch als verliehen eingetragen  wird
			$aFields = array(
				'ID' => $this->r_ID,
				'user_ID' => $this->r_user_ID,
				'pickup_date' => date("Y-m-d H:i:s"),
				'return_date' => NULL,
				'returned' => NULL
			);
		$this->ID=$this->store_data(TABLE_LEND, $aFields, FALSE, FALSE);
		
		$aFields = array(
		'lend' => 1
	);
		if($this->r_type=="book"){
			$this->store_data(TABLE_BOOKS, $aFields, 'book_ID', $this->r_ID);
		}
		if($this->r_type=="stuff"){
			$this->store_data(TABLE_STUFF, $aFields, 'stuff_ID', $this->r_ID);
		}
	}
	
	function return_lend(){
		//einfügen, dass das Buch als verliehen eingetragen  wird
		$aFields = array(
			'return_date' => date("Y-m-d H:i:s"),
			'returned' => 1
		);	
		$this->ID=$this->store_data(TABLE_LEND, $aFields, 'lend_ID', $this->r_lend_ID);
		
		$aFields = array(
		'lend' => 0
		);
		$this->store_data(TABLE_BOOKS, $aFields, 'book_ID', $this->r_book_ID);
	echo $this->ID;		
	}
	
	function delete_lend(){
		$aFields = array (
			'lend_ID' => $this->r_lend_ID
		);
		$this->removed=$this->delete_rows(TABLE_LEND, $aFields);
		$aFields = array(
				'lend' => 0
				);
		$this->store_data(TABLE_BOOKS, $aFields, 'book_ID', $this->r_book_ID);
		echo $this->ID;	
	}

	function get_lend (){
		//needs: String lend_ID returns: Associative array with complete lend Information
		//create an array containig lend_ID
		$aFields= array();
		
		$oUser = new User;
		$oBook = new Book;
		$oStuff = new Stuff;	
		$oBook->r_book_ID = NULL;
		$oSTUFF->r_stuff_ID = NULL;
		$this->all_user = $oUser->get_user();
		$this->all_book = $oBook->get_book_itemized();
		$this->all_stuff = $oStuff->get_stuff_itemized();
		if((isset($this->r_user_ID)) and ($this->r_user_ID!= "")){$aFields["user_ID"] = $this->r_user_ID;}
		if((isset($this->r_lend_ID)) and ($this->r_lend_ID!= "") and ($this->r_lend_ID!=NULL)){$aFields["lend_ID"] = $this->r_lend_ID;}
		$this->p_result = $this->select_rows(TABLE_LEND, $aFields);
		while($aRow=mysqli_fetch_assoc($this->p_result)){
			$aLend[$aRow['lend_ID']] = $aRow;
		}
		
		return $aLend;
	} 


}
	
	
?>
