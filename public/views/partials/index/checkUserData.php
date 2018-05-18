<div class="row mt col-lg-12 form-panel">
    <form class="form-horizontal style-form" id="formCheckUserData" method="post">

        <label class="control-label col-sm-12" style="font-size: x-large;"><?= L10N['index']['checkUserData']['chooseUser']?></label>

        <select name="clientNumber" class="col-sm-8 form-control">
            <?php
            foreach(User::getAllClient() as $user)
            {
                echo "<option value=" . $user->getId() .">" . $user->getUsername() . "</option>";
            }
            ?>
        </select>
    </form>
</div>

<div class="row mt col-lg-12 form-panel">

    <label class="control-label col-sm-12" style="font-size: x-large; text-align:center; margin-bottom: 20px;"><?= L10N['index']['installation']['systemDefinition']?></label>

        <!-- USER -->
        <label class="col-sm-2 col-sm-2 control-label"><?= L10N['index']['installation']['clientName']?></label>
        <div class="col-sm-10" style="margin-bottom: 10px;">
            <textbox class="col-sm-8 form-control" name="clientName"></textbox>
        </div>

        <!-- GATEWAY -->
        <label class="col-sm-2 col-sm-2 control-label"><?= L10N['index']['installation']['boxNumber']?></label>
        <div class="col-sm-10" style="margin-bottom: 10px;">
            <textbox class="col-sm-8 form-control" name="boxNumber"></textbox>
        </div>

        <!-- FACTURATION -->
        <label class="col-sm-2 col-sm-2 control-label"><?= L10N['index']['installation']['facturation']?></label>
        <div class="col-sm-10" style="margin-bottom: 10px;">
            <textbox class="col-sm-8 form-control" name="facturation"></textbox>
        </div>

        <!-- BUSINESS SECTOR -->
        <label class="col-sm-2 col-sm-2 control-label"><?= L10N['index']['installation']['businessSector']?></label>
        <div class="col-sm-10">
            <textbox class="col-sm-8 form-control" name="businessSector"></textbox>
        </div>

    <!-- -------------------------------------------------------------------------------------------- -->
    <!-- HEAT -->

    <label class="control-label col-sm-12" style="font-size: x-large; text-align:center; margin-bottom: 20px; margin-top: 50px;"><?= L10N['index']['installation']['equipmentEnergyDefinitionHeat']?></label>

    <label class="col-sm-2 col-sm-2 control-label"><?= L10N['index']['installation']['energyHeat']?></label>
    <div class="col-sm-10" style="margin-bottom: 10px;">
        <textbox class="col-sm-8 form-control" name="energyHeat"></textbox>
    </div>

    <label class="col-sm-2 col-sm-2 control-label"><?= L10N['index']['installation']['technoHeat']?></label>
    <div class="col-sm-10" style="margin-bottom: 10px;">
        <textbox class="col-sm-8 form-control" name="technoHeat"></textbox>
    </div>

    <label class="col-sm-2 col-sm-2 control-label"><?= L10N['index']['installation']['consommationSensor']?></label>
    <div class="col-sm-10" style="margin-bottom: 10px;">
        <textbox class="col-sm-8 form-control" name="technoHeat"></textbox>
    </div>

    <label class="col-sm-2 col-sm-2 control-label"><?= L10N['index']['installation']['insideTemperatureSensor']?></label>
    <div class="col-sm-10" style="margin-bottom: 10px;">
        <textbox class="col-sm-8 form-control" name="technoHeat"></textbox>
    </div>

    <label class="col-sm-2 col-sm-2 control-label"><?= L10N['index']['installation']['positionNote']?></label>
    <div class="col-sm-10" style="margin-bottom: 10px;">
        <textbox class="col-sm-8 form-control" name="heatNotePosition"></textbox>
    </div>

    <!-- ADD HEAT PICS THERE -->
    <!-- -------------------------------------------------------------------------------------------- -->
    <!-- Water hot -->

    <label class="control-label col-sm-12" style="font-size: x-large; text-align:center; margin-bottom: 20px; margin-top: 50px;"><?= L10N['index']['installation']['equipmentEnergyDefinitionHotwater']?></label>

    <label class="col-sm-2 col-sm-2 control-label"><?= L10N['index']['installation']['energyHotwater']?></label>
    <div class="col-sm-10" style="margin-bottom: 10px;">
        <textbox class="col-sm-8 form-control" name="energyHotwater"></textbox>
    </div>

    <label class="col-sm-2 col-sm-2 control-label"><?= L10N['index']['installation']['technoHotwater']?></label>
    <div class="col-sm-10" style="margin-bottom: 10px;">
        <textbox class="col-sm-8 form-control" name="technoHotwater"></textbox>
    </div>

    <label class="col-sm-2 col-sm-2 control-label"><?= L10N['index']['installation']['consommationSensor']?></label>
    <div class="col-sm-10" style="margin-bottom: 10px;">
        <textbox class="col-sm-8 form-control" name="consommationHotwaterSensor"></textbox>
    </div>

    <label class="col-sm-2 col-sm-2 control-label"><?= L10N['index']['installation']['boilerTemperatureSensor']?></label>
    <div class="col-sm-10" style="margin-bottom: 10px;">
        <textbox class="col-sm-8 form-control" name="boilerTemperatureSensor"></textbox>
    </div>

    <label class="col-sm-2 col-sm-2 control-label"><?= L10N['index']['installation']['positionNote']?></label>
    <div class="col-sm-10" style="margin-bottom: 10px;">
        <textbox class="col-sm-8 form-control" name="hotwaterNotePosition"></textbox>
    </div>

    <!-- ADD Hot water PICS THERE -->
    <!-- -------------------------------------------------------------------------------------------- -->
    <!-- Solar Panel -->

    <label class="control-label col-sm-12" style="font-size: x-large; text-align:center; margin-bottom: 20px; margin-top: 50px;"><?= L10N['index']['installation']['equipmentEnergyDefinitionSolarPanel']?></label>

    <label class="col-sm-2 col-sm-2 control-label"><?= L10N['index']['installation']['solarPanel']?></label>
    <div class="col-sm-10" style="margin-bottom: 10px;">
        <textbox class="col-sm-8 form-control" name="solarPanel"></textbox>
    </div>

    <!-- IF pour masquer les deux textbox du dessous en cas de "no" pour le paneau solaire -->

    <label class="col-sm-2 col-sm-2 control-label"><?= L10N['index']['installation']['productionSensor']?></label>
    <div class="col-sm-10" style="margin-bottom: 10px;">
        <textbox class="col-sm-8 form-control" name="productionSensor"></textbox>
    </div>

    <label class="col-sm-2 col-sm-2 control-label"><?= L10N['index']['installation']['positionNote']?></label>
    <div class="col-sm-10" style="margin-bottom: 10px;">
        <textbox class="col-sm-8 form-control" name="solarPanelNotePosition"></textbox>
    </div>

    <!-- -------------------------------------------------------------------------------------------- -->
    <!-- address -->

    <label class="control-label col-sm-12" style="font-size: x-large; text-align:center; margin-bottom: 20px; margin-top: 50px;"><?= L10N['index']['installation']['generalInformation']?></label>

    <label class="col-sm-2 col-sm-2 control-label"><?= L10N['index']['installation']['address']?></label>
    <div class="col-sm-10" style="margin-bottom: 10px;">
        <textbox class="col-sm-8 form-control" name="address"></textbox>
    </div>

    <label class="col-sm-2 col-sm-2 control-label"><?= L10N['index']['installation']['npa']?></label>
    <div class="col-sm-10" style="margin-bottom: 10px;">
        <textbox class="col-sm-8 form-control" name="npa"></textbox>
    </div>

    <label class="col-sm-2 col-sm-2 control-label"><?= L10N['index']['installation']['city']?></label>
    <div class="col-sm-10" style="margin-bottom: 10px;">
        <textbox class="col-sm-8 form-control" name="city"></textbox>
    </div>

    <label class="col-sm-2 col-sm-2 control-label"><?= L10N['index']['installation']['generalNote']?></label>
    <div class="col-sm-10" style="margin-bottom: 10px;">
        <textbox class="col-sm-8 form-control" name="generalNote"></textbox>
    </div>

    <!-- ADD House PICS THERE -->



</div>
