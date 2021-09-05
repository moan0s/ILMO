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


$oLang = new Lang;
$oData = new Data($oLang);
$oUser = new User($oData);


if (isset($oData->payload['ac'])) {
    $action = $oData->payload['ac'];
} else {
    $action = "";
}

//view header
$oData->output = "";
$oData->navigation = $oData->get_view(MODULE_PATH."install/views/navigation.php");
//methods
switch ($action){
	case 'user_save':
		$aUser = $oUser->create_user_array($oData);
		$oUser->save_user($aUser);
		$oUser->aUser = $oUser->get_user(NULL, NULL, NULL, NULL, NULL, NULL);
		$oData->output .= 'You now have user in your database. You can <a href="'.BASE_URL.'/install/create_user/"> continue </a> adding user or you can ';
		$oData->output .= '<a href="'.BASE_URL.'/install/finish"> finish </a>';
		$oData->output .= $oData->get_view(MODULE_PATH."views/all_user.php");
		break;
	case 'language_change':
		$oLang = new Lang;
		$oLang->change_language($oUser->r_language);
		$oData->output .= $oData->get_view(MODULE_PATH.'views/changed_language.php');
		break;
	default:
		if ($oUser->get_user() != NULL and count($oUser->get_user())>0){
			$oData->output .= 'You already have user in your database. Please ';
			$oData->output .= '<a href="'.BASE_URL.'/install/finish"> finish </a> the installation.<br>';
		}
		else {
			$standard_user_password = "ILMO";
			$password_hash = $oData->hash_password($standard_user_password);
			$aUser = array("user_ID" => 0, "surname" => "", "forename" => "admin", 
			"email" => "ilmo_admin@hyteck.de", "password_hash" => $password_hash, 
			"language" => $oUser->settings['default_language'], 'admin' => 1);
			$oUser->save_user($aUser);
			$oData->output .= "Created standard user. Login with user_ID: ".$aUser['user_ID'].' and the password: "'.$standard_user_password.'".<br>
							Please create your own admin account and delete the standard account.';
			$oData->output .= '<a href="'.BASE_URL.'/install/finish">Finish </a> the installation.<br>';
		}
		break;


}

function output($oData, $action)
{
    if (substr($action, -3) != "bot") {
        echo $oData->get_view(MODULE_PATH."views/head.php");
        echo $oData->get_view(MODULE_PATH."views/body.php");
        if (substr($action, -5) != "plain") {
            echo $oData->get_view(MODULE_PATH."views/footer.php");
        }
    }
}

output($oData, $action);
?>
