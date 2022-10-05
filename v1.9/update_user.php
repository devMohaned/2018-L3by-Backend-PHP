<?php
include ("db_config.php");


 $userFirebaseUid = $_POST['firebase_uid'];
 $userLocation = $_POST['location'];
 $firstName = $_POST['first_name'];
 $lastName = $_POST['last_name'];
 $district = $_POST['district'];

 if ($_GET['api_key'] == 'com_trade_api_key') {


$sql_upate_user = "UPDATE user_table SET location = :userLocation, first_name = :firstName, last_name = :lastName, district =:district WHERE firebase_uid = :userFirebaseUid";

$stmt = $con->prepare($sql_upate_user);
$stmt->execute(
	array('userLocation' => $userLocation,
'firstName' => $firstName,
'lastName' => $lastName,
'district' => $district,
'userFirebaseUid' => $userFirebaseUid));
    echo "Data has been added";

$con = null;
}


?>