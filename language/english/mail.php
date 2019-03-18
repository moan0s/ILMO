<?php

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

//main texts that will be shown
$lang = array_merge($lang, array(

	'YOUR_LOANS_AT_THE' => 'Your loans at the',
	'HELLO' => 'Hello',
	'YOU_HAVE_LENT' => 'You have loan:',
	'MAIL_TITLE' => 'Title',
	'MAIL_AUTOR' => 'Author',
	'MAIL_NAME' => 'Name',
	'CONDITIONS_OF_LOAN' => 'You can keep the loan as long as you need it. If you do not need it anymore: Please return it soon.',
	'SHOW_LOANS_ONLINE' => 'You can see all your loans at '.$library_info['URL'].'. Just login via email and your password.', 
	'GREETINGS' => 'Kind regards',
	'TEAM' => 'Team Lerninsel',
	'FUTHER_INFORMATION' => "This E-Mail was automatically generated. You can find all important information on www.fs-medtech.de
Feel free to contact us -just reply to this e-mail. 
This email will be sent to you every ".$this->settings['mail_reminder_interval']." days.
If you don't want this service anymore answer this E-Mail"
));
?>
