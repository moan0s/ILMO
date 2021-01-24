<?php

/*
ILMO - Intelligent Library Management Online
 */


session_start();

//start: includes
include ("config/config.inc.php");

ini_set('display_errors', DEBUG);
ini_set('display_startup_errors', DEBUG);
error_reporting(E_ALL);
var_dump($_SESSION);
include ("class/class.php");

$oLang = new Lang;
$oObject = new Data($oLang);

if (isset($oObject->payload['ac'])) {
    $action = $oObject->payload['ac'];
}
else {
    $action = "";
}

$oObject->output = "";
$oObject->navigation = $oObject->get_view("views/navigation.php");
//methods
echo("Action ".$action."<br>");
switch ($action){
	case 'mail_send':
		$oMail = new Mail($oObject->databaselink);
		$oObject->mail_stats = $oMail->send_todays_mails();
		$oObject->output .= $oObject->get_view("views/mail_stats.php");
		break;

	case 'login':
		if ($oObject->login($oObject->payload['login_user_info'],$oObject->payload['login_password'])) {
			if ($_SESSION['admin'] == 1){
				//send mails
				$oMail = new Mail($oObject->databaselink);
				if (!$oMail->check_if_mail_send()){
					$oObject->mail_stats = $oMail->send_todays_mails();
					$oMail->set_mails_send();
					$oObject->output .= $oObject->get_view("views/mail_stats.php");
				}

			}
			$oObject->output .=  $oObject->get_view("views/start.php");
		} else{
			$oObject->error .= $oObject->oLang->texts['WRONG_PASSWORD'];
		}
		break;
	case 'logi':
		$oObject->output .=  $oObject->get_view('views/login_form.php');
		break;
	case 'logout':
		$oObject->logout();
		$oObject->output .=  $oObject->get_view('views/login_form.php');
		break;
	case 'language_change':
		$oLang = new Lang;
		$oLang->change_language($oObject->r_language);
		$oObject->output .= $oObject->get_view('views/changed_language.php');
		break;
	case 'open_change':
		if ($_SESSION['admin']==1){
		$oObject->aOpen = $oObject->get_open();
		$oObject->output .= $oObject->get_view("views/open_form.php");
		}
		else{
			$oObject->error .= $oObject->oLang->texts['NO_PERMISSION'];
		}
		break;
	case 'open_save':
		if ($_SESSION['admin']==1){
		$oObject->save_open();
		$oObject->aOpen = $oObject->get_open();
		$oObject->output .= $oObject->get_view("views/display_open.php");
		}
		else{
			$oObject->error .= $oObject->oLang->texts['NO_PERMISSION'];
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
	case 'open_show_small':
		$oObject->aOpen = $oObject->get_open();
		$oObject->output .= $oObject->get_view("views/display_open_small.php");
		break;
		case 'open_show_small_plain':
		$oObject->aOpen = $oObject->get_open();
		$oObject->output .= $oObject->get_view("views/display_open_small.php");
		break;
	case 'book_new':
		if ($_SESSION['admin']==1){
		$oObject->output .= $oObject->get_view('views/book_form.php');
		}
		else{
			$oObject->error .= $oObject->oLang->texts['NO_PERMISSION'];
		}
		break;

	case 'book_change':
		if ($_SESSION['admin']==1){
		$oObject->aRow_all = $oObject->get_book_itemized();
		$oObject->aRow = $oObject->aRow_all[$oObject->r_book_ID];
		$oObject->output = $oObject->get_view('views/book_form.php');
		}
		else{
			$oObject->error .= $oObject->oLang->texts['NO_PERMISSION'];
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
			$oObject->error .= $oObject->oLang->texts['NO_PERMISSION'];
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
			$oObject->error.= $oObject->oLang->texts['NO_PERMISSION'];
		}
		break;

	case 'material_new':
		if ($_SESSION['admin']==1){
		$oObject->output .= $oObject->get_view('views/material_form.php');
		}
		else{
			$oObject->error .= $oObject->oLang->texts['NO_PERMISSION'];
		}
		break;

	case 'material_change':
		if ($_SESSION['admin']==1){
			$oObject->aRow_all = $oObject->get_material_itemized();
			$oObject->aRow = $oObject->aRow_all[$oObject->r_material_ID];
			$oObject->output .= $oObject->get_view('views/material_form.php');
		}
		else{
			$oObject->error .= $oObject->oLang->texts['NO_PERMISSION'];
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
			$oObject->error .= $oObject->oLang->texts['NO_PERMISSION'];
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
			$oObject->error.= $oObject->oLang->texts['NO_PERMISSION'];
		}
		break;
	case 'user_new':
		if ($_SESSION['admin']==1){
		$oObject->output .= $oObject->get_view("views/user_form.php");
		}
		else{
			$oObject->error.= $oObject->oLang->texts['NO_PERMISSION'];
		}
		break;
	case 'settings_change':
		if ($_SESSION['admin']==1){
			$settings = new Setting;
			$oObject->output .= $oObject->get_view("views/settings.php");
		}
		else{
			$oObject->error.= $oObject->oLang->texts['NO_PERMISSION'];
		}
		break;
	case 'settings_save':
		if ($_SESSION['admin']==1){
			//Saving routine here
			$settings = new Setting;
			$settings_to_change = $settings->request_to_array($oObject);
			$oObject->settings = $settings->set(MODULE_PATH."config/settings.json", $settings_to_change,False);
			$oObject->output .= $oObject->get_view("views/settings.php");
		}
		else{
			$oObject->error.= $oObject->oLang->texts['NO_PERMISSION'];
		}
		break;
	case 'user_save':
		$oObject->error = "";
		if ($_SESSION['admin']==1){
			if(isset($oObject->r_user_ID)){
				$oObject->r_user_ID = (int)$oObject->r_user_ID;
				$er = $oObject->check_user_ID($oObject->r_user_ID);
			}
			if ($er != ""){
				$oObject->error .= $er;
			}
			else{
				$aUser = $oObject->create_user_array();
				$oObject->save_user($aUser);
				$oObject->aUser = $oObject->get_user(NULL, NULL, NULL, NULL, NULL, NULL);
				$oObject->output .= $oObject->get_view("views/all_user.php");
			}
		}
		else{
			$oObject->error .= $oObject->oLang->texts['NO_PERMISSION'];
		}
		break;
	case 'user_delete':
		if ($_SESSION['admin']==1){
			$oObject->delete_user();
			$oObject->aUser = $oObject->get_user(NULL, NULL, NULL, NULL, NULL, NULL);
			$oObject->output .= $oObject->get_view("views/all_user.php");
		}
		else{
			$oObject->error.= $oObject->oLang->texts['NO_PERMISSION'];
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
			$oObject->error.= $oObject->oLang->texts['NO_PERMISSION'];
		}
		break;
	case 'user_search':
		if ($_SESSION['admin']==1){
			$oObject->output .= $oObject->get_view("views/user_form.php");
		}
		else {
			$oObject->error .= $oObject->oLang->texts['NO_PERMISSION'];
		}
		break;
	case 'user_change':
		if ($_SESSION['admin']==1){
		$oObject->aRow_all = $oObject->get_user($oObject->r_user_ID, NULL, NULL, NULL, NULL, NULL);
		$oObject->aRow = $oObject->aRow_all[$oObject->r_user_ID];
		$oObject->output .= $oObject->get_view("views/user_form.php");
		}
		else{
			$oObject->error.= $oObject->oLang->texts['NO_PERMISSION'];
		}
		break;
	case 'loan_new':
		if($_SESSION['admin']==1){
		$oObject->output .= $oObject->get_view("views/loan_form.php");
		}
		else{
			$oObject->error.= $oObject->oLang->texts['NO_PERMISSION'];
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
			$oObject->error .= $oObject->oLang->texts['NO_PERMISSION'];
		}
		break;
	case 'loan_return':
		if ($_SESSION['admin']==1){
		$oObject->return_loan();
		$oObject->aLoan = $oObject->get_loan(NULL, NULL, NULL);
		$oObject->output .= $oObject->get_view("views/all_loans.php");
		}
		else{
			$oObject->error .= $oObject->oLang->texts['NO_PERMISSION'];
		}
		break;
	case 'loan_show':
		if (($_SESSION['admin']==1) or ($_SESSION['user_ID'] == $oObject->r_user_ID)){
			$oObject->aLoan = $oObject->get_loan(NULL, $oObject->r_user_ID, NULL);
			$oObject->output .= $oObject->get_view("views/all_loans.php");
		}
		else{
			$oObject->error .= $oObject->oLang->texts['NO_PERMISSION'];
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
			$oObject->error .= $oObject->oLang->texts['NO_PERMISSION'];
		}
		break;

	default:
		if ($_SESSION['role'] > 0) {
			$oObject->output .= $oObject->get_view("views/start.php");
		} else {
			$oObject->output .= $oObject->get_view("views/login_form.php");
		}
		break;


}

function output($oObject, $action){
	if (substr($action, -3) != "bot"){
		echo $oObject->get_view("views/head.php");
		echo $oObject->get_view("views/body.php");
		if (substr($action, -5) != "plain"){
			echo $oObject->get_view("views/footer.php");
		}
	}
}
output($oObject, $action);
?>
