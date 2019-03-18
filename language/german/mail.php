<?php


if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

//main texts that will be shown
$lang = array_merge($lang, array(
'YOUR_LOANS_AT_THE' => 'Deine Ausleihen in der',
'HELLO' => 'Hallo',
'YOU_HAVE_LENT' => 'du hast bei uns noch folgens ausgeliehen:',
'TITLE' => 'Titel',
'AUTHOR' => 'Autor',
'NAME' => 'Name',
'CONDITIONS_OF_LOAN' => 'Diese E-Mail ist nur eine Erinnerung, dass du noch etwas ausgeliehen hast.	
Du kannst die Ausleihe gerne so lange behalten wie du sie brauchst. Wenn du sie aber nicht mehr brauchst bring sie bitte zeitnah zurück.',
'SHOW_LOANS_ONLINE' => 'Du kannst alle deine Ausleihen unter '.$library_info['URL'].' einsehen. Melde dich dazu mit deiner E-Mail (an die auch diese E-Mail geht) und deinem Passwort an.',
'GREETINGS' => 'Viele Grüße',
'TEAM' => 'Die Lerninsel-HiWis',
'FUTHER_INFORMATION' => 'Diese E-Mail wurde automatisiert erstellt und versendet. Sie wird alle '.$this->settings['mail_reminder_interval'].' Tage an dich gesendet. Solltest du das genannte nicht ausgeliehen haben antworte einfach kurz auf diese Mail, ebenso solltest du diese E-Mails abbestellen wollen. Wichtige Informationen findest du unter www.fs-medtech.de'
));
?>
