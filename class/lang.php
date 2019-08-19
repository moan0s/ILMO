<?php

class Lang {
	function __construct(){
		$this->settings = $this->get_settings();	
		

	}
	#parses settings in an array
	#returns array
	function get_settings(){
		return parse_ini_file(__DIR__."/../config/settings.ini");

	}


	function set_language($language = NULL){
		if(isset($language)){
			include ("language/".$language."/library_info.php");
			include ("language/".$language."/texts.php");
			include ("language/".$language."/presence.php");
			include ("language/".$language."/mail.php");
		}
		else{
			include ("language/".$this->settings['default_language']."/library_info.php");
			include ("language/".$this->settings['default_language']."/texts.php");
			include ("language/".$this->settings['default_language']."/presence.php");
			include ("language/".$this->settings['default_language']."/mail.php");
		}
	      	$this->library_info = $library_info;	
		$this->texts = $lang;
	}
	function change_language($language){
		$this->set_language($language);
		$_SESSION['language'] = $language;
	}
}

