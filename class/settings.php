<?php

/*
ILMO - Intelligent Library Management Online
*/
class Setting
{

    #parses settings in an array
    #returns array
    public static function get_settings()
    {
        $path = MODULE_PATH."config/settings.json";
        $fSettings= fopen($path, "r") or die("Unable to open ".$path."!");
        $sSettings =  fread($fSettings, filesize($path));
        fclose($fSettings);
        $aSettings = json_decode($sSettings, true);
        return $aSettings;
    }

    public function set($path, $settings_to_change, $dry_run = false)
    {
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
        $settings = array_replace_recursive($settings, $settings_to_change);
        $this->save_settings($path, $settings, $dry_run);
        return $settings;
    }

    public function request_to_array($oData)
    {
        $simple_keys = ['default_language', 'log_mail', 'max_loan_time', 'minimum_pw_length','minimum_token_hours', 'path_mail_log','timezone'];
        foreach ($simple_keys as $key) {
            $arr[$key] = $oData->payload[$key];
        }
        $arr['lang']['german']['OPENING_TIMES_INFO'] = $oData->payload['german_OPENING_TIMES_INFO'];
        $arr['lang']['english']['OPENING_TIMES_INFO'] = $oData->payload['english_OPENING_TIMES_INFO'];
        return $arr;
    }

    public function load_settings($path)
    {
        /*
        Load settings and return as array

         */
        $fSettings= fopen($path, "r") or die("Unable to open ".$path."!");
        $sSettings =  fread($fSettings, filesize($path));
        fclose($fSettings);
        $aSettings = json_decode($sSettings, true);
        return $aSettings;
    }

    public function save_settings($path, $settings, $dry_run = false)
    {
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
            $settings_text_html = str_replace("}", "}<br>", $settings_text);
            echo $settings_text_html;
        } else {
            $fConfig = fopen($path, 'w');
            $settings_text = str_replace("}", "}\r\n", $settings_text);
            $settings_text = str_replace(",", ",\r\n", $settings_text);
            fwrite($fConfig, $settings_text);
            fclose($fConfig);
        }
        return true;
    }
}
