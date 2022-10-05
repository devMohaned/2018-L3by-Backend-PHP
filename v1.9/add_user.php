<?php
include ("db_config.php");
date_default_timezone_set('Africa/Cairo');

 $first_name = $_POST['first_name'];
 $last_name = $_POST['last_name'];
 $firebase_uid = $_POST['firebase_uid'];
 $email = $_POST['email'];
 $password = $_POST['password'];
 $platform = $_POST['platform'];
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);


$yesterday = date('d.m.Y',strtotime("-1 days"));

if ($_GET['api_key'] == 'com_trade_api_key') {

$selection_query = "SELECT id FROM user_table WHERE firebase_uid = :firebase_uid";



$sth = $con->prepare($selection_query);
$sth->execute(
	array(
		'firebase_uid' => $firebase_uid
					)
);


$result = $sth->fetch(PDO::FETCH_ASSOC);
if (!$result) {


 $Sql_Query = "INSERT INTO user_table (name, first_name,last_name,firebase_uid,email,password,last_collected,platform)
  VALUES (:name,:first_name,:last_name,:firebase_uid,:email,:password,:last_collected,:platform)";


$sth2 = $con->prepare($Sql_Query);
$sth2->execute(
	array(
		'name' => $first_name.' '.$last_name,
		'first_name' => $first_name,
		'last_name' => $last_name,
		'firebase_uid' => $firebase_uid,
		'email' => $email,
		'password' => $hashedPassword,
		'last_collected' => $yesterday,
		'platform' => $platform

			)
);

echo "Inserted";

$con = null;
}else{
	echo "Registered";
}
}
?>