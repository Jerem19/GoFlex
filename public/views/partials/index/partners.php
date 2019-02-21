<div class="row mt col-lg-12 form-panel" id="partner">
    <div style="width:80%;margin:auto;">
        <h3>Informations</h3>
        <p>
           <?= $l10n["partners"]["main_text"] ?><a href="mailto:goflex@esr.ch">goflex@esr.ch</a>
        </p>
        <hr />
        <div class="row">
            <div class="col-xs-12 col-sm-3"><img style="max-width:100%;" src="<?= BASE_URL ?>public/images/goflex-logo.png"></div>
            <div class="col-xs-12 col-sm-9"><p><?= $l10n["partners"]["goflex"] ?></p></div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-3"><img style="max-width:100%;" src="<?= BASE_URL ?>public/images/ch-partner.png"></div>
            <div class="col-xs-12 col-sm-9"><p><?= $l10n["partners"]["ch"] ?></p></div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-3"><img style="max-width:100%;" src="<?= BASE_URL ?>public/images/eu-partner.png"></div>
            <div class="col-sm-9"><p><?= $l10n["partners"]["eu"] ?></p></div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-3"><img style="max-width:100%;" src="<?= BASE_URL ?>public/images/ark-partner.png"></div>
            <div class="col-xs-12 col-sm-9"><p><?= $l10n["partners"]["theark"] ?></p></div>
        </div>
    </div>
</div>

<style>
    div#partner div.row {
        margin: 10px 0;
    }

    div#partner div.row div.col-sm-3{
        margin-bottom: 2px;
    }
</style>