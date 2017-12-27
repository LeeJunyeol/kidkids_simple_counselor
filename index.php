<?php
require 'vendor/autoload.php';
use KCS\Controller\CategoryController;

$url = "/";

if(isset($_GET['url'])){
    $url = $_GET['url'];
}

$url = explode("/", $url);

if($url[0] == "api"){
    switch($url[1]){
        case 'category':
        $category = new CategoryController();
        $category->getAll();
    }
} else {
    switch($url[0]){
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