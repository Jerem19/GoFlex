<?php require_once 'Class/Router.php';

$router = new Router();
define('BASE_URL', $router->getBaseURL() . '/');

$router
    ->on('/*.css', function(Response $res, $args) { // active less (if 2 same names => less has priority)
        $file = PUBLIC_FOLDER . 'css-less/' . $args[0] . '.less';
        if (file_exists($file)) {
            require_once 'less.inc.php';
            $css = new lessc;
            $css->setVariables([
                "base_url" => '"' . BASE_URL .  '"'
            ]);
            $res->send($css->compileFile($file), false, "text/css");
        }
    })
    ->byExt('css', PUBLIC_FOLDER . 'css')
    ->byExt('js', PUBLIC_FOLDER . 'js')
    ->byExt(['png', 'jpg', 'jpeg', 'gif', 'tiff', 'bmp', 'ico'], PUBLIC_FOLDER . 'images')
    ->on('/base_url', function(Response $res) {
        $res->send(BASE_URL);
    });

require_once 'Class/DB/User.php';
session_set_cookie_params(30*30*60);
session_start();

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
            "callback" => function(Response $res) {
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
            "callback" => function(Response $res, $args) {
                $res->sendFile(sprintf("%sl10n/%s.json",PUBLIC_FOLDER, $args["lang"]));
            }
        ]
    ])

    /*->get("/contact", function(Response $res) {
        $res->render("contact.php");
    })*/;

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

    ->post('/data/*', function() {
        require_once 'routes/data.php';
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
                        }
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

    ->post('/userInfo', function(Response $res) {
        if ($_SESSION["User"]->getRole()->getId() != 4) {
            if (isset($_POST["id"])) {
                $user = new User($_POST["id"]);
                if ($user->getId() > 0) {
                    $res->send(array(
                        "username" => $user->getUsername(),
                        "firstname" => $user->getFirstname(),
                        "lastname" => $user->getLastname(),
                        "phone" => $user->getPhone(),
                        "email" => $user->getEMail()
                    ));
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

    ->post('/user_exist', function (Response $res) {
        if ($_SESSION["User"]->getRole()->getId() != 4)
            $res->send(isset($_POST["user"]) ? User::exists($_POST["user"]) : false);
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

    ->post('/edit', function(Response $res) {
        if ($_SESSION["User"]->getRole()->getId() == 1) {
            $user = new User($_POST["id"]);
            if ($user->getId() > 0)
                $res->send($user->update($_POST));
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
        if ($_SESSION["User"]->getRole()->getId() < 4)
            $res->redirect('/checkUserData');
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