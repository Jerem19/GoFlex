<div id="loading" style="display: none;"></div>
<div class="row mt form-panel" style="text-align: center; font-size: xx-large;">
    <h2 class="head-title"><?= $isInstall ? L10N['index']['sidebar']['installationGateway'] : L10N['index']['sidebar']['checkUserData'] ?></h2>
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
                    <label class="control-label"><?= $l10n['installation']['egidNumber'] ?></label>
                    <div>
                        <input type="number" class="form-control" name="egidNumber"/>
                    </div>
                </div>

                <div class="col-sm-12">
                    <label class="control-label"><?= $l10n['installation']['flexibleChargeNumber'] ?></label>
                    <div>
                        <input type="number" class="form-control" name="flexibleChargeNumber"/>
                    </div>
                </div>

                <div class="col-sm-12">
                    <label class="control-label"><?= $l10n['installation']['buildingYear'] ?></label>
                    <div>
                        <input type="text" class="form-control" name="buildingYear"/>
                    </div>
                </div>

                <div class="col-sm-12">
                    <label class="control-label"><?= $l10n['installation']['renovationYear'] ?></label>
                    <div>
                        <input type="text" class="form-control" name="renovationYear"/>
                    </div>
                </div>

                <div class="col-sm-12">
                    <label class="control-label"><?= $l10n['installation']['surfaceSRE'] ?></label>
                    <div>
                        <input type="number" class="form-control" name="surfaceSRE"/>
                    </div>
                </div>


                <div class="col-sm-12">
                    <label class="control-label"><?= $l10n['installation']['inhabitantsNumber'] ?></label>
                    <div>
                        <input type="number" class="form-control" name="inhabitantsNumber"/>
                    </div>
                </div>

                <div class="col-sm-12">
                    <label class="control-label"><?= $l10n['installation']['typeOfHousing'] ?></label>
                    <div>
                        <select name="typeOfHousing" class="form-control">
                            <option value="individual"><?= $l10n['installation']['individual'] ?></option>
                            <option value="collective"><?= $l10n['installation']['collective'] ?></option>
                        </select>
                    </div>
                </div>

                <div class="col-sm-12">
                    <label class="control-label">Relay 1</label>
                    <div>
                        <select name="relay1" class="form-control">
                            <option value="heat_pump"><?= $l10n['installation']['heat_pump'] ?></option>
                            <option value="boiler"><?= $l10n['installation']['boiler'] ?></option>
                            <option value="electric"><?= $l10n['installation']['elec'] ?></option>
                        </select>
                    </div>
                </div>

                <div class="col-sm-12">
                    <label class="control-label">Relay 2</label>
                    <div>
                        <select name="relay2" class="form-control">
                            <option value="heat_pump"><?= $l10n['installation']['heat_pump'] ?></option>
                            <option value="boiler"><?= $l10n['installation']['boiler'] ?></option>
                            <option value="electric"><?= $l10n['installation']['elec'] ?></option>
                        </select>
                    </div>
                </div>

                <div class="col-sm-12">
                    <label class="control-label"><?= $l10n['installation']['remoteManagement'] ?></label>
                    <div>
                        <select name="remoteManagement" class="form-control">
                            <option value="none"> none </option>
                            <option value="inea"> inea </option>
                            <option value="aau"> aau </option>
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
                    <label class="control-label"><?= $l10n['installation']['heatingSurface'] ?></label>
                    <div>
                        <input type="number" class="form-control" name="egidNumber"/>
                    </div>
                </div>


                <div class="col-sm-12">
                    <label class="control-label"><?= $l10n['installation']['heatingYear'] ?></label>
                    <div >
                        <input type="text" class="form-control" name="heatingYear"/>
                    </div>
                </div>

                <div class="col-sm-12">
                    <label class="control-label"><?= $l10n['installation']['distribution'] ?></label>
                    <div>
                        <select name="distribution" class="form-control">
                            <option value="ground"> <?= $l10n['installation']['ground'] ?> </option>
                            <option value="hydraulic"> <?= $l10n['installation']['hydraulic'] ?> </option>
                            <option value="direct"> <?= $l10n['installation']['direct'] ?> </option>
                        </select>
                    </div>
                </div>


                <div class="col-sm-12">
                    <label class="control-label"><?= $l10n['installation']['consommationSensor'] ?></label>
                    <div>
                        <input required="required" type="number" class="form-control" name="heatSensors"/>
                    </div>
                </div>
                <div class="col-sm-12">
                    <label class="control-label"><?= $l10n['installation']['insideTemperatureSensor'] ?></label>
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
                <div class="col-sm-12">
                    <label class="control-label"><?= $l10n['installation']['pictureHeat'] ?></label>
                    <div >
                        <input type="file" multiple accept="image/*" name="heatPictures[]" id="heatPictures"/>
                    </div>
                </div>
                <div class="img-galery col-sm-12">
                    <div class="img-slider" id="heatPics"></div>
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
                    <label class="control-label"><?= $l10n['installation']['boilerYear'] ?></label>
                    <div >
                        <input type="text" class="form-control" name="boilerYear"/>
                    </div>
                </div>

                <div class="col-sm-12">
                    <label class="control-label"><?= $l10n['installation']['boilerVolume'] ?></label>
                    <div >
                        <input type="number" class="form-control" name="boilerVolume"/>
                    </div>
                </div>

                <div class="col-sm-12">
                    <label class="control-label"><?= $l10n['installation']['consommationSensor'] ?></label>
                    <div>
                        <input required="required" type="number" class="form-control" name="hotwaterSensors"/>
                    </div>
                </div>
                <div class="col-sm-12">
                    <label class="control-label"><?= $l10n['installation']['boilerTemperatureSensor'] ?></label>
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
                    <label class="control-label"><?= $l10n['installation']['productionSensor'] ?></label>
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
                <label class="control-label col-sm-12 head-title">
                    <?= $l10n['installation']['generalInformation'] ?>
                    <br><a style="font-size: 12px; margin-left: 25px;" id="map-url" target="_blank">[ <?= $l10n['installation']['map_url'] ?> ]</a>
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
                    <label class="control-label"><?= $l10n['installation']['pictureHouse'] ?>
                        <a id="picHouse" target="_blank"><i class="fa fa-download"></i></a>
                    </label>
                    <div>
                        <input type="file" accept="image/*" name="picture"capture="camera" id="picture"/>
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
    function disabledOrEnable() {
        if(document.getElementById('solarPanelSelect').value == 0)
        {
            document.getElementById('productionSensor').disabled = true;
            document.getElementById('positionNoteSolarPanel').disabled = true;
        }
        else
        {
            document.getElementById('productionSensor').disabled = false;
            document.getElementById('positionNoteSolarPanel').disabled = false;
        }
        //document.getElementById('productionSensor').disabled = !elem.selectedIndex;
        //document.getElementById('positionNoteSolarPanel').disabled = !elem.selectedIndex;
    }

    disabledOrEnable();


    window.onload = function () {

        $('.form-group div label:first-child').addClass('col-sm-3 col-lg-2');
        $('.form-group div:not(.img-galery) div:last-child').addClass('col-sm-9 col-lg-10');

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
                        if (JSON.parse(response)) {
                            alert("<?= $l10n['installation']['alertLinUserGatewaySuccess']?>");
                            window.location.reload();
                        } else alert("<?= $l10n['installation']['alertLinUserGatewayFailed']?>");
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



        var divHot = $("#hotwaterPics"),
            divHeat = $("#heatPics"),
            selectGw = $('select[name="gwId"]');
        var loadingDiv = document.getElementById('loading'),
            aHouse = document.getElementById('picHouse');


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
                        disabledOrEnable();
                    } else console.error("No data");
                    loadingDiv.style.display = 'none';
                    $('fieldset').prop('disabled', false);
                }
            });
        }).change();
    }
</script>

