<?php

require 'Class/Router.php';
require 'Class/User.php';

$router = new Router();

$router
    ->byExt('css', PUBLIC_FOLDER . 'css', 'text/css')
    ->byExt('js', PUBLIC_FOLDER . 'js', 'application/javascript')
    ->byExt(['png', 'jpg', 'jpeg', 'gif', 'tiff', 'bmp'], PUBLIC_FOLDER . 'images', 'image')
    ->get('/', function() {
        require_once PUBLIC_FOLDER . 'views/login.php';
    })
    ->get('/lang/:lang', function($res, $req) {

        echo 'Woa<pre>';
        print_r($res->body);
        echo '</pre>';

    })
    ->post('/log', function() {
        echo json_encode(["like" => "this"]);
    })
    ->get('/admin', function($req, $res) {
        //$res->redirect('http://google.com');
        //$user = User::getUser(1);
    })
    ->use('/admin', [
        "/login" => [
            "method" => Router::GET,
            "callback" => function() {
                echo "logi";
            }
        ],
        "logoff"=> [
            "method" => Router::GET,
            "callback" => function() {
                echo "logo";
            }
        ],
        "/config"=> [
            "routes" => [
                "/" => [
                    "method" => Router::GET,
                    "callback" => function() {
                        echo "config";
                    }
                ], "/get" => [
                    "method" => Router::GET,
                    "callback" => function() {
                        echo "get";
                    }
                ], "/set" => [
                    "method" => Router::POST,
                    "callback" => function() {
                        echo "set";
                    }
                ], "*" => [
                    "method" => Router::GET,
                    "callback" => function() {
                        echo "404 config";
                    }
                ]
            ]
        ]
    ])
    ->on('/admin/*', function() {
        header('HTTP/1.0 404 Not Found');
        echo 403;
    })
    ->on('*', function() {
        header('HTTP/1.0 404 Not Found');
        echo 404;
    })
;