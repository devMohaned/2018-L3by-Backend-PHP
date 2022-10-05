<?php
//Creating a connection
include ("db_config.php");
error_reporting(E_ERROR | E_PARSE);
header('Content-Type:Application/json');
$search = $_GET["firebase_uid"];
date_default_timezone_set('Africa/Cairo');
if ($_GET['api_key'] == 'com_trade_api_key') {
	
$selection_query = "SELECT id FROM user_table WHERE firebase_uid = :firebase_uid";

$stmt = $con->prepare($selection_query);

$stmt->execute(array('firebase_uid' => $search));
$result = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$result) {
	// No user found
	
	$array[] = array(					
						'user_state' => "DOES_NOT_EXIST"
						);

echo json_encode($array);
}else{

	$access_key = 'AKIAJB4QHACQ6OJH6ZIA';
	$secret_key = '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';

$stmt2 = $con->prepare('SELECT id,first_name,last_name,email,location,district,profile_image,token,facebook,whatsapp FROM user_table WHERE firebase_uid = :firebase_uid');

$stmt2->execute(array('firebase_uid' => $search));




foreach ($stmt2 as $row) {



    $currentTime = time();

$stmt3 = $con->prepare('UPDATE user_table SET last_active = :last_active WHERE firebase_uid = :firebase_uid');

$stmt3->execute(array(
	'firebase_uid' => $search,
	':last_active' => $currentTime
)
);





$array[] = array(
						'id' => $row['id']
						,'first_name' => $row['first_name']
						,'last_name' => $row['last_name']
						,'email' => $row['email']
						,'location' => $row['location']
						,'district' => $row['district']
							,'profile_image' => $row['profile_image']
							,'token' => $row['token']
							,'facebook' => $row['facebook']
							,'whatsapp' => $row['whatsapp']
							,'user_state' => "DOES_EXIST"
							,'access_key' => $access_key
							,'secret_key' =>$secret_key
						);

echo json_encode($array);



}

}


}


  
?>