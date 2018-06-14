<div class="row mt col-lg-12 form-panel" style="margin-bottom: 10px; text-align: center; font-size: xx-large;">
    <?= L10N['index']['sidebar']['checkUserData']?>
</div>
<div class="row mt col-lg-12 form-panel">
    <form class="form-horizontal style-form" id="formCheckUserData" method="post">

        <label class="control-label col-sm-12" style="font-size: x-large;"><?= L10N['index']['checkUserData']['chooseUser']?></label>

        <select name="client" class="col-sm-8 form-control">
            <?php
            foreach (User::getAllLinked() as $user) { ?>
                <option value="<?= $user->getId() ?>"><?= $user->getInstallations()[0]->getGateway()->getName() ?> [<?= $user->getUsername() ?>]</option>
            <?php }?>
        </select>
    </form>
</div>

<div class="row mt col-lg-12 form-panel" id="info" style="display: <?= empty(Gateway::getAllInstalled()) ? "none" : "block" ?>">
    <form class='form-horizontal style-form' id="formLinkGatewayUser" method='post' enctype="multipart/form-data">
        <label class="control-label col-sm-12" style="font-size: x-large; margin-bottom: 20px;"><?= $l10n['installation']['systemDefinition']?></label>

        <div class="form-group">
            <label class="col-sm-2 col-sm-2 control-label"><?= $l10n['installation']['boxNumber']?></label>
            <div class="col-sm-10" style="margin-bottom: 10px;">
                <select name="gwId" class="col-sm-8 form-control">
                    <?php foreach(Gateway::getAllInstalled() as $gw) { ?>
                        <option value="<?= $gw->getId()?>"><?= $gw->getName()?></option>
                    <?php } ?>
                </select>
            </div>

            <label class="col-sm-2 col-sm-2 control-label"><?= $l10n['installation']['facturation']?></label>
            <div class="col-sm-10" style="margin-bottom: 10px;">
                <select name="facturation" class="col-sm-8 form-control">
                    <option value="1"><?= $l10n['installation']['lower']?></option>
                    <option value="0"><?= $l10n['installation']['higher']?></option>
                </select>
            </div>

            <label class="col-sm-2 col-sm-2 control-label"><?= $l10n['installation']['businessSector']?></label>
            <div class="col-sm-10" style="margin-bottom: 10px;">
                <select name="businessSector" class="col-sm-8 form-control">
                    <?php foreach (BusinessSector::getAll() as $busSec) { ?>
                        <option value="<?= $busSec->getId() ?>"><?= $l10n['installation'][$busSec->getName()] ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <label class="control-label col-sm-12" style="font-size: x-large; margin-bottom: 20px;"><?= $l10n['installation']['equipmentEnergyDefinitionHeat']?></label>

        <div class="form-group">
            <label class="col-sm-2 col-sm-2 control-label"><?= $l10n['installation']['energyHeat']?></label>
            <div class="col-sm-10" style="margin-bottom: 10px;">
                <select name="heatEner" class="col-sm-8 form-control">
                    <?php foreach (Energy::getAll() as $ener) { ?>
                        <option value="<?= $ener->getId() ?>"><?= $l10n['installation'][$ener->getName()]?></option>
                    <?php } ?>
                </select>
            </div>

            <label class="col-sm-2 col-sm-2 control-label"><?= $l10n['installation']['technoHeat']?></label>
            <div class="col-sm-10" style="margin-bottom: 10px;">
                <select name="heatTech" class="col-sm-8 form-control">
                    <?php foreach (Technology::getAll() as $tech) { ?>
                        <option value="<?= $tech->getId() ?>"><?= $l10n['installation'][$tech->getName()]?></option>
                    <?php } ?>
                </select>
            </div>

            <label class="col-sm-2 col-sm-2 control-label"><?= $l10n['installation']['consommationSensor']?></label></label>
            <div class="col-sm-10" style="margin-bottom: 10px;">
                <input required="required" type="number" class="col-sm-8 form-control" name="heatSensors" />
            </div>

            <label class="col-sm-2 col-sm-2 control-label"><?= $l10n['installation']['insideTemperatureSensor']?></label></label>
            <div class="col-sm-10" style="margin-bottom: 10px;">
                <input required="required" type="number" class="col-sm-8 form-control" name="heatTempSensors" />
            </div>

            <label class="col-sm-2 col-sm-2 control-label"><?= $l10n['installation']['positionNote']?></label>
            <div class="col-sm-10" style="margin-bottom: 10px;">
                <textarea class="col-sm-8 form-control" name="heatNote"></textarea>
            </div>

            <div class="img-galery col-sm-12" >
                <div id="heatPics"></div>
            </div>
        </div>


        <label class="control-label col-sm-12" style="font-size: x-large; margin-bottom: 20px;"><?= $l10n['installation']['equipmentEnergyDefinitionHotwater']?></label>

        <div class="form-group">
            <label class="col-sm-2 col-sm-2 control-label"><?= $l10n['installation']['energyHotWater']?></label>
            <div class="col-sm-10" style="margin-bottom: 10px;">
                <select name="hotwaterEner" class="col-sm-8 form-control">
                    <?php foreach (Energy::getAll() as $ener) { ?>
                        <option value="<?= $ener->getId() ?>"><?= $l10n['installation'][$ener->getName()]?></option>
                    <?php } ?>
                </select>
            </div>

            <label class="col-sm-2 col-sm-2 control-label"><?= $l10n['installation']['technoHotWater']?></label>
            <div class="col-sm-10" style="margin-bottom: 10px;">
                <select name="hotwaterTech" class="col-sm-8 form-control">
                    <?php foreach (Technology::getAll() as $tech) { ?>
                        <option value="<?= $tech->getId() ?>"><?= $l10n['installation'][$tech->getName()]?></option>
                    <?php } ?>
                </select>
            </div>

            <label class="col-sm-2 col-sm-2 control-label"><?= $l10n['installation']['consommationSensor']?></label></label>
            <div class="col-sm-10" style="margin-bottom: 10px;">
                <input required="required" type="number" class="col-sm-8 form-control" name="hotwaterSensors" />
            </div>

            <label class="col-sm-2 col-sm-2 control-label"><?= $l10n['installation']['boilerTemperatureSensor']?></label></label>
            <div class="col-sm-10" style="margin-bottom: 10px;">
                <input required="required" type="number" class="col-sm-8 form-control" name="hotwaterTempSensors" />
            </div>
            <label class="col-sm-2 col-sm-2 control-label"><?= $l10n['installation']['positionNote']?></label>
            <div class="col-sm-10" style="margin-bottom: 10px;">
                <textarea class="col-sm-8 form-control" name="hotwaterNote"></textarea>
            </div>

            <div class="img-galery col-sm-12">
                <div id="hotwaterPics"></div>
            </div>
        </div>

        <label class="control-label col-sm-12" style="font-size: x-large; margin-bottom: 20px;"><?= $l10n['installation']['equipmentEnergyDefinitionSolarPanel']?></label>

        <div class="form-group">

            <label class="col-sm-2 col-sm-2 control-label"><?= $l10n['installation']['solarPanel']?></label>
            <div class="col-sm-10" style="margin-bottom: 10px;">
                <select id="solarPanelSelect" name="solarPanel" class="col-sm-8 form-control" onChange="disabledOrEnable(this)">
                    <option value="0"><?= $l10n['installation']['no']?></option>
                    <option value="1"><?= $l10n['installation']['yes']?></option>
                </select>
            </div>

            <label class="col-sm-2 col-sm-2 control-label"><?= $l10n['installation']['productionSensor']?></label></label>
            <div class="col-sm-10" style="margin-bottom: 10px;">
                <input id="productionSensor" disabled="disabled" type="number" class="col-sm-8 form-control" name="solarSensors" />
            </div>

            <label class="col-sm-2 col-sm-2 control-label"><?= $l10n['installation']['positionNote']?></label>
            <div class="col-sm-10" style="margin-bottom: 10px;">
                <textarea id="positionNoteSolarPanel" disabled="disabled" class="col-sm-8 form-control" name="solarNote"></textarea>
            </div>

        </div>

        <label class="control-label col-sm-12" style="font-size: x-large; margin-bottom: 20px;"><?= $l10n['installation']['generalInformation']?>
            <a style="font-size: 15px;" id="map-url" target="_blank">[ <?= $l10n['installation']['map_url'] ?> ]</a>
        </label>
        <div class="form-group">

            <label class="col-sm-2 col-sm-2 control-label"><?= $l10n['installation']['address']?></label>
            <div class="col-sm-10" style="margin-bottom: 10px;">
                <input required="required" class="col-sm-8 form-control" name="address" />
            </div>
            <label class="col-sm-2 col-sm-2 control-label"><?= $l10n['installation']['npa']?></label>
            <div class="col-sm-10" style="margin-bottom: 10px;">
                <input required="required" type="number" class="col-sm-8 form-control" name="npa" />
            </div>
            <label class="col-sm-2 col-sm-2 control-label"><?= $l10n['installation']['city']?></label>
            <div class="col-sm-10" style="margin-bottom: 10px;">
                <input required="required" class="col-sm-8 form-control" name="city" />
            </div>
            <label class="col-sm-2 col-sm-2 control-label"><?= $l10n['installation']['generalNote']?></label>
            <div class="col-sm-10" style="margin-bottom: 10px;">
                <textarea class="col-sm-8 form-control" name="note"></textarea>
            </div>
        </div>
    </form>
</div>

<?php loadStyles([
    "3rdparty/lightbox.css"
]); ?>
<script>
    window.onload = function() {
        $('#formLinkGatewayUser').find('input, select, textarea').prop("disabled", true);

        var divHot = $("#hotwaterPics");
        var divHeat = $("#heatPics");
        
        $('select[name="client"').on('change', function() {
            $.post('installInfo', 'id=' + $(this).val(), function(data) {

                divHeat.empty();
                divHot.empty();

                function showImg(imgs, target, attrName) {
                    for (i in imgs) {
                        var img = document.createElement('img');
                        img.src = imgs[i]['url'];
                        img.alt = imgs[i]['name'];

                        var a = document.createElement('a');
                        a.href = img.src;
                        a.setAttribute("data-title", img.alt);
                        a.setAttribute("data-lightbox", attrName);

                        a.append(img)
                        target.append(a);
                    }
                }

                showImg(data.hotwaterPics, divHot, "hotwater");
                showImg(data.heatPics, divHeat, "heat");

                lightbox.option({
                    'resizeDuration': 200,
                    'wrapAround': true
                });

                if(data != false) {
                    for (var d in data)
                        $('[name="' + d + '"]').val(data[d]);
                }

                document.getElementById("map-url").href = ("https://www.google.com/maps/place/" + data["address"] + ", " + data["npa"] + " " + data["city"]).replace(' ', '+');
            });
        }).change();


    }
</script>

