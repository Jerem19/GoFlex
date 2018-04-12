<?php

require 'Class/Router.php';
//require 'Class/User.php';

$router = new Router();

$router
    ->enableSession(["lifetime" => 60*60*30])
    ->setViewsPath(PUBLIC_FOLDER . 'views')
    ->on('/*.css', function($req, $res) { // active less (if 2 same names => css has priority)
        $file = PUBLIC_FOLDER . 'css-less/' . $req->params[0] . '.less';
        if(file_exists($file)) {
            require_once 'less.inc.php';
            $css = (new lessc($file))->parse();
            $res->send($css, false, "test/css");
        }
    })

    ->byExt('css', PUBLIC_FOLDER . 'css')
    ->byExt('js', PUBLIC_FOLDER . 'js')
    ->byExt(['png', 'jpg', 'jpeg', 'gif', 'tiff', 'bmp'], PUBLIC_FOLDER . 'images')

    ->get('/', function($req, $res) {
        $res->render('login.php', ["some text" => "Yeah, I see"]);
    })
    ->on('/lang/:lang', function($req, $res) {
        $res->send(($req->params)); // contain "lang"
    })
    ->post('/log', function($req, $res) {
        $res->send(["like" => "this"]);
    })

    ->get('/admin', function($req, $res) {
        //$res->redirect('http://google.com', false);
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
    ->on('*', function($req, $res) {
        $res->setHeader('HTTP/1.0 404 Not Found');
        $res->send(404, false);
    })
;