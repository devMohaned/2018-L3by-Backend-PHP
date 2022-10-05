<?php
include ("db_config.php");

 if ($_GET['api_key'] == 'com_trade_api_key') {

$file_name = $_POST['file_name'];
 $userFirebaseUid = $_POST['firebase_uid'];

$sql_update_image = "UPDATE user_table SET profile_image = :file_name WHERE firebase_uid = :userFirebaseUid";

$stmt = $con->prepare($sql_update_image);
$stmt->execute(
	array(
'userFirebaseUid' => $userFirebaseUid,
'file_name' => $file_name)
);

$con = null;
}
?>