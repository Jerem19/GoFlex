<div class="form-panel flex-fill" id="notfound">
    <h1 style="text-align: center;">404</h1>
    <h3 style="text-align: center;"><?= L10N["index"]["404"]["main_text"] ?></h3>

    <style>
        #notfound {
            animation: falling 5s linear 0s 1 normal ;
        }

        @keyframes falling {
            0%   {transform: rotate(30deg); }
            75%  {transform: translate(40px, 100px); }
        }
    </style>
</div>
