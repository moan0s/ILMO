<?php

/*
ILMO - Intelligent Library Management Online
version 1.2
 */


session_start();
//uncomment to show errors

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//start: includes
include ("config/config.inc.php");
include ("class/class.php");

if (isset($_SESSION['language'])){
	if($_SESSION['language'] == "english"){
		include ("language/english/texts.php");
		include ("language/english/library_info.php");
		include ("language/english/presence.php");
	}
	else{
		include ("language/german/texts.php");
		include ("language/german/library_info.php");
		include ("language/german/presence.php");
	}
}
else {
	$_SESSION['language'] = 'german';
	include ("language/german/texts.php");
	include ("language/german/library_info.php");
	include ("language/german/presence.php");
}		
//object: parameter to clear which object
$sName = "book";
if (isset ($_REQUEST['ac'])){
	$sName = substr($_REQUEST['ac'],0,4);
}
if($sName == 'user'){
	$oObject = new User;

}
elseif ($sName == 'book') {
	$oObject = new Book;
}
elseif ($sName == 'mate') {
	$oObject = new Material;
}
elseif ($sName == 'loan') {
	$oObject = new Loan;
}
elseif ($sName == 'open') {
	$oObject = new Open;
}
elseif ($sName == 'mail') {
	$oObject = new Mail;
}
elseif ($sName == 'pres') {
	$oObject = new Presence;
}
else{
	$oObject = new Data;
}
//view header
$oObject->output = "";
$oObject->navigation = $oObject->get_view("views/navigation.php");
//methods
switch ($oObject->r_ac){
	case 'mail_send':
		$oMail = new Mail;
		$oObject->mail_stats = $oMail->send_todays_mails();
		$oObject->output .= $oObject->get_view("views/mail_stats.php");
		break;

	case 'strt':
		if ($_SESSION['admin'] == 1){
			$oMail = new Mail;
			if (!$oMail->check_if_mail_send()){
				$oObject->mail_stats = $oMail->send_todays_mails();
				$oMail->set_mails_send();
				$oObject->output .= $oObject->get_view("views/mail_stats.php");
			}

		}
		$oObject->output .=  $oObject->get_view("views/start.php");
		break;
	case 'logi':
		$oObject->output .=  $oObject->get_view('views/login_form.php');
		break;
	case 'logo':
		$oObject->output .=  $oObject->get_view('views/login_form.php');
		break;
	case 'language_change':
		$oObject->change_language($oObject->r_language);
		$oObject->output .= $oObject->get_view('views/changed_language.php');
		break;
	case 'open_change':
		if ($_SESSION['admin']==1){	
		$oObject->aOpen = $oObject->get_open();
		$oObject->output .= $oObject->get_view("views/open_form.php");
		}
		else{
			$oObject->error .= $lang['NO_PERMISSION'];
		}
		break;
	case 'open_save':
		if ($_SESSION['admin']==1){	
		$oObject->save_open();
		$oObject->aOpen = $oObject->get_open();
		$oObject->output .= $oObject->get_view("views/display_open.php");
		}
		else{
			$oObject->error .= $lang['NO_PERMISSION'];
		}
		break;
	case 'open_show':
		$oObject->aOpen = $oObject->get_open();
		$oObject->output .= $oObject->get_view("views/display_open.php");
		break;	
	case 'open_show_plain':
		$oObject->aOpen = $oObject->get_open();
		$oObject->output .= $oObject->get_view("views/display_open.php");
		break;	
	case 'book_new':
		if ($_SESSION['admin']==1){	
		$oObject->output .= $oObject->get_view('views/book_form.php');
		}
		else{
			$oObject->error .= $lang['NO_PERMISSION'];
		}
		break;
	
	case 'book_change':
		if ($_SESSION['admin']==1){	
		$oObject->aRow_all = $oObject->get_book_itemized();
		$oObject->aRow = $oObject->aRow_all[$oObject->r_book_ID];
		$oObject->output = $oObject->get_view('views/book_form.php');
		}
		else{
			$oObject->error .= $lang['NO_PERMISSION'];
		}
		break;	
	case 'book_save':
		if ($_SESSION['admin']==1){	
		$oObject->save_book();
		$oObject->r_book_ID = NULL;
		$oObject->aBook = $oObject->get_book_itemized();
		$oObject->output .= $oObject->get_view("views/all_books_itemized.php");
		}
		else{
			$oObject->error .= $lang['NO_PERMISSION'];
		}
		break;
	case 'book_show':
		$oObject->aBook = $oObject->get_book();
		$oObject->output .= $oObject->get_view("views/all_books.php");
		break;
	case 'book_show_plain':
		$oObject->aBook = $oObject->get_book();
		$oObject->output .= $oObject->get_view("views/all_books.php");

		break;
	case 'book_show_itemized':
		$oObject->aBook = $oObject->get_book_itemized();
		$oObject->output .= $oObject->get_view("views/all_books_itemized.php");
		break;
	case 'book_delete':
		if ($_SESSION['admin']==1){	
		$oObject->delete_book();
		$oObject->r_book_ID = NULL;
		$oObject->aBook = $oObject->get_book_itemized();
		$oObject->output .= $oObject->get_view("views/all_books_itemized.php");
		}
		else{
			$oObject->error.= $lang['NO_PERMISSION'];
		}
		break;

	case 'material_new':
		if ($_SESSION['admin']==1){	
		$oObject->output .= $oObject->get_view('views/material_form.php');
		}
		else{
			$oObject->error .= $lang['NO_PERMISSION'];
		}
		break;
	
	case 'material_change':
		if ($_SESSION['admin']==1){	
			$oObject->aRow_all = $oObject->get_material_itemized();
			$oObject->aRow = $oObject->aRow_all[$oObject->r_material_ID];
			$oObject->output .= $oObject->get_view('views/material_form.php');
		}
		else{
			$oObject->error .= $lang['NO_PERMISSION'];
		}
		break;	
	case 'material_save':
		if ($_SESSION['admin']==1){	
		$oObject->save_material();
		$oObject->r_material_ID = NULL;
		$oObject->aMaterial = $oObject->get_material_itemized();
		$oObject->output .= $oObject->get_view("views/all_material_itemized.php");
		}
		else{
			$oObject->error .= $lang['NO_PERMISSION'];
		}
		break;
	case 'material_show':
		$oObject->aMaterial = $oObject->get_material();
		$oObject->output .= $oObject->get_view("views/all_material.php");
		break;
	case 'material_show_plain':
		$oObject->aMaterial = $oObject->get_material();
		$oObject->output .= $oObject->get_view("views/all_material.php");

		break;
	case 'material_show_itemized':
		$oObject->aMaterial = $oObject->get_material_itemized();
		$oObject->output .= $oObject->get_view("views/all_material_itemized.php");
		break;
	case 'material_delete':
		if ($_SESSION['admin']==1){	
		$oObject->delete_material();
		$oObject->r_material_ID = NULL;
		$oObject->aMaterial = $oObject->get_material_itemized();
		$oObject->output .= $oObject->get_view("views/all_material_itemized.php");
		}
		else{
			$oObject->error.= $lang['NO_PERMISSION'];
		}
		break;
	case 'user_new':
		if ($_SESSION['admin']==1){	
		$oObject->output .= $oObject->get_view("views/user_form.php");
		}
		else{
			$oObject->error.= $lang['NO_PERMISSION'];
		}
		break;
	case 'user_save':
		if ($_SESSION['admin']==1){	
			$er = $oObject->check_input();
			if ($er != ""){
				$oObject->error .= $er;
			}
			else{
				$oObject->save_user();
				$oObject->aUser = $oObject->get_user(NULL, NULL, NULL, NULL, NULL, NULL);
				$oObject->output .= $oObject->get_view("views/all_user.php");
			}
		}
		else{
			$oObject->error .= $lang['NO_PERMISSION'];
		}
		break;
	case 'user_delete':
		if ($_SESSION['admin']==1){	
			$oObject->delete_user();
			$oObject->aUser = $oObject->get_user(NULL, NULL, NULL, NULL, NULL, NULL);
			$oObject->output .= $oObject->get_view("views/all_user.php");
		}
		else{
			$oObject->error.= $lang['NO_PERMISSION'];
		}
		break;
	case 'user_self':
		$oObject->aUser = $oObject->get_user($_SESSION['user_ID'], NULL, NULL, NULL, NULL, NULL);
		$oObject->output .= $oObject->get_view("views/all_user.php");
		break;
	case 'user_show':
		if ($_SESSION['admin']==1){	
			$oObject->aUser = $oObject->get_user($oObject->r_user_ID, $oObject->r_forename, $oObject->r_surname, $oObject->r_email, $oObject->r_UID, $oObject->r_language);
			$oObject->output .= $oObject->get_view("views/all_user.php");
		}
		else{
			$oObject->error.= $lang['NO_PERMISSION'];
		}
		break;
	case 'user_search':	
		if ($_SESSION['admin']==1){	
			$oObject->output .= $oObject->get_view("views/user_form.php");
		}
		else {
			$oObject->error .= $lang['NO_PERMISSION'];
		}
		break;
	case 'user_change':
		if ($_SESSION['admin']==1){	
		$oObject->aRow_all = $oObject->get_user($oObject->r_user_ID, NULL, NULL, NULL, NULL, NULL);
		$oObject->aRow = $oObject->aRow_all[$oObject->r_user_ID];
		$oObject->output .= $oObject->get_view("views/user_form.php");
		}
		else{
			$oObject->error.= $lang['NO_PERMISSION'];
		}
		break;
	case 'loan_new':
		if($_SESSION['admin']==1){	
		$oObject->output .= $oObject->get_view("views/loan_form.php");
		}
		else{
			$oObject->error.= $lang['NO_PERMISSION'];
		}
		break;
	case 'loan_save':
		if ($_SESSION['admin']==1){	
			//$error_message .= $oObject->check_ID_loan($oObject->r_ID);
			//$error_message .= $oObject->check_input();
			$error_message .= $oObject->check_type();
			$error_message .= $oObject->check_ID_exists($oObject->r_ID);
			$error_message .= $oObject->check_user_exists($oObject->r_user_ID);
			if($error_message !=""){
				$oObject->error .= $error_message;
			}
			else{
				$oObject->save_loan();
				$oObject->aLoan = $oObject->get_loan(NULL, NULL, NULL);
				$oObject->output .= $oObject->get_view("views/all_loans.php");
			
			}
		}
		else{
			$oObject->error .= $lang['NO_PERMISSION'];
		}
		break;
	case 'loan_return':
		if ($_SESSION['admin']==1){	
		$oObject->return_loan();
		$oObject->aLoan = $oObject->get_loan(NULL, NULL, NULL);
		$oObject->output .= $oObject->get_view("views/all_loans.php");
		}
		else{
			$oObject->error .= $lang['NO_PERMISSION'];
		}
		break;
	case 'loan_show':
		if (($_SESSION['admin']==1) or ($_SESSION['user_ID'] == $oObject->r_user_ID)){	
			$oObject->aLoan = $oObject->get_loan(NULL, $oObject->r_user_ID, NULL);
			$oObject->output .= $oObject->get_view("views/all_loans.php");
		}
		else{
			$oObject->error .= $lang['NO_PERMISSION'];
		}
		break;
	case 'loan_self':
		$oObject->r_user_ID = $_SESSION['user_ID'];
		$oObject->aLoan = $oObject->get_loan(NULL, $_SESSION['user_ID'], NULL);
		$oObject->output .= $oObject->get_view("views/all_loans.php");
		break;
	case 'loan_change':
		if ($_SESSION['admin']==1){	
			$oObject->aLoan = $oObject->get_loan($oObject->r_loan_ID, NULL, NULL)[$oObject->r_loan_ID];
			$oObject->output .= $oObject->get_view("views/loan_form.php");
		}
		else{
			$oObject->error .= $lang['NO_PERMISSION'];
		}
		break;

	case 'presence_checkin_bot':
		$oObject->set_status($oObject->r_UID, 0);
		$oObject->output_json(TRUE);
		break;
	case 'presence_checkout_bot':
		$oObject->set_status($oObject->r_UID, 1);
		$oObject->output_json(TRUE);
		break;
	case 'presence_checkout':
		if ($_SESSION['admin']==1){	
			$oObject->set_status($oObject->r_UID, 1);
			$oObject->aPresence = $oObject->get_presence();
			$oObject->output .= $oObject->get_view("views/all_present.php");
		}
		else{
			$oObject->error.= $lang['NO_PERMISSION'];
		}
		break;
	case 'get_UID_status_bot':
		$aAnswer = array();
		$oUser = new User;
		$aAnswer['registered'] = !empty($oUser->get_user(NULL, NULL, NULL, NULL, $oObject->r_UID, NULL));
		$aAnswer['present'] = $oObject->get_status($oObject->r_UID);
		//var_dump($aAnswer);
		$oObject->output_json($aAnswer);
		break;
	case 'presence_new':
		if($_SESSION['admin']==1){	
		$oObject->output .= $oObject->get_view("views/presence_form.php");
		}
		else{
			$oObject->error.= $lang['NO_PERMISSION'];
		}
		break;
	case 'presence_show_all':
		if ($_SESSION['admin']==1){	
			$oObject->aPresence = $oObject->get_presence();
			$oObject->output .= $oObject->get_view("views/all_present.php");
		}
		else{
			$oObject->error.= $lang['NO_PERMISSION'];
		}
		break;
	case 'presence_show_status':
		if ($_SESSION['admin']==1){	
			$oObject->aPresence = $oObject->get_status();
			$oObject->output .= $oObject->get_view("views/all_present.php");
		}
		else{
			$oObject->error.= $lang['NO_PERMISSION'];
		}
		break;
	case 'presence_delete':
		if ($_SESSION['admin']==1){	
			$oObject->delete_presence($oObject->r_presence_ID);
			$oObject->r_presence_ID = NULL;
			$oObject->aPresence = $oObject->get_presence();
			$oObject->output .= $oObject->get_view("views/all_present.php");
		}
		else{
			$oObject->error.= $lang['NO_PERMISSION'];
		}
		break;
	case 'presence_change':
		if ($_SESSION['admin']==1){	
			$oObject->aRow_all = $oObject->get_presence();
			$oObject->aRow = $oObject->aRow_all[$oObject->r_presence_ID];
			$oObject->output .= $oObject->get_view("views/presence_form.php");
		}
		else{
			$oObject->error.= $lang['NO_PERMISSION'];
		}
		break;

	case 'presence_save':
		if ($_SESSION['admin']==1){	
			$oObject->save_presence($oObject->r_presence_ID);
			$oObject->r_presence_ID = NULL;
			$oObject->r_UID = NULL;
			$oObject->aPresence = $oObject->get_presence();
			$oObject->output .= $oObject->get_view("views/all_present.php");
		}
		else{
			$oObject->error.= $lang['NO_PERMISSION'];
		}
		break;
	default: 
		$oObject->output .= $oObject->get_view("views/start.php");
		break;


}

//$oObject->show_oObject();
if (substr($oObject->r_ac, -3) != "bot"){
	echo $oObject->get_view("views/head.php");
	echo $oObject->get_view("views/body.php");
	if (substr($oObject->r_ac, -5) != "plain"){
		echo $oObject->get_view("views/footer.php");
	}
}
?>
