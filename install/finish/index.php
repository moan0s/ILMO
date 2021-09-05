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

if (isset($oData->payload['ac'])) {
    $action = $oData->payload['ac'];
} else {
    $action = "";
}

//view header
$oData->output = 'You finished the installation. Please delete the folder "install/" now from your server and then you are good to go!';
$oData->navigation = $oData->get_view(MODULE_PATH."install/views/navigation.php");
//methods


function output($oData, $action){
	if (substr($action, -3) != "bot"){
		echo $oData->get_view(MODULE_PATH."views/head.php");
		echo $oData->get_view(MODULE_PATH."views/body.php");
		if (substr($action, -5) != "plain"){
			echo $oData->get_view(MODULE_PATH."views/footer.php");
		}
	}
}
output($oData, $action);
?>
