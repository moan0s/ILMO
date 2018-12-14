<?php

/*
controller for a lending system
version 1.1
date 4.12.18
tested on php 7.2 and php 5.6.38
Database: MariaDB
 */


session_start();
//uncomment to show errors
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

//start: includes
include ("config/config.inc.php");
include ("class/class.php");

if (isset($_SESSION['language'])){
	if($_SESSION['language'] == "english"){
		include ("language/english/texts.php");
	}
	else{
		include ("language/german/texts.php");
	}
}
else {
	$_SESSION['language'] = 'german';
	include ("language/german/texts.php");
}		
$oObject = new Data();
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
elseif ($sName == 'stuf') {
	$oObject = new Stuff;
}
elseif ($sName == 'lend') {
	$oObject = new Lend;
}
elseif ($sName == 'open') {
	$oObject = new Open;
}
else{
	$oObject = new Data;
}
//view header
$oObject->output = "";
$oObject->navigation = $oObject->get_view("views/navigation.php");
//methods
switch ($oObject->r_ac){
	case 'strt':
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
			$oObject->error .= NO_PERMISSION;
		}
		break;
	case 'open_save':
		if ($_SESSION['admin']==1){	
		$oObject->save_open();
		$oObject->aOpen = $oObject->get_open();
		$oObject->output .= $oObject->get_view("views/display_open.php");
		}
		else{
			$oObject->error .= NO_PERMISSION;
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
			$oObject->error .= NO_PERMISSION;
		}
		break;
	
	case 'book_change':
		if ($_SESSION['admin']==1){	
		$oObject->aRow_all = $oObject->get_book_itemized();
		$oObject->aRow = $oObject->aRow_all[$oObject->r_book_ID];
		$oObject->output = $oObject->get_view('views/book_form.php');
		}
		else{
			$oObject->error .= NO_PERMISSION;
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
			$oObject->error .= NO_PERMISSION;
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
			$oObject->error.= NO_PERMISSION;
		}
		break;

	case 'stuff_new':
		if ($_SESSION['admin']==1){	
		$oObject->output .= $oObject->get_view('views/stuff_form.php');
		}
		else{
			$oObject->error .= NO_PERMISSION;
		}
		break;
	
	case 'stuff_change':
		if ($_SESSION['admin']==1){	
		$oObject->aRow_all = $oObject->get_stuff_itemized();
		$oObject->aRow = $oObject->aRow_all[$oObject->r_stuff_ID];
		$oObject->output = $oObject->get_view('views/stuff_form.php');
		}
		else{
			$oObject->error .= NO_PERMISSION;
		}
		break;	
	case 'stuff_save':
		if ($_SESSION['admin']==1){	
		$oObject->save_stuff();
		$oObject->r_stuff_ID = NULL;
		$oObject->aStuff = $oObject->get_stuff_itemized();
		$oObject->output .= $oObject->get_view("views/all_stuff_itemized.php");
		}
		else{
			$oObject->error .= NO_PERMISSION;
		}
		break;
	case 'stuff_show':
		$oObject->aStuff = $oObject->get_stuff();
		$oObject->output .= $oObject->get_view("views/all_stuff.php");
		break;
	case 'stuff_show_plain':
		$oObject->aStuff = $oObject->get_stuff();
		$oObject->output .= $oObject->get_view("views/all_stuff.php");

		break;
	case 'stuff_show_itemized':
		$oObject->aStuff = $oObject->get_stuff_itemized();
		$oObject->output .= $oObject->get_view("views/all_stuff_itemized.php");
		break;
	case 'stuff_delete':
		if ($_SESSION['admin']==1){	
		$oObject->delete_stuff();
		$oObject->r_stuff_ID = NULL;
		$oObject->aStuff = $oObject->get_stuff_itemized();
		$oObject->output .= $oObject->get_view("views/all_stuff_itemized.php");
		}
		else{
			$oObject->error.= NO_PERMISSION;
		}
		break;
	case 'user_new':
		if ($_SESSION['admin']==1){	
		$oObject->output .= $oObject->get_view("views/user_form.php");
		}
		else{
			$oObject->error.= NO_PERMISSION;
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
			$oObject->r_user_ID = NULL;
			$oObject->aUser = $oObject->get_user();
			$oObject->output .= $oObject->get_view("views/all_user.php");
			}
		}
		else{
			$oObject->error .= NO_PERMISSION;
		}
		break;
	case 'user_delete':
		if ($_SESSION['admin']==1){	
		$oObject->delete_user();
		$oObject->r_user_ID = NULL;
		$oObject->aUser = $oObject->get_user();
		$oObject->output .= $oObject->get_view("views/all_user.php");
		}
		else{
			$oObject->error.= NO_PERMISSION;
		}
		break;
	case 'user_self':
		$oObject->r_user_ID =$_SESSION['user_ID'];
		$oObject->aUser = $oObject->get_user();
		$oObject->output .= $oObject->get_view("views/all_user.php");
		break;
	case 'user_show':
		if ($_SESSION['admin']==1){	
		$oObject->aUser = $oObject->get_user();
		$oObject->output .= $oObject->get_view("views/all_user.php");
		}
		else{
			$oObject->error.= NO_PERMISSION;
		}
		break;
	case 'user_search':	
		if ($_SESSION['admin']==1){	
		$oObject->output .= $oObject->get_view("views/user_search.php");
		}
		else {
			$oObject->error .= NO_PERMISSION;
		}
		break;
	case 'user_change':
		if ($_SESSION['admin']==1){	
		$oObject->aRow_all = $oObject->get_user();
		$oObject->aRow = $oObject->aRow_all[$oObject->r_user_ID];
		$oObject->output .= $oObject->get_view("views/user_form.php");
		}
		else{
			$oObject->error.= NO_PERMISSION;
		}
		break;
		
	case 'lend_new':
		if ($_SESSION['admin']==1){	
		$oObject->output .= $oObject->get_view("views/lend_form.php");
		}
		else{
			$oObject->error.= NO_PERMISSION;
		}
		break;
	case 'lend_save':
		if ($_SESSION['admin']==1){	
			$error_message .= $oObject->check_ID_lend($oObject->r_ID);
			$error_message .= $oObject->check_input();
			$error_message .= $oObject->check_type();
			$error_message .= $oObject->check_ID_exists($oObject->r_ID);
			$error_message .= $oObject->check_user_exists($oObject->r_user_ID);
			if($error_message !=""){
				$oObject->error .= $error_message;
			}
			else{
				$oObject->save_lend();
				$oObject->r_lend_ID = NULL;
				$oObject->aLend = $oObject->get_lend();
				$oObject->output .= $oObject->get_view("views/all_lend.php");
			
			}
		}
		else{
			$oObject->error .= NO_PERMISSION;
		}
		break;
	case 'lend_return':
		if ($_SESSION['admin']==1){	
		$oObject->return_lend();
		$oObject->r_lend_ID = NULL;
		$oObject->r_book_ID = NULL;
		$oObject->aLend = $oObject->get_lend();
		$oObject->output .= $oObject->get_view("views/all_lend.php");
		}
		else{
			$oObject->error .= NO_PERMISSION;
		}
		break;
	case 'lend_show':
		if (($_SESSION['admin']==1) or ($_SESSION['user_ID'] == $oObject->r_user_ID)){	
		$oObject->aLend = $oObject->get_lend();
		$oObject->output .= $oObject->get_view("views/all_lend.php");
		}
		else{
			$oObject->error .= NO_PERMISSION;
		}
		break;
	case 'lend_self':
		$oObject->r_user_ID = $_SESSION['user_ID'];
		$oObject->aLend = $oObject->get_lend();
		$oObject->output .= $oObject->get_view("views/all_lend.php");
		break;
	case 'lend_change':
		if ($_SESSION['admin']==1){	
		$oObject->get_lend();
		$oObject->output .= $oObject->get_view("views/lend_form.php");
		}
		else{
			$oObject->error .= NO_PERMISSION;
		}
		break;
	default: 
		$oObject->aBook = $oObject->get_book();
		$oObject->output .= $oObject->get_view("views/all_books.php");
		break;


}

//$oObject->show_this();
echo $oObject->get_view("views/head.php");
echo $oObject->get_view("views/body.php");
if (substr($oObject->r_ac, -5) != "plain"){
	echo $oObject->get_view("views/footer.php");
}
?>
