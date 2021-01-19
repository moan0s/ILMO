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
		$settings = array_merge($settings, $settings_to_change);
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
		$fSettings= fopen($path, "r") or die("Unable to open ".$path."!");
		$sSettings =  fread($fSettings,filesize($path));
		fclose($fSettings);
		$aSettings = json_decode($sSettings, True);
		return $aSettings;
	}

	function save_settings($path, $settings, $dry_run = False) {
	/* Write settings as JSON to pathe
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
		$settings_text = json_encode($settings);
		if ($dry_run) {
			$settings_text_html = str_replace("}","}<br>", $settings_text);
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
