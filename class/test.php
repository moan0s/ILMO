<?php
require_once("config_php_file.php");

$config_file = "../config/config.inc.php";

$config = new config_php_file($config_file);
var_dump($config->get_all());
echo "Finished";
?>
