<?php
//Creating a connection
include ("db_config.php");
error_reporting(E_ERROR | E_PARSE);


 $myFirebaseUid = $_GET['sender'];
$startingLimit = $_GET['starting_limit'];
$endingLimit = $_GET['ending_limit'];



if ($_GET['api_key'] == 'com_trade_api_key') {

$sqlRoomsOfMine = "SELECT u.firebase_uid,u.first_name,u.last_name,u.online_status,u.profile_image, u.token,
r.room_id,r.room_sender_id ,r.room_reciever_id,r.last_sent
 FROM room_table 
AS r 
INNER JOIN user_table AS u 
  ON r.room_reciever_id = u.firebase_uid
 WHERE room_sender_id = :myFirebaseUid 
 ORDER BY last_sent DESC "
 ."LIMIT ".$startingLimit. ',' . $endingLimit ;



// Getting games of others
$stmtOtherGames = $con->prepare($sqlRoomsOfMine);
$stmtOtherGames->execute(array(
 'myFirebaseUid' => $myFirebaseUid
));
foreach ($stmtOtherGames as $otherGamesRow) {
$arrayotherGames[] = $otherGamesRow;
}




echo json_encode($arrayotherGames);
}

?>