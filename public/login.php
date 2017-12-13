<?php

session_start();
$_SESSION["user"] = $_GET["user_id"];
header("location: http://localhost/ksc/home");

?>