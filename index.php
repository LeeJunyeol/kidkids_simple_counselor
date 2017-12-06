<?php

$url = str_replace("index.php","","http://{$_SERVER['HTTP_HOST']}{$_SERVER['PHP_SELF']}");

define('_URL',$url);
define('_CSS',_URL.'public/css');
define('_JS',_URL.'public/js');
define('_NODE',_URL.'public/node_modules');
define('_IMG',_URL.'public/images');

if(!isset($_GET['url'])){
    require_once "public/home.php";
} else{
    $path = explode('/', $_GET['url']);
    switch($path[0]){
        case 'home':
        require_once "public/home.php";
        break;
        case 'view':
        require_once "public/view-question.php";
        break;
        case 'write':
        require_once "public/write-question.php";
        break;
        default:
        require_once "public/404.html";
        break;
    }    
}
return;
?>