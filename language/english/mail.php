<?php


if (empty($lang) || !is_array($lang)) {
    $lang = array();
}

$lang = array_merge($lang, array(
    'loan_reminder_message' => "Hello &FORENAME &SURNAME,\r\n
you have still lent\r
Label: &LABEL\r
ID: &ID\r
Pickup date: &PICKUP_DATE\r
at &LIBRARY_NAME. You can keep the loan as long as you need it. If you do not need it anymore: Please return it soon.\r
Review your loans at &LIBRARY_URL.\r\r

Yours\r
&ADMIN_TEAM
\r\r
This E-Mail was automatically generated. This email will be sent to you every &MAIL_REMINDER_INTERVAL days. Feel free to contact us -just reply to this e-mail. If you don't want this service anymore answer this E-Mail and tell us",
"loan_reminder_subject" => "Reminder: Your loan &LABEL"));
