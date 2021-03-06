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
        "https://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css",
        "https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css",
        "/3rdparty/style.css",
        "/3rdparty/BootstrapXL.css",
        "/3rdparty/style-responsive.css",
        "/3rdparty/lightpick.css",
        "/footer.css",
        "/index.css",
    ]);
    ?>

</head>
<body>

<section id="container">
    <?php include 'partials/index/header.php';
    include 'partials/index/sidebar.php'; ?>
    <section id="main-content" style="position: relative;">
        <section class="wrapper">
            <?php $roleId = $user->getRole()->getId();

            $includedFiles = count(get_included_files());
            if (isset($path)) {
                if ($roleId == 1) {
                    switch ($path) {
                        case "creationUser":
                            include 'partials/index/addUser.php';
                            break;

                        case "editUser":
                            include 'partials/index/editUser.php';
                            break;

                        case "checkUserData":
                            include 'partials/index/userData.php';
                            break;

                        case "allUsers":
                            include 'partials/index/allUsers.php';
                            break;

                        case "userGraph":
                            include 'partials/index/userGraph.php';
                            break;
                    }
                } else if ($roleId == 2) {
                    switch ($path) {
                        case "checkUserData": $isInstall = false;
                        case "installationGateway":
                            $isInstall = !isset($isInstall);
                            include 'partials/index/userData.php';
                            break;
                        case "userGraph":
                            include 'partials/index/userGraph.php';
                            break;
                    }
                } else if ($roleId == 3) {
                    switch ($path) {
                        case "checkUserData":
                            include 'partials/index/userData.php';
                            break;
                    }
                } else if ($roleId == 4) {
                    switch ($path) {
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
                }

                switch ($path) {
                    case "profile":
                        include 'partials/index/profile.php';
                        break;
                    case "partners":
                        include 'partials/index/partners.php';
                        break;
                }
            } else if ($roleId == 4)
                include 'partials/index/dashboard.php';

            if ($includedFiles === count(get_included_files()))
                include 'partials/index/404.php';
            ?>

        </section>

        <?php include 'partials/footer.php'; ?>
    </section>
</section>

</body>
<?php loadScripts([
    /*"https://code.jquery.com/jquery-3.1.1.min.js",*/
    "https://cdn.jsdelivr.net/jquery/latest/jquery.min.js",
    "https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js",
    "https://code.highcharts.com/stock/highstock.js",
    "https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js",
    "https://cdnjs.cloudflare.com/ajax/libs/jquery-scrollTo/2.1.2/jquery.scrollTo.js",
    "https://code.highcharts.com/modules/exporting.js",
    "https://code.highcharts.com/modules/export-data.js",
    "https://cdn.jsdelivr.net/npm/dcjqaccordion@2.7.1/js/jquery.dcjqaccordion.2.7.min.js",
    "https://cdn.jsdelivr.net/npm/dcjqaccordion@2.7.1/js/jquery.cookie.js",
    "https://cdn.jsdelivr.net/gh/jboesch/Gritter@1.7.4/js/jquery.gritter.min.js",
    "https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js",
    "/3rdparty/common-scripts.js",
    "/3rdparty/lightbox.js",
    "/3rdparty/lightpick.js",
    "/script.js",
    "/index.js",
]); ?>
</html>