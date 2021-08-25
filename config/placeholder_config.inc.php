<?php

define ("INSTALLATION", False);
define ("DEBUG", %debug_mode%);

//database settings
define ("DB_USER", "%db_user%");
define ("DB_HOST", "localhost");
define ("DB_PW", "%db_password%");
define ("DB_DATABASE", "%db_databasename%");

//database tables:
define ("TABLE_USER", "%table_prefix%user");
define ("TABLE_BOOKS", "%table_prefix%books");
define ("TABLE_LOAN", "%table_prefix%loan");
define ("TABLE_OPEN", "%table_prefix%open");
define ("TABLE_MATERIAL", "%table_prefix%material");
define ("TABLE_LOG", "%table_prefix%log");
define ("TABLE_PRESENCE", "%table_prefix%presence");
define ("TABLE_TOKEN", "%table_prefix%token");
define ("TABLE_ACESS", "%table_prefix%acess");


define("MODULE_PATH", $_SERVER['DOCUMENT_ROOT']."%module_path%/");

function url(){
    if(isset($_SERVER['HTTPS'])){
        $protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
    }
    else{
        $protocol = 'http';
    }
    return $protocol . "://" . $_SERVER['HTTP_HOST'];
}

define("BASE_URL", url()."/%module_path%/");

?>
