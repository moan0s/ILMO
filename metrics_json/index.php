<?php

/*
ILMO - Intelligent Library Management Online
 */


session_start();
header("Content-Type: application/json; charset=UTF-8");

//start: includes
include ("../config/config.inc.php");

include (MODULE_PATH."class/class.php");

$oObject = new Data;

$metrics = array();

$counts = array('user', 'books', 'material', 'loan');
foreach ($counts as &$key) {
	$q_num = "SELECT COUNT(*) FROM ".$key.";";
	$result = $oObject->sql_statement($q_num);
	while($row = mysqli_fetch_all($result)) {
		$metrics[$key] = $row[0];
	}
}
//var_dump($metrics);
$metrics_as_json = json_encode($metrics);
echo($metrics_as_json);
