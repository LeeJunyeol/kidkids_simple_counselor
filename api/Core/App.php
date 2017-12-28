<?php

class App {
    protected $controller = 'home';

    protected $method = 'index';

    protected $params = [];

    public function __construct() {
        echo 'OK';
    }

    public function parseUrl(){
        if(isset($_GET[url])) {

        }
    }
}

