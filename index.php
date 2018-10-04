<?php

/*
controller for a lending system
version 0.3
date 02.10.18
 */

//tut nix 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//start: includes
include ("config/config.inc.php");
include ("class/class.php");

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
elseif ($sName == 'lend') {
	$oObject = new Lend;
}
if(!isset ($oObject->r_ac)){
$oObject->r_ac= null;
}
//view header
include ('views/header.php');

//methods
switch ($oObject->r_ac){
	case 'book_new':
		include ('views/book_form.php');
		break;
	
	case 'book_change':
		$oObject->aRow_all = $oObject->get_book();
		$oObject->aRow = $oObject->aRow_all[$oObject->r_book_ID];
		include ('views/book_form.php');
		break;	
	case 'book_save':
		$oObject->save_book();
		$oObject->r_book_ID = NULL;
		$oObject->aBook = $oObject->get_book();
		include ("views/all_books.php");
		break;
	case 'book_show':
		$oObject->aBook = $oObject->get_book();
		include ("views/all_books.php");
		break;
	case 'book_delete':
		$oObject->delete_book();
		$oObject->r_book_ID = NULL;
		$oObject->aBook = $oObject->get_book();
		include ("views/all_books.php");
		break;
	case 'user_new':
		include ("views/user_form.php");
		break;
	case 'user_save':
		$oObject->save_user();
		$oObject->r_book_ID = NULL;
		$oObject->aUser = $oObject->get_user();
		include ("views/all_user.php");
		break;
	case 'user_delete':
		$oObject->delete_user();
		$oObject->r_user_ID = NULL;
		$oObject->aUser = $oObject->get_user();
		include ("views/all_user.php");
		break;
	case 'user_show':
		$oObject->aUser = $oObject->get_user();
		include ("views/all_user.php");
		break;
	case 'user_search':	
		include ("views/user_search.php");
		break;
	case 'user_change':
	
		$oObject->aRow_all = $oObject->get_user();
		$oObject->aRow = $oObject->aRow_all[$oObject->r_user_ID];
		include ("views/user_form.php");
		break;
		
	case 'lend_new':
		include ("views/lend_form.php");
		break;
	case 'lend_save':
		$oObject->save_lend();
		$oObject->get_lend();
		include ("views/all_lend.php");
		break;
	case 'lend_delete':
		$oObject->delete_lend();
		$oObject->get_lend();
		include ("views/all_lend.php");
		break;
	case 'lend_show':
		$oObject->get_lend();
		include ("views/all_lend.php");
		break;
	case 'lend_change':
		$oObject->get_lend();
		include ("views/lend_form.php");
		break;
	default: 
		$oObject->aBook = $oObject->get_book();
		include ("views/all_books.php");
		break;


}

//$oObject->show_this();


?>
