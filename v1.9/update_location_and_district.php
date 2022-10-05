<?php
include ("db_config.php");


 $userFirebaseUid = $_POST['firebase_uid'];
 $userLocation = $_POST['location'];
 $district = $_POST['district'];

 if ($_GET['api_key'] == 'com_trade_api_key') {


$sql_upate_user = "UPDATE user_table SET location = :userLocation, district =:district WHERE firebase_uid = :userFirebaseUid";

$stmt = $con->prepare($sql_upate_user);
$stmt->execute(
	array('userLocation' => $userLocation,
'district' => $district,
'userFirebaseUid' => $userFirebaseUid));
    echo "Data has been added";

$con = null;
}


?>