</body>
    <?php foreach ($scripts as $script) {
    if (! ($script[0] == "/" && $script[1] == "/" || substr($script,0,4) == "http"))
        $script = BASE_URL . $script; ?>
    <script type="text/javascript" src="<?= $script ?>"></script>
<?php } ?>

</html>