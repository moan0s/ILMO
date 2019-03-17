<?php




if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

//main texts that will be shown
$lang = array_merge($lang, array(

'STATUS_PRESENT' => 'Present',
'BUTTON_CHECKOUT' => 'Checkout',
'ALREADY_CHECKED_OUT' => 'Already checked out',
'NEW_PRESENCE' => 'New presence',
'OPEN' => 'Open',
'CLOSE' => 'Close',
'CURRENT_STATUS' => 'Current Status',
'SHOW_PRESENCE' => 'Show Presences',
'CHECKIN_AT' => 'Checkin at',
'CHECKOUT_AT' => 'Checkout at'
));

?>
