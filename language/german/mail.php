<?php

define ("YOUR_LOANS_AT_THE", "Deine Ausleihen in der");
define ("HELLO", "Hallo");
define ("YOU_HAVE_LENT", "du hast bei uns noch folgens ausgeliehen:");
define ("TITLE", "Titel");
define ("AUTHOR", "Autor");
define ("NAME", "Name");
define ("CONDITIONS_OF_LOAN", "Diese E-Mail ist nur eine Erinnerung, dass du noch etwas ausgeliehen hast.\r\n	
Du kannst die Ausleihe gerne so lange behalten wie du sie brauchst. \r\nWenn du sie aber nicht mehr brauchst bring sie bitte zeitnah zurück.");
define ("SHOW_LOANS_ONLINE", "Du kannst alle deine Ausleihen unter ".URL." einsehen. Melde dich dazu mit deiner E-Mail (an die auch diese E-Mail geht) und deinem Passwort an.");
define("GREETINGS", "Viele Grüße");
define("TEAM", "Die Lerninsel-HiWis");
define("FUTHER_INFORMATION", "Diese E-Mail wurde automatisiert erstellt und versendet. Solltest du das genannte nicht ausgeliehen haben antworte einfach kurz auf diese Mail. Wichtige Informationen findest du unter www.fs-medtech.de");

define ("MAIL_HEADER",
		'From: '.ADMIN_MAIL.'' . "\r\n" .
		'Reply-To: '.ADMIN_MAIL.'' . "\r\n" .
		'X-Mailer: PHP/' . phpversion()."\r\n".
		"Mime-Version: 1.0\r\n".
		"Content-type: text/plain; charset=utf-8");
?>
