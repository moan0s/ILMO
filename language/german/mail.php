
<?php


if (empty($lang) || !is_array($lang)) {
    $lang = array();
}

$lang = array_merge($lang, array(
    'loan_reminder_message' => "Hallo <FORENAME <SURNAME,\r\n
du hast bei <LIBRARY_NAME noch folgendes ausgeliehen:\r\n
Name: <LABEL\r\n
ID: <ID\r\n
Pickup date: <PICKUP_DATE\r\n
\r\n
Diese E-Mail ist nur eine Erinnerung, dass du noch etwas ausgeliehen hast.
Du kannst die Ausleihe gerne so lange behalten wie du sie brauchst. Wenn du sie aber nicht mehr brauchst bring sie bitte zeitnah zurück.
Du kannst alle deine Ausleihen unter <LIBRARY_URL einsehen. Melde dich dazu mit deiner E-Mail (an die auch diese E-Mail geht) und deinem Passwort an.\r\n\r\n

Viele Grüße\r\n
<ADMIN_TEAM
\r\n\r\n
Diese E-Mail wurde automatisiert erstellt und versendet. Sie wird alle >MAIL_REMINDER_INTERVAL Tage an dich gesendet. Solltest du das genannte nicht ausgeliehen haben antworte einfach kurz auf diese Mail, ebenso solltest du diese E-Mails abbestellen wollen.",
    "loan_reminder_subject" => 'Erinnerung: Deine Ausleihe <LABEL'));
