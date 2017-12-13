<?php

session_start();
$_SESSION["user"] = "jylee";
header("location: http://localhost/ksc/home");

?>