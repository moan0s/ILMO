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
//methods
echo("Action ".$action."<br>");

switch ($action) {
    case 'mail_send':
        $oMail = new Mail($oData);
        $oData->mail_stats = $oMail->send_todays_mails();
        $oData->output .= $oData->get_view("views/mail_stats.php");
        break;

    case 'login':
        if ($oData->login($oData->payload['login_user_info'], $oData->payload['login_password'])) {
            if ($_SESSION['role'] == 2) {
                //send mails
                $oLoan = new Loan($oData);
                if (!$oLoan->check_if_mail_send()) {
                    $oData->mail_stats = $oLoan->send_todays_mails();
                    $oLoan->set_loan_mails_send();
                    $oData->output .= $oData->get_view("views/mail_stats.php");
                }
            }
            $oData->output .=  $oData->get_view("views/start.php");
        } else {
            $oData->error[] = $oData->oLang->texts['WRONG_PASSWORD'];
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
        $oLang->change_language($oData->payload['session_language']);
        $oData->oLang = $oLang;
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
            $oData->aRow = $oData->aRow_all[$oData->payload['material_ID']];
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
            $oData->output .= $oData->get_view("views/user_add.php");
        }
        break;
    case 'settings_change':
        if ($oData->check_permission("SAVE_SETTINGS", $_SESSION['role'])) {
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
        if ($oData->check_permission("SAVE_USER", $_SESSION['role'])) {
            $oUser = new User($oData);
            $user_ID = $oData->payload['user_ID'];
            if ((isset($user_ID) and ($user_ID != ""))) {
                $er = $oData->check_user_ID($user_ID);
            }
            if ($er != "") {
                $oData->error[] = $er;
            } else {
                $allowed_keys = array("user_ID",
                    "forename",
                    "surname",
                    "email",
                    "password",
                    "language",
                    "role",
					"acess");
                $aUser = $oUser->create_user_array($allowed_keys);
                $oUser->save_user($aUser);
                $oData->aUser = $oUser->get_user();
                $oData->output .= $oData->get_view("views/all_user.php");
            }
        }
        break;
    case 'self_pw_change':
        $oData->output .= $oData->get_view("views/password_change.php");
        break;
    case 'forgot_password':
        $oData->output .= $oData->get_view("views/password_forgot.php");
        break;
    case 'request_token':
        $oUser = new User($oData);
        $aUsers = $oUser->get_user(null, null, null, $oData->payload['email'], null);
        if (count($aUsers) != 1) {
            //E-Mail does not exist
            $oData-> output .= "E-Mail does not exist";
            break;
        } else {
            $aUser = array_values($aUsers)[0];
        }
        $oToken = new Token($oData);
        if ($oToken->send_store_token($aUser)) {
            $oData->output .= "Success";
        } else {
            $oData->output .= $oData->get_view("views/password_forgot.php");
        }
        break;
    case 'self_pw_save':
    //Check if user tries to change own password with old password
        if ($oData->check_permission("CHANGE_PASSWORD_SELF", $_SESSION['role'])) {
            $user_ID = $_SESSION['user_ID'];
            //Check if old password matches
            if ($oData->em_get_user($user_ID, $oData->payload['old_password'])) {
                $permission = true;
            } else {
                $oData->error[] = $oData->oLang->texts['WRONG_PASSWORD'];
            }
        }
        // Test if the user tries to change the password
        // with a token
        elseif (isset($oData->payload['token'])) {
            $token = $oData->payload['token'];
            $user_ID= $oData->payload['user_ID'];
            $oToken = new Token($oData);
            //Check if token is valid
            $token_ID = $oToken->check_token($user_ID, $token);
            if ($token_ID > 0) {
                $token_use = true;
                $permission = true;
            } else {
                $oData->error[] = $oData->oLang->texts['TOKEN_INVALID'];
                break;
            }
        } else {
            $oData->output .= "NO_PERMISSION";
        }
        if ($permission) {
            //Check if user has given the correct password
            if ($oData->payload["new_password"] == $oData->payload["confirm_password"]) {
                $oUser = new User($oData);
                $aUser['user_ID'] = $user_ID;
		$aUser['password'] = "";
		$aUser['password_hash'] = $oData->hash_password($oData->payload['new_password']);
                $oUser->save_user($aUser);

                // If a token is used to change the password we mark the token as used
                if ($token_use) {
                    $oToken->mark_token_used($token_ID);
                }
                $oData->output .= "User saved.";
            } else {
                $oData->error[] = $oData->oLang->texts['PASSWORDS_DO_NOT_MATCH'];
            }
        }
        break;
    case 'user_delete':
        if ($oData->check_permission("SAVE_USER", $_SESSION['role'])) {
            $oUser = new User($oData);
            $oUser->delete_user($oData->payload['user_ID']);
            $oData->aUser = $oUser->get_user(null, null, null, null, null, null);
            $oData->output .= $oData->get_view("views/all_user.php");
        }
        break;
    case 'user_self':
        $oUser = new User($oData);
        if ($oData->check_permission("SHOW_SELF", $_SESSION['role'])) {
            $oData->aUser = $oUser->get_user($_SESSION['user_ID'], null, null, null, null, null)[$_SESSION['user_ID']];
            $oData->output .= $oData->get_view("views/user_form.php");
        } else {
            $oData->error[] = $oData->oLang->texts['NO_PERMISSION'];
        }
        break;
    case 'user_show':
        if ($oData->check_permission("SHOW_USER", $_SESSION['role'])) {
            $oUser = new User($oData);
            $oData->aUser = $oUser->get_user(
                $oData->payload['user_ID'],
                $oData->payload['forename'],
                $oData->payload['surname'],
                $oData->payload['email'],
                $oData->payload['language'],
                $oData->payload['role']
            );
            $oData->output .= $oData->get_view("views/all_user.php");
        }
        break;
    case 'user_search':
        if ($oData->check_permission("SHOW_USER", $_SESSION['role'])) {
            $oData->output .= $oData->get_view("views/user_search.php");
        }
        break;
    case 'user_change':
        if ($oData->check_permission("SAVE_USER", $_SESSION['role'])) {
            $oUser = new User($oData);
            $oData->aRow_all = $oUser->get_user($oData->payload['user_ID']);
            $oData->aUser= $oData->aRow_all[$oData->payload['user_ID']];
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
                $oData->error[] = $error_message;
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
            $oData->aLoan = $oLoan->get_loan(
                $oData->payload['loan_ID'],
                $user_ID = $oData->payload['user_ID'],
                $oData->payload['book_ID'],
                $oData->payload['material_ID'],
                $oData->payload['returned']
            );
            var_dump($oData->aLoan);
            $oData->output .= $oData->get_view("views/all_loans.php");
        }
        break;
    case 'loan_self':
        $oLoan = new Loan($oData);
        $oData->payload['user_ID'] = $_SESSION['user_ID'];
        $oData->aLoan = $oLoan->get_loan(null, $_SESSION['user_ID'], null);
        $oData->output .= $oData->get_view("views/all_loans.php");
        break;
    case 'loan_change':
        if ($oData->check_permission("SAVE_LOAN", $_SESSION['role'])) {
            $oLoan = new Loan($oData);
            $oData->aLoan = $oLoan->get_loan($oData->payload['loan_ID'], null, null)[$oData->payload['loan_ID']];
            $oData->output .= $oData->get_view("views/loan_form.php");
        }
        break;

    case 'acess_show':	#Placeholder
        if (($oData->check_permission("SHOW_LOAN", $_SESSION['role'])) or ($_SESSION['user_ID'] == $oData->payload['user_ID'])) {
            $oLoan = new Loan($oData);
            $oData->aLoan = $oLoan->get_loan(
                $oData->payload['loan_ID'],
                $user_ID = $oData->payload['user_ID'],
                $oData->payload['book_ID'],
                $oData->payload['material_ID'],
                $oData->payload['returned']
            );
            var_dump($oData->aLoan);
            $oData->output .= $oData->get_view("views/all_loans.php");
        }
        break;
    case 'acess_self':	#Placeholder
        $oLoan = new Loan($oData);
        $oData->payload['user_ID'] = $_SESSION['user_ID'];
        $oData->aLoan = $oLoan->get_loan(null, $_SESSION['user_ID'], null);
        $oData->output .= $oData->get_view("views/all_loans.php");
        break;
    default:
        if ($_SESSION['role'] > 0) {
            $oData->output .= $oData->get_view("views/start.php");
        } else {
            $oData->output .= $oData->get_view("views/login_form.php");
        }
        break;


}

$oData->navigation = $oData->get_view("views/navigation.php");
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
