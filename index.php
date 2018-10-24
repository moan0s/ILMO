<?php

/*
controller for a lending system
version 0.4
date 18.10.18
 */
echo "vor session start<br>";
session_start();


//tut nix 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
echo "vor includes <br>";
//start: includes
include ("config/config.inc.php");
include ("class/class.php");
echo "includes abgeschlossen, starte Session<br>";
$oObject = new Data();
$oObject->show_this();
//$oSession->set_session();
//echo "This Session";
//$oSession->show_this();
//object: parameter to clear which object
$sName = "book";
echo "book gesetzt <br>";
//echo "<br>zuerst book dann:".$_REQUEST['ac']."<br>";
echo $_REQUEST['ac'];
if (isset ($_REQUEST['ac'])){
	$sName = substr($_REQUEST['ac'],0,4);
}
echo "<br>sName:".$sName."<br>";
if($sName == 'user'){
	$oObject = new User;

}
elseif ($sName == 'book') {
	echo "vor new book<br>";
	$oObject = new Book;
	echo "New book<br>";
}
elseif ($sName == 'lend') {
	$oObject = new Lend;
}
elseif (($sName == 'logi') or ($sName == 'strt') or ($sName == 'logo')){
//	echo "<br>new Data is created<br>";
	$oObject = new Data;
	echo "New Data Object";
	$oObject->show_this();
}
if(!isset ($oObject->r_ac)){
$oObject->r_ac= null;
}
//view header
include ('views/header.php');

$oObject->show_this();
echo "Jetzt in den switchi<br>";
echo $_REQUEST['ac'];
//methods
switch ($oObject->r_ac){
	case 'strt':
		echo "Herzlich Willkommen";
		break;
	case 'logi':
		echo "Herzlich Wilkommen, bitte melde dich an";
		include('views/login_form.php');
		break;
	case 'logo':
		include('views/login_form.php');
		break;
		
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
		$oObject->set_session();
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
		$oObject->r_user_ID = NULL;
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
		$oObject->r_lend_ID = NULL;
		$oObject->aLend = $oObject->get_lend();
		include ("views/all_lend.php");
		break;
	case 'lend_return':
		$oObject->return_lend();
	//	$oBook = new Book();
	//	$oBook->return_book($oObject->r_book_ID);
		$oObject->r_lend_ID = NULL;
		$oObject->r_book_ID = NULL;
		$oObject->aLend = $oObject->get_lend();
		include ("views/all_lend.php");
		break;
	case 'lend_delete':
		$oObject->delete_lend();
	//	$oBook = new Book();
	//	$oBook->return_book($oObject->r_book_ID);
		$oObject->r_lend_ID = NULL;
		$oObject->aLend = $oObject->get_lend();
		include ("views/all_lend.php");
		break;
	case 'lend_show':

		$oObject->aLend = $oObject->get_lend();

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
