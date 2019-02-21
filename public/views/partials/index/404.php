<?php loadStyles([
        "/index/404.css"
]); ?>

<div class="form-panel" id="notfound" style="text-align: center;">
    <h1>404</h1>
    <h3><?= L10N["index"]["404"]["main_text"] ?></h3>
</div>

<script>
    window.onload = function() {
        $("#footer").css("overflow","hidden");
        $("#footer").prepend($('<div class="tumbleweed"></div>').css("bottom",$("#footer-child").height()).show());
        resizeFooter();
    }
</script>