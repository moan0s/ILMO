<?php
#check if installation is complete
if file_exists("../config/config.inc.php"){
    $settings = parse_ini_file("../config/settings.ini");
    if ($settings['log_mail'] != 0){
	fopen($mail_log_file, $settings['path_mail_log'],"r");
	fread($mail_log_file);
	fclose($mail_log_file);
    }
    echo "version = ".$settings['version'];
}

?>
