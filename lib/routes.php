<?php
require 'Class/Router.php';
require 'Class/User.php';

$router = new Router();

$isConnected = false;

$router
    ->enableSession(["lifetime" => 60*60*30])
    ->setViewsPath(PUBLIC_FOLDER . 'views')
    ->on('/*.css', function($req, $res) { // active less (if 2 same names => less has priority)
        $file = PUBLIC_FOLDER . 'css-less/' . $req->params[0] . '.less';
        if(file_exists($file)) {
            require_once 'less.inc.php';
            $css = (new lessc($file))->parse();
            $res->send($css, false, "text/css");
        }
    })
    ->byExt('css', PUBLIC_FOLDER . 'css')
    ->byExt('js', PUBLIC_FOLDER . 'js')
    ->byExt(['png', 'jpg', 'jpeg', 'gif', 'tiff', 'bmp'], PUBLIC_FOLDER . 'images')

    // Define lang and verify if connected
    ->on('*', function($req, $res) {
        if (!isset($req->session["lang"])) {
            $req->session["lang"] = "fr";
            $req->session->save();
        }
        define('L10N', json_decode(file_get_contents(PUBLIC_FOLDER . 'l10n/' . $req->session["lang"] . '.json'), true));
        define('L10NAvail', json_decode(file_get_contents(PUBLIC_FOLDER . 'l10n/l10n.json'), true));

        if (isset($req->session["User"])) {
            global $isConnected;
            $isConnected = $req->session["User"]->isCorrect();
        }
    })

    ->post('/lang/', function($req, $res) {
        if (isset($req->body["lang"])) {
            $lang = $req->body["lang"];
            $isExisting = false;
            foreach (L10NAvail as $langAv)
                if ($langAv["abr"] == $lang) {
                    $isExisting = true;
                    break;
                }
            if ($isExisting) {
                $req->session["lang"] = $req->body["lang"];
                $req->session->save();
                $res->send(true);
            }
            $res->send(false);
        } else
            $res->send(L10N);
    })
    ->post('/lang/:lang', function($req, $res) {
        $res->sendFile(sprintf("%sl10n/%s.json",PUBLIC_FOLDER, $req->params["lang"]));
    })

    ->get("/contact", function($req, $res) {
        $res->render("contact.php");
    })

    ->post('/login', function($req, $res) {
        $exist = User::isExisting($req->body["username"], $req->body["password"]);
        if ($exist != false) {
            $req->session["User"] = User::getUser($exist);
            $req->session->save();
        }
        $res->send($exist != false);
    })
    ->on('/logout', function($req, $res) {
        unset($req->session["User"]);
        $req->session->save();
        $res->redirect('/');
    })

    ->get("*", function($req, $res) {
        global $isConnected;
        if (!$isConnected)
            $res->render("login.php", ["lang" => $req->session["lang"]]);
    })
    ->post("*", function($req, $res) {
        global $isConnected;
        if (!$isConnected) {
            $res->setHeader('HTTP/1.1 401 Unauthorized');
            $res->send(403, false);
        }
    })

    ->get('/', function($req, $res) {
        $res->render("index.php", ["User" => $req->session["User"], "lang" => $req->session["lang"]]);
    })
    ->get('/*', function($req, $res) {
        $res->render("index.php", ["User" => $req->session["User"], "lang" => $req->session["lang"], "path" => $req->params[0]]);
    })

    ->post('*', function($req, $res) {
        $res->setHeader('HTTP/1.0 404 Not Found');
        $res->send(404, false);
    })
;