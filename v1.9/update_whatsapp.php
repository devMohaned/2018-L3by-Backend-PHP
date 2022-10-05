<?php
include ("db_config.php");


 $userFirebaseUid = $_POST['firebase_uid'];
 $whatsapp = $_POST['whatsapp'];


 if ($_GET['api_key'] == 'com_trade_api_key') {


$sql_upate_user = "UPDATE user_table SET whatsapp = :whatsapp  WHERE firebase_uid = :userFirebaseUid";

$stmt = $con->prepare($sql_upate_user);
$stmt->execute(
	array(
'whatsapp' => $whatsapp,
'userFirebaseUid' => $userFirebaseUid));

    echo "Data has been added";

$con = null;
}


?>