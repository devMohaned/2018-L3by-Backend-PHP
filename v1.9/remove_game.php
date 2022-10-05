<?php
include ("db_config.php");



 $flag = $_POST['flag'];
 $gameName = $_POST['game_name'];
 $gameFirebaseUid = $_POST['game_firebase_uid'];
if ($_GET['api_key'] == 'com_trade_api_key') {


$array = json_decode($gameName,true);
print_r($array);


 $deletion_query = "DELETE FROM `test_table` WHERE game_name = :gameName AND user_id = :gameFirebaseUid AND flag = :flag";

try {
    $query = $con->prepare($deletion_query);


foreach($array as $item) {
        $query->execute(
        	array(
        		'gameName' => $item['game_name']
        		, 'gameFirebaseUid' => $gameFirebaseUid,
        		'flag' => $flag));
    }
} catch (PDOException $e) {
    echo "failed";
}

$con = null;
}
?>
