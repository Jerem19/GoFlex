<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">

    <?php foreach ($metas as $key => $value) { ?>
        <meta name="<?= $key ?>" content="<?= $value ?>">
    <?php } ?>

    <?php foreach ($styles as $style) {
        if (! ($style[0] == "/" && $style[1] == "/" || substr($style,0,4) == "http"))
            $style = BASE_URL . $style; ?>
        <link rel="stylesheet" type="text/css" href="<?= $style ?>">
    <?php } ?>

    <title><?= $title; ?></title>

    <!--[if lt IE 9]>
    <?php foreach ($scriptsIE as $script) {
    if (! (substr($script,0,2) == '//' || substr($script,0,4) == "http"))
            $script = BASE_URL . $script; ?>
        <script type="text/javascript" src="<?= $script ?>"></script>
    <?php } ?>
    <![endif]-->

</head>
<body>