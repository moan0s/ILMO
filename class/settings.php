<?php

/*
ILMO - Intelligent Library Management Online
*/
class Setting {
	function set($path, $settings_to_change, $dry_run = False) {
	/* Replace settings with new setting_array
	*  
	* Parameters:
	* 	$path:String
	* 		Path to settings file
	* 	$settings_to_change:array
	* 		Array of settings that are to be updated
	* 	$dry_run:bool
	* 		If true prints settings text, does not write to file
	*
	*/
		$settings = $this->load_settings($path);
		foreach($settings_to_change as $key=>$value){
			$settings[$key] = $value;
        	}
		$this->save_settings($path, $settings, $dry_run);
		return $settings;
	}

	function request_to_array($oObject) {
		$arr['enable_status'] = $oObject->r_enable_status;
		return $arr;
		
	}

	function load_settings($path) {
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
		return $settings;
	}

	function print_setting_array($data) {
		$content = "";
		foreach($data as $key=>$value){
			$content .= $key."=".$value."<br>";
        	}
		echo($content);
	}

	function save_settings($path, $settings, $dry_run = False) {
	/* Write settings to a file
	*  
	* Parameters:
	* 	$path:String
	* 		Path to settings file
	* 	$settings:array
	* 		Array of settings that are to be updated
	* 	$dry_run:bool
	* 		If true prints settings text, does not write to file
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
		$settings_text = "";
		foreach($settings as $key=>$value){
			if(is_array($value)) {
				foreach($data as $key=>$value){
					$setting_text.= $key."[] = ".$value."\n";
				}
			}
			else {
				$settings_text.= $key." = ".$value."\n";
			}
		}
		if ($dry_run) {
			$settings_text_html = str_replace("\n","<br>", $settings_text);
			echo $settings_text_html;
		}
		else {
			$fConfig = fopen($path, 'w');
			fwrite($fConfig, $settings_text);
			fclose($fConfig);
		}
		return True;
	}
}

?>
