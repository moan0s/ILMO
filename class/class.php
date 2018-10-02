<?php
class Data {
	function __construct(){
		$this->link_database();
		$this->read_variables();
	}
    
   function read_variables() {
      //reads all GET and POST variables into the object, addslashing both
      if (count($_POST)) {
         while (list($key, $val) = each($_POST)) {
            $key=addslashes("r_".$key);
            if (is_array($val)) { for ($z=0;$z<count($val);$z++) { $val[$z]=addslashes($val[$z]);}}
            else {$val=addslashes($val);}
            $this->$key=$val;
         }
      }
      if (count($_GET)) {
         while (list($key, $val) = each($_GET)) {
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
   
   function store_data($sTable,$aFields,$sKey_ID,$mID) {
      //updates or inserts data
      //returns ID or -1 if fails
	   $i=0; $returnID = 0;
	   
	if(($mID>0) or ($mID!="") or ($mID != null)) {
	      //search for it
         $aCheckFields=array($sKey_ID=>$mID);
         $aRow=$this->select_row($sTable,$aCheckFields);
         $returnID=$mID;
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
}   
class Book extends Data {
	function get_book (){
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
	
	function save_book(){
		$aFields = array(
			'title' => $this->r_title,
			'author' => $this->r_author,
			'location' => $this->r_location,
			'lend' => null		
		);
		if ((isset($this->r_number)) and ($this->r_number>0)){
			for ($i=1; $i<=$this->r_number; $i++){
				$aFields['book_ID'] = $this->r_book_ID." ".chr(96+$i);
				$this->ID=$this->store_data(TABLE_BOOKS, $aFields, FALSE, FALSE);
			}
				
		}
		else{
			$aFields['book_ID'] = $this->r_book_ID;
			$this->ID=$this->store_data(TABLE_BOOKS, $aFields, 'book_ID',$this->r_book_ID);
		}
				
		
	echo $this->ID;
	}
	function delete_book(){
		$aFields = array (
			'book_ID' => $this->r_book_ID
		);
		$this->removed=$this->delete_rows(TABLE_BOOKS, $aFields);
	}
	function show_this(){
		//only for debugging
		echo "<pre>";
		print_r ($this);
		echo"</pre>";

	}
	function show_all_books(){
		$this->p_result = $this->select_rows(TABLE_BOOKS, FALSE, FALSE);
	}
}
class User extends Data {
	function save_user(){
	$aFields = array(
			'user_ID' => $this->r_user_ID,
			'forename' => $this->r_forename,
			'surname' => $this->r_surname,
			'email' => $this->r_email,
		);
		$this->ID=$this->store_data(TABLE_USER, $aFields, 'user_ID', $this->r_user_ID);
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
	/*function show_all_user(){
		$this->p_result = $this->select_rows(TABLE_USER,  $aFields);
	}*/
	function show_this(){
		//only for debugging
		echo "<pre>";
		print_r ($this);
		echo"</pre>";

	}

}

class Lend extends Data {
	function save_lend(){
		//einfügen, dass das Buch als verliehen eingetragen  wird
		$aFields = array(
			'book_ID' => $this->r_book_ID,
			'user_ID' => $this->r_user_ID,
			'pickup_date' => date("Y-m-d H:i:s"),
			'return_date' => NULL,
			'returned' => NULL
		);	
		$this->ID=$this->store_data(TABLE_LEND, $aFields, FALSE, FALSE);
		
		$aFields = array(
		'lend' => 1
		);
		$this->store_data(TABLE_BOOKS, $aFields, 'book_ID', $this->r_book_ID);
		$this->show_this();
	echo $this->ID;		
	}
	function delete_lend(){
		$aFields = array (
			'lend_ID' => $this->r_lend_ID
		);
		$this->removed=$this->delete_rows(TABLE_LEND, $aFields);
	}
	function get_lend (){
		//needs: String lend_ID returns: Associative array with complete lend Information
		//create an array containig lend_ID
		//$aFields= array();
		$this->all_user = User::get_user();
		$this->all_book = Book::get_book();
		if((isset($this->r_user_ID)) and ($this->r_user_ID!= "")){$aFields["user_ID"] = $this->r_user_ID;}
		if((isset($this->r_lend_ID)) and ($this->r_lend_ID!= "")){$aFields["lend_ID"] = $this->r_lend_ID;}
		$this->p_result = $this->select_rows(TABLE_LEND, $aFields);
	} 

	function show_this(){
		//only for debugging
		echo "<pre>";
		print_r ($this);
		echo"</pre>";

	}

}
	
	
?>
