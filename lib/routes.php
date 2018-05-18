<?php

require_once 'Class/Router.php';

$router = new Router();
$router
    ->on('/*.css', function(Response $res, $args) { // active less (if 2 same names => less has priority)
        $file = PUBLIC_FOLDER . 'css-less/' . $args[0] . '.less';
        if (file_exists($file)) {
            require_once 'less.inc.php';
            $css = (new lessc($file))->parse();
            $res->send($css, false, "text/css");
        }
    })
    ->byExt('css', PUBLIC_FOLDER . 'css')
    ->byExt('js', PUBLIC_FOLDER . 'js')
    ->byExt(['png', 'jpg', 'jpeg', 'gif', 'tiff', 'bmp'], PUBLIC_FOLDER . 'images');


require_once 'Class/DB/User.php';
session_start();
session_set_cookie_params(30*30*60);
define('BASE_URL', $router->getBaseURL() . '/');

// Define lang and verify if connected
if (!isset($_SESSION["lang"]))
    $_SESSION["lang"] = "fr";
define('L10N', json_decode(file_get_contents(PUBLIC_FOLDER . 'l10n/' . $_SESSION["lang"] . '.json'), true));
define('L10NAvail', json_decode(file_get_contents(PUBLIC_FOLDER . 'l10n/l10n.json'), true));

$isConnected = isset($_SESSION["User"]) ? $_SESSION["User"]->isCorrect() : false;

$router
    ->setViewsPath(PUBLIC_FOLDER . 'views')
    ->use('/lang', [
        "" => [
            "method" => Router::POST,
            "callback" => function($res) {
                if (isset($_REQUEST["lang"])) {
                    $lang = $_REQUEST["lang"];
                    foreach (L10NAvail as $langAv)
                        if ($langAv["abr"] == $lang) {
                            $_SESSION["lang"] = $lang;
                            $res->send(true);
                        }
                    $res->send(false);
                } else
                    $res->send(L10N);
            }
        ],
        ":lang" => [
            "method" => Router::POST,
            "callback" => function($res, $args) {
                $res->sendFile(sprintf("%sl10n/%s.json",PUBLIC_FOLDER, $args["lang"]));
            }
        ]
    ])

    /*->get("/contact", function(Response $res) {
        $res->render("contact.php");
    })*/;

// For Luc's Demo
function getInfluxDb() {
    require 'influxdb/autoload.php';
    $user = "jeremie_vianin";
    $pass = "bae8Oozi";
    $host = "10.4.255.11";
    $port = 8086;
    $dbname = "cloudio";

    $client = new InfluxDB\Client($host, $port, $user, $pass);

    return $client->selectDB($dbname);
}

function getUser(User $user) {
    return $user->getInstallations()[0]->getGateway()->getName();
}

$router
    ->get("/signup", function (Response $res) {
        if (isset($_GET["id"])) {

            $user = User::getByToken($_GET["id"]);
            if ($user != false && !$user->isActive()) {
                $_SESSION["_token"] = $_GET["id"];
                $res->render("login.php", ["user" => User::getByToken($_GET["id"])]);
            } else $res->redirect('/');
        }
    })

    ->post('/login', function(Response $res) {
        if (isset($_POST["username"]) and isset($_POST["password"])) {
            if (isset($_SESSION["_token"])) {
                $user = User::getByToken($_SESSION["_token"]);
                if ($user != false && $_POST["username"] == $user->getUsername()
                    && !$user->isActive() && $user->setPassword($_POST["password"])
                    && $user->setActive())
                    $user = new User($user->getUsername(), $_POST["password"]);

                unset($_SESSION["_token"]);
            } else $user = User::login($_POST["username"], $_POST["password"]);

            if ($user != false)
                $_SESSION["User"] = $user;

            $res->send($user != false);
        } else $res->send(false);
    })

    ->get("*", function(Response $res) {
        global $isConnected;
        if (!$isConnected)
            $res->render("login.php");
    })
    ->post("*", function(Response $res) {
        global $isConnected;
        if (!$isConnected) {
            $res->setHeader('HTTP/1.1 403 Unauthorized');
            $res->send(403, false);
        }
    })
    ->post('/boiler', function(Response $res) {
        $database = getInfluxDb();
        $dbName = getUser($_SESSION["User"]);
        $result = $database->query('SELECT value FROM "'.$dbName.'.nodes.temperatureProbe_A.objects.temperature.attributes.datapoint" ORDER BY "time" DESC ;');

        $data[L10N["index"]["chart"]["boiler_temp"]] = ["data" => $result->getPoints(), "y" => L10N["index"]["chart"]["temperature"] ];
        $result = $database->query('SELECT value FROM "'.$dbName.'.nodes.energyMeter_A.objects.wattsTotal.attributes.datapoint" ORDER BY "time" DESC ;');

        $data[L10N["index"]["chart"]["boiler_power"]] = ["data" => $result->getPoints(), "y" => L10N["index"]["chart"]["power"]];
        $res->send($data);
    })
    ->post('/insideTemp', function(Response $res) {
        $database = getInfluxDb();
        $dbName = getUser($_SESSION["User"]);
        $result = $database->query('SELECT value FROM "'.$dbName.'.nodes.ambientSensor-1.objects.temperature.attributes.datapoint" ORDER BY "time" DESC ;');
        $data["insideTemp"] = $result->getPoints();

        $res->send($data);
    })
    ->post('/electricConsumption', function(Response $res) {
        $database = getInfluxDb();
        $dbName = getUser($_SESSION["User"]);
        $result = $database->query('SELECT value FROM "'.$dbName.'.nodes.SmartMeterTechnical.objects.obis_1_0_1_7_0_255_2.attributes.datapoint" ORDER BY "time" DESC ;');
        $data["ElectricConsumption"] = $result->getPoints();

        $res->send($data);
    })
    ->post('/consumptionHeatPump', function(Response $res) {
        $database = getInfluxDb();
        $dbName = getUser($_SESSION["User"]);
        $result = $database->query('SELECT value FROM "'.$dbName.'.nodes.powerMeter-1.objects.wattsTotal.attributes.datapoint" ORDER BY "time" DESC ;');
        $data["ConsumptionHeatPump"] = $result->getPoints();

        $res->send($data);
    })

    ->post('/hotwaterTemperature', function(Response $res) {
        $database = getInfluxDb();
        $dbName = getUser($_SESSION["User"]);
        $result = $database->query('SELECT value FROM "'.$dbName.'.nodes.boilerSensor-1.objects.temperature.attributes.datapoint" ORDER BY "time" DESC ;');
        $data["hotwaterTemperature"] = $result->getPoints();

        $res->send($data);
    })


    ->post('/create', function(Response $res) {
        if (isset($_POST["username"]) && isset($_POST["email"]) && isset($_POST["gatewayname"])
            && !(User::exists($_POST["username"]) || Gateway::exists($_POST["gatewayname"]))) {

            $gateway = $_POST["gatewayname"];
            unset($_POST["gatewayname"]);

            $userId = User::create($_POST);
            $gwId = Gateway::create(["name" => $gateway]);

            $res->send(Installation::link($userId, $gwId) != false);
        }
        $res->send(false);
    })


    ->post('/createSpecialUser', function(Response $res) {
        $res->send(User::create($_POST));
    })

    ->post('/updateProfile', function(Response $res) {
        $res->send($_SESSION['User']->setPhone($_POST["phone"]));
    })

    ->post('/linkUserGateway', function(Response $res) {
        $gw = new Gateway($_POST["gwId"]);
        unset($_POST["gwId"]);
        if ($gw->getInstallation()->update($_POST) && $gw->setStatus(2))
            $res->send(true); // send mail
        $res->send(false);
    })


    ->on('/logout', function($res) {
        unset($_SESSION["User"]);
        $res->redirect('/');
    })


    ->get('/', function(Response $res) {
        $res->render("index.php", ["user" => $_SESSION["User"]]);
    })
    ->get('/*', function(Response $res, $uriParams) {
        $res->render("index.php", ["user" => $_SESSION["User"], "path" => $uriParams[0]]);
    })

    ->post('*', function(Response $res) {
        $res->setHeader('HTTP/1.0 404 Not Found');
        $res->send(404, false);
    })
;