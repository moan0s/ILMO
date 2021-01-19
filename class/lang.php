<?php

class Lang {
	function __construct(){
		$this->settings = $this->get_settings();
	}
	#parses settings in an array
	#returns array
	function get_settings(){
		$path = MODULE_PATH."config/settings.json";
		$fSettings= fopen($path, "r") or die("Unable to open ".$path."!");
		$sSettings =  fread($fSettings,filesize($path));
		fclose($fSettings);
		$aSettings = json_decode($sSettings, True);
		return $aSettings;

	}


	function set_language($language = NULL){
		if(isset($language)){
			include (MODULE_PATH."language/".$language."/library_info.php");
			include (MODULE_PATH."language/".$language."/texts.php");
			include (MODULE_PATH."language/".$language."/presence.php");
			include (MODULE_PATH."language/".$language."/mail.php");
		}
		else{
			include (MODULE_PATH."language/".$this->settings['default_language']."/library_info.php");
			include (MODULE_PATH."language/".$this->settings['default_language']."/texts.php");
			include (MODULE_PATH."language/".$this->settings['default_language']."/presence.php");
			include (MODULE_PATH."language/".$this->settings['default_language']."/mail.php");
		}
	      	$this->library_info = $library_info;	
		$this->texts = $lang;
	}
	function change_language($language){
		$this->set_language($language);
		$_SESSION['language'] = $language;
	}
}

