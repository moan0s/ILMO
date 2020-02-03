<?php

/*
ILMO - Intelligent Library Management Online
version 1.2
 */


session_start();

ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);


function config_form_to_array(){
	/*
	reads data submitted by a config form and joins it together in array
	
	returns:array
	*/
	$config = array();
	$config['db_user'] 			= $_POST['db_user'];
	$config['db_password'] 		= $_POST['db_password'];
	$config['db_databasename'] 	= $_POST['db_databasename'];
	$config['debug_mode'] 		= $_POST['debug_mode'];
	$config['table_prefix'] 	= $_POST['table_prefix'];
	$config['module_path'] 		= $_POST['module_path'];
	
	return $config;
}
function save_config($config){
	/*
	writes configuration in config file
	$config:array
	returns: 
		successfull:bool
		Is true if write was sucessfull
	*/
	$placeholder_config_file = fopen( "../../config/placeholder_config.inc.php", "rb");
	$config_text = fread($placeholder_config_file, 20000);
	foreach ($config as $key => $value){
		$config_text = str_replace("%".$key."%",$value, $config_text);
	}
	$fConfig = fopen("../../config/config.inc.php", 'w');
	fwrite($fConfig, $config_text);
	fclose($fConfig);
	return True;
}

switch ($_POST['ac']){
	case 'config_save':
		$config = config_form_to_array();
		save_config($config);
		header('Location: ../create_user');
		break;
	default: 
		include("views/settings_form.php");
		break;


}

?>
