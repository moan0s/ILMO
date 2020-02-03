<?php

/*
ILMO - Intelligent Library Management Online
version 1.2
 */


session_start();
$_SESSION['user_ID'] = -1;
$_SESSION['admin'] = 1;

//start: includes

include ("../../config/config.inc.php");

ini_set('display_errors', DEBUG);
ini_set('display_startup_errors', DEBUG);
error_reporting(E_ALL);

include (MODULE_PATH."class/class.php");

$oObject = new Data;

//view header
$oObject->output = "";
$oObject->navigation = $oObject->get_view(MODULE_PATH."install/views/navigation.php");
//methods
switch ($oObject->r_ac){
	case 'create_standard_user':
		$oUser = new User;
		$standard_user_password = "ILMO";
		$password_hash = $oUser->hash_password($standard_user_password);
		$aUser = array("user_ID" => 0, "surname" => "", "forename" => "admin", 
		email => "ilmo_admin@hyteck.de", "password_hash" => $password_hash, 
		"language" => $oUser->settings['default_language'], 'admin' => 1);
		$oUser->save_user($aUser);
		$oObject->output .= "Created standard user. Login with user_ID: ".$aUser['user_ID'].' and the password: "'.$standard_user_password.'".<br>
							Change this password immediately! You can also create your own admin account and delete the standard account (recommended).';
		break;
	case 'user_save':
		$oUser = new User;
		$aUser = $oUser->create_user_array();
		$oUser->save_user($aUser);
		$oUser->aUser = $oUser->get_user(NULL, NULL, NULL, NULL, NULL, NULL);
		$oObject->output .= $oUser->get_view(MODULE_PATH."views/all_user.php");
		break;
	case 'language_change':
		$oLang = new Lang;
		$oLang->change_language($oObject->r_language);
		$oObject->output .= $oObject->get_view(MODULE_PATH.'views/changed_language.php');
		break;
	default: 
		$oObject->output .= $oObject->get_view(MODULE_PATH."install/create_user/views/install.php");
		break;


}

function output($oObject){
	if (substr($oObject->r_ac, -3) != "bot"){
		echo $oObject->get_view(MODULE_PATH."views/head.php");
		echo $oObject->get_view(MODULE_PATH."views/body.php");
		if (substr($oObject->r_ac, -5) != "plain"){
			echo $oObject->get_view(MODULE_PATH."views/footer.php");
		}
	}
}
output($oObject);
?>
