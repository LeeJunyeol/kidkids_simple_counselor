<?php

class App {
    private $url_controller = null;
    private $url_action =  null;
    private $url_parmas = array();

    public function __construct(){
        if(isset($_GET['url'])){
            $url = trim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL); // The FILTER_SANITIZE_URL 필터는 모든 유효하지않은 URL 문자를 제거한다.
            $url = explode('/', $url);

            $this->url_controller = isset($url[0]) ? $url[0] : null;
            $this->url_action = isset($url[1]) ? $url[1] : null;

            unset($url[0], $url[1]);

            $this->url_params = array_values($url);
        }
    }

}