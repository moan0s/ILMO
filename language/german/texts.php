<?php

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}
//main texts that will be shown
$lang = array_merge($lang, array(

	'NO_PERMISSION' => '<h1>Keine Berechtigung</h1>Du hast nicht die nötigen Rechte für diese Aktion. Wenn du denkst, dass hier ein Fehler vorliegt informiere die Administration.',

	'WELCOME' => '<h1>Herzlich Willkommen</h1><br>',

	'ALL_BOOKS' => 'Alle Bücher',
	'ALL_MATERIAL' => 'Alle Materialien',
	'OPENING_HOURS' => 'Öffnungszeiten',
	'ALL_USER' => 'Alle Benutzer*innen',
	'ALL_LOAN' => 'Alle Ausleihen',
	'CHANGE_OPENING_HOURS' => 'Öffnungszeiten ändern',
	'NEW_BOOK' => 'Neues Buch',
	'NEW_MATERIAL' => 'Neues Material',
	'NEW_USER' => 'Neue Benutzer*in',
	'NEW_LOAN' => 'Neue Ausleihe',
	'SEARCH_USER' => 'Benutzer*in suchen',
	'SHOW_BOOKS_ITEMIZED' => 'Bücher einzeln zeigen',
	'SHOW_MATERIAL_ITEMIZED' => 'Materialien einzeln zeigen',
	'MY_PROFIL' => 'Mein Profil',
	'MY_LOANS' => 'Meine Ausleihen',
	'LOGOUT' => 'Ausloggen',

	'PLEASE_LOG_IN' => 'Melde dich bitte an',
	'USER_ID_OR_EMAIL' => 'User-ID oder E-Mail',
	'USER_INSTRUCTION' => '
		Du hast jetzt die Möglichkeit dir anzusehen welche Bücher verfügbar sind und welche Bücher du ausgeliehen hast. 
		Außerdem kannst du deine Daten wie E-Mail Adresse oder Passwort zu ändern.<br>',
	'ADMIN_INSTRUCTION' => 'Du bist als Administrator angemeldet. 
		Du kannst also Bücher verleihen, neue hinzufügen und vieles mehr.<br>',

	'ENGLISH' => 'Englisch',
	'GERMAN' => 'Deutsch',
	'LANGUAGE' => 'Sprache',
	'CHANGE_LANGUAGE' => 'Sprache wechseln',
	'CHANGED_LANGUAGE_TO' => 'Sprache wurde gewechselt zu',
	'CONTACT' => 'Kontakt',
	'PRIVACY' => 'Datenschutz',
	'LINKS' => 'Links',
	'HOME' => 'Startseite',
	'LOAN' => 'Ausleihe',

	'GIVE_NUMBER_AS_USER_ID' => 'Bitte gib eine Zahl als User-ID ein.<br>',
	'GIVE_BOOK_ID' => 'Bitte gib eine Bücher-ID ein',
	'GIVE_VALID_E_MAIL_ADRESS' => 'Bitte gib eine gültige E-Mail Adresse ein',
	'E_MAIL_ALREADY_IN_USE' => 'Diese E-Mail Adresse ist bereits registriert. Bitte melde dich mit dieser an oder erstelle ein neues Konto mit einer anderen E-Mail Adresse',
	'PASSWORD_TO_SHORT' => 'Das Passwort ist zu kurz. Bitte wähle ein Passwort mit mehr als 4 Zeichen.<br>',
	'ENTER_BOOK_TITLE' => 'Bitte gib einen Titel für das Buch ein.<br>',
	'ENTER_BOOK_AUTHOR' => 'Bitte gib einen Autor des Buchs ein.<br>',
	'ENTER_LOCATION' => 'Bitte gib den Standort des Artikels an.<br>',
	'ENTER_VALID_DATE_IN_FORMAT_YYYY_MM_DD' => 'Gib bitte ein Datum im Format JJJJ-MM-TT ein.<br>',

	'BOOK_ALREADY_LOAN' => 'Dieses Buch ist bereits verliehen.<br>',
	'IS_ALREADY_LENT' => 'Der Artikel ist bereits verliehen',
	'ID_DOES_NOT_EXIST' => 'Diese ID existiert nicht.<br>',
	'USER_DOES_NOT_EXIST' => 'Diese*r Benutzer*in  existiert nicht.<br>',
	'WRONG_PASSWORD' => 'Fasches Passwort.<br>',
	'ENTER_USER_IDENTIFICATION' => 'Bitte gib deine User_ID oder deine E-Mail ein.',
	'ENTER_PASSWORD' => 'Bitte gib ein Passwort ein.',
	'WRONG_LOGIN' => 'Die eingegebene Benutzer-ID/E-Mail oder das Passwort ist falsch.',
	'PLEASE_GIVE_TYPE' => 'Bitte gib einen Typ an',

	'W_DAY' => 'Tag',
	'W_START' => 'Start',
	'W_END' => 'Ende',
	'W_NOTICE' => 'Bemerkung',

	'MONDAY' => 'Montag',
	'TUESDAY' => 'Dienstag',
	'WEDNESDAY' => 'Mittwoch',
	'THURSDAY' => 'Donnerstag',
	'FRIDAY' => 'Freitag',
	'SATURDAY' => 'Samstag',
	'SUNDAY' => 'Sonntag',
	
	'MONDAY_SHORT' => 'Mo',
	'TUESDAY_SHORT' => 'Di',
	'WEDNESDAY_SHORT' => 'Mi',
	'THURSDAY_SHORT' => 'Do',
	'FRIDAY_SHORT' => 'Fr',
	'SATURDAY_SHORT' => 'Sa',
	'SUNDAY_SHORT' => 'So',

	'USER_ID' => 'Benutzer-ID',
	'LOAN_ID' => 'Ausleih-ID',
	'BOOK_ID' => 'Buch-ID',
	'UID' => 'UID',
	'NUMBER' =>'Anzahl',
	'MATERIAL_ID' , 'Material-ID',
	'TITLE' => 'Titel',
	'AUTHOR' => 'Autor',
	'TITLE_MATERIAL' => 'Buchtitel/Gegenstand',
	'LOCATION' => 'Standort',
	'LENT_ON' => 'Ausgeliehen am',
	'RETURNED_ON' => 'Zurückgegeben am',
	'ALREADY_RETURNED' => 'Bereits zurückgegeben',
	'ID' => 'ID',
	'SURNAME' => 'Nachname',
	'FORENAME' => 'Vorname',
	'EMAIL' => 'E-Mail',
	'PASSWORD' => 'Paswort',
	'STATUS_AVAILABLE' => 'Verfügbar',
	'STATUS_LENT' => 'Verliehen',
	'AVAILABILITY' => 'Verfügbarkeit',
	'TOTAL' => 'Gesamt',
	'NAME' => 'Name',
	'STATUS' => 'Status',
	'TYPE' => 'Typ',

	'BOOK' => 'Buch',
	'MATERIAL' => 'Material',
	'ADMIN' => 'Administrator',

	'TODAYS_MAIL_STATS' => 'Heutige Mailstatistik',
	'TOTAL_MAILS' => 'Gesamtzahl der Mails',
	'SUCCESSFUL_MAILS' => 'Erfolgreich gesendete Mails',
	'FAILED_MAILS' => 'Fehlgeschlagene Sendeversuche',

	'BUTTON_SEND' => 'Absenden',
	'BUTTON_RESET' => 'Zurücksetzen',
	'BUTTON_CHANGE' => 'Ändern',
	'BUTTON_DELETE' => 'Löschen',
	'BUTTON_RETURN' => 'Zurückgeben',
	'BUTTON_SHOW_LOANS' => 'Zeige Ausleihen',
	'BUTTON_ADD_USER' =>'Benutzer*in hinzufügen',
	'BUTTON_SEARCH' => 'Suchen',
	'YES' => 'Ja',
	'NO' =>'Nein'
));
?>
