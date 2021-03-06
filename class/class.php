<?php
$install_folder = "install/";
if (is_dir($install_folder) and !strpos($_SERVER['PHP_SELF'], "install/")) {
    header('Location: install/');
}
include(MODULE_PATH."class/lang.php");
include(MODULE_PATH."class/settings.php");
include(MODULE_PATH."class/data.php");
include(MODULE_PATH."class/user.php");
include(MODULE_PATH."class/book.php");
include(MODULE_PATH."class/material.php");
include(MODULE_PATH."class/loan.php");
include(MODULE_PATH."class/open.php");

include(MODULE_PATH."class/mail.php");
include(MODULE_PATH."class/token.php");
