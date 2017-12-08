<?php

$url = str_replace("index.php","home","http://{$_SERVER['HTTP_HOST']}{$_SERVER['PHP_SELF']}");
header("Location: $url");
return;

?>