<?php

session_start();
$_SESSION["user"] = "jylee";
header("location: home.php");

?>