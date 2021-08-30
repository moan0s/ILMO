<?php
class Data
{
    public function __construct($oLang)
    {
        include(MODULE_PATH."config/permissions.php");
        $this->oLang = $oLang;
        $this->roles = $roles;
        $this->permissions = $permissions;
        $this->settings = $this->get_settings();
        $this->link_database();
        $this->em_check_database();
        $this->read_variables();
        if (isset($_SESSION['language'])) {
            $this->oLang->set_language($_SESSION['language']);
        } else {
            $this->oLang->set_language($this->settings['default_language']);
        }
        date_default_timezone_set($this->settings['timezone']);
        $this->set_session();
        $this->error = array();
        $this->output = "";
    }

    #parses settings in an array
    #returns array
    public function get_settings()
    {
        $path = MODULE_PATH."config/settings.json";
        $fSettings= fopen($path, "r") or die("Unable to open ".$path."!");
        $sSettings =  fread($fSettings, filesize($path));
        fclose($fSettings);
        $aSettings = json_decode($sSettings, true);
        return $aSettings;
    }

    #parses given data in json and outputs them
    public function output_json($data)
    {
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function read_variables()
    {
        //reads all GET and POST variables into the object, addslashing both
        if (count($_POST)) {
            foreach ($_POST as $key => $val) {
                $this->payload[$key] = mysqli_real_escape_string($this->databaselink, $val);
            }
        }
        if (count($_GET)) {
            foreach ($_GET as $key => $val) {
                $this->payload[$key] = mysqli_real_escape_string($this->databaselink, $val);
            }
        }
    }


    public function link_database()
    {
        //links the database. If the database does not exist, creates it
        $this->databaselink = new mysqli(DB_HOST, DB_USER, DB_PW);
        $this->databaselink->set_charset('utf8');
        if ($this->databaselink->connect_errno) {
            return "Datenbank nicht erreichbar: (" . $this->databaselink->connect_errno . ") " . $this->databaselink->connect_error;
        } else {
            // Create database if it does not exist
            $database_exists = $this->databaselink->query('SHOW DATABASES LIKE "'.DB_DATABASE.'";')->num_rows !=0;
            if (!$database_exists) {
                echo "Creating database ".DB_DATABASE."<br>";
                $query_create_database = "CREATE DATABASE ".DB_DATABASE.";";
                echo $query_create_database."<br>";
                if (false == $this->databaselink->query($query_create_database)) {
                    echo "Error creating the database. Please check the user priviliges!<br>";
                    printf("Error: %s\n", $this->databaselink->error);
                    exit;
                }
            }
            $this->databaselink->select_db(DB_DATABASE);
            $this->databasename=DB_DATABASE;
            $this->databaselink->query("SET SQL_MODE = '';");
            return true;
        }
    }

    public function check_permission($action, $user_role)
    {
        if (array_key_exists($action, $this->permissions)) {
            $allowed_roles = $this->permissions[$action];
            return in_array($user_role, $allowed_roles);
        } else {
            $this->error['ACTION_NOT_IN_PERMISSION_LIST'] .= "<h1>".$action."</h1><br>Action is not in permission list, therfore not allowed.";
            return false;
        }
    }

    public function set_session()
    {
        if (!isset($_SESSION['role'])) {
            $_SESSION['role'] = 0;
        }
    }

    public function logout()
    {
        $_SESSION['user_ID'] = "";
        $_SESSION['role'] = 0;
        session_destroy();
        return;
    }

    public function hash_password($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public function login($user_identification, $password)
    {
        $aUser = $this->em_get_user($user_identification, $password);
        if (isset($aUser) and $aUser) {
            if (DEBUG) {
                echo "Login successful";
                var_dump($aUser);
            }
            $_SESSION['user_ID'] = $aUser['user_ID'];
            $_SESSION['language'] = $aUser['language'];
            $_SESSION['role'] = intval($aUser['role']);
            return true;
        } else {
            if (DEBUG) {
                echo "Login failed";
            }
            $this->logout();
            return false;
        }
    }

    public function convert_admin_to_roles()
    {
        /* Converts leagacy admin property of user to role
         *
         */
        $query = 'UPDATE '.TABLE_USER.' SET role = 2 WHERE admin=1;';
        $this->databaselink->query($query);
        $query = 'UPDATE '.TABLE_USER.' SET role = 2 WHERE admin=1;';
        $this->databaselink->query($query);
    }

    public function em_check_database()
    {
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
        while ($row = $result->fetch_array(MYSQLI_BOTH)) {
            $aTable[]=$row[0];
        }
        $aData=array();
        $database_structure_path = __DIR__."/../config/db_array.inc.php";
        include($database_structure_path);
        foreach ($aData as $table=>$fields) {
            if (!in_array($table, $aTable)) {
                //Add table to database
                $mCounter=0;
                $sCommand="CREATE TABLE IF NOT EXISTS `".$table."` (";
                foreach ($fields as $fieldname=>$properties) {
                    $extra = "";
                    if ($mCounter==0) {
                        $key="KEY `".$fieldname."` (`".$fieldname."`)";
                    }
                    if ($properties["size"]!="") {
                        $size="(".$properties["size"].")";
                    } else {
                        $size="";
                    }
                    if ((isset($properties["unique"])) and ($properties['unique']==true)) {
                        $unique="UNIQUE KEY `".$fieldname."_2` (`".$fieldname."`),";
                    } else {
                        $unique="";
                    }
                    if ((isset($properties["extra"])) and ($properties != "")) {
                        $extra = $properties['extra'];
                    }
                    $sCommand .= "`".$fieldname."` ".$properties["type"].$size." ".$properties["standard"]." ".$extra.",";
                    $mCounter++;
                }
                $sCommand.=$unique.$key.") ENGINE=InnoDB ;";
                $this->last_query[]=$sCommand;
                $updateresult=$this->databaselink->query($sCommand);
            } else {
                //Felder checken und Tabelle updaten
                $resultField=$this->databaselink->query("show fields from ".DB_DATABASE.".".$table);
                while ($aRowF = $resultField->fetch_array(MYSQLI_BOTH)) {
                    $aTableFields[]=$aRowF[0];
                }
                foreach ($fields as $fieldname=>$properties) {
                    if (!in_array($fieldname, $aTableFields)) {
                        if ((isset($properties["size"]) and ($properties['size']!=""))) {
                            $size="(".$properties["size"].")";
                        } else {
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
        $this->convert_admin_to_roles();
    }

    public function password_verify_legacy($sPassword, $legacy_password_hash)
    {
        /*
        params:
            String $sPassword:
                Plaintext password
            String $legacy_password_hash:
                Password as stored by legacy password hashing function (md5(strrev(password)))
         */
        return md5(strrev($sPassword)) == $legacy_password_hash;
    }
    public function em_get_user(String $sUser, String $sPassword)
    {
        /*
        params:
            String $sUser:
                String of userinformation, either ID or E-mail is vaild
            String $sPassword:
                Plaintext password given by the user
        */
        if (isset($sUser)) {
            if (strpos($sUser, "@")>0) {
                $aFields=array("email"=>$sUser);
            } else {
                $aFields=array("user_ID"=>$sUser);
            }
            $aResult=$this->select_row(TABLE_USER, $aFields);

            if (isset($aResult['password_hash']) and $aResult['password_hash'] != "") {
                if (password_verify($sPassword, $aResult['password_hash'])) {
                    return $aResult;
                }
            } else {
                if (DEBUG) {
                    echo "Trying legacy password";
                }
                if ($this->password_verify_legacy($sPassword, $aResult['password'])) {
                    if (DEBUG) {
                        echo "Updating legacy password hash to secure password hash";
                    }
                    $oUser = new User($this);
                    $aUser = $aResult;
                    $aUser['password'] = '';
                    $aUser['password_hash'] = $this->hash_password($sPassword);
                    $oUser->save_user($aUser);
                    return $aResult;
                }
            }
        }
        return false;
    }

    public function store_data($sTable, $aFields, $sKey_ID, $mID)
    {
        //updates or inserts data
        //returns ID or -1 if fails
        $i=0;
        $returnID = 0;

        if (($mID>0) or ($mID!="") or ($mID != null)) {
            //search for it
            $aCheckFields=array($sKey_ID=>$mID);
            $aRow=$this->select_row($sTable, $aCheckFields);
            $returnID=$aRow[$sKey_ID];
        }
		var_dump($returnID);
        if (($returnID>0) and ($returnID!="")) {
            $sQuery="update ".$sTable." set ";
            foreach ($aFields as $key=>$value) {
                $sQuery.=$key."='".$value."'";
                $i++;
                if ($i<count($aFields)) {
                    $sQuery.=",";
                }
            }
            $sQuery.=" where ".$sKey_ID."='".$mID."'";
            $mDataset_ID=$returnID;
        } else {
            $sKeys = "";
            $sValues = "";
            $sQuery="insert into ".$sTable." (";
            foreach ($aFields as $sKey=>$value) {
                $sKeys.=$sKey;
                $sValues.="'".$value."'";
                $i++;
                if ($i<count($aFields)) {
                    $sKeys.=",";
                    $sValues.=",";
                }
            }
            $sQuery.=$sKeys.") values (".$sValues.")";
        }
        $this->last_query[]=$sQuery;
        if ($pResult = $this->databaselink->query($sQuery)) {
            if (($returnID>0) or ($returnID!="")) {
                return $returnID;
            } else {
                return $this->databaselink->insert_id;
            }
        } else {
            return -1;
        }
    }

    public function delete_data($sTable, $sKey_ID, $mID)
    {
        //deletes data specified by id
        //returns 1 or -2 if fails, -1 if no id is given
        if ($mID>0) {
            $sQuery="delete from ".$sTable." where ".$sKey_ID." = '".$mID."'";
            $this->last_query[]=$sQuery;
            if ($pResult = $this->databaselink->query($sQuery)) {
                return 1;
            } else {
                return -2;
            }
        } else {
            return -1;
        }
    }

    public function delete_rows($sTable, $aFields)
    {
        //deletes multiple rows from the database
        //returns 1 if ok, -1 if fails
        $i = 0;
        if ($aFields==false) {
            unset($aFields);
        }
        if (isset($aFields)) {
            foreach ($aFields as $key=>$value) {
                if ($i>0) {
                    $sConditions.=" and ";
                } else {
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

    public function select_row($sTable, $aFields)
    {
        //selects a single row from the database
        //returns array or -1
        $i = 0;
        $sConditions="";
        foreach ($aFields as $key=>$value) {
            if ($i>0) {
                $sConditions.=" and ";
            }
            $sConditions.=" ".$key."='".$value."'";
            $i++;
        }
        $sQuery="SELECT * FROM ".$sTable." WHERE".$sConditions;
        $pResult=$this->databaselink->query($sQuery);
        $this->last_query[]=$sQuery;
        $mNumber=$pResult->num_rows;
        if ($mNumber>0) {
            return $pResult->fetch_assoc();
        } else {
            return -1;
        }
    }

    public function select_rows(String $sTable, array $aFields = array(), array $aOrder = array())
    {
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
        $i = 0;
        $sConditions="";
        $sOrder = "";
        if ($aOrder==false) {
            unset($aOrder);
        }
        if ($aFields==false) {
            unset($aFields);
        }
        if (isset($aFields)) {
            foreach ($aFields as $key=>$value) {
                if ($i>0) {
                    $sConditions.=" and ";
                } else {
                    $sConditions=" WHERE";
                }
                $sConditions.=" ".$key."='".$value."'";
                $i++;
            }
        }
        $i = 0;
        if (isset($aOrder)) {
            $sOrder=" ORDER BY ";
            foreach ($aOrder as $value) {
                if ($i>0) {
                    $sOrder.=",";
                }
                $minuspos = strpos($value, "-");
                if (is_int($minuspos)) {
                    $sOrder.= " ".str_replace("-", "", $value)." DESC ";
                    $i++;
                } else {
                    $sOrder.=" ".$value;
                    $i++;
                }
            }
        }
        $sQuery = "SELECT * FROM ".$sTable.$sConditions.$sOrder;
        $this->last_query[] = $sQuery;
        return $this->databaselink->query($sQuery);
    }

    public function check_type()
    {
        if (isset($this->payload['type'])) {
            return;
        } else {
            return $this->oLang->texts['PLEASE_GIVE_TYPE'];
        }
    }

    //checks if an E-MAil Adress is already used
    public function check_email_used($email)
    {
        $aFields = array('email' => $email);
        $aResult = $this->select_row(TABLE_USER, $aFields);
        if ($aResult == -1) {
            return false;
        } else {
            return true;
        }
    }

    //returns String containing "" or an error message
    public function check_user_ID($user_ID)
    {
        if ((!isset($user_ID)) and ($user_ID=="")) {
            return $this->oLang->texts['ENTER_USER_ID'];
        } elseif (!is_numeric($user_ID)) {
            return $this->oLang->texts['GIVE_NUMBER_AS_USER_ID'];
        } else {
            return "";
        }
    }

    public function check_email($email)
    {
        if (!is_string(filter_var($email, FILTER_VALIDATE_EMAIL))) {
            $error .= $this->oLang->texts['GIVE_VALID_E_MAIL_ADRESS'];
        }
        if ($this->check_email_used()) {
            return $this->oLang->texts['E_MAIL_ALREADY_IN_USE'];
        }
    }

    public function check_password($password)
    {
        if (strlen($password)<$this->settings['mimimum_pw_length']) {
            return $this->oLang->texts['PASSWORD_TO_SHORT'];
        }
    }

    public function check_date($date)
    {
        if (!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $date)) {
            return $this->oLang->texts['ENTER_VALID_DATE_IN_FORMAT_YYYY_MM_DD'];
        }
    }

    public function check_ID_exists($ID)
    {
        if (($this->select_row(TABLE_BOOKS, array('book_ID' => $ID)) == -1) and ($this->select_row(TABLE_MATERIAL, array('material_ID' => $ID)) == -1)) {
            return $this->oLang->texts['ID_DOES_NOT_EXIST'];
        }
    }
    public function check_user_exists($user_ID)
    {
        if ($this->select_row(TABLE_USER, array('user_ID' => $user_ID)) == -1) {
            return $this->oLang->texts['USER_DOES_NOT_EXIST'];
        }
    }
    public function get_view($filename)
    {
        if (file_exists($filename)) {
            ob_start();  //startet Buffer
            include($filename);
            $output=ob_get_contents();  //Buffer wird geschrieben
        ob_end_clean();  //Buffer wird gelöscht
        return $output;
        } else {
            $output = "Could not find ".$filename."<br>";
            return $output;
        }
    }

    public function redirect($url, $statusCode = 303)
    {
        header('Location: ' . $url, true, $statusCode);
        die();
    }

    public function show_this()
    {
        //only for debugging
        echo "<pre>";
        print_r($this);
        echo"</pre>";
    }

    public function sql_statement($sQuery)
    {
        //selects multiple rows from the database
        //returns resultset
        $this->last_query[]=$sQuery;

        // return mysql_query($sQuery,$this->databaselink);
        return $this->databaselink->query($sQuery);
    }
}
