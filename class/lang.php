<?php

class Lang
{
    public function __construct()
    {
        $this->settings = $this->get_settings();
    }
    #parses settings in an array
    #returns array
    public function get_settings()
    {
        $path = MODULE_PATH."config/settings.json";
        $fSettings= fopen($path, "r") or die("Unable to open ".$path."!");
        $sSettings =  fread($fSettings, filesize($path));
        fclose($fSettings);
        $aSettings = json_decode($sSettings, true);
        return $aSettings;
    }


    public function set_language($language = null)
    {
		
        if (isset($language) and $language != null) {
            $lang_to_use = $language;
        } else {
            $lang_to_use = $this->settings['default_language'];
        }
        include(MODULE_PATH."language/".$lang_to_use."/library_info.php");
        include(MODULE_PATH."language/".$lang_to_use."/texts.php");
        include(MODULE_PATH."language/".$lang_to_use."/presence.php");
        include(MODULE_PATH."language/".$lang_to_use."/mail.php");
        $this->library_info = $library_info;
        $this->texts = array_merge($lang, $this->settings['lang'][$lang_to_use]);
        $_SESSION['language'] = $lang_to_use;
    }
    public function change_language($language)
    {
        $this->set_language($language);
        $_SESSION['language'] = $language;
    }
}
