<div class="row mt col-lg-12 form-panel" style="margin-bottom: 10px; text-align: center; font-size: xx-large;">
    <?= $isInstall ? L10N['index']['sidebar']['installationGateway'] : L10N['index']['sidebar']['checkUserData'] ?>
</div>

<div class="row mt col-lg-12 form-panel">
        <label class="control-label col-sm-12" style="font-size: x-large;"><?= L10N['index']['checkUserData']['chooseUser']?></label>

        <select name="gwId" class="col-sm-8 form-control">
            <?php
            $gws = $isInstall ? Gateway::getAllReady() : Gateway::getAllInstalled();
            foreach($gws as $gw) { ?>
                <option value="<?= $gw->getId()?>"><?= $gw->getName()?> [<?= $gw->getInstallation()->getUser()->getUsername() ?>]</option>
            <?php } ?>
        </select>
</div>

<div class="row mt col-lg-12 form-panel" id="info" style="display: <?= empty($gws) ? "none" : "block" ?>">
    <form class='form-horizontal style-form' id="formGw" method='post' enctype="multipart/form-data">
        <label class="control-label col-sm-12" style="font-size: x-large; margin-bottom: 20px;"><?= $l10n['installation']['systemDefinition']?></label>

        <div class="form-group">

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

            <label class="col-sm-2 col-sm-2 control-label"><?= $l10n['installation']['adminNote'] ?></label>
            <div class="col-sm-10" style="margin-bottom: 10px;">
                <textarea class="col-sm-8 form-control" name="adminNote"></textarea>
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

            <?php if (!$isInstall) { ?>
                <div class="img-galery col-sm-12" >
                    <div id="heatPics"></div>
                </div>
            <?php } ?>
            <label class="col-sm-2 col-sm-2 control-label"><?= $l10n['installation']['pictureHeat']?></label>
            <div class="col-sm-10" style="margin-bottom: 10px;">
                <input type="file" style="margin-bottom: 20px;" multiple accept="image/*" name="heatPictures[]" id="heatPictures" />
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

            <?php if (!$isInstall) { ?>
                <div class="img-galery col-sm-12">
                    <div id="hotwaterPics"></div>
                </div>
            <?php } ?>
            <label class="col-sm-2 col-sm-2 control-label"><?= $l10n['installation']['pictureHotwater']?></label>
            <div class="col-sm-10" style="margin-bottom: 10px;">
                <input type="file" style="margin-bottom: 20px;" multiple accept="image/*" name="hotwaterPictures[]" id="hotwaterPictures"/>
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
            <br><a style="font-size: 12px;" id="map-url" target="_blank">[ <?= $l10n['installation']['map_url'] ?> ]</a>
        </label>
        <div class="form-group localisation">

            <label class="col-sm-2 col-sm-2 control-label"><?= $l10n['installation']['address']?></label>
            <div class="col-sm-10" style="margin-bottom: 10px;">
                <input required="required" type="text" class="col-sm-8 form-control" name="address" />
            </div>
            <label class="col-sm-2 col-sm-2 control-label"><?= $l10n['installation']['npa']?></label>
            <div class="col-sm-10" style="margin-bottom: 10px;">
                <input required="required" type="number" class="col-sm-8 form-control" name="npa" />
            </div>
            <label class="col-sm-2 col-sm-2 control-label"><?= $l10n['installation']['city']?></label>
            <div class="col-sm-10" style="margin-bottom: 10px;">
                <input required="required" type="text" class="col-sm-8 form-control" name="city" />
            </div>
            <label class="col-sm-2 col-sm-2 control-label"><?= $l10n['installation']['generalNote']?></label>
            <div class="col-sm-10" style="margin-bottom: 10px;">
                <textarea class="col-sm-8 form-control" name="note"></textarea>
            </div>

            <label class="col-sm-2 col-sm-2 control-label"><?= $l10n['installation']['pictureHouse']?></label>
            <div class="col-sm-10" style="margin-bottom: 10px;">
                <input type="file" style="margin-bottom: 20px;" accept="image/*" name="picture" id="picture" />
            </div>
        </div>
        <?php if ($user->getRole()->getId() <= 2) { ?>
            <button class="btn btn-theme02 btn-block" type="submit"><?= $isInstall ? $l10n['installation']['link'] : $l10n['installation']['update'] ?></button>
        <?php } ?>
    </form>
</div>

<?php loadStyles([
    "3rdparty/lightbox.css"
]); ?>
<script>
    function disabledOrEnable(elem) {
        document.getElementById('productionSensor').disabled = !elem.selectedIndex;
        document.getElementById('positionNoteSolarPanel').disabled = !elem.selectedIndex;
    }

    window.onload = function() {
        $('#formGw')<?php if ($user->getRole()->getId() <= 2) { ?>
            .submit(function() {
                var form_data = new FormData(this);
                form_data.append('id', $('select[name="gwId"]').val());
                $.ajax({
                    url: 'updateInfo',
                    type: 'POST',
                    cache: false,
                    contentType: false,
                    processData: false,
                    data : form_data,
                    success: function(response) {
                        if (JSON.parse(response)) {
                            alert("<?= $l10n['installation']['alertLinUserGatewaySuccess']?>");
                            window.location.reload();
                        } else alert("<?= $l10n['installation']['alertLinUserGatewayFailed']?>");
                    }
                });
                return false;
            })
        <?php } ?>.find('<?php
        switch ($user->getRole()->getId()) {
            case 1:
                echo ':not(.localisation input, textarea[name="adminNote"], button[type="submit"]), input[type="file"]';
                break;
            case 2:
                echo 'textarea[name="adminNote"]';
                break;
            default:
                echo 'input, select, textarea';
                break;
        } ?>').prop("disabled", true);

        var divHot = $("#hotwaterPics");
        var divHeat = $("#heatPics");
        
        $('select[name="gwId"]').on('change', function() {

            $.post('installInfo', 'id=' + $(this).val(), function(data) {

                <?php if (!$isInstall) { ?>
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

                            a.append(img);
                            target.append(a);
                        }
                    }

                    showImg(data.hotwaterPics, divHot, "hotwater");
                    showImg(data.heatPics, divHeat, "heat");

                    lightbox.option({
                        'resizeDuration': 200,
                        'wrapAround': true
                    });
                <?php } ?>


                if(data != false) {
                    for (var d in data)
                        $('[name="' + d + '"]').val(data[d]);
                }

                document.getElementById("map-url").href = ("https://www.google.com/maps/place/" + data["address"] + ", " + data["npa"] + " " + data["city"]).replace(' ', '+');
            });
        }).change();
    }
</script>

