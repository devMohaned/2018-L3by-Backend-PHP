<?php
include ("db_config.php");
header('Content-Type:Application/json');


        /*Get the id of the last visible item in the RecyclerView from the request and store it in a variable. For            the first request id will be zero.*/
$search = $_GET["search"];
$my_user_id = $_GET["firebase_uid"];
if ($_GET['api_key'] == 'com_trade_api_key') {



$myGamesSql = "SELECT * FROM test_table WHERE user_id = :user_id AND flag = 'o'";


$stmt2 = $con->prepare($myGamesSql);
$stmt2->execute(array('user_id' => $my_user_id));
foreach ($stmt2 as $row2) {
$myGamesArray[] = $row2;
$myGamesGamesArray[] = $row2['game_name'];
}




$myWishesSql = "SELECT * FROM test_table WHERE user_id = :user_id AND flag = 'w'";


$stmt3 = $con->prepare($myWishesSql);
$stmt3->execute(array('user_id' => $my_user_id));
foreach ($stmt3 as $row3) {
$myWishesArray[] = $row3;
$myWishesGamesArray[] = $row3['game_name'];
}




$sql= "SELECT * FROM test_table WHERE user_id = :search";


$stmt = $con->prepare($sql);
$stmt->execute(array('search' => $search));
foreach ($stmt as $row) {

if ($row['flag'] == 'o') {

if (in_array($row['game_name'], $myWishesGamesArray)) {

$array[] = array(
						'game_name' => $row['game_name']
						,'flag' => $row['flag']
						,'tag' => $row['tag']
						,'common_games' => true
	);	


}else{

$array[] = array(
						'game_name' => $row['game_name']
						,'flag' => $row['flag']
											,'tag' => $row['tag']
	,'common_games' => false
	);	
}

}else{
if (in_array($row['game_name'], $myGamesGamesArray)) {

$array[] = array(
						'game_name' => $row['game_name']
						,'flag' => $row['flag']
											,'tag' => $row['tag']
	,'common_games' => true
	);	
}else{

$array[] = array(
						'game_name' => $row['game_name']
						,'flag' => $row['flag']
												,'tag' => $row['tag']
,'common_games' => false
	);	
}
}

}




echo json_encode($array);
}

?>