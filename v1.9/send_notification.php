<?php
include ("db_config.php");

    header('Content-Type:Application/json');
 if ($_GET['api_key'] == 'com_trade_api_key') {

 define( 'API_ACCESS_KEY', 
 	/*'AAAAP8nT9Kc:APA91bHl34aOiTJ5iAvH1zxd97nGePJAOo4Hv_hdkcXPD7lXIAd68hIHdhGjpYf4AyBlEPcdxIqcaoKiXnY9UpubNW22R5R2WpvYr9fz88DYr7v_uZekheBfsTjgbx4G9GCpVrJ0MnQ-' OLD ONE */
 	'AAAA8Wp5cxA:APA91bF72XN19yaOBqM_rtva7ThN01_DXyhLbRq0FLLbut-5ObMdnPglfImq288N29BQpfJteTZMGJa-hsem5iQVhPTeYEv3_TM0pBNfMFePspOEc4Mmlhcf3xQWw8_QZRhyDSLj_0B7');

 $myToken = $_GET["token"];

 $token = array();
 
  $token[]=$myToken; 
         echo $row["token"];  

 var_dump($token);
 $title = $_POST["title"];
 $notification = $_POST["message"];
 $profile_image = $_POST["profile_image"];

 $room_id = $_POST['room_id'];
 $notification_sender_id = $_POST['notification_sender_id'];
 $notification_sender_first_name = $_POST['notification_sender_first_name'];
 $notification_sender_last_name = $_POST['notification_sender_last_name'];

$sqlGetHisOtherToken = "SELECT token FROM user_table WHERE firebase_uid = :myFirebaseUid LIMIT 1";
// Getting The Token
$stmtGetToken = $con->prepare($sqlGetHisOtherToken);
$stmtGetToken->execute(array('myFirebaseUid' => $notification_sender_id));
foreach ($stmtGetToken as $hisRealTokenRow) {
 $realToken = $hisRealTokenRow['token'];	
}

if ($profile_image != 'null') {
	$msg =
 [
    'message'   => $notification,
    'title'   => $title,
    'room_id' => $room_id,
    'notification_sender_id' => $notification_sender_id,
    'notification_sender_first_name' => $notification_sender_first_name,
    'notification_sender_last_name' => $notification_sender_last_name,
     'token' => $realToken,
     'profile_image' => $profile_image
 ];
}else{
	$msg =
 [
   'message'   => $notification,
    'title'   => $title,
    'room_id' => $room_id,
    'notification_sender_id' => $notification_sender_id,
    'notification_sender_first_name' => $notification_sender_first_name,
    'notification_sender_last_name' => $notification_sender_last_name,
    'token' => $realToken
     ];
}
 
 $fields = 
 [
 //   'registration_ids'  => $token,
    'to'  => $myToken,
    'data'      => $msg
 ];
 
 $headers = 
 [
   'Authorization: key=' . API_ACCESS_KEY,
   'Content-Type: application/json',
   'priority: 10'
 ];
 $ch = curl_init();
 curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
 curl_setopt( $ch,CURLOPT_POST, true );
 curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
 curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
 curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
 curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
 $result = curl_exec($ch );
 curl_close( $ch );
 echo $result;
}
?>