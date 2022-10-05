<?php
//Creating a connection
include ("db_config.php");
error_reporting(E_ERROR | E_PARSE);
header('Content-Type:Application/json');
$firebase_uid = $_GET["firebase_uid"];
$token = $_GET['token'];
//echo "Test 1";
if ($_GET['api_key'] == 'com_trade_api_key') {

$stmt2 = $con->prepare('UPDATE user_table SET token = :token WHERE firebase_uid = :firebase_uid');

$stmt2->execute(
	array('firebase_uid' => $firebase_uid,
'token' => $token));

					
$array[] = array(
	'name' => 'done'
						);

echo json_encode($array);

}

  
?>