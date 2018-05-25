<?php
$isSignup = isset($user);

$metas = [
    "viewport" => "width=device-width, initial-scale=1.0",
    "description" => "",
    "author" => "",
    "keyword" => "Login"
];
$styles = [
    "https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css",
    "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css",
    "3rdparty/style.css",
    "3rdparty/style-responsive.css",
    "/footer.css",
    "/login.css"
];

$l10n = L10N["login"];//$isSignup ? L10N["signup"] : L10N["login"]; // for translate
$title = $l10n["title"];
$scriptsIE = [];

include "partials/header.php";
?>
    <div id="main-content" style="margin: 0">
        <?php include 'partials/sltLang.php';?>
        <div class="container">
            <form class="form-login" method="post">
                <h2 class="form-login-heading"><?= L10N['login']['sign_in_now'] ?></h2>
                <div class="login-wrap">
                    <input autofocus type="text" class="form-control" required placeholder="<?= L10N['login']['username'] ?>" name="username" autofocus <?php if ($isSignup) echo 'disabled value="' . $user->getUsername() . '"'; ?>">
                    <br>
                    <input style="margin-bottom: 20px;" type="password" class="form-control" required name="password" placeholder="<?= L10N['login']['password'] ?>">

                    <label style="display: none;" class="checkbox">
                            <span class="pull-right">
                                <a data-toggle="modal"><?= L10N['login']['forgot_pwd'] ?></a>
                            </span>
                    </label>
                    <button class="btn btn-theme btn-block" name="submit" type="submit"><?= L10N['login']['sign_in'] ?></button>
                    <img src="<?= BASE_URL ?>/public/images/goflex-logo.png" style="margin-top: 10px; width: 100%;">
                </div>
            </form>
        </div>
    </div>
    <div class="backstretch"><img /></div>
<?php
include 'partials/index/footer.php';
$scripts = [
    "https://code.jquery.com/jquery-3.1.1.min.js",
    "https://blacktie.co/demo/dashgum/assets/js/jquery.backstretch.min.js",
    "/l10n.js",
    "/footer.js",
    "/login.js"
];
include 'partials/footer.php';