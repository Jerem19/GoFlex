<?php

$metas = [
    "viewport" => "",
    "description" => "",
    "author" => "",
    "keyword" => "Login"
];
$styles = [
    "http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css",
    "3rdparty/style.css",
    "/login.css"
];
$title = L10N["login"]["title"];
$scriptsIE = [];

include "partials/header.php";
?>
    <div id="login-page">
        <?php include 'partials/sltLang.php';?>
        <div class="container">
            <form class="form-login" method="post">
                <h2 class="form-login-heading"><?= L10N['login']['sign_in_now'] ?></h2>
                <div class="login-wrap">
                    <input autofocus type="text" class="form-control" required placeholder="<?= L10N['login']['username'] ?>" name="username" autofocus>
                    <br>
                    <input type="password" class="form-control" required name="password" placeholder="<?= L10N['login']['password'] ?>">
                    <label class="checkbox">
                            <span class="pull-right">
                                <a data-toggle="modal"><?= L10N['login']['forgot_pwd'] ?></a>
                            </span>
                    </label>
                    <button class="btn btn-theme btn-block" name="submit" type="submit"><?= L10N['login']['sign_in'] ?></button>

                </div>
            </form>
        </div>
    </div>
<?php
include 'partials/index/footer.php';
$scripts = [ "/l10n.js", "/login.js" ];
include 'partials/footer.php';