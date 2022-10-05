<?php
//Creating a connection
include ("db_config.php");
error_reporting(E_ERROR | E_PARSE);


 $category = $_GET['category'];
$startingLimit = $_GET['starting_limit'];
$endingLimit = $_GET['ending_limit'];
$min = $_GET['min'];
$max = $_GET['max'];


if ($_GET['api_key'] == 'com_trade_api_key') {

if ($category == 'all') {
	
$sqlAffiliate = "SELECT title,brand,old_price,current_price,time,product_image,product_link,category FROM amazon_affiliate_table WHERE (current_price BETWEEN ".$min. " AND ". $max. ") ORDER BY time DESC " ."LIMIT ".$startingLimit. ',' . $endingLimit;


// Getting productss
$stmtGetAffiliate = $con->prepare($sqlAffiliate);
$stmtGetAffiliate->execute();
foreach ($stmtGetAffiliate as $row) {
$array[] = $row;
}


}else{

$sqlAffiliate = "SELECT title,brand,old_price,current_price,time,product_image,product_link,category FROM amazon_affiliate_table WHERE category = :category AND (current_price BETWEEN ".$min. " AND ". $max. ") ORDER BY time DESC " ."LIMIT ".$startingLimit. ',' . $endingLimit;
// Getting products
$stmtGetAffiliate = $con->prepare($sqlAffiliate);
$stmtGetAffiliate->execute(array(
 'category' => $category
));
foreach ($stmtGetAffiliate as $row) {
$array[] = $row;
}


}

echo json_encode($array);
}

?>