<?php
$defaultLang = 'en';
define('L10N', json_decode(file_get_contents(PUBLIC_FOLDER . 'l10n/' . $defaultLang . '.json'), true));

$metas = [
    "viewport" => "width=device-width, initial-scale=1.0",
    "description" => "",
    "author" => "Dashboard",
    "keyword" => "Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina"
];
$styles = [
    "3rdparty/bootstrap.css",
    "3rdparty/style.css"
];
$title = "contact";
$scriptsIE = [];

include "partials/header.php";
?>
<?php
$scripts = [];
include 'partials/footer.php';