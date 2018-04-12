<?php
$defaultLang = 'en';
define('L10N', json_decode(file_get_contents(PUBLIC_FOLDER . 'l10n/' . $defaultLang . '.json'), true));
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="Dashboard">
        <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">

        <title><?= L10N['login']['title'] ?></title>

        <link href="3rdparty/bootstrap.css" rel="stylesheet">
        <link href="3rdparty/style.css" rel="stylesheet">

        <?php // Necessary ?
        /*
        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
        */ ?>
    </head>
    <style>
        body {
            background: url("login-bg.jpg") no-repeat center fixed;
            background-size: cover;
        }
    </style>
    <body>
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
    </body>
    <script src="login.js"></script>
</html>