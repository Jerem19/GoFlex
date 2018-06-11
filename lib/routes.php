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
    ->byExt(['png', 'jpg', 'jpeg', 'gif', 'tiff', 'bmp'], PUBLIC_FOLDER . 'images')
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

    ->post('/insideTemp', function(Response $res) {
        $database = getInfluxDb();
        $dbName = getUser($_SESSION["User"]);
        $result = $database->query('SELECT value FROM "'.$dbName.'.nodes.ambientSensor-1.objects.temperature.attributes.datapoint" ORDER BY "time" DESC ;');
        $res->send($result->getPoints());
    })
    ->post('/electricConsumption', function(Response $res) {
        $database = getInfluxDb();
        $dbName = getUser($_SESSION["User"]);
        $result = $database->query('SELECT value FROM "'.$dbName.'.nodes.SmartMeterTechnical.objects.obis_1_0_1_7_0_255_2.attributes.datapoint" ORDER BY "time" DESC ;');

        $res->send($result->getPoints());
    })
    ->post('/consumptionHeatPump', function(Response $res) {
        $database = getInfluxDb();
        $dbName = getUser($_SESSION["User"]);
        $result = $database->query('SELECT value FROM "'.$dbName.'.nodes.powerMeter-1.objects.wattsTotal.attributes.datapoint" ORDER BY "time" DESC ;');

        $res->send($result->getPoints());
    })

    ->post('/hotwaterTemperature', function(Response $res) {
        $database = getInfluxDb();
        $dbName = getUser($_SESSION["User"]);
        $result = $database->query('SELECT value FROM "'.$dbName.'.nodes.boilerSensor-1.objects.temperature.attributes.datapoint" ORDER BY "time" DESC ;');
        $res->send($result->getPoints());
    })

    ->get('/pics/:img.pic', function(Response $res, $params) {        
        if ($_SESSION["User"]->getRole()->getId() != 4)
            $res->sendFile( (new Picture($params["img"]))->getPath());
    })

    ->post('/installInfo', function(Response $res) {
        if (isset($_POST["id"])) {
            $inst = Installation::getByUser($_POST["id"]);
            if (isset($inst[0])) {
                $inst = $inst[0];
                $data = $inst->getJSON();
                foreach ($inst->Hotwater()->getPictures() as $pic)
                    $data["hotwaterPics"][] = [
                        "url" => sprintf('%spics/%s.pic', BASE_URL, $pic->getId()),
                        "name" => $pic->getName()
                    ];
                foreach ($inst->Heat()->getPictures() as $pic)
                    $data["heatPics"][] = [
                        "url" => sprintf('%spics/%s.pic', BASE_URL, $pic->getId()),
                        "name" => $pic->getName()
                    ];
                $data["gwId"] = $inst->getGateway()->getId();
                $res->send($data);
            }
        }
        $res->send(false);
    })

    ->post('/gw_exist', function(Response $res) {
        $res->send(isset($_POST["gw"]) ? Gateway::exists($_POST["gw"]) : false);
    })

    ->post('/create', function(Response $res) {
        if (isset($_POST["username"]) && isset($_POST["email"])
            && !(User::exists($_POST["username"]))) {

            if($_POST["role"] == 4) {
                if (isset($_POST["gatewayname"]) && $_POST["gatewayname"] != "" && !Gateway::exists($_POST["gatewayname"])) {
                    $gateway = "goflex-dc-" . $_POST["gatewayname"];
                    unset($_POST["gatewayname"]);

                    $userId = User::create($_POST);
                    $gwId = Gateway::create(["name" => $gateway]);

                    $res->send(Installation::link($userId, $gwId) != false);
                }
            } else {
                require_once PRIVATE_FOLDER .'./Class/Mail.php';
                unset($_POST["gatewayname"]);
                $user = new User(User::create($_POST));
                Mail::activation($user);
                $res->send(true);
            }

        }
        $res->send(false);
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

    ->post('/linkUserGateway', function(Response $res) {
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
        if (isset($_FILES["picture"]) && $_FILES["picture"]["error"] == 0)
            $picId = Picture::create($_FILES["picture"]);

        $_POST["picture"] = $picId;
        $_POST["heatPictures"] = json_encode(getPicsIds($_FILES["heatPictures"]));
        $_POST["hotwaterPictures"] = json_encode(getPicsIds($_FILES["hotwaterPictures"]));

        $gw = new Gateway($_POST["gwId"]);
        unset($_POST["gwId"]);
        if ($gw->getInstallation()->update($_POST) && $gw->setStatus(2)) {
            require_once PRIVATE_FOLDER .'./Class/Mail.php';
            Mail::activation($gw->getInstallation()->getUser());
            $res->send(true);
        }

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