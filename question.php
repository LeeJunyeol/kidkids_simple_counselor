<?php

$host = "127.0.0.1";
$dbName = "mydb";
$userName = "root";
$password = "";

$pdo = new PDO("mysql:host=".$host.";dbname=".$dbName.";charset=utf8", $userName, $password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);



?>