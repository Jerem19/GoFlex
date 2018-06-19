<?php
    $isSignup = isset($user);
    $isPwdRecup = isset($pwdRecup) && !$isSignup;
    $l10n = L10N["login"];
    $l10nSpec = $l10n[($isSignup ? "signup" : ($isPwdRecup ? "pwd_rec" : "login"))];
?>

<!DOCTYPE html>
<html lang="<?= $_SESSION["lang"] ?>">
    <head>
        <meta charset="utf-8">
        <title><?= $l10nSpec["title"]; ?></title>

        <link rel="icon" href="<?= BASE_URL ?>favicon_Goflex.ico">

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
        <div id="loading" style="display: none;"></div>
        <div id="main-content" style="margin: 0">
            <div class="container">
                <form class="form-login" method="post" action="<?= $isPwdRecup ? 'getpassword' : 'login' ?>">
                    <fieldset>
                        <h2 class="form-login-heading"><?= $l10nSpec['header'] ?></h2>
                        <div class="login-wrap">
                            <?php if ($isPwdRecup) { ?>
                                <input autofocus type="email" class="form-control" required
                                   placeholder="<?= $l10n['email'] ?>" name="email" autofocus>
                                <div class="g-recaptcha" data-sitekey="6Leynl8UAAAAAEsejH5h0AcmjYh_GsimjlrMdpfm"></div>
                                <script>
                                    window.onload = function () {
                                        grecaptcha.ready(function () {
                                            resizeFooter();
                                        });
                                    };
                                </script>
                            <?php } else { ?>
                                <input autofocus type="text" class="form-control" required
                                       placeholder="<?= $l10n['username'] ?>" name="username"
                                       autofocus <?php if ($isSignup) printf('readonly value="%s"', $user->getUsername()); ?>">
                                <input type="password" class="form-control" required name="password"
                                       placeholder="<?= $l10n['password'] ?>">
                            <?php } ?>
                            <label class="checkbox">
                            <span class="pull-right">
                                <a data-toggle="modal" href="<?= BASE_URL . ($isPwdRecup || $isSignup ? '' : 'getpassword') ?>">
                                    <?= $l10n[$isPwdRecup || $isSignup ? 'return_login' : 'forgot_pwd'] ?>
                                </a>
                            </span>
                            </label>
                            <button class="btn btn-theme btn-block" name="submit" type="submit"><?= $l10nSpec['button'] ?></button>
                            <a href="https://goflex-community.eu/">
                                <img src="<?= BASE_URL ?>goflex-logo.png" style="margin-top: 10px; width: 100%;">
                            </a>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
        <div class="backstretch"></div>
    </body>
    <?php include 'partials/footer.php';
    loadScripts([
        "https://code.jquery.com/jquery-3.1.1.min.js",
        "https://blacktie.co/demo/dashgum/assets/js/jquery.backstretch.min.js",
        $isPwdRecup ? "https://www.google.com/recaptcha/api.js" : "",
        "/script.js",
        "/login.js"
    ]); ?>
</html>
