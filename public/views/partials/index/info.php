<?php
function chart_info($chart) {
    $l10n = L10N["index"]; ?>
    <div style="width:75%;font-size:15px;margin:auto;text-align:center;">
        <p style="width:75%;margin:auto;text-align:left;"><?= $l10n["info"][$chart]["info"] ?></p>

        <img style="margin:20px 0px;max-width:100%;" src="<?= BASE_URL ?>/public/images/info/<?= $chart ?>.png"/>

        <?php eco_tip($l10n["info"][$chart]["tip"]); ?>

        <?php if(!empty($l10n["info"][$chart]["note"])) { ?>
            <br style="clear: both" /><br />
            <p style="width:75%;margin:auto;text-align:left;"><?= $l10n["info"][$chart]["note"] ?></p>
        <?php } ?>
    </div>
<?php }

function eco_tip($tip) { ?>
    <p class="eco_tip">
        <img src="<?= BASE_URL ?>/public/images/eco-reflexes.png" />
        <?= $tip ?>
    </p>

    <style>
        .eco_tip {
            width:75%;
            margin:auto;
            text-align:left;
            display:flex;
            align-items:center;
        }

        .eco_tip img {
            max-height:100px;
            max-width:25%;
            float:left;
        }

        @media (max-width: 590px) {
            .eco_tip {
                width:100%;
            }
        }
    </style>
<?php } ?>


