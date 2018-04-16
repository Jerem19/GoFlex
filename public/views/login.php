<?php
$defaultLang = 'en';
define('L10N', json_decode(file_get_contents(PUBLIC_FOLDER . 'l10n/' . $defaultLang . '.json'), true));

$metas = [
    "viewport" => "width=device-width, initial-scale=1.0",
    "description" => "",
    "author" => "Dashboard",
    "keyword" => "Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina"
];
$styles = [
    "3rdparty/bootstrap.css",
    "3rdparty/style.css"
];
$title = L10N["login"]["title"];
$scriptsIE = [];

include "partials/header.php";
?>
    <style>
        body {
            background: url("login-bg.jpg") no-repeat center fixed;
            background-size: cover;
        }
    </style>

    <div id="login-page">
        <?php //echo PARAMS["some text"]; ?>
        <div class="container">
            <form class="form-login" action='' method='post'>
                <h2 class="form-login-heading"><?= L10N['login']['sign_in_now'] ?></h2>
                <div class="login-wrap">
                    <input type="text" class="form-control" placeholder="<?= L10N['login']['username'] ?>" name="username" autofocus>
                    <br>
                    <input type="password" class="form-control" name="password" placeholder="<?= L10N['login']['password'] ?>">
                    <label class="checkbox">
                            <span class="pull-right">
                                <a data-toggle="modal"><?= L10N['login']['forgot_pwd'] ?></a>
                            </span>
                    </label>
                    <button class="btn btn-theme btn-block" type="submit"><?= L10N['login']['sign_in'] ?></button>

                </div>
            </form>
        </div>
    </div>
<?php
$scripts = [ "login.js" ];
include 'partials/footer.php';