<?php

    $serverHost = "localhost";
$serverUserName = "user";
$serverPassword = "pass";
$serverDatabaseName = "db";
$serverType = "mysql:host=".$serverHost.";"."dbname=".$serverDatabaseName."";

try {
    $con = new PDO($serverType, $serverUserName, $serverPassword,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"));
    // set the PDO error mode to exception
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   $con->exec("SET CHARACTER SET UTF8");
 }
catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
    }
    
?>