<?php
//Creating a connection
include ("db_config.php");
    header('Content-Type:Application/json');
$search = $_GET["firebase_uid"];
if ($_GET['api_key'] == 'com_trade_api_key') {

$stmt = $con->prepare('SELECT facebook,whatsapp,location,district FROM user_table WHERE firebase_uid = :firebase_uid');

$stmt->execute(array('firebase_uid' => $search));

foreach ($stmt as $row) {
$array[] = $row;
}
echo json_encode($array);
}

?>