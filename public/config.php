<?php 
session_start();
$url = "http://{$_SERVER['HTTP_HOST']}{$_SERVER['PHP_SELF']}";

$publicUrl = preg_replace('/public\/.+\.php/','public/',$url, 1);

define('_URL',$publicUrl);
define('_CSS',_URL.'css');
define('_JS',_URL.'js');
define('_DISTJS',_URL.'dist/js');
define('_NODE',_URL.'node_modules');
define('_IMG',_URL.'images');

?>