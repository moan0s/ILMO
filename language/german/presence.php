<?php
if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

//main texts that will be shown
$lang = array_merge($lang, array(

	'STATUS_PRESENT' => "Anwesend",
	'BUTTON_CHECKOUT' => "Checkout",
	'ALREADY_CHECKED_OUT' => "Bereits ausgecheckt",
	'NEW_PRESENCE' => "Anwesenheit hinzufgen",
	'OPEN' => "Geöffnet",
	'CLOSE' => "Geschlossen",
	'CURRENT_STATUS' => "Aktueller Status",
	'SHOW_PRESENCE' => "Zeige Anwesenheiten",
	'CHECKIN_AT' => "Eingecheckt um",
	'CHECKOUT_AT' => "Ausgecheckt um"
);
?>
