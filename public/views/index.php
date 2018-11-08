<?php $l10n = L10N["index"]; ?>
<!DOCTYPE html>
<html lang="<?= $_SESSION["lang"] ?>">
<head>
    <meta charset="utf-8">
    <title>GOFLEX-Service technique</title>

    <link rel="icon" href="<?= BASE_URL ?>favicon_Goflex.ico">

    <?php loadMeta([
        "viewport" => "width=device-width, initial-scale=1.0",
        "description" => "",
        "author" => "Dashboard",
        "keyword" => "Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina"
    ]);

    loadStyles([
        "https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css",
        "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css",
        "https://cdn.jsdelivr.net/gh/jboesch/Gritter@1.7.4/css/jquery.gritter.css",
        "3rdparty/style.css",
        "3rdparty/BootstrapXL.css",
        "3rdparty/style-responsive.css",
        "/footer.css",
        "/index.css"
    ]);
    ?>

</head>
<body>

<section id="container">
    <?php include 'partials/index/header.php';
    include 'partials/index/sidebar.php'; ?>
    <section id="main-content" style="position: relative;">
        <section class="wrapper">

            <?php

            if (isset($path)) {
                if ($user->getRole()->getId() == 1) {
                    switch ($path) {
                        case "creationUser":
                            include 'partials/index/addUser.php';
                            break;

                        case "checkUserData": $isInstall = false;
                            include 'partials/index/userData.php';
                            break;

                        case "allUsers":
                            include 'partials/index/allUsers.php';
                            break;

                        case "grafana":
                            header('Location: https://cloudio-data.esr.ch/grafana/');
                            break;

                        case "userGraph":
                            include 'partials/index/userGraph.php';
                            break;
                    }
                } else if ($user->getRole()->getId() == 2) {
                    if (isset($path)) {
                        switch ($path) {
                            case "checkUserData": $isInstall = false;
                            case "installationGateway":
                                $isInstall = !isset($isInstall) || $isInstall && true;
                                include 'partials/index/userData.php';
                                break;
                            case "grafana":
                                header('Location: https://cloudio-data.esr.ch/grafana/');
                                break;
                            case "userGraph":
                                include 'partials/index/userGraph.php';
                                break;
                        }
                    }
                }

                else if ($user->getRole()->getId() == 3) {
                    if (isset($path)) {
                        switch ($path) {
                            case "checkUserData":
                                include 'partials/index/checkUserData.php';
                                break;
                        }
                    }
                }

                switch ($path) {
                    case "profile":
                        include 'partials/index/profile.php';
                        break;
                    case "consumptionElect":
                        include 'partials/index/chart/consumptionElect.php';
                        break;
                    case "boiler":
                        include 'partials/index/chart/boiler.php';
                        break;
                    case "consumptionHeatPump":
                        include 'partials/index/chart/heat_pump.php';
                        break;
                    case "insideTemp":
                        include 'partials/index/chart/insideTemperature.php';
                        break;
                    case "productionElect":
                        include 'partials/index/chart/productionElect.php';
                        break;
                }
            } else {
                if ($user->getRole()->getId() < 4)
                    $this->redirect('/checkUserData');
                else include 'partials/index/dashboard.php';

            }?>

        </section>

        <?php include 'partials/footer.php'; ?>
    </section>
</section>

</body>
<?php loadScripts([
    "https://code.jquery.com/jquery-3.1.1.min.js",
    "https://code.highcharts.com/stock/highstock.js",
    "https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js",
    "https://cdnjs.cloudflare.com/ajax/libs/jquery-scrollTo/2.1.2/jquery.scrollTo.js",
    "https://blacktie.co/demo/dashgum/assets/js/jquery.dcjqaccordion.2.7.js",
    "https://cdn.jsdelivr.net/gh/jboesch/Gritter@1.7.4/js/jquery.gritter.min.js",
    "3rdparty/common-scripts.js",
    "3rdparty/lightbox.js",
    "/script.js",
    "/index.js"
]); ?>
</html>