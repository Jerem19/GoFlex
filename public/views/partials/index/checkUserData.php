<div class="row mt col-lg-12 form-panel">
    <form class="form-horizontal style-form" id="formCheckUserData" method="post">

        <label class="control-label col-sm-12" style="font-size: x-large;"><?= L10N['index']['checkUserData']['chooseUser']?></label>

        <select name="client" class="col-sm-8 form-control">
            <?php
            foreach (User::getAllLinked() as $user) { ?>
                <option value="<?= $user->getId() ?>"><?= $user->getUsername() ?> [<?= $user ?>]</option>
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

            <label class="col-sm-2 col-sm-2 control-label"><?= $l10n['installation']['picture']?></label>
            <div class="col-sm-10" style="margin-bottom: 10px;">
                <input type="file" disabled style="margin-bottom: 20px;" class="col-sm-8 form-control" name="heatPictures" id="heatPictures" />
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

            <!-- 25mo autorises -->
            <!-- <input type="hidden" name="MAX_FILE_SIZE" value="26214400" /> -->

            <label class="col-sm-2 col-sm-2 control-label"><?= $l10n['installation']['picture']?></label>
            <div class="col-sm-10" style="margin-bottom: 10px;">
                <input type="file" disabled style="margin-bottom: 20px;" class="col-sm-8 form-control" name="hotwaterPictures" id="hotwaterPictures"/>
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
        </div>

        <label class="col-sm-2 col-sm-2 control-label"><?= $l10n['installation']['pictureHouse']?></label>
        <div class="col-sm-10" style="margin-bottom: 10px;">
            <input type="file" disabled style="margin-bottom: 20px;" class="col-sm-8 form-control" style="margin-bottom: 10px;" name="picture" id="picture" />
        </div>
    </form>
</div>

<script>
    window.onload = function() {
        $('#formLinkGatewayUser').find('input, select, textarea').prop("disabled", true);

        $('select[name="client"').on('change', function() {
            $.post('installInfo', 'id=' + $(this).val(), function(data) {
                if(data != false) {
                    for (var d in data)
                        $('[name="' + d + '"]').val(data[d]);
                }
            });
        }).change();
    }
</script>
