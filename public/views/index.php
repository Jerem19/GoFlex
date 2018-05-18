<?php
$l10n = L10N["index"];
$metas = [
    "viewport" => "width=device-width, initial-scale=1.0",
    "description" => "",
    "author" => "Dashboard",
    "keyword" => "Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina"
];
$styles = [
    "https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css",
    "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css",
    "3rdparty/style.css",
    "3rdparty/style-responsive.css",
    "index.css"
];
$scriptsIE = [
    "https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js",
    "https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js",
    "https://code.highcharts.com/highcharts.js",
    "https://code.highcharts.com/modules/exporting.js"
];
$title = "GOFLEX-Service technique";
include "partials/header.php";
?>

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

                        case "creationSpecialUser":
                            include 'partials/index/addSpecialUser.php';
                            break;

                        case "checkUserData":
                            include 'partials/index/checkUserData.php';
                            break;
                    }
                } elseif ($user->getRole()->getId() == 2) {
                    if (isset($path)) {
                        switch ($path) {
                            case "installationGateway":
                                include 'partials/index/installationGateway.php';
                                break;

                            case "checkUserData":
                                include 'partials/index/checkUserData.php';
                                break;
                        }
                    }
                }

                elseif ($user->getRole()->getId() == 3) {
                    if (isset($path)) {
                        switch ($path) {
                           case "checkUserData":
                                include 'partials/index/checkUserData.php';
                                break;
                        }
                    }
                }

                ?>

                <?php
                switch ($path) {

                    case "dashboard":
                        include 'partials/index/dashboard.php';
                        break;
                    case "profile":
                        include 'partials/index/profile.php';
                        break;
                    case "consumption":
                        include 'partials/index/chart/consumption.php';
                        break;
                    case "heater":
                        include 'partials/index/chart/heat_pump.php';
                        break;
                }
            }?>

        </section>

    </section>
</section>
<?php include 'partials/index/footer.php'; ?>

<?php
$scripts = [
"https://code.jquery.com/jquery-3.1.1.min.js",
"https://code.highcharts.com/stock/highstock.js",
"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js",
"https://cdnjs.cloudflare.com/ajax/libs/jquery-scrollTo/2.1.2/jquery.scrollTo.js",
"https://blacktie.co/demo/dashgum/assets/js/jquery.dcjqaccordion.2.7.js",
"https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.js",
"3rdparty/common-scripts.js",
"/l10n.js",
"/index.js"
];
include 'partials/footer.php';
?>