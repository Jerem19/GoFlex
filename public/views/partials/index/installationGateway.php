<div class="row mt col-lg-12 form-panel" style="margin-bottom: 10px; text-align: center; font-size: xx-large;">
    <?= L10N['index']['sidebar']['installationGateway']?>
</div>
<div class="row mt col-lg-12 form-panel">
    <form class='form-horizontal style-form' id="formLinkGatewayUser" method='post' enctype="multipart/form-data">
        <label class="control-label col-sm-12" style="font-size: x-large; margin-bottom: 20px;"><?= $l10n['installation']['systemDefinition']?></label>

        <div class="form-group">
            <label class="col-sm-2 col-sm-2 control-label"><?= $l10n['installation']['boxNumber']?></label>
            <div class="col-sm-10" style="margin-bottom: 10px;">
                <select required="required" name="gwId" class="col-sm-8 form-control">
                    <?php foreach(Gateway::getAllReady() as $gw) { ?>
                        <option value="<?= $gw->getId()?>"><?= $gw->getName()?> [<?= $gw->getInstallation()->getUser()->getUsername() ?>]</option>
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
                <input required="required" type="number" value="0" min="0" class="col-sm-8 form-control" name="heatSensors" />
            </div>

            <label class="col-sm-2 col-sm-2 control-label"><?= $l10n['installation']['insideTemperatureSensor']?></label></label>
            <div class="col-sm-10" style="margin-bottom: 10px;">
                <input required="required" type="number" value="0" min="0" class="col-sm-8 form-control" name="heatTempSensors" />
            </div>

            <label class="col-sm-2 col-sm-2 control-label"><?= $l10n['installation']['positionNote']?></label>
            <div class="col-sm-10" style="margin-bottom: 10px;">
                <textarea class="col-sm-8 form-control" name="heatNote"></textarea>
            </div>

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
                <input required="required" type="number" value="0" min="0" class="col-sm-8 form-control" name="hotwaterSensors" />
            </div>

            <label class="col-sm-2 col-sm-2 control-label"><?= $l10n['installation']['boilerTemperatureSensor']?></label></label>
            <div class="col-sm-10" style="margin-bottom: 10px;">
                <input required="required" type="number" value="0" min="0" class="col-sm-8 form-control" name="hotwaterTempSensors" />
            </div>
            <label class="col-sm-2 col-sm-2 control-label"><?= $l10n['installation']['positionNote']?></label>
            <div class="col-sm-10" style="margin-bottom: 10px;">
                <textarea class="col-sm-8 form-control" name="hotwaterNote"></textarea>
            </div>
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
                <input id="productionSensor" disabled value="0" min="0" type="number" class="col-sm-8 form-control" name="solarSensors" />
            </div>

            <label class="col-sm-2 col-sm-2 control-label"><?= $l10n['installation']['positionNote']?></label>
            <div class="col-sm-10" style="margin-bottom: 10px;">
                <textarea id="positionNoteSolarPanel" disabled="disabled" class="col-sm-8 form-control" name="solarNote"></textarea>
            </div>

        </div>

        <label class="control-label col-sm-12" style="font-size: x-large; margin-bottom: 20px;"><?= $l10n['installation']['generalInformation']?></label>
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


        <label class="col-sm-2 col-sm-2 control-label"><?= $l10n['installation']['pictureHouse']?></label>
        <div class="col-sm-10" style="margin-bottom: 10px;">
            <input type="file" style="margin-bottom: 20px;" accept="image/x-png,image/jpeg" name="picture" id="picture" />
        </div>
        </div>
        <button class="btn btn-theme02 btn-block" type="submit"><?= $l10n['installation']['link']?></button>
    </form>
</div>

<script>
    window.onload = function() {

        $("#formLinkGatewayUser").submit(function (event) {
            var form_data = new FormData(this);

            $.ajax({
                url: 'linkUserGateway',
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
        });
    }

    function disabledOrEnable(elem) {
        document.getElementById('productionSensor').disabled = !elem.selectedIndex;
        document.getElementById('positionNoteSolarPanel').disabled = !elem.selectedIndex;
    }
</script>