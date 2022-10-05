<?php
include ("db_config.php");

 $online_status = $_POST['online_status'];
 $firebase_uid = $_POST['firebase_uid'];

if ($_GET['api_key'] == 'com_trade_api_key') {

 $insertion_query = "UPDATE user_table SET online_status = :online_status WHERE firebase_uid = :firebase_uid";


$sth2 = $con->prepare($insertion_query);
$sth2->execute(
	array(
		'online_status' => $online_status,
		'firebase_uid' => $firebase_uid
			)
);

$con = null;
}

?>
