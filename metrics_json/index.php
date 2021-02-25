<?php

/*
ILMO - Intelligent Library Management Online
 */

session_start();
header("Content-Type: application/json; charset=UTF-8");

//start: includes
include("../config/config.inc.php");
ini_set("display_errors", 1);

include(MODULE_PATH."class/class.php");

$oLang = new Lang;
$oObject = new Data($oLang);

$metrics = array();

$counts = array('user', 'loan');
foreach ($counts as &$key) {
    $q_num = "SELECT COUNT(*) FROM ".$key.";";
    $result = $oObject->sql_statement($q_num);
    $metrics[$key] = (int) mysqli_fetch_all($result)[0][0];
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
$admins = (int) mysqli_fetch_all($result)[0][0];
$metrics['admin_num'] = $admins;

$q_lent = "SELECT COUNT(*) FROM `".TABLE_BOOKS."` WHERE `lent` = 1";
$result_l = $oObject->sql_statement($q_lent);
$num_lent = (int) mysqli_fetch_all($result_l)[0][0];
$metrics['lent_books_num'] = $num_lent;
$q_available = "SELECT COUNT(*) FROM `books` WHERE `lent` = 0";
$result_a = $oObject->sql_statement($q_available);
$num_avail = (int) mysqli_fetch_all($result_a)[0][0];
$metrics['avail_books_num'] = $num_avail;

$q_lent = "SELECT COUNT(*) FROM `material` WHERE `lent` = 1";
$result_l = $oObject->sql_statement($q_lent);
$num_lent = (int) mysqli_fetch_all($result_l)[0][0];
$metrics['lent_material_num'] = $num_lent;
$q_available = "SELECT COUNT(*) FROM `material` WHERE `lent` = 0";
$result_a = $oObject->sql_statement($q_available);
$num_avail = (int) mysqli_fetch_all($result_a)[0][0];
$metrics['avail_material_num'] = $num_avail;


//var_dump($metrics);
$metrics_as_json = json_encode($metrics);
echo($metrics_as_json);
