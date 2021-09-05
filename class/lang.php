<?php

class Lang
{
    public function __construct()
    {
        $this->settings = Setting::get_settings();
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
        include(MODULE_PATH."language/".$lang_to_use."/settings.php");
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
