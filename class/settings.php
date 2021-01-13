<?php

/*
ILMO - Intelligent Library Management Online
*/
class Setting {
	function set($path, $settings_to_change) {
	/* Replace settings with new setting_array
	*  
	* Parameters:
	* 	$path:String
	* 		Path to settings file
	* 	$settings_to_change:array
	* 		Array of settings that are to be updated
	*
	*/
		$settings = $this->load_config($path);
		foreach($settings_to_change as $key=>$value){
			$settings[$key] = $value;
        	}
		$this->save_settings($path, $settings);
	}

	function request_to_array($oObject) {
		$arr['enable_status'] = $oObject->r_enable_status;
		return $arr;
		
	}

	function load_config($path) {
		/*
		Load settings and return as array

		*/
		if(!is_readable($path)){
			$error_message = sprintf('File %s does not exist or is not readable',$path);
			error_log($error_message);
			echo($error_message);
			return False;
		}
		$settings = parse_ini_file($path);
		$this->print_setting_array($settings);
		//var_dump($settings);
		return $settings;
	}

	function print_setting_array($data) {
		$content = "";
		foreach($data as $key=>$value){
			$content .= $key."=".$value."<br>";
        	}
		echo($content);
	}

	function save_settings($path, $settings) {
	/* Write settings to a file
	*  
	* Parameters:
	* 	$path:String
	* 		Path to settings file
	* 	$settings:array
	* 		Array of settings that are to be updated
	*
	* Returns:
	* 	bool: True if successful
	*/
		/*
		$settings:array

		returns: 
			successfull:bool
			Is true if write was sucessfull
		*/
		foreach($settings as $key=>$value){
			if(is_array($value)) {
				foreach($data as $key=>$value){
					$setting_text.= $key."[] = ".$value."\n";
				}
			}
			else {
				$setting_text.= $key." = ".$value."\n";
			}
		}
		$fConfig = fopen($path, 'w');
		fwrite($fConfig, $setting_text);
		fclose($fConfig);
		return True;
	}
}

?>
