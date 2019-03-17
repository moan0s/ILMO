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
	'SHOW_LOANS_ONLINE' => 'You can see all your loans at '.URL.'. Just login via email and your password.', 
	'GREETINGS' => 'Kind regards',
	'TEAM' => 'Team Lerninsel',
	'FUTHER_INFORMATION' => 'This E-Mail was automatically generated.\r\n You can find all important information on www.fs-medtech.de\r\n
	Feel free to contact us -just reply to this e-mail.\r\n
	This email will be sent to you every month.',

	'MAIL_HEADER' =>
			'From: '.ADMIN_MAIL.'' . '\r\n' .
			'Reply-To: '.ADMIN_MAIL.'' . '\r\n' .
			'X-Mailer: PHP/' . phpversion().'\r\n'.
			'Mime-Version: 1.0\r\n'.
			'Content-type: text/plain; charset=utf-8'
	);
?>
