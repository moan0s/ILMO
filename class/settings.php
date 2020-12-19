<?php

/*
ILMO - Intelligent Library Management Online
*/
class Setting {

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

	function load_config($path) {
		$handler = fopen($path, "rb");
		$config_text = fread($handler, 20000);
		$line_array = preg_split ('/$\R?^/m', $config_text);
		foreach ($line_array as $line){
			echo $line;
		}
	}

	function save_config($config) {
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
			$key_exists = strpos($config_text, "%".$key."%");
			if ($key_existis != False) {
				$config_text = str_replace("%".$key."%",$value, $config_text);
			}
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
}

?>
