<?php
if (empty($lang) || !is_array($lang)) {
    $lang = array();
}

//main texts that will be shown
$lang = array_merge($lang, array(
    "DEFAULT_LANGUAGE" => "Standard-Sprache",
    "LOG_MAIL" => "Mails loggen? (0 für Nein, 1 für Ja)",
    "MAIL_REMINDER_INTERVAL" => "Interval für E-Mail-Erinnerungen (in Tagen)",
    "MAX_LOAN_TIME" => "Maximale Ausleihzeit (in Tagen, 0 für unbegrenzt)",
    "MINIMUM_PW_LENGTH" => "Minimale Passwordlänge",
    "MINIMUM_TOKEN_HOURS" => "Cooldown für Passwortreset-Tokengenerierung (in Stunden)",
    "PATH_MAIL_LOG" => "Pfad für das Mail-Log",
    "TIMEZONE" => "Zeitzone im Format Europe/Berlin",
	"ACCESS_KEY" => "Zutrittsschlüssel für die Zutrittskontrolle",
	"ACCESS_KEY_FEATURE" => "Aktiviere Zutrittskontrolle? (0 für Nein, 1 für Ja)"
	
));
