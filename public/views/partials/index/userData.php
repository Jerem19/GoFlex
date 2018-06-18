<div id="loading" style="display: none;"></div>
<div class="row mt form-panel" style="text-align: center; font-size: xx-large;">
    <?= $isInstall ? L10N['index']['sidebar']['installationGateway'] : L10N['index']['sidebar']['checkUserData'] ?>
</div>

<div class="row mt form-panel">
    <label class="control-label"><?= L10N['index']['checkUserData']['chooseUser'] ?></label>

    <select name="gwId" class="form-control">
        <?php
        $gws = $isInstall ? Gateway::getAllReady() : Gateway::getAllInstalled();
        foreach ($gws as $gw) { ?>
            <option value="<?= $gw->getId() ?>"><?= $gw->getName() ?>
                [<?= $gw->getInstallation()->getUser()->getUsername() ?>]
            </option>
        <?php } ?>
    </select>
</div>

<div class="row mt form-panel" id="info" style="display: <?= empty($gws) ? "none" : "block" ?>">
    <form class='form-horizontal style-form' id="formGw" method='post' enctype="multipart/form-data"><fieldset>
        <div class="form-group">
            <label class="control-label col-sm-12 head-title"><?= $l10n['installation']['systemDefinition'] ?></label>

            <div class="col-sm-12">
                <label class="control-label"><?= $l10n['installation']['facturation'] ?></label>
                <div>
                    <select name="facturation" class="form-control">
                        <option value="1"><?= $l10n['installation']['lower'] ?></option>
                        <option value="0"><?= $l10n['installation']['higher'] ?></option>
                    </select>
                </div>
            </div>

            <div class="col-sm-12">
                <label class="control-label"><?= $l10n['installation']['businessSector'] ?></label>
                <div>
                    <select name="businessSector" class="form-control">
                        <?php foreach (BusinessSector::getAll() as $busSec) { ?>
                            <option value="<?= $busSec->getId() ?>"><?= $l10n['installation'][$busSec->getName()] ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <div class="col-sm-12">
                <label class="control-label"><?= $l10n['installation']['adminNote'] ?></label>
                <div>
                    <textarea class="form-control" name="adminNote"></textarea>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-sm-12 head-title"><?= $l10n['installation']['equipmentEnergyDefinitionHeat'] ?></label>
            <div class="col-sm-12">
                <label class="control-label"><?= $l10n['installation']['energyHeat'] ?></label>
                <div>
                    <select name="heatEner" class="form-control">
                        <?php foreach (Energy::getAll() as $ener) { ?>
                            <option value="<?= $ener->getId() ?>"><?= $l10n['installation'][$ener->getName()] ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <div class="col-sm-12">
                <label class="control-label"><?= $l10n['installation']['technoHeat'] ?></label>
                <div>
                    <select name="heatTech" class="form-control">
                        <?php foreach (Technology::getAll() as $tech) { ?>
                            <option value="<?= $tech->getId() ?>"><?= $l10n['installation'][$tech->getName()] ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="col-sm-12">
                <label class="control-label"><?= $l10n['installation']['consommationSensor'] ?></label></label>
                <div>
                    <input required="required" type="number" class="form-control" name="heatSensors"/>
                </div>
            </div>
            <div class="col-sm-12">
                <label class="control-label"><?= $l10n['installation']['insideTemperatureSensor'] ?></label></label>
                <div>
                    <input required="required" type="number" class="form-control" name="heatTempSensors"/>
                </div>
            </div>
            <div class="col-sm-12">
                <label class="control-label"><?= $l10n['installation']['positionNote'] ?></label>
                <div>
                    <textarea class="form-control" name="heatNote"></textarea>
                </div>
            </div>

            <?php if (!$isInstall) { ?>
                <div class="img-galery col-sm-12">
                    <div id="heatPics"></div>
                </div>
            <?php } ?>
            <div class="col-sm-12">
                <label class="control-label"><?= $l10n['installation']['pictureHeat'] ?></label>
                <div >
                    <input type="file" multiple accept="image/*" name="heatPictures[]" id="heatPictures"/>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-sm-12 head-title"><?= $l10n['installation']['equipmentEnergyDefinitionHotwater'] ?></label>
            <div class="col-sm-12">
                <label class="control-label"><?= $l10n['installation']['energyHotWater'] ?></label>
                <div>
                    <select name="hotwaterEner" class="form-control">
                        <?php foreach (Energy::getAll() as $ener) { ?>
                            <option value="<?= $ener->getId() ?>"><?= $l10n['installation'][$ener->getName()] ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="col-sm-12">
                <label class="control-label"><?= $l10n['installation']['technoHotWater'] ?></label>
                <div >
                    <select name="hotwaterTech" class="form-control">
                        <?php foreach (Technology::getAll() as $tech) { ?>
                            <option value="<?= $tech->getId() ?>"><?= $l10n['installation'][$tech->getName()] ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="col-sm-12">
                <label class="control-label"><?= $l10n['installation']['consommationSensor'] ?></label></label>
                <div>
                    <input required="required" type="number" class="form-control" name="hotwaterSensors"/>
                </div>
            </div>
            <div class="col-sm-12">
                <label class="control-label"><?= $l10n['installation']['boilerTemperatureSensor'] ?></label></label>
                <div >
                    <input required="required" type="number" class="form-control" name="hotwaterTempSensors"/>
                </div>
            </div>
            <div class="col-sm-12">
                <label class="control-label"><?= $l10n['installation']['positionNote'] ?></label>
                <div>
                    <textarea class="form-control" name="hotwaterNote"></textarea>
                </div>
            </div>

            <?php if (!$isInstall) { ?>
                <div class="img-galery col-sm-12">
                    <div id="hotwaterPics"></div>
                </div>
            <?php } ?>
            <div class="col-sm-12">
                <label class="control-label"><?= $l10n['installation']['pictureHotwater'] ?></label>
                <div>
                    <input type="file" multiple accept="image/*" name="hotwaterPictures[]"
                           id="hotwaterPictures"/>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-sm-12 head-title"><?= $l10n['installation']['equipmentEnergyDefinitionSolarPanel'] ?></label>
            <div class="col-sm-12">
                <label class="control-label"><?= $l10n['installation']['solarPanel'] ?></label>
                <div>
                    <select id="solarPanelSelect" name="solarPanel" class="form-control"
                            onChange="disabledOrEnable(this)">
                        <option value="0"><?= $l10n['installation']['no'] ?></option>
                        <option value="1"><?= $l10n['installation']['yes'] ?></option>
                    </select>
                </div>
            </div>
            <div class="col-sm-12">
                <label class="control-label"><?= $l10n['installation']['productionSensor'] ?></label></label>
                <div>
                    <input id="productionSensor" type="number" class="form-control" name="solarSensors"/>
                </div>
            </div>
            <div class="col-sm-12">
                <label class="control-label"><?= $l10n['installation']['positionNote'] ?></label>
                <div>
                    <textarea id="positionNoteSolarPanel" class="form-control" name="solarNote"></textarea>
                </div>
            </div>

        </div>

        <div class="form-group localisation">
            <label class="control-label col-sm-12 head-title"><?= $l10n['installation']['generalInformation'] ?>
                <br><a style="font-size: 12px;" id="map-url" target="_blank">[ <?= $l10n['installation']['map_url'] ?> ]</a>
            </label>
            <div class="col-sm-12">
                <label class="control-label"><?= $l10n['installation']['address'] ?></label>
                <div>
                    <input required="required" type="text" class="form-control" name="address"/>
                </div>
            </div>
            <div class="col-sm-12">
                <label class="control-label"><?= $l10n['installation']['npa'] ?></label>
                <div>
                    <input required="required" type="number" class="form-control" name="npa"/>
                </div>
            </div>
            <div class="col-sm-12">
                <label class="control-label"><?= $l10n['installation']['city'] ?></label>
                <div>
                    <input required="required" type="text" class="form-control" name="city"/>
                </div>
            </div>
            <div class="col-sm-12">
                <label class="control-label"><?= $l10n['installation']['generalNote'] ?></label>
                <div>
                    <textarea class="form-control" name="note"></textarea>
                </div>
            </div>
            <div class="col-sm-12">
                <label class="control-label"><?= $l10n['installation']['pictureHouse'] ?></label>
                <div>
                    <input type="file" accept="image/*" name="picture" id="picture"/>
                </div>
            </div>
        </div>

        <?php if ($user->getRole()->getId() <= 2) { ?>
            <button class="btn btn-theme02 btn-block"
                    type="submit"><?= $isInstall ? $l10n['installation']['link'] : $l10n['installation']['update'] ?></button>
        <?php } ?>
    </fieldset></form>
</div>

<?php loadStyles([
    "3rdparty/lightbox.css"
]); ?>
<script>
    function disabledOrEnable(elem) {
        document.getElementById('productionSensor').disabled = !elem.selectedIndex;
        document.getElementById('positionNoteSolarPanel').disabled = !elem.selectedIndex;
    }
    disabledOrEnable({ selectedIndex: false });



    window.onload = function () {

        $('.form-group div label:first-child').addClass('col-sm-3 col-lg-2');
        $('.form-group div:not(.img-galery) div:last-child').addClass('col-sm-9 col-lg-10');

        var loadingDiv = document.getElementById('loading');
        $('#formGw')<?php if ($user->getRole()->getId() <= 2) { ?>
            .submit(function () {
                var form_data = new FormData(this);
                form_data.append('id', $('select[name="gwId"]').val());
                $.ajax({
                    url: 'updateInfo',
                    type: 'POST',
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: form_data,
                    success: function (response) {
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

        $('select[name="gwId"]').on('change', function () {
            $.ajax({
                url: 'installInfo',
                type: 'POST',
                data: { id : $(this).val() },
                beforeSend: function () {
                    $('fieldset').prop('disabled', true);
                    loadingDiv.style.display = 'block';
                },
                success : function (data) {
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


                    if (data != false) {
                        for (var d in data)
                            $('[name="' + d + '"]').val(data[d]);
                    }

                    document.getElementById("map-url").href = ("https://www.google.com/maps/place/" + data["address"] + ", " + data["npa"] + " " + data["city"]).replace(' ', '+');
                    loadingDiv.style.display = 'none';
                    $('fieldset').prop('disabled', false);
                }
            });
        }).change();
    }
</script>

