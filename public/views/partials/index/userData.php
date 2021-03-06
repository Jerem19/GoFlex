<?php if (!isset($isInstall)) $isInstall = false; ?>
<div id="loading" style="display: none;"></div>
<div class="row mt form-panel" style="text-align: center; font-size: xx-large;">
    <h2 class="head-title"><?= $isInstall ? L10N['index']['sidebar']['installationGateway'] : L10N['index']['sidebar']['checkUserData'] ?></h2>
</div>

<div class="row mt form-panel">
    <label class="control-label"><?= L10N['index']['checkUserData']['chooseUser'] ?></label>

    <select name="gwId" class="form-control">
        <?php
        $gws = $isInstall ? Gateway::getAllReady() : Gateway::getAllInstalled();
        foreach ($gws as $gw) {
            if ($gw->getInstallation() != false) { ?>
            <option value="<?= $gw->getId() ?>"><?= $gw->getName() ?> [<?= $gw->getInstallation()->getUser()->getUsername() ?>]</option>
        <?php }} ?>
    </select>
</div>

<div class="row mt form-panel" id="info" style="display: <?= empty($gws) ? "none" : "block" ?>">
    <form class='form-horizontal style-form' id="formGw" method='post' enctype="multipart/form-data"><fieldset>
        <div class="form-group">
            <label class="control-label col-sm-12 head-title">
                <?= $l10n['installation']['generalInformation'] ?>
                <br><a style="font-size: 12px; margin-left: 25px;" id="map-url" target="_blank">[ <?= $l10n['installation']['map_url'] ?> ]</a>
            </label>
            <div class="col-sm-12">
                <label class="control-label"><?= $l10n['installation']['address'] ?></label>
                <div><input type="text" class="form-control" name="address"/></div>
            </div>
            <div class="col-sm-12">
                <label class="control-label"><?= $l10n['installation']['npa'] ?></label>
                <div><input type="number" class="form-control" name="npa"/></div>
            </div>
            <div class="col-sm-12">
                <label class="control-label"><?= $l10n['installation']['city'] ?></label>
                <div><input type="text" class="form-control" name="city"/></div>
            </div>
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
                <label class="control-label"><?= $l10n['installation']['egidNumber'] ?></label>
                <div><input type="text" class="form-control" name="egidNumber"/></div>
            </div>
            <div class="col-sm-12">
                <label class="control-label"><?= $l10n['installation']['constructionYear'] ?></label>
                <div><input type="text" class="form-control" name="constructionYear"/></div>
            </div>
            <div class="col-sm-12">
                <label class="control-label"><?= $l10n['installation']['renovationYear'] ?></label>
                <div><input type="text" class="form-control" name="renovationYear"/></div>
            </div>
            <div class="col-sm-12">
                <label class="control-label"><?= $l10n['installation']['sreArea'] ?></label>
                <div><input type="text" class="form-control" name="sreArea"/></div>
            </div>
            <div class="col-sm-12">
                <label class="control-label"><?= $l10n['installation']['inhabitants'] ?></label>
                <div><input type="text" class="form-control" name="inhabitants"/></div>
            </div>
            <div class="col-sm-12">
                <label class="control-label"><?= $l10n['installation']['housingType'] ?></label>
                <div>
                    <select name="housingType" class="form-control">
                        <option value="1"><?= $l10n['installation']['individual'] ?></option>
                        <option value="0"><?= $l10n['installation']['collective'] ?></option>
                    </select>
                </div>
            </div>
            <div class="col-sm-12">
                <label class="control-label"><?= $l10n['installation']['delegatedControl'] ?></label>
                <div>
                    <select name="inst_dcId" class="form-control">
                        <?php foreach (DelegatedControl::getAll() as $delContr) { ?>
                            <option value="<?= $delContr->getId() ?>"><?= $l10n['installation'][$delContr->getName()] ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <div class="col-sm-12">
                <label class="control-label"><?= $l10n['installation']['generalNote'] ?></label>
                <div><textarea class="form-control" name="note"></textarea></div>
            </div>

            <div class="col-sm-12">
                <label class="control-label"><?= $l10n['installation']['adminNote'] ?></label>
                <div><textarea class="form-control" name="adminNote"></textarea></div>
            </div>
            <div class="col-sm-12">
                <label class="control-label"><?= $l10n['installation']['pictureHouse'] ?>
                    <a id="picHouse" target="_blank"><i class="fa fa-download"></i></a>
                </label>
                <div><input type="file" accept="image/*" name="picture"capture="camera" id="picture"/></div>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-sm-12 head-title"><?= $l10n['installation']['equipmentEnergyDefinitionHeat'] ?></label>
            <div class="col-sm-12">
                <label class="control-label"><?= $l10n['installation']['heatProduction'] ?></label>
                <div>
                    <select name="heatProduction" class="form-control">
                        <option value="0"><?= $l10n['installation']['unknown'] ?></option>
                        <option value="1"><?= $l10n['installation']['pac'] ?></option>
                        <option value="2"><?= $l10n['installation']['directElectric'] ?></option>
                        <option value="3"><?= $l10n['installation']['other'] ?></option>
                    </select>
                </div>
            </div>
            <div class="col-sm-12">
                <label class="control-label"><?= $l10n['installation']['heatDistribution'] ?></label>
                <div>
                    <select name="heatDistribution" class="form-control">
                        <option value="0"><?= $l10n['installation']['unknown'] ?></option>
                        <option value="1"><?= $l10n['installation']['electricFloor'] ?></option>
                        <option value="2"><?= $l10n['installation']['hydraulicFloor'] ?></option>
                        <option value="3"><?= $l10n['installation']['electricRadiator'] ?></option>
                        <option value="4"><?= $l10n['installation']['hydraulicRadiator'] ?></option>
                    </select>
                </div>
            </div>
            <div class="col-sm-12">
                <label class="control-label"><?= $l10n['installation']['serviceYear'] ?></label>
                <div><input type="text" class="form-control" name="heatServiceYear"/></div>
            </div>
            <div class="col-sm-12">
                <label class="control-label"><?= $l10n['installation']['powerMeter'] ?></label>
                <div>
                    <select name="heatPowerMeter" class="form-control">
                        <option value="0">0</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                    </select>
                </div>
            </div>
            <div class="col-sm-12">
                <label class="control-label"><?= $l10n['installation']['ambiantTemperature'] ?></label>
                <div>
                    <select name="ambiantTemperature" class="form-control">
                        <option value="0">0</option>
                        <option value="1">1</option>
                    </select>
                </div>
            </div>
            <div class="col-sm-12">
                <label class="control-label"><?= $l10n['installation']['relay'] ?></label>
                <div>
                    <select name="heatRelay" class="form-control">
                        <option value="0">0</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                    </select>
                </div>
            </div>

            <div class="col-sm-12">
                <label class="control-label"><?= $l10n['installation']['positionNote'] ?></label>
                <div><textarea class="form-control" name="heatNote"></textarea></div>
            </div>
            <div class="col-sm-12">
                <label class="control-label"><?= $l10n['installation']['pictureHeat'] ?></label>
                <div ><input type="file" multiple accept="image/*" name="heatPictures[]" id="heatPictures"/></div>
            </div>
            <div class="img-galery col-sm-12">
                <div class="img-slider" id="heatPics"></div>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-12 head-title"><?= $l10n['installation']['equipmentEnergyDefinitionHotwater'] ?></label>
            <div class="col-sm-12">
                <label class="control-label"><?= $l10n['installation']['heatProduction'] ?></label>
                <div>
                    <select name="watterHeatProduction" class="form-control">
                        <option value="0"><?= $l10n['installation']['unknown'] ?></option>
                        <option value="1"><?= $l10n['installation']['idemHeating'] ?></option>
                        <option value="3"><?= $l10n['installation']['boilerPac'] ?></option>
                        <option value="3"><?= $l10n['installation']['electricBoiler'] ?></option>
                    </select>
                </div>
            </div>
            <div class="col-sm-12">
                <label class="control-label"><?= $l10n['installation']['serviceYear'] ?></label>
                <div>
                    <input type="text" class="form-control" name="watterServiceYear"/>
                </div>
            </div>
            <div class="col-sm-12">
                <label class="control-label"><?= $l10n['installation']['boilerVolume'] ?></label>
                <div>
                    <input type="text" class="form-control" name="boilerVolume"/>
                </div>
            </div>
            <div class="col-sm-12">
                <label class="control-label"><?= $l10n['installation']['powerMeter'] ?></label>
                <div>
                    <select name="watterPowerMeter" class="form-control">
                        <option value="0">0</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                    </select>
                </div>
            </div>
            <div class="col-sm-12">
                <label class="control-label"><?= $l10n['installation']['boilerTemperature'] ?></label>
                <div>
                    <select name="boilerTemperature" class="form-control">
                        <option value="0">0</option>
                        <option value="1">1</option>
                    </select>
                </div>
            </div>
            <div class="col-sm-12">
                <label class="control-label"><?= $l10n['installation']['relay'] ?></label>
                <div>
                    <select name="watterRelay" class="form-control">
                        <option value="0">0</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                    </select>
                </div>
            </div>

            <div class="col-sm-12">
                <label class="control-label"><?= $l10n['installation']['positionNote'] ?></label>
                <div>
                    <textarea class="form-control" name="hotwaterNote"></textarea>
                </div>
            </div>
            <div class="col-sm-12">
                <label class="control-label"><?= $l10n['installation']['pictureHotwater'] ?></label>
                <div>
                    <input type="file" multiple accept="image/*" name="hotwaterPictures[]"
                           id="hotwaterPictures"/>
                </div>
            </div>
            <div class="img-galery col-sm-12">
                <div class="img-slider" id="hotwaterPics"></div>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-sm-12 head-title"><?= $l10n['installation']['equipmentEnergyDefinitionSolarPanel'] ?></label>
            <div class="col-sm-12">
                <label class="control-label"><?= $l10n['installation']['photovoltaic'] ?></label>
                <div>
                    <select name="photovoltaic" class="form-control">
                        <option value="0"><?= $l10n['installation']['no'] ?></option>
                        <option value="1"><?= $l10n['installation']['yes'] ?></option>
                    </select>
                </div>
            </div>
            <div class="col-sm-12">
                <label class="control-label"><?= $l10n['installation']['thermal'] ?></label>
                <div>
                    <select name="thermal" class="form-control">
                        <option value="0"><?= $l10n['installation']['unknown'] ?></option>
                        <option value="1"><?= $l10n['installation']['no'] ?></option>
                        <option value="2"><?= $l10n['installation']['ecs'] ?></option>
                        <option value="3"><?= $l10n['installation']['ecsHeat'] ?></option>
                    </select>
                </div>
            </div>
            <div class="col-sm-12">
                <label class="control-label"><?= $l10n['installation']['powerMeter'] ?></label>
                <div>
                    <select name="solarPowerMeter" class="form-control">
                        <option value="0">0</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                    </select>
                </div>
            </div>

            <div class="col-sm-12">
                <label class="control-label"><?= $l10n['installation']['positionNote'] ?></label>
                <div>
                    <textarea id="positionNoteSolarPanel" class="form-control" name="solarNote"></textarea>
                </div>
            </div>
        </div>

        <?php if ($user->getRole()->getId() <= 2) { ?>
            <button class="btn btn-theme02 btn-block"
                    type="submit"><?= $isInstall ? $l10n['installation']['link'] : $l10n['installation']['update'] ?></button>
        <?php } ?>
        </fieldset>
    </form>
</div>

<?php loadStyles([
    "3rdparty/lightbox.css"
]); ?>


<script>

    window.onload = function () {
        $('.form-group div label:first-child').addClass('col-sm-3 col-lg-2');
        $('.form-group div:not(.img-galery) div:last-child').addClass('col-sm-9 col-lg-10');

        var divHot = $("#hotwaterPics"),
            divHeat = $("#heatPics"),
            selectGw = $('select[name="gwId"]');
        var loadingDiv = document.getElementById('loading'),
            aHouse = document.getElementById('picHouse');

        $('#formGw')<?php if ($user->getRole()->getId() <= 2) { // admin and tech only can update ?>
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
                        <?php if ($isInstall) { ?>
                            if (JSON.parse(response)) {
                                alert("<?= $l10n['installation']['alertLinUserGatewaySuccess']?>");
                                window.location.reload();
                            } else alert("<?= $l10n['installation']['alertLinUserGatewayFailed']?>");
                        <?php } else { ?>
                            var msg = "";
                            if (JSON.parse(response)) {
                                msg = "<?= $l10n['installation']['alertLinUserGatewaySuccess']?>";
                                selectGw.trigger('change');
                            } else msg = "<?= $l10n['installation']['alertLinUserGatewayFailed']?>";
                            $.gritter.add({
                                text: msg
                            });
                        <?php } ?>
                    }
                });
                return false;
            })
            <?php } ?>.find('<?php // Desactivate some inputs
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

        function delImg (imgId, domain, container) {
            $.ajax({
                url : 'pics/delete',
                type: 'POST',
                data: {
                    gwId: selectGw.val(),
                    imgId: imgId,
                    element: domain
                }, success: function(response) {
                    var gritterText = "";
                    if (response) {
                        gritterText = "Successful deletion.";
                        $(container).remove();
                    } else gritterText = "Error when deleting.";

                    $.gritter.add({
                        text: gritterText
                    });
                }
            });
        }

        function showImg(imgs, target, attrName) {
            target.parent().css({
                display : imgs  && imgs.length > 0 ? "block" : "none"
            });

            for (i in imgs) {
                const imgArr = imgs[i];

                if(imgArr['name'] != "no_Picture")
                {
                    const divCont = document.createElement('div');
                    divCont.classList.add('img-container');

                    var img = document.createElement('img');
                    img.src = imgArr['url'];
                    img.alt = imgArr['name'];

                    var a = document.createElement('a');
                    a.href = img.src;
                    a.setAttribute("data-title", img.alt);
                    a.setAttribute("data-lightbox", attrName);

                    a.append(img);
                    divCont.append(a);

                    { // Icons
                        <?php if ($user->getRole()->getId() == 2) { ?>
                        var iDel = document.createElement('i');
                        iDel.classList.add('img-delete', 'fa', 'fa-trash');

                        iDel.onclick = function() {
                            delImg(imgArr.id, attrName, divCont);
                        };
                        divCont.append(iDel);
                        <?php } ?>

                        var iDown = document.createElement('i');
                        iDown.classList.add('img-down', 'fa', 'fa-download');

                        var aDown = document.createElement('a');
                        aDown.href = imgArr['url'];
                        aDown.target = "_blank";

                        aDown.append(iDown);
                        divCont.append(aDown);
                    }
                    target.append(divCont);
                }
            }
        }

        selectGw.on('change', function () {
            $.ajax({
                url: 'installInfo',
                type: 'POST',
                data: { id : $(this).val() },
                beforeSend: function () {
                    $('fieldset').prop('disabled', true);
                    loadingDiv.style.display = 'block';
                }, success : function (data) {
                    if (data != false) {
                        divHeat.empty();
                        divHot.empty();

                        if (data.picHouse) {
                            aHouse.href = data.picHouse;
                            aHouse.style.display = "block";
                        } else {
                            aHouse.removeAttribute('href');
                            aHouse.style.display = "none";
                        }

                        showImg(data.hotwaterPics, divHot, "hotwater");
                        showImg(data.heatPics, divHeat, "heat");

                        lightbox.option({
                            'resizeDuration': 200,
                            'wrapAround': true
                        });

                        for (var d in data)
                            $('[name="' + d + '"]').val(data[d]);

                        document.getElementById("map-url").href = ("https://www.google.com/maps/place/" + data["address"] + ", " + data["npa"] + " " + data["city"]).replace(' ', '+');
                    } else console.error("No data");
                    loadingDiv.style.display = 'none';
                    $('fieldset').prop('disabled', false);
                }
            });
        }).change();
    }
</script>
