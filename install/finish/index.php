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
$oObject->output = 'You finished the installation. Please delete the folder "install/" now from your server and then you are good to go!';
$oObject->navigation = $oObject->get_view(MODULE_PATH."install/views/navigation.php");
//methods


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
