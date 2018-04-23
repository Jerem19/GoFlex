<?php
$l10n = L10N["index"];
$metas = [
    "viewport" => "width=device-width, initial-scale=1.0",
    "description" => "",
    "author" => "Dashboard",
    "keyword" => "Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina"
];
$styles = [
    "//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css",
    "//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css",
    "3rdparty/style.css",
    "3rdparty/style-responsive.css",
    "index.css"
];
$scriptsIE = [
    "//oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js",
    "//oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js",
    "//code.highcharts.com/highcharts.js",
    "//code.highcharts.com/modules/exporting.js"
];
$title = "GOFLEX-Service technique";
include "partials/header.php";
?>

<section id="container">
    <?php include 'partials/index/header.php';
    include 'partials/index/sidebar.php'; ?>
    <section id="main-content">
        <section class="wrapper">

            <?php if (isset($params["path"])) {
                switch ($params["path"]) {
                    case "profile":
                        include 'partials/index/profile.php';
                }
            }?>

        </section>
        <?php include 'partials/index/footer.php'; ?>
    </section>
</section>

<?php
$scripts = [
    "//code.jquery.com/jquery-3.1.1.min.js",
    "//code.highcharts.com/stock/highstock.js",
    "//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js",
    "//cdnjs.cloudflare.com/ajax/libs/jquery-scrollTo/2.1.2/jquery.scrollTo.js",
    "//blacktie.co/demo/dashgum/assets/js/jquery.dcjqaccordion.2.7.js",
    "//cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.js",
    "3rdparty/common-scripts.js",
    "l10n.js"
];
include 'partials/footer.php';
?>