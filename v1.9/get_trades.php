<?php
//Creating a connection
include ("db_config.php");
error_reporting(E_ERROR | E_PARSE);
header('Content-Type:Application/json');


 $myFirebaseUid = $_GET['search'];
 $location = $_GET['location'];
 $district = $_GET['district'];
$platform = $_GET['platform'];
$startingLimit = $_GET['starting_limit'];
$endingLimit = $_GET['ending_limit'];

$commonCount = 0;

if ($_GET['api_key'] == 'com_trade_api_key') {


$sqlMyWishes = "SELECT game_name, user_id FROM test_table WHERE user_id = :myFirebaseUid AND flag = 'w'";
$sqlMyGames = "SELECT game_name, user_id FROM test_table WHERE user_id = :myFirebaseUid AND flag = 'o'";


// Getting My Wishes Into Array
$stmtMyWishes = $con->prepare($sqlMyWishes);
$stmtMyWishes->execute(array('myFirebaseUid' => $myFirebaseUid));
foreach ($stmtMyWishes as $myWishesRow) {
$arrayMyWishes[] =
array('game_name' => $myWishesRow['game_name']);	
}

// Getting My Games Into Array
$stmtMyGames = $con->prepare($sqlMyGames);
$stmtMyGames->execute(array('myFirebaseUid' => $myFirebaseUid));
foreach ($stmtMyGames as $myGamesRow) {
$arrayMyGames[] =
array('game_name' => $myGamesRow['game_name']);	
}




if ($district == "null") {

$sqlGetUsers = "SELECT name,first_name,last_name,location,district,profile_image,token,firebase_uid,online_status FROM user_table WHERE firebase_uid != :myFirebaseUid AND location = :location AND platform = :platform AND token IS NOT NULL ORDER BY last_active DESC LIMIT ".$startingLimit. ',' . $endingLimit ;

// Getting games of others
$stmtGetUsers = $con->prepare($sqlGetUsers);
$stmtGetUsers->execute(array(
	'myFirebaseUid' => $myFirebaseUid,
	'location' => $location,
	'platform' => $platform
));
foreach ($stmtGetUsers as $userRow) {


// GET GAMES OF USERS
$sqlGetUserGameList = "SELECT game_name,flag,tag FROM test_table WHERE user_id = :user_id";

$stmtGetGameList = $con->prepare($sqlGetUserGameList);
$stmtGetGameList->execute(array(
	'user_id' => $userRow['firebase_uid']
));


foreach ($stmtGetGameList as $gameRow) {
if ($gameRow['flag'] == 'o') {
	$gamesArray[] = array(
						'game_name' => $gameRow['game_name']
						, 'flag' => $gameRow['flag']
						,'tag' => $gameRow['tag']);	

}else{
	$wishesArray[] =
	array(
						'game_name' => $gameRow['game_name']
						, 'flag' => $gameRow['flag']
					,'tag' => $gameRow['tag']);	
}

}

if (count($gamesArray) > 0) {

for ($i=0; $i <count($arrayMyWishes) ; $i++) { 
for ($j=0; $j <count($gamesArray) ; $j++) { 
		if ($gamesArray[$j]['game_name'] == $arrayMyWishes[$i]['game_name']) {
			 $commonGames[] = array('game_name' => $arrayMyWishes[$i]['game_name']);	
			 $commonCount++;
		}
	}
}



for ($i=0; $i <count($arrayMyGames) ; $i++) { 
for ($j=0; $j <count($wishesArray) ; $j++) { 
		if ($wishesArray[$j]['game_name'] == $arrayMyGames[$i]['game_name']) {
			 $commonWishes[] = array('game_name' => $arrayMyGames[$i]['game_name']);	
				 $commonCount++;
	}
	}
}


$arrayOfMyWishesWithGamesOfOthers[] = array(
						'my_user_id' => $myFirebaseUid
						,'my_games_game_name' => json_encode($commonWishes)
						,'my_wished_game_name' => json_encode($commonGames)
						,'common_user_id' => $userRow['firebase_uid']
						,'game_owner_first_name' => $userRow['first_name']
						,'game_owner_last_name' => $userRow['last_name']
						,'game_owner_location' => $userRow['location']
						,'game_owner_district' => $userRow['district']
						,'game_owner_profile_image' => $userRow['profile_image']
							,'game_owner_online_status' => $userRow['online_status']
							,'game_owner_token' => $userRow['token']
						,'game_owner_wishes' => json_encode($wishesArray)
							,'game_owner_games' => json_encode($gamesArray)
							,'game_owner_common_games_count' => $commonCount
						);	
	
unset($wishesArray);
unset($gamesArray);
unset($commonGames);
unset($commonWishes);
unset($userRow);
$commonCount = 0;

}else{
// If user doesn't have games, so why do we add him in the first place

unset($wishesArray);
unset($gamesArray);
unset($commonGames);
unset($commonWishes);
unset($userRow);
$commonCount = 0;

}

}





}else{

$sqlGetUsers = "SELECT name,first_name,last_name,location,district,profile_image,token,firebase_uid,online_status FROM user_table WHERE firebase_uid != :myFirebaseUid AND location = :location AND district IN ". $district ." AND platform = :platform AND token IS NOT NULL ORDER BY last_active DESC LIMIT ".$startingLimit. ',' . $endingLimit;

// Getting games of others
$stmtGetUsers = $con->prepare($sqlGetUsers);
$stmtGetUsers->execute(array(
	'myFirebaseUid' => $myFirebaseUid,
	'location' => $location,
	'platform' => $platform
));
foreach ($stmtGetUsers as $userRow) {

// GET GAMES OF USERS
$sqlGetUserGameList = "SELECT game_name,flag,tag FROM test_table WHERE user_id = :user_id";

$stmtGetGameList = $con->prepare($sqlGetUserGameList);
$stmtGetGameList->execute(array(
	'user_id' => $userRow['firebase_uid']
));




foreach ($stmtGetGameList as $gameRow) {
if ($gameRow['flag'] == 'o') {
	$gamesArray[] = array(
						'game_name' => $gameRow['game_name']
						, 'flag' => $gameRow['flag']
						,'tag' => $gameRow['tag']);	

}else{
	$wishesArray[] =
	array(
						'game_name' => $gameRow['game_name']
						, 'flag' => $gameRow['flag']
											,'tag' => $gameRow['tag']);	
}

}

if (count($gamesArray) > 0) {

for ($i=0; $i <count($arrayMyWishes) ; $i++) { 
for ($j=0; $j <count($gamesArray) ; $j++) { 
		if ($gamesArray[$j]['game_name'] == $arrayMyWishes[$i]['game_name']) {
			 $commonGames[] = array('game_name' => $arrayMyWishes[$i]['game_name']);	
						 $commonCount++;
		}
	}
}



for ($i=0; $i <count($arrayMyGames) ; $i++) { 
for ($j=0; $j <count($wishesArray) ; $j++) { 
		if ($wishesArray[$j]['game_name'] == $arrayMyGames[$i]['game_name']) {
			 $commonWishes[] = array('game_name' => $arrayMyGames[$i]['game_name']);	
					 $commonCount++;
		}
	}
}



$arrayOfMyWishesWithGamesOfOthers[] = array(
						'my_user_id' => $myFirebaseUid
						,'my_games_game_name' => json_encode($commonWishes)
						,'my_wished_game_name' => json_encode($commonGames)
						,'common_user_id' => $userRow['firebase_uid']
						,'game_owner_first_name' => $userRow['first_name']
						,'game_owner_last_name' => $userRow['last_name']
						,'game_owner_location' => $userRow['location']
						,'game_owner_district' => $userRow['district']
						,'game_owner_profile_image' => $userRow['profile_image']
							,'game_owner_online_status' => $userRow['online_status']
							,'game_owner_token' => $userRow['token']
						,'game_owner_wishes' => json_encode($wishesArray)
							,'game_owner_games' => json_encode($gamesArray)
														,'game_owner_common_games_count' => $commonCount

						);	
	
unset($wishesArray);
unset($gamesArray);
unset($commonGames);
unset($commonWishes);
unset($userRow);
$commonCount = 0;

}else{
// If user doesn't have games, so why do we add him in the first place

unset($wishesArray);
unset($gamesArray);
unset($commonGames);
unset($commonWishes);
unset($userRow);
$commonCount = 0;

}

}





}




echo json_encode($arrayOfMyWishesWithGamesOfOthers);

}

?>