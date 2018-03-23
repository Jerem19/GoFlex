<?php

function getCurrentUri() {
    $dir = pathinfo($_SERVER['PHP_SELF'], PATHINFO_DIRNAME);    
    return str_replace($dir, "" , $_SERVER["REQUEST_URI"]);
}

$uri = getCurrentUri();
$method = $_SERVER["REQUEST_METHOD"]; //GET || POST

switch($uri) {
    case '/':
        //require_once './path';
        break;        
    default:
        //require_once './path';
        break;
}