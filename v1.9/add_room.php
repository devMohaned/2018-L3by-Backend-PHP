<?php
include ("db_config.php");

 $room_id = $_POST['room_id'];
 $room_created_by = $_POST['room_created_by'];
 $room_sender_id = $_POST['room_sender_id'];
 $room_reciever_id = $_POST['room_reciever_id'];


if ($_GET['api_key'] == 'com_trade_api_key') {

// Check if already connected 
 $already_exists_query = "SELECT room_id FROM room_table WHERE 
 room_sender_id = :room_sender_id AND
 room_reciever_id = :room_reciever_id";

$sth = $con->prepare($already_exists_query);
$sth->execute(
 array(
  'room_sender_id' => $room_sender_id,
  'room_reciever_id' => $room_reciever_id
   )
);
$row = $sth->fetch(PDO::FETCH_ASSOC);

if($row)
{
    echo $row['room_id'];
}else{




// Insert a new row for the sender
 $sender_query = "INSERT INTO room_table (
 room_id,
 room_created_by,
 room_sender_id,
 room_reciever_id
 )
  VALUES (
  :room_id,
  :room_created_by,
  :room_sender_id,
  :room_reciever_id
)";

// Insert a new row for the reciever
$reciever_query = "INSERT INTO room_table (
 room_id,
 room_created_by,
 room_sender_id,
 room_reciever_id
 )
  VALUES (
  :room_id,
  :room_created_by,
  :room_sender_id,
  :room_reciever_id
)";


//  Query Sender
$sth2 = $con->prepare($sender_query);
$sth2->execute(
 array(
  'room_id' => $room_id,
  'room_created_by' => $room_created_by,
  'room_sender_id' => $room_sender_id,
  'room_reciever_id' => $room_reciever_id
   )
);


//  Query Reciever
$sth3 = $con->prepare($reciever_query);
$sth3->execute(
 array(
  'room_id' => $room_id,
  'room_created_by' => $room_created_by,
  'room_sender_id' => $room_reciever_id,
  'room_reciever_id' => $room_sender_id
   )
);

echo "inserted";
}
$con = null;

}

?>
