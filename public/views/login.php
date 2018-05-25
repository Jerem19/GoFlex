<?php
$isSignup = isset($user);
$l10n = L10N["login"];
?>
<!DOCTYPE html>
<html lang="<?= $_SESSION["lang"] ?>">
    <head>
        <meta charset="utf-8">
        <title><?= $l10n["title"]; ?></title>

        <?php loadMeta([
            "viewport" => "width=device-width, initial-scale=1.0",
            "keyword" => "Login"
        ]);

        loadStyles([
            "https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css",
            "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css",
            "3rdparty/style.css",
            "3rdparty/style-responsive.css",
            "/footer.css",
            "/login.css"
        ]); ?>

    </head>
    <body> <?php include 'partials/sltLang.php';?>
        <div id="main-content" style="margin: 0">
            <div class="container">
                <form class="form-login" method="post">
                    <h2 class="form-login-heading"><?= $l10n['sign_in_now'] ?></h2>
                    <div class="login-wrap">
                        <input autofocus type="text" class="form-control" required placeholder="<?= $l10n['username'] ?>" name="username" autofocus <?php if ($isSignup) echo 'disabled value="' . $user->getUsername() . '"'; ?>">
                        <br>
                        <input style="margin-bottom: 20px;" type="password" class="form-control" required name="password" placeholder="<?= $l10n['password'] ?>">

                        <label style="display: none;" class="checkbox">
                            <span class="pull-right">
                                <a data-toggle="modal"><?= $l10n['forgot_pwd'] ?></a>
                            </span>
                        </label>
                        <button class="btn btn-theme btn-block" name="submit" type="submit"><?= $l10n['sign_in'] ?></button>
                        <img src="<?= BASE_URL ?>esr-logo.png" style="margin-top: 10px; width: 100%;">
                    </div>
                </form>
            </div>
        </div>
        <div class="backstretch"></div>
    </body>
    <?php include 'partials/footer.php';
    loadScripts([
        "https://code.jquery.com/jquery-3.1.1.min.js",
        "https://blacktie.co/demo/dashgum/assets/js/jquery.backstretch.min.js",
        "/script.js",
        "/login.js"
    ]); ?>
</html>
