<?php

$config_path = "../config/config.inc.php";
if (file_exists($config_path)){
	include ($config_path);
	header('Location: create_user/');
}
else{
	header('Location: config/');
}
?>
