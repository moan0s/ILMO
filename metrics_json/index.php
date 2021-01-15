<?php

/*
ILMO - Intelligent Library Management Online
 */

session_start();
header("Content-Type: application/json; charset=UTF-8");

//start: includes
include ("../config/config.inc.php");
ini_set("display_errors", 0);

include (MODULE_PATH."class/class.php");

$oObject = new Data;

$metrics = array();

$counts = array('user', 'books', 'material', 'loan');
foreach ($counts as &$key) {
	$q_num = "SELECT COUNT(*) FROM ".$key.";";
	$result = $oObject->sql_statement($q_num);
	while($row = mysqli_fetch_all($result)) {
		$metrics[$key] = (int) $row[0][0];
	}
}
$q_loan_length = "SELECT DATEDIFF(return_date, pickup_date) FROM `loan` WHERE `returned` = 1";
$result = $oObject->sql_statement($q_loan_length);
$loan_lengths = array();
while ($row = mysqli_fetch_assoc($result)) {
	$loan_lengths[] = (int) $row["DATEDIFF(return_date, pickup_date)"];
}
$metrics['loan_length_mean'] = array_sum($loan_lengths)/count($loan_lengths);

$q_admins = "SELECT COUNT(*) FROM `user` WHERE `admin` = 1";
$result = $oObject->sql_statement($q_admins);
while ($row = mysqli_fetch_assoc($result)) {
	$admins = (int) $row["COUNT(*)"];
}

$metrics['admin_num'] = $admins;
//var_dump($metrics);
$metrics_as_json = json_encode($metrics);
echo($metrics_as_json);
