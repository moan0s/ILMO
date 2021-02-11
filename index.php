<?php

/*
ILMO - Intelligent Library Management Online
 */


session_start();

//start: includes
include("config/config.inc.php");

ini_set('display_errors', DEBUG);
ini_set('display_startup_errors', DEBUG);
error_reporting(E_ALL);
var_dump($_SESSION);
include("class/class.php");

$oLang = new Lang;
$oData = new Data($oLang);

if (isset($oData->payload['ac'])) {
    $action = $oData->payload['ac'];
} else {
    $action = "";
}

$oData->output = "";
$oData->navigation = $oData->get_view("views/navigation.php");
//methods
echo("Action ".$action."<br>");

switch ($action) {
    case 'mail_send':
        $oMail = new Mail($oData->databaselink);
        $oData->mail_stats = $oMail->send_todays_mails();
        $oData->output .= $oData->get_view("views/mail_stats.php");
        break;

    case 'login':
        if ($oData->login($oData->payload['login_user_info'], $oData->payload['login_password'])) {
            if ($_SESSION['admin'] == 1) {
                //send mails
                $oMail = new Mail($oData->databaselink);
                if (!$oMail->check_if_mail_send()) {
                    $oData->mail_stats = $oMail->send_todays_mails();
                    $oMail->set_mails_send();
                    $oData->output .= $oData->get_view("views/mail_stats.php");
                }
            }
            $oData->output .=  $oData->get_view("views/start.php");
        } else {
            $oData->error .= $oData->oLang->texts['WRONG_PASSWORD'];
        }
        break;
    case 'logi':
        $oData->output .=  $oData->get_view('views/login_form.php');
        break;
    case 'logout':
        $oData->logout();
        $oData->output .=  $oData->get_view('views/login_form.php');
        break;
    case 'language_change':
        $oLang = new Lang;
        $oLang->change_language($oData->r_language);
        $oData->output .= $oData->get_view('views/changed_language.php');
        break;
    case 'open_change':
        if ($oData->check_permission("SAVE_OPEN", $_SESSION['role'])) {
            $oOpen = new Open($oData);
            $oData->aOpen = $oOpen->get_open();
            $oData->output .= $oData->get_view("views/open_form.php");
        }
        break;
    case 'open_save':
        if ($oData->check_permission("SAVE_OPEN", $_SESSION['role'])) {
            $oOpen = new Open($oData);
            $oOpen->save_open();
            $oData->aOpen = $oOpen->get_open();
            $oData->output .= $oData->get_view("views/display_open.php");
        }
        break;
    case 'open_show':
        $oOpen = new Open($oData);
        $oData->aOpen = $oOpen->get_open();
        $oData->output .= $oData->get_view("views/display_open.php");
        break;
    case 'open_show_plain':
        $oOpen = new Open($oData);
        $oData->aOpen = $oOpen->get_open();
        $oData->output .= $oData->get_view("views/display_open.php");
        break;
    case 'open_show_small':
        $oOpen = new Open($oData);
        $oData->aOpen = $oOpen->get_open();
        $oData->output .= $oData->get_view("views/display_open_small.php");
        break;
    case 'open_show_small_plain':
        $oOpen = new Open($oData);
        $oData->aOpen = $oOpen->get_open();
        $oData->output .= $oData->get_view("views/display_open_small.php");
        break;
    case 'book_new':
        if ($oData->check_permission("SAVE_BOOK", $_SESSION['role'])) {
            $oData->output .= $oData->get_view('views/book_form.php');
        }
        break;

    case 'book_change':
        if ($oData->check_permission("SAVE_BOOK", $_SESSION['role'])) {
            $oBook = new Book($oData);
            $oData->aRow_all = $oBook->get_book_itemized();
            $oData->aRow = $oData->aRow_all[$oData->payload['book_ID']];
            $oData->output = $oData->get_view('views/book_form.php');
        }
        break;
    case 'book_save':
        if ($oData->check_permission("SAVE_BOOK", $_SESSION['role'])) {
            $oBook = new Book($oData);
            $oBook->save_book(
                $oData->payload['book_ID'],
                $oData->payload['title'],
                $oData->payload['author'],
                $oData->payload['number'],
                $oData->payload['location']
            );
            $oData->aBook = $oBook->get_book_itemized();
            $oData->output .= $oData->get_view("views/all_books_itemized.php");
        }
        break;
    case 'book_show':
        $oBook = new Book($oData);
        $oData->aBook = $oBook->get_book();
        $oData->output .= $oData->get_view("views/all_books.php");
        break;
    case 'book_show_plain':
        $oData->aBook = $oBook->get_book();
        $oData->output .= $oData->get_view("views/all_books.php");

        break;
    case 'book_show_itemized':
        $oBook = new Book($oData);
        $oData->aBook = $oBook->get_book_itemized();
        $oData->output .= $oData->get_view("views/all_books_itemized.php");
        break;
    case 'book_delete':
        if ($oData->check_permission("SAVE_BOOK", $_SESSION['role'])) {
            $oBook = new Book($oData);
            $oBook->delete_book($oData->payload['book_ID']);
            $oData->aBook = $oBook->get_book_itemized();
            $oData->output .= $oData->get_view("views/all_books_itemized.php");
        }
        break;

    case 'material_new':
        if ($oData->check_permission("SAVE_MATERIAL", $_SESSION['role'])) {
            $oData->output .= $oData->get_view('views/material_form.php');
        }
        break;

    case 'material_change':
        if ($oData->check_permission("SAVE_MATERIAL", $_SESSION['role'])) {
            $oMaterial = new Material($oData);
            $oData->aRow_all = $oMaterial->get_material_itemized();
            $oData->aRow = $oData->aRow_all[$oData->r_material_ID];
            $oData->output .= $oData->get_view('views/material_form.php');
        }
        break;
    case 'material_save':
        if ($oData->check_permission("SAVE_MATERIAL", $_SESSION['role'])) {
            $oMaterial = new Material($oData);
            $oMaterial->save_material(
                $oData->payload['material_ID'],
                $oData->payload['name'],
                $oData->payload['number'],
                $oData->payload['location']
            );
            $oData->aMaterial = $oMaterial->get_material_itemized();
            $oData->output .= $oData->get_view("views/all_material_itemized.php");
        }
        break;
    case 'material_show':
        $oMaterial = new Material($oData);
        $oData->aMaterial = $oMaterial->get_material();
        $oData->output .= $oData->get_view("views/all_material.php");
        break;
    case 'material_show_plain':
        $oMaterial = new Material($oData);
        $oData->aMaterial = $oMaterial->get_material();
        $oData->output .= $oData->get_view("views/all_material.php");

        break;
    case 'material_show_itemized':
        $oMaterial = new Material($oData);
        $oData->aMaterial = $oMaterial->get_material_itemized();
        $oData->output .= $oData->get_view("views/all_material_itemized.php");
        break;
    case 'material_delete':
        if ($oData->check_permission("SAVE_MATERIAL", $_SESSION['role'])) {
            $oMaterial = new Material($oData);
            $oMaterial->delete_material($oData->payload['material_ID']);
            $oData->aMaterial = $oMaterial->get_material_itemized();
            $oData->output .= $oData->get_view("views/all_material_itemized.php");
        }
        break;
    case 'user_new':
        if ($oData->check_permission("SAVE_USER", $_SESSION['role'])) {
            $oData->output .= $oData->get_view("views/user_form.php");
        }
        break;
    case 'settings_change':
        if ($oData->check_permission("SAVE_SETTINGS", $_SESSION['role'])) {
            $settings = new Setting;
            $oData->output .= $oData->get_view("views/settings.php");
        }
        break;
    case 'settings_save':
        if ($oData->check_permission("SAVE_SETTINGS", $_SESSION['role'])) {
            //Saving routine here
            $settings = new Setting;
            $settings_to_change = $settings->request_to_array($oData);
            $oData->settings = $settings->set(MODULE_PATH."config/settings.json", $settings_to_change, false);
            $oData->output .= $oData->get_view("views/settings.php");
        }
        break;
    case 'user_save':
        $oData->error = "";
        if ($oData->check_permission("SAVE_USER", $_SESSION['role'])) {
            $oUser = new User($oData);
            $user_ID = $oData->payload['user_ID'];
            if ((isset($user_ID) and ($user_ID != ""))) {
                $er = $oData->check_user_ID($user_ID);
            }
            if ($er != "") {
                $oData->error .= $er;
            } else {
                $allowed_keys = array("user_ID",
                    "forename",
                    "surname",
                    "email",
                    "password",
                    "role");
                $aUser = $oUser->create_user_array($allowed_keys);
                $oUser->save_user($aUser);
                $oData->aUser = $oUser->get_user();
                $oData->output .= $oData->get_view("views/all_user.php");
            }
        }
        break;
    case 'user_delete':
        if ($oData->check_permission($action, $_SESSION['role'])) {
            $oUser = new User($oData);
            $oUser->delete_user();
            $oData->aUser = $oUser->get_user(null, null, null, null, null, null);
            $oData->output .= $oData->get_view("views/all_user.php");
        }
        break;
    case 'user_self':
        $oUser = new User($oData);
        $oData->aUser = $oUser->get_user($_SESSION['user_ID'], null, null, null, null, null);
        $oData->output .= $oData->get_view("views/all_user.php");
        break;
    case 'user_show':
        if ($oData->check_permission("SHOW_USER", $_SESSION['role'])) {
            $oUser = new User($oData);
            $oData->aUser = $oUser->get_user(
                $oData->payload['user_ID'],
                $oData->payload['forename'],
                $oData->payload['surname'],
                $oData->payload['email'],
                $oData->payload['UID'],
                $oData->payload['language']
            );
            $oData->output .= $oData->get_view("views/all_user.php");
        }
        break;
    case 'user_search':
        if ($oData->check_permission("SHOW_USER", $_SESSION['role'])) {
            $oData->output .= $oData->get_view("views/user_form.php");
        }
        break;
    case 'user_change':
        if ($oData->check_permission("SAVE_USER", $_SESSION['role'])) {
            $oUser = new User($oData);
            $oData->aRow_all = $oUser->get_user($oData->payload['user_ID']);
            $oData->aRow = $oData->aRow_all[$oData->payload['user_ID']];
            $oData->output .= $oData->get_view("views/user_form.php");
        }
        break;
    case 'loan_new':
        if ($oData->check_permission("SAVE_LOAN", $_SESSION['role'])) {
            $oData->output .= $oData->get_view("views/loan_form.php");
        }
        break;
    case 'loan_save':
        if ($oData->check_permission("SAVE_LOAN", $_SESSION['role'])) {
            $oLoan = new Loan($oData);
            //$error_message .= $oData->check_ID_loan($oData->r_ID);
            //$error_message .= $oData->check_input();
            $error_message .= $oData->check_type();
            $error_message .= $oData->check_ID_exists($oData->payload['ID']);
            $error_message .= $oData->check_user_exists($oData->payload['user_ID']);
            if ($error_message !="") {
                $oData->error .= $error_message;
            } else {
                $oLoan->save_loan(
                    $loan_ID = $oData->payload['loan_ID'],
                    $ID = $oData->payload['ID'],
                    $type = $oData->payload['type'],
                    $user_ID = $oData->payload['user_ID'],
                    $pickup_date = $oData->payload['pickup_date'],
                    $return_date = $oData->payload['return_date'],
                    $returned= $oData->payload['returned']
                );
                $oData->aLoan = $oLoan->get_loan();
                $oData->output .= $oData->get_view("views/all_loans.php");
            }
        }
        break;
    case 'loan_return':
        if ($oData->check_permission("SAVE_LOAN", $_SESSION['role'])) {
            $oLoan = new Loan($oData);
            $oLoan->return_loan($oData->payload['loan_ID']);
            $oData->aLoan = $oLoan->get_loan();
            $oData->output .= $oData->get_view("views/all_loans.php");
        }
        break;
    case 'loan_show':
        if (($oData->check_permission("SHOW_LOAN", $_SESSION['role'])) or ($_SESSION['user_ID'] == $oData->payload['user_ID'])) {
            $oLoan = new Loan($oData);
            $oData->aLoan = $oLoan->get_loan(null, $user_ID = $oData->payload['user_ID'], null, null);
            var_dump($oData->aLoan);
            $oData->output .= $oData->get_view("views/all_loans.php");
        }
        break;
    case 'loan_self':
        $oLoan = new Loan($oData);
        $oData->payload['user_ID'] = $_SESSION['user_ID'];
        $oData->aLoan = $oData->get_loan(null, $_SESSION['user_ID'], null);
        $oData->output .= $oData->get_view("views/all_loans.php");
        break;
    case 'loan_change':
        if ($oData->check_permission("SAVE_LOAN", $_SESSION['role'])) {
            $oLoan = new Loan($oData);
            $oData->aLoan = $oData->get_loan($oData->payload['loan_ID'], null, null)[$oData->payload['loan_ID']];
            $oData->output .= $oData->get_view("views/loan_form.php");
        }
        break;

    default:
        if ($_SESSION['role'] > 0) {
            $oData->output .= $oData->get_view("views/start.php");
        } else {
            $oData->output .= $oData->get_view("views/login_form.php");
        }
        break;


}

function output($oData, $action)
{
    if (substr($action, -3) != "bot") {
        echo $oData->get_view("views/head.php");
        echo $oData->get_view("views/body.php");
        if (substr($action, -5) != "plain") {
            echo $oData->get_view("views/footer.php");
        }
    }
}
output($oData, $action);
