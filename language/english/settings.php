<?php
if (empty($lang) || !is_array($lang)) {
    $lang = array();
}

//main texts that will be shown
$lang = array_merge($lang, array(
    "DEFAULT_LANGUAGE" => "Default language",
    "LOG_MAIL" => "Log mails? (0 for No, 1 for Yes)",
    "MAIL_REMINDER_INTERVAL" => "Interval for e-mail reminders (in days)",
    "MAX_LOAN_TIME" => "Maximum time of loans (in Days, 0 None)",
    "MINIMUM_PW_LENGTH" => "Minimum password length",
    "MINIMUM_TOKEN_HOURS" => "Cooldown for token generation for the password reset (in hours)",
    "PATH_MAIL_LOG" => "Path for the Mail-Log",
    "TIMEZONE" => "Timezone in the format Europe/Berlin"
));
