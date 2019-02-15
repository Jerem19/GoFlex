<div class="form-panel" style="width:100%;" id="notfound">
    <h1 style="text-align: center;">404</h1>
    <h3 style="text-align: center;"><?= L10N["index"]["404"]["main_text"] ?></h3>
</div>
<div class="tumbleweed" style="display: none;"></div>
<script>

    window.onload = function() {
        $("#footer").css("overflow","hidden");
        $("#footer").prepend($(".tumbleweed").css("bottom",$("#footer-child").height()).show());
        resizeFooter();
    }
</script>
<style>
    body {
        background-image: url("<?= BASE_URL ?>/404/background.jpg");
        background-size: cover;
        background-position-x: right;
        background-position-y: bottom;
    }

    .tumbleweed{
        position: absolute;
        bottom: 0;
        left: -70px;
        width: 70px;
        height: 70px;
        background: url('<?= BASE_URL ?>/404/tumbleweed.png') no-repeat;
        background-size: 100%;
        animation: tumbleweed 5s linear infinite;
        z-index: 0;
    }

    @keyframes tumbleweed{
        0% {
            transform:  translateY(-45px)  rotate(0deg);
            left: -10%;
        }
        9% {
            transform:  translateY(0px)  rotate(130deg);
        }
        17% {
            transform:  translateY(-30px)  rotate(250deg);
        }
        26% {
            transform:  translateY(-15px)  rotate(360deg);
        }
        34% {
            transform:  translateY(0px)  rotate(490deg);
        }
        42% {
            transform:  translateY(-15px)  rotate(600deg);
        }
        50% {
            transform:  translateY(-45px)  rotate(720deg);
        }
        59% {
            transform:  translateY(-15px)  rotate(800deg);
        }
        67% {
            transform:  translateY(0px)  rotate(860deg);
        }
        76% {
            transform:  translateY(-30px)  rotate(980deg);
        }
        84% {
            transform:  translateY(-45px)  rotate(1140deg);
        }
        92% {
            transform:  translateY(-30px)  rotate(1300deg);
        }
        100% {
            transform:  translateY(-45px)  rotate(1400deg);
            left: 100%;
        }
    }
</style>