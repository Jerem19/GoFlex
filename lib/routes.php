<?php require_once 'Class/Router.php';

$router = new Router();
define('BASE_URL', $router->getBaseURL() . '/');

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
    ->byExt(['png', 'jpg', 'jpeg', 'gif', 'tiff', 'bmp', 'ico'], PUBLIC_FOLDER . 'images')
    ->on('/base_url', function(Response $res) {
        $res->send(BASE_URL);
    });

require_once 'Class/DB/User.php';
session_start();
session_set_cookie_params(30*30*60);

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

function getHeatPowerMeter(User $user){
    return $user->getInstallations()[0]->getHeatPowerMeter();
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

    ->get('/getpassword', function(Response $res) {
        $res->render('login.php', [ "pwdRecup" => true ]);
    })

    ->post('/getpassword', function (Response $res) {
        if (isset($_POST['email'])) {
            $api_url = "https://www.google.com/recaptcha/api/siteverify?"
                . http_build_query([
                    "secret" => "6Leynl8UAAAAACjjVBYat9eXBq9wvEuWURkyi6nI",
                    "response" => $_POST['g-recaptcha-response'],
                    "remoteip" => $_SERVER['REMOTE_ADDR']
                ])
            ;

            $apiRes = json_decode(file_get_contents($api_url), true);

            if (isset($apiRes['success']) && $apiRes['success']) {
                $user = User::getByEmail($_POST['email']);
                $user->setInactive();

                require_once PRIVATE_FOLDER . './Class/Mail.php';
                Mail::activation($user);
                $res->send(true);
            }
        }
        $res->send(false);
    })


    ->post('/login', function(Response $res) {
        if (isset($_POST["username"]) and isset($_POST["password"])) {
            if (isset($_SESSION["_token"])) {
                $user = User::getByToken($_SESSION["_token"]);
                if ($user != false && $_POST["username"] == $user->getUsername()
                    && !$user->isActive() && $user->setPassword($_POST["password"])
                    && $user->setActive())
                    $user = new User($user->getId(), $_POST["password"]);
            } else $user = User::login($_POST["username"], $_POST["password"]);

            if ($user != false) {
                unset($_SESSION["_token"]);
                $_SESSION["User"] = $user;
            }

            $res->send($user != false);
        } else $res->send(false);
    })

    ->on('*', function(Response $res) {
        global $isConnected, $router;
        if (!$isConnected) {
            if ($router->getMethod() == Router::POST) {
                $res->setHeader('HTTP/1.1 403 Unauthorized');
                $res->send(403, false);
            } else $res->render('login.php');
        }
    })



    /* ------------------------------------------------------------------------------------------------------------------------------------------------------------------*/

    /*INSIDE TEMPERATURE*/

    ->post('/insideTemp', function(Response $res) {
        $database = getInfluxDb();
        $dbName = getUser($_SESSION["User"]);
        $interval = $_POST["time"];
        $range = $_POST["range"];
        $result = $database->query('SELECT DISTINCT value FROM "'.$dbName.'.nodes.ambientSensor-1.objects.temperature.attributes.datapoint" where time >= now()-'.$range.' GROUP BY time('.$interval.') fill(none) ORDER BY time DESC ;');
        $res->send($result->getPoints());
    })

    ->post('/insideTempAll', function(Response $res) {
        $database = getInfluxDb();
        $dbName = getUser($_SESSION["User"]);
        $result = $database->query('SELECT DISTINCT value FROM "'.$dbName.'.nodes.ambientSensor-1.objects.temperature.attributes.datapoint" GROUP BY time(1d) fill(none) ORDER BY time DESC ;');
        $res->send($result->getPoints());
    })

    ->post('/insideTempSpeed', function(Response $res) {
        $database = getInfluxDb();
        $dbName = getUser($_SESSION["User"]);
        $result = $database->query('SELECT LAST("value") FROM "' . $dbName . '.nodes.ambientSensor-1.objects.temperature.attributes.datapoint" ;');
        $res->send($result->getPoints());
    })


    ->post('/insideTempSpec', function(Response $res) {
        $database = getInfluxDb();
        $dbName = Gateway::getById($_POST['idGateway']);
        $interval = $_POST["time"];
        $range = $_POST["range"];
        $result = $database->query('SELECT DISTINCT("value") FROM "'.$dbName.'.nodes.ambientSensor-1.objects.temperature.attributes.datapoint" where time >= now()-'.$range.' GROUP BY time('.$interval.') fill(none) ORDER BY "time" DESC ;');
        $res->send($result->getPoints());

    })

    ->post('/insideTempSpecAll', function(Response $res) {
        $database = getInfluxDb();
        $dbName = Gateway::getById($_POST['idGateway']);
        $result = $database->query('SELECT DISTINCT("value") FROM "'.$dbName.'.nodes.ambientSensor-1.objects.temperature.attributes.datapoint" GROUP BY time(1d) fill(none) ORDER BY time DESC ;');
        $res->send($result->getPoints());

    })

    ->post('/insideTempHistory', function(Response $res) {
        $database = getInfluxDb();
        $dbName = getUser($_SESSION["User"]);
        $result = $database->query('SELECT DISTINCT("value") FROM "'.$dbName.'.nodes.ambientSensor-1.objects.temperature.attributes.datapoint" where time > now()-12h GROUP BY time(1s) fill(none) ORDER BY time DESC ;');
        $res->send($result->getPoints());
    })


    /* CONSUMPTION ELECT */

    /* -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
    ->post('/consumptionElect', function(Response $res) {
        $database = getInfluxDb();
        $dbName = getUser($_SESSION["User"]);
        $interval = $_POST["time"];
        $range = $_POST["range"];
        $result = $database->query('SELECT DISTINCT("value") FROM "'.$dbName.'.nodes.SmartMeterTechnical.objects.obis_1_0_1_7_0_255_2.attributes.datapoint" where time >= now()-'.$range.' GROUP BY time('.$interval.') fill(none) ORDER BY "time" DESC ;');

        $res->send($result->getPoints());
    })

    ->post('/consumptionElectAll', function(Response $res) {
        $database = getInfluxDb();
        $dbName = getUser($_SESSION["User"]);
        $result = $database->query('SELECT DISTINCT("value") FROM "'.$dbName.'.nodes.SmartMeterTechnical.objects.obis_1_0_1_7_0_255_2.attributes.datapoint" GROUP BY time(1d) fill(none) ORDER BY time DESC ;');

        $res->send($result->getPoints());
    })

    ->post('/consumptionElectSpeed', function(Response $res) {
        $database = getInfluxDb();
        $dbName = getUser($_SESSION["User"]);
        $result = $database->query('SELECT LAST("value") FROM "'.$dbName.'.nodes.SmartMeterTechnical.objects.obis_1_0_1_7_0_255_2.attributes.datapoint";');
        $res->send($result->getPoints());
    })

    ->post('/consumptionElectSpec', function(Response $res) {
        $database = getInfluxDb();
        $dbName = Gateway::getById($_POST['idGateway']);
        $interval = $_POST["time"];
        $range = $_POST["range"];
        $result = $database->query('SELECT DISTINCT("value") FROM "'.$dbName.'.nodes.SmartMeterTechnical.objects.obis_1_0_1_7_0_255_2.attributes.datapoint" where time >= now()-'.$range.' GROUP BY time('.$interval.') fill(none) ORDER BY "time" DESC ;');

        $res->send($result->getPoints());
    })

    ->post('/consumptionElectSpecAll', function(Response $res) {
        $database = getInfluxDb();
        $dbName = Gateway::getById($_POST['idGateway']);
        $result = $database->query('SELECT DISTINCT("value") FROM "'.$dbName.'.nodes.SmartMeterTechnical.objects.obis_1_0_1_7_0_255_2.attributes.datapoint" GROUP BY time(1d) fill(none) ORDER BY time DESC ;');

        $res->send($result->getPoints());
    })

    ->post('/consumptionElectHistory', function(Response $res) {
        $database = getInfluxDb();
        $dbName = getUser($_SESSION["User"]);
        $result = $database->query('SELECT DISTINCT("value") FROM "'.$dbName.'.nodes.SmartMeterTechnical.objects.obis_1_0_1_7_0_255_2.attributes.datapoint" where time > now()-12h GROUP BY time(1s) fill(none) ORDER BY time DESC ;');

        $res->send($result->getPoints());
    })
    /* -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/

    /* PRODUCTION ELECT */

    ->post('/productionElect', function(Response $res) {
        $database = getInfluxDb();
        $dbName = getUser($_SESSION["User"]);
        $interval = $_POST["time"];
        $range = $_POST["range"];
        $result = $database->query('SELECT DISTINCT("value") FROM "'.$dbName.'.nodes.SmartMeterTechnical.objects.obis_1_0_2_7_0_255_2.attributes.datapoint" where time >= now()-'.$range.' GROUP BY time('.$interval.') fill(none) ORDER BY "time" DESC ;');
        $res->send($result->getPoints());
    })

    ->post('/productionElectAll', function(Response $res) {
        $database = getInfluxDb();
        $dbName = getUser($_SESSION["User"]);
        $result = $database->query('SELECT DISTINCT("value") FROM "'.$dbName.'.nodes.SmartMeterTechnical.objects.obis_1_0_2_7_0_255_2.attributes.datapoint" GROUP BY time(1d) fill(none) ORDER BY time DESC ;');
        $res->send($result->getPoints());
    })

    ->post('/productionElectSpeed', function(Response $res) {
        $database = getInfluxDb();
        $dbName = getUser($_SESSION["User"]);
        $result = $database->query('SELECT LAST("value") FROM "'.$dbName.'.nodes.SmartMeterTechnical.objects.obis_1_0_2_7_0_255_2.attributes.datapoint";');
        $res->send($result->getPoints());
    })

    ->post('/productionElectSpec', function(Response $res) {
        $database = getInfluxDb();
        $dbName = Gateway::getById($_POST['idGateway']);
        $interval = $_POST["time"];
        $range = $_POST["range"];
        $result = $database->query('SELECT DISTINCT("value") FROM "'.$dbName.'.nodes.SmartMeterTechnical.objects.obis_1_0_2_7_0_255_2.attributes.datapoint" where time >= now()-'.$range.' GROUP BY time('.$interval.') fill(none) ORDER BY "time" DESC ;');
        $res->send($result->getPoints());

    })

    ->post('/productionElectSpecAll', function(Response $res) {
        $database = getInfluxDb();
        $dbName = Gateway::getById($_POST['idGateway']);
        $result = $database->query('SELECT DISTINCT("value") FROM "'.$dbName.'.nodes.SmartMeterTechnical.objects.obis_1_0_2_7_0_255_2.attributes.datapoint" GROUP BY time(1d) fill(none) ORDER BY time DESC ;');
        $res->send($result->getPoints());

    })

    ->post('/productionElectHistory', function(Response $res) {
        $database = getInfluxDb();
        $dbName = getUser($_SESSION["User"]);
        $powerMeter = getHeatPowerMeter($_SESSION["User"]);
        $result = $database->query('SELECT DISTINCT("value") FROM "'.$dbName.'.nodes.SmartMeterTechnical.objects.obis_1_0_2_7_0_255_2.attributes.datapoint" where time > now()-12h GROUP BY time(1s) fill(none) ORDER BY time DESC ;');
        $res->send($result->getPoints());
    })

    /* CONSUMPTION HEAT PUMP */
    /* -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/

    ->post('/consumptionHeatPump', function(Response $res) {
        $database = getInfluxDb();
        $dbName = getUser($_SESSION["User"]);
        $powerMeter = getHeatPowerMeter($_SESSION["User"]);
        $interval = $_POST["time"];
        $range = $_POST["range"];
        $result = $database->query('SELECT DISTINCT("value") FROM "'.$dbName.'.nodes.powerMeter-'.$powerMeter.'.objects.wattsTotal.attributes.datapoint" where time >= now()-'.$range.' GROUP BY time('.$interval.') fill(none) ORDER BY time DESC ;');
        $res->send($result->getPoints());
    })

    ->post('/consumptionHeatPumpAll', function(Response $res) {
        $database = getInfluxDb();
        $dbName = getUser($_SESSION["User"]);
        $powerMeter = getHeatPowerMeter($_SESSION["User"]);
        $result = $database->query('SELECT DISTINCT value FROM "'.$dbName.'.nodes.powerMeter-'.$powerMeter.'.objects.wattsTotal.attributes.datapoint" GROUP BY time(1d) fill(none) ORDER BY time DESC ;');
        $res->send($result->getPoints());
    })

    ->post('/consumptionHeatPumpSpeed', function(Response $res) {
        $database = getInfluxDb();
        $dbName = getUser($_SESSION["User"]);
        $powerMeter = getHeatPowerMeter($_SESSION["User"]);
        $result = $database->query('SELECT LAST("value") FROM "'.$dbName.'.nodes.powerMeter-'.$powerMeter.'.objects.wattsTotal.attributes.datapoint";');
        $res->send($result->getPoints());
    })

    ->post('/consumptionHeatPumpSpec', function(Response $res) {
        $database = getInfluxDb();
        $dbName = Gateway::getById($_POST['idGateway']);
        $powerMeter = Installation::getByGateway($_POST['idGateway'])->getHeatPowerMeter();
        $interval = $_POST["time"];
        $range = $_POST["range"];
        $result = $database->query('SELECT DISTINCT("value") FROM "'.$dbName.'.nodes.powerMeter-'.$powerMeter.'.objects.wattsTotal.attributes.datapoint" where time >= now()-'.$range.' GROUP BY time('.$interval.') fill(none) ORDER BY "time" DESC ;');
        $res->send($result->getPoints());
    })

    ->post('/consumptionHeatPumpSpecAll', function(Response $res) {
        $database = getInfluxDb();
        $dbName = Gateway::getById($_POST['idGateway']);
        $powerMeter = Installation::getByGateway($_POST['idGateway'])->getHeatPowerMeter();
        $result = $database->query('SELECT DISTINCT("value") FROM "'.$dbName.'.nodes.powerMeter-'.$powerMeter.'.objects.wattsTotal.attributes.datapoint" GROUP BY time(1d) fill(none) ORDER BY time DESC ;');
        $res->send($result->getPoints());
    })

    ->post('/consumptionHeatPumpHistory', function(Response $res) {
        $database = getInfluxDb();
        $dbName = getUser($_SESSION["User"]);
        $powerMeter = getHeatPowerMeter($_SESSION["User"]);
        $result = $database->query('SELECT DISTINCT("value") FROM "'.$dbName.'.nodes.powerMeter-'.$powerMeter.'.objects.wattsTotal.attributes.datapoint" where time > now()-12h GROUP BY time(1s) fill(none) ORDER BY time DESC ;');
        $res->send($result->getPoints());
    })
    /* -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/

    /* HOTWATER */

    ->post('/hotwaterTemperature', function(Response $res) {
        $database = getInfluxDb();
        $dbName = getUser($_SESSION["User"]);
        $interval = $_POST["time"];
        $range = $_POST["range"];
        $result = $database->query('SELECT DISTINCT("value") FROM "'.$dbName.'.nodes.boilerSensor-1.objects.temperature.attributes.datapoint" where time >= now()-'.$range.' GROUP BY time('.$interval.') fill(none) ORDER BY time DESC ;');
        $res->send($result->getPoints());
    })

    ->post('/hotwaterTemperatureAll', function(Response $res) {
        $database = getInfluxDb();
        $dbName = getUser($_SESSION["User"]);
        $result = $database->query('SELECT DISTINCT("value") FROM "'.$dbName.'.nodes.boilerSensor-1.objects.temperature.attributes.datapoint" GROUP BY time(1d) fill(none) ORDER BY time DESC ;');
        $res->send($result->getPoints());
    })

    ->post('/hotwaterTemperatureSpeed', function(Response $res) {
        $database = getInfluxDb();
        $dbName = getUser($_SESSION["User"]);
        $result = $database->query('SELECT LAST("value") FROM "'.$dbName.'.nodes.boilerSensor-1.objects.temperature.attributes.datapoint";');
        $res->send($result->getPoints());
    })

    ->post('/hotwaterTemperatureSpec', function(Response $res) {
        $database = getInfluxDb();
        $dbName = Gateway::getById($_POST['idGateway']);
        $interval = $_POST["time"];
        $range = $_POST["range"];
        $result = $database->query('SELECT DISTINCT("value") FROM "'.$dbName.'.nodes.boilerSensor-1.objects.temperature.attributes.datapoint" where time >= now()-'.$range.' GROUP BY time('.$interval.') fill(none) ORDER BY "time" DESC ;');
        $res->send($result->getPoints());
    })

    ->post('/hotwaterTemperatureSpecAll', function(Response $res) {
        $database = getInfluxDb();
        $dbName = Gateway::getById($_POST['idGateway']);
        $interval = $_POST["time"];
        $range = $_POST["range"];
        $result = $database->query('SELECT DISTINCT("value") FROM "'.$dbName.'.nodes.boilerSensor-1.objects.temperature.attributes.datapoint" GROUP BY time(1d) fill(none) ORDER BY time DESC ;');
        $res->send($result->getPoints());
    })

    ->post('/hotwaterTemperatureHistory', function(Response $res) {
        $database = getInfluxDb();
        $dbName = getUser($_SESSION["User"]);
        $result = $database->query('SELECT DISTINCT("value") FROM "'.$dbName.'.nodes.boilerSensor-1.objects.temperature.attributes.datapoint" where time > now()-12h GROUP BY time(1s) fill(none) ORDER BY time DESC ;');
        $res->send($result->getPoints());
    })

    /* ------------------------------------------------------------------------------------------------------------------------------------------------------------------*/

    /* Counter */

    ->post('/counterConsumption1', function (Response $res){
        $database = getInfluxDb();
        $dbName = getUser($_SESSION["User"]);
        $result = $database->query('SELECT LAST("value") FROM "'.$dbName.'.nodes.SmartMeterBilling.objects.obis_1_1_1_8_1_255_2.attributes.datapoint";');
        $res->send($result->getPoints());
    })

    ->post('/counterConsumption2', function (Response $res){
        $database = getInfluxDb();
        $dbName = getUser($_SESSION["User"]);
        $result = $database->query('SELECT LAST("value") FROM "'.$dbName.'.nodes.SmartMeterBilling.objects.obis_1_1_1_8_2_255_2.attributes.datapoint";');
        $res->send($result->getPoints());
    })

    ->post('/counterProduction1', function (Response $res){
        $database = getInfluxDb();
        $dbName = getUser($_SESSION["User"]);
        $result = $database->query('SELECT LAST("value") FROM "'.$dbName.'.nodes.SmartMeterBilling.objects.obis_1_1_2_8_1_255_2.attributes.datapoint";');
        $res->send($result->getPoints());
    })

    ->post('/counterProduction2', function (Response $res){
        $database = getInfluxDb();
        $dbName = getUser($_SESSION["User"]);
        $result = $database->query('SELECT LAST("value") FROM "'.$dbName.'.nodes.SmartMeterBilling.objects.obis_1_1_2_8_2_255_2.attributes.datapoint";');
        $res->send($result->getPoints());
    })

    /* ------------------------------------------------------------------------------------------------------------------------------------------------------------------*/

    ->use('/pics', [
        "/:img.pic" => [
            "method" => Router::GET,
            "callback" => function(Response $res, $params) {
                if ($_SESSION["User"]->getRole()->getId() != 4)
                    $res->sendFile( (new Picture($params["img"]))->getPath());
            }
        ],
        "/delete" => [
            "method" => Router::POST,
            "callback" => function(Response $res) {
                if ($_SESSION["User"]->getRole()->getId() == 2) {

                    if (isset($_POST["imgId"]) && isset($_POST["gwId"])) {
                        $inst = (new Gateway(isset($_POST["gwId"])))->getInstallation();

                        if (isset($_POST["element"])) {
                            $picsHeat = $inst->Heat()->getPicturesId();
                            $picsHot = $inst->Hotwater()->getPicturesId();

                            switch ($_POST["element"]) {
                                case 'heat':
                                    if (($key = array_search($_POST["imgId"], $picsHeat)) !== false)
                                        unset($picsHeat[$key]);
                                    break;
                                case 'hotwater':
                                    if (($key = array_search($_POST["imgId"], $picsHot)) !== false)
                                        unset($picsHot[$key]);
                                    break;
                            }

                            if (Picture::delete($_POST["imgId"]))
                                $res->send($inst->update([
                                    "heatPictures" => json_encode($picsHeat),
                                    "hotwaterPictures" => json_encode($picsHot)
                                ]));
                        } else { } // House Pic (! foreign key !)
                    } $res->send(false);
                }
            }
        ]
    ])

    ->post('/installInfo', function(Response $res) {
        if ($_SESSION["User"]->getRole()->getId() != 4) {
            if (isset($_POST["id"])) {
                $inst = Installation::getByGateway($_POST["id"]);

                if ($inst != false) {
                    $data = $inst->getJSON();

                    function getPicsHTMLinfos(array $pics) {
                        $return = [];
                        foreach ($pics as $pic)
                            $return[] = [
                                "id" => $pic->getId(),
                                "url" => sprintf('%spics/%s.pic', BASE_URL, $pic->getId()),
                                "name" => $pic->getName()
                            ];
                        return $return;
                    }
                    $data["hotwaterPics"] = getPicsHTMLinfos($inst->Hotwater()->getPictures());
                    $data["heatPics"] = getPicsHTMLinfos($inst->Heat()->getPictures());


                    $data["gwId"] = $inst->getGateway()->getId();
                    if ($inst->getPicture()->getId() > 0)
                        $data["picHouse"] = sprintf('%spics/%s.pic', BASE_URL, $inst->getPicture()->getId());
                    $res->send($data);
                }
            }
            $res->send(false);
        }
    })

    ->post('/installUser', function(Response $res) {
        if ($_SESSION["User"]->getRole()->getId() != 4) {
            if (isset($_POST["id"])) {
                $inst = Installation::getByGateway($_POST["id"]);

                if ($inst != false) {
                    $data = $inst->getJSON();

                    $data["gwId"] = $inst->getGateway()->getId();
                    $res->send($data["gwId"]);
                }
            }
            $res->send(false);
        }
    })

    ->post('/gw_exist', function (Response $res) {
        if ($_SESSION["User"]->getRole()->getId() != 4)
            $res->send(isset($_POST["gw"]) ? Gateway::exists($_POST["gw"]) : false);
    })

    ->post('/create', function(Response $res) {
        if ($_SESSION["User"]->getRole()->getId() == 1) {
            if (isset($_POST["username"]) && isset($_POST["email"])
                && !(User::exists($_POST["username"]))) {

                if ($_POST["role"] == 4) {
                    if (isset($_POST["gatewayname"]) && $_POST["gatewayname"] != "" && !Gateway::exists($_POST["gatewayname"])) {
                        $gateway = "goflex-dc-" . $_POST["gatewayname"];
                        $userId = User::create([
                            "firstname" => $_POST["firstname"],
                            "lastname" => $_POST["lastname"],
                            "phone" => $_POST["phone"],
                            "username" => $_POST["username"],
                            "email" => $_POST["email"]
                        ]);
                        $gwId = Gateway::create(["name" => $gateway]);

                        $inst = Installation::link($userId, $gwId);
                        if ($inst != false)
                            $res->send((new Installation($inst))->updateCreation([
                                "city" => $_POST["city"],
                                "npa" => $_POST["npa"],
                                "address" => $_POST["address"],
                                "noteAdmin" => $_POST["adminNote"]
                            ]));
                    }
                } else {
                    require_once PRIVATE_FOLDER . './Class/Mail.php';
                    $user = new User(User::create([
                        "firstname" => $_POST["firstname"],
                        "lastname" => $_POST["lastname"],
                        "phone" => $_POST["phone"],
                        "username" => $_POST["username"],
                        "email" => $_POST["email"],
                        "role" => $_POST["role"]
                    ]));
                    Mail::activation($user);
                    $res->send(true);
                }
            }
            $res->send(false);
        }
    })

    ->post('/updateProfile', function(Response $res) {
        $res->send($_SESSION['User']->setPhone($_POST["phone"]));
    })

    ->get('/user.icon', function(Response $res) {
        $user = $_SESSION["User"];

        $ico = PUBLIC_FOLDER . 'images/default_user.jpg';
        if (isset($user->getInstallations()[0])) {
            $file = $user->getInstallations()[0]->getPicture()->getPath();
            if (file_exists($file))
                $ico = $file;
        }
        $res->sendFile($ico);
    })

    ->post('/updateInfo', function(Response $res) {
        $roleId = $_SESSION["User"]->getRole()->getId();
        if ($roleId <= 2 && $roleId > 0) {
            $gw = new Gateway($_POST["id"]);
            $inst = $gw->getInstallation();
            if ($roleId == 1) {
                $res->send($inst->update([
                    "city" => isset($_POST["city"]) ? $_POST["city"] : null,
                    "npa" => isset($_POST["npa"]) ? $_POST["npa"] : null,
                    "address" => isset($_POST["address"]) ? $_POST["address"] : null,
                    "noteAdmin" => isset($_POST["adminNote"]) ? $_POST["adminNote"] : null
                ]));
            } else {
                require_once PRIVATE_FOLDER .'./Class/DB/Picture.php';

                function getPicsIds($files) {
                    $ids = [];
                    for ($i = 0; $i < count($files["name"]); $i++) {
                        if ($files["error"][$i] == 0) {
                            $ids[] = Picture::create([
                                "name" => $files["name"][$i],
                                "tmp_name" => $files["tmp_name"][$i]
                            ]);
                        }
                    }
                    return $ids;
                }

                $picId = null;
                if (isset($_FILES["picture"]) && $_FILES["picture"]["error"] == 0) {
                    if ($inst->getPicture()->getId() > 0) {
                        $inst->getPicture()->change($_FILES["picture"]);
                    } else $picId = Picture::create($_FILES["picture"]);
                }


                $_POST["picture"] = $picId;
                $_POST["heatPictures"] = json_encode(array_merge(getPicsIds($_FILES["heatPictures"]), $inst->Heat()->getPicturesId()));
                $_POST["hotwaterPictures"] = json_encode(array_merge(getPicsIds($_FILES["hotwaterPictures"]), $inst->Hotwater()->getPicturesId()));

                unset($_POST["adminNote"]);

                if ($gw->getStatus()->getId() == 1) {
                    require_once PRIVATE_FOLDER .'./Class/Mail.php';
                    Mail::activation($gw->getInstallation()->getUser());
                }

                $res->send($inst->update($_POST) && $gw->setStatus(2));
            }
        }
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