<?php
include ("db_config.php");
header('Content-Type:Application/json');

$search = $_GET["search"];
$flag = $_GET["flag"];
if ($_GET['api_key'] == 'com_trade_api_key') {

$sql= "SELECT * FROM test_table WHERE user_id = :search AND flag = :flag";

$stmt = $con->prepare($sql);
$stmt->execute(array('search' => $search,
'flag' => $flag));
foreach ($stmt as $row) {
$array[] = $row;
}
echo json_encode($array);
}
?>