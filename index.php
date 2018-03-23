<?php
define('PUBLIC_FOLDER', __DIR__ . '/public/');

function getCurrentUri() {
    $dir = pathinfo($_SERVER['PHP_SELF'], PATHINFO_DIRNAME);    
    return str_replace($dir, "" , $_SERVER["REQUEST_URI"]);
}

$uri = getCurrentUri();
$method = $_SERVER["REQUEST_METHOD"]; //GET || POST

$isConnected = true;

if ($method === 'GET') {
    $isView = false;
    $contentType = null;
    $contentFolder = null;
    switch(pathinfo($uri, PATHINFO_EXTENSION)) {
        case 'css':
            $contentType = "text/css";
            $contentFolder = 'css';
            break;
        case 'js':
            $contentType = "application/javascript";
            $contentFolder = 'js';
            break;
        case 'png': case 'jpg': case 'jpeg': case 'gif';
            $contentType = "image";
            $contentFolder = 'images';
            break;
        default:
            $isView = true;
            break;
    }

    if ($isView) {
        $defaultLang = 'en';

        define('L10N', json_decode(file_get_contents(PUBLIC_FOLDER . 'l10n/' . $defaultLang . '.json'), true));
        
        if ($uri == '/') {
            if ($isConnected)
                require_once PUBLIC_FOLDER . 'views/dashboard.php';
            else
                require_once PUBLIC_FOLDER . 'views/login.php';
        } else 
            echo 404;
    } else {
        header("Content-type: " . $contentType);
        require_once PUBLIC_FOLDER . $contentFolder . $uri;
    }
} else {

}