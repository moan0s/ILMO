<?php


if (empty($lang) || !is_array($lang)) {
    $lang = array();
}

//main texts that will be shown
$lang = array_merge($lang, array(

//main texts that will be shown
    'NO_PERMISSION' => '<h1>No Permission!</h1>You don not have the permission for this action. If you think this is an mistake please inform an administrator',

    'WELCOME' => '<h1>Welcome!</h1><br>',

    'ALL_BOOKS' => 'All books',
    'ALL_MATERIAL' => 'All material',
    'OPENING_HOURS' => 'Opening hours',
    'ALL_USER' => 'All user',
    'ALL_LOAN' => 'All loan',
    'CHANGE_OPENING_HOURS' => 'Change Opening hours',
    'NEW_BOOK' => 'New book',
    'NEW_LOAN' => 'New loan',
    'NEW_MATERIAL' => 'New material',
    'NEW_USER' => 'New User',
    'SEARCH_USER' => 'Search user',
    'SHOW_BOOKS_ITEMIZED' => 'Show books itemized',
    'SHOW_MATERIAL_ITEMIZED' => 'Show material itemized',
    'SETTINGS' => 'Settings',
    'MY_PROFIL' => 'My profil',
    'MY_LOANS' => 'My loans',
    'LOGOUT' => 'Logout',

    'PLEASE_LOG_IN' => 'Please log in',
    'USER_ID_OR_EMAIL' => 'User-ID or E-Mail',
    'USER_INSTRUCTION' => '
		You can check the available books and materials, the opening hours and see your profile and your loans.<br>',
    'ADMIN_INSTRUCTION' => 'You are logged in as administrator. You have the ability to add and change users, books and materials.<br>',

    'ENGLISH' => 'English',
    'GERMAN' => 'German',
    'LANGUAGE' => 'Language',
    'CHANGE_LANGUAGE' => 'Change language',
    'CHANGED_LANGUAGE_TO' => 'Changed language to',

    'CONTACT' => 'Contact',
    'PRIVACY' => 'Privacy',
    'LINKS' => 'Links',
    'HOME' => 'Home',

    'LOAN' => 'Loan',
    //error messages
    'GIVE_NUMBER_AS_USER_ID' => 'Please give a number as user-ID.<br>',
    'GIVE_BOOK_ID' => 'Please enter a book-ID.<br>',
    'GIVE_VALID_E_MAIL_ADRESS' => 'Please enter a valid e-mail adress.<br>',
    'E_MAIL_ALREADY_IN_USE' => 'This e-mail adress is already in use. Please log into your already existing account or register with annother e-mail adress.<br>',
    'PASSWORD_TO_SHORT' => 'Your choosen password is to short. Please enter a password with more characters.<br>',
    'ENTER_BOOK_TITLE' => 'Please enter a title for the book.<br>',
    'ENTER_BOOK_AUTHOR' => 'Please enter a author for the book.<br>',
    'ENTER_LOCATION' => 'Please enter a location.<br>',
    'ENTER_VALID_DATE_IN_FORMAT_YYYY_MM_DD' => 'Please enter a valid date in the format YYYY-MM-DD.<br>',

    'BOOK_ALREADY_LOAN' => 'This book is already loan.<br>',
    'IS_ALREADY_LENT' => 'This article is already lent.',
    'ID_DOES_NOT_EXIST' => 'This ID does not exist.<br>',
    'USER_DOES_NOT_EXIST' => 'This user does not exist.<br>',
    'WRONG_PASSWORD' => 'Wrong Password.<br>',
    'ENTER_USER_IDENTIFICATION' => 'Please enter your user-ID or e-mail-adress',
    'ENTER_PASSWORD' => 'Please enter a password',
    'WRONG_LOGIN' => 'The user-ID/e-mail or your password is wrong.',
    'PLEASE_GIVE_TYPE' => 'Please give a type',
    'PASSWORDS_DO_NOT_MATCH' => 'The passwords do not match',

    'W_DAY' => 'Day',
    'W_START' => 'Start',
    'W_END' => 'End',
    'W_NOTICE' => 'Notice',

    'MONDAY' => 'Monday',
    'TUESDAY' => 'Tuesday',
    'WEDNESDAY' => 'Wednesday',
    'THURSDAY' => 'Thursday',
    'FRIDAY' => 'Friday',
    'SATURDAY' => 'Saturday',
    'SUNDAY' => 'Sunday',

    'MONDAY_SHORT' => 'Mon',
    'TUESDAY_SHORT' => 'Tue',
    'WEDNESDAY_SHORT' => 'Wed',
    'THURSDAY_SHORT' => 'Thu',
    'FRIDAY_SHORT' => 'Fri',
    'SATURDAY_SHORT' => 'Sat',
    'SUNDAY_SHORT' => 'Sun',

    'USER_ID' => 'User-ID',
    'LOAN_ID' => 'Loan-ID',
    'BOOK_ID' => 'Book-ID',
    'UID' => 'UID',
    'NUMBER' =>'Number',
    'MATERIAL_ID' => 'Material-ID',
    'TITLE' => 'Titel',
    'AUTHOR' => 'Author',
    'TITLE_MATERIAL' => 'Title/Material',
    'LOCATION' => 'Location',
    'LENT_ON' => 'Lent on',
    'RETURNED_ON' => 'Returned on',
    'ID' => 'ID',
    'SURNAME' => 'Surname',
    'FORENAME' => 'Forename',
    'USERNAME' => 'Username',
    'EMAIL' => 'E-Mail',
    'PASSWORD' => 'Password',
    'OLD_PASSWORD' => 'Old password',
    'NEW_PASSWORD' => 'New password',
    'CONFIRM_PASSWORD' => 'Confirm password',
    'FORGOT_PASSWORD' => 'Forgot password',
    'TOKEN' => 'Token',
    'TOKEN_INVALID' => 'Token is invalid',
    'STATUS_AVAILABLE' => 'Available',
    'STATUS_LENT' => 'Lent',
    'AVAILABILITY' => 'Availability',
    'ALREADY_RETURNED' => 'Already returned',
    'TOTAL' => 'Total',
    'NAME' => 'Name',
    'STATUS' => 'Status',
    'TYPE' => 'Type',

    'BOOK' => 'Book',
    'MATERIAL' => 'Material',
    'ADMIN' => 'Administrator',
    'USER' => 'User',

    'TODAYS_MAIL_STATS' => 'Todays mail statistics',
    'TOTAL_MAILS' => 'Total number of mails',
    'SUCCESSFUL_MAILS' => 'Successful mails',
    'FAILED_MAILS' => 'Failed mails',

    'BUTTON_SEND' => 'Send',
    'BUTTON_RESET' => 'Reset',
    'BUTTON_CHANGE' => 'Change',
    'BUTTON_DELETE' => 'Delete',
    'BUTTON_RETURN' => 'Return',
    'BUTTON_SHOW_LOANS' => 'Show loans',
    'BUTTON_ADD_USER' => 'Add user',
    'BUTTON_SEARCH' => 'Search',
    'BUTTON_SAVE_CHANGES' => 'Save changes',
    'BUTTON_CHANGE_PASSWORD' => 'Change password',

    'YES' => 'Yes',
    'NO' => 'No',
	
	'FABLAB' => 'Fablab',
	'NO_ACCESS' => 'No access',
	'TIMESTAMP' => 'Timestamp',
	'SHOW_ALL_access' => 'Show all acces attemps',
	'SHOW_MY_access' => 'Show my acces attemps',
	'access_ID' => 'access-ID',
	'KEY_AVAILABLE' => 'Key available'
	
	
));
