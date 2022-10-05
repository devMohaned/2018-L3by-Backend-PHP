<?php
include ("db_config.php");

 $game_name = $_POST['game_name'];
 $game_firebase_uid = $_POST['game_firebase_uid'];

if ($_GET['api_key'] == 'com_trade_api_key') {

$arrayxx = json_decode($game_name,true);

 print_r($arrayxx);

foreach($arrayxx as $item) {


$selection_query = "SELECT game_name FROM test_table WHERE game_name = :game_name AND user_id = :game_firebase_uid AND flag = :flag";

$sth = $con->prepare($selection_query);

$sth->execute(
    array(
        'game_name' => $item['game_name'],
        'game_firebase_uid' => $game_firebase_uid,
        'flag'=> $item['flag']
            )
);


$result = $sth->fetch(PDO::FETCH_ASSOC);
if ($result) {
    
$sql = 
"UPDATE test_table SET tag = :tag WHERE game_name = :game_name AND user_id = :user_id AND flag = :flag";

$stmt = $con->prepare ($sql);
    $stmt->execute(array(
        'game_name' => $item['game_name'],
        'user_id' => $game_firebase_uid,
        'flag'=> $item['flag'],
        'tag' => $item['tag']
            )
);

}

}

$con = null;

}


?>
