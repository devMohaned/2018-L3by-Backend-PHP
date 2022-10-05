<?php
include ("db_config.php");


 $room_id = $_POST['room_id'];
 $last_sent = $_POST['time'];


 if ($_GET['api_key'] == 'com_trade_api_key') {


$sql_update_room = "UPDATE room_table SET last_sent = :last_sent  WHERE room_id = :room_id";

$stmt = $con->prepare($sql_update_room);
$stmt->execute(
	array(
'last_sent' => $last_sent,
'room_id' => $room_id));

    echo "Data has been added";

$con = null;
}


?>