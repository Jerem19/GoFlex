<?php
$isSignup = isset($user);
$l10n = L10N["login"];
?>
<!DOCTYPE html>
<html lang="<?= $_SESSION["lang"] ?>">
    <head>
        <meta charset="utf-8">
        <title><?= $l10n["title"]; ?></title>

        <link rel="icon" type="image/ico" href="<?= BASE_URL ?>favicon_Goflex.ico">

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
                    <h2 class="form-login-heading"><?= $l10n['passwordRecuperation'] ?></h2>
                    <div class="login-wrap">
                        <input autofocus type="text" class="form-control" required placeholder="<?= $l10n['email'] ?>" name="email" autofocus>
                        <br>
                        <div class="g-recaptcha" data-sitekey="6Leynl8UAAAAAEsejH5h0AcmjYh_GsimjlrMdpfm"></div>
                        <br>
                        <button class="btn btn-theme btn-block" name="submit" type="submit"><?php echo $l10n['passwordRecuperation'];  ?></button>
                        <a href="https://goflex-community.eu/"><img src="<?= BASE_URL ?>goflex-logo.png" style="margin-top: 10px; width: 100%;"></a>
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
        "https://www.google.com/recaptcha/api.js",
        "/script.js",
        "/login.js"
    ]); ?>
</html>
