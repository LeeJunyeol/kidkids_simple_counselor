<?php
require 'vendor/autoload.php';
use KCS\Controller\CategoryController;

$url = "/";

if(isset($_GET['url'])){
    $url = $_GET['url'];
}

// preg_match("/question\/([0-9+])/", $input_line, $output_array);
$url = explode("/", $url);

if($url[0] == "api"){
    array_shift($url);
    switch($url[0]){
        case 'category':
        $category = new Category."Controller";
        $category->getAll();
        break;
    }
} else {
    switch($url[0]){
        case 'question':
        
        default:
        require_once 'public/home.php';
    }
}

// print_r($url);
// $request = $_SERVER['REQUEST_URI'];
// print_r($request);

// print_r($_SERVER['REQUEST_METHOD']);

// $router = new Router($request);

// $router->get('/', 'public/home');
// $router->get('/question', 'public/question');
// $router->get('/write', 'public/write');