<div class="row mt col-lg-12 form-panel">
    <form class='form-horizontal style-form' id="formLinkGatewayUser" method='post' enctype="multipart/form-data">

        <label class="control-label col-sm-12" style="font-size: x-large; margin-bottom: 20px;"><?= L10N['index']['installation']['systemDefinition']?></label>


        <div class="form-group">
            <!-- USER -->
            <label class="col-sm-2 col-sm-2 control-label"><?= L10N['index']['installation']['clientName']?></label>
            <div class="col-sm-10" style="margin-bottom: 10px;">
                <select name="clientNumber" class="col-sm-8 form-control">
                    <?php
                    foreach($user->getAllInactiveUser() as $valueGateway)
                    {
                        echo "<option value=" . $valueGateway['userId'] .">" . $valueGateway['username'] . "</option>";
                    }
                    ?>
                </select>
            </div>


            <!-- INSTALLATION -->
            <label class="col-sm-2 col-sm-2 control-label"><?= L10N['index']['installation']['boxNumber']?></label>
            <div class="col-sm-10" style="margin-bottom: 10px;">
                <select name="boxNumber" class="col-sm-8 form-control">
                    <?php
                    foreach($user->getAllGateway() as $valueGateway)
                    {
                        echo "<option value=" . $valueGateway['gatewayId'] .">" . $valueGateway['name'] . "</option>";
                    }
                    ?>
                </select>
            </div>


            <!-- FACTURATION -->
            <label class="col-sm-2 col-sm-2 control-label"><?= L10N['index']['installation']['facturation']?></label>
            <div class="col-sm-10" style="margin-bottom: 10px;">
                <select name="facturation" class="col-sm-8 form-control">
                    <option value="inf"><?= L10N['index']['installation']['lower']?></option>
                    <option value="sup"><?= L10N['index']['installation']['higher']?></option>
                </select>
            </div>

            <!-- SECTEURACTIVITE -->
            <label class="col-sm-2 col-sm-2 control-label"><?= L10N['index']['installation']['businessSector']?></label>
            <div class="col-sm-10" style="margin-bottom: 10px;">
                <select name="businessSector" class="col-sm-8 form-control">
                    <option value="residential"><?= L10N['index']['installation']['residential']?></option>
                    <option value="industrial"><?= L10N['index']['installation']['industrial']?></option>
                    <option value="tertiary"><?= L10N['index']['installation']['tertiary']?></option>
                </select>
            </div>
        </div>


        <!-- -------------------------------------------------------------------------------------------- -->

        <!-- HEAT -->


        <label class="control-label col-sm-12" style="font-size: x-large; margin-bottom: 20px;"><?= L10N['index']['installation']['equipmentEnergyDefinitionHeat']?></label>

        <div class="form-group">
            <label class="col-sm-2 col-sm-2 control-label"><?= L10N['index']['installation']['energyHeat']?></label>
            <div class="col-sm-10" style="margin-bottom: 10px;">
                <select name="energyHeat" class="col-sm-8 form-control">
                    <option value="electricity"><?= L10N['index']['installation']['electricity']?></option>
                    <option value="gaz"><?= L10N['index']['installation']['gaz']?></option>
                    <option value="wood"><?= L10N['index']['installation']['wood']?></option>
                </select>
            </div>

            <label class="col-sm-2 col-sm-2 control-label"><?= L10N['index']['installation']['technoHeat']?></label>
            <div class="col-sm-10" style="margin-bottom: 10px;">
                <select name="technoHeat" class="col-sm-8 form-control">
                    <option value="pac"><?= L10N['index']['installation']['pac']?></option>
                    <option value="boiler"><?= L10N['index']['installation']['boiler']?></option>
                    <option value="wood-burner"><?= L10N['index']['installation']['wood-burner']?></option>
                </select>
            </div>

            <label class="col-sm-2 col-sm-2 control-label"><?= L10N['index']['installation']['consommationSensor']?></label></label>
            <div class="col-sm-10" style="margin-bottom: 10px;">
                <input required="required" type="number" class="col-sm-8 form-control" name="consommationHeatSensor" />
            </div>

            <label class="col-sm-2 col-sm-2 control-label"><?= L10N['index']['installation']['insideTemperatureSensor']?></label></label>
            <div class="col-sm-10" style="margin-bottom: 10px;">
                <input required="required" type="number" class="col-sm-8 form-control" name="insideTemperatureSensor" />
            </div>

            <label class="col-sm-2 col-sm-2 control-label"><?= L10N['index']['installation']['positionNote']?></label>
            <div class="col-sm-10" style="margin-bottom: 10px;">
                <textarea class="col-sm-8 form-control" name="heatNotePosition"></textarea>
            </div>

            <label class="col-sm-2 col-sm-2 control-label"><?= L10N['index']['installation']['picture']?></label>
            <div class="col-sm-10" style="margin-bottom: 10px;">
                <input type="file" style="margin-bottom: 20px;" class="col-sm-8 form-control" name="pictureHeat[]" multiple="multiple" />
            </div>
        </div>

        <!-- -------------------------------------------------------------------------------------------- -->

        <!-- Hot water -->

        <label class="control-label col-sm-12" style="font-size: x-large; margin-bottom: 20px;"><?= L10N['index']['installation']['equipmentEnergyDefinitionHotwater']?></label>

        <div class="form-group">
            <label class="col-sm-2 col-sm-2 control-label"><?= L10N['index']['installation']['energyHotWater']?></label>
            <div class="col-sm-10" style="margin-bottom: 10px;">
                <select name="energyHotWater" class="col-sm-8 form-control">
                    <option value="electricity"><?= L10N['index']['installation']['electricity']?></option>
                    <option value="gaz"><?= L10N['index']['installation']['gaz']?></option>
                    <option value="wood"><?= L10N['index']['installation']['wood']?></option>
                </select>
            </div>

            <label class="col-sm-2 col-sm-2 control-label"><?= L10N['index']['installation']['technoHotWater']?></label>
            <div class="col-sm-10" style="margin-bottom: 10px;">
                <select name="technoHotWater" class="col-sm-8 form-control">
                    <option value="pac"><?= L10N['index']['installation']['pac']?></option>
                    <option value="boiler"><?= L10N['index']['installation']['boiler']?></option>
                    <option value="wood-burner"><?= L10N['index']['installation']['wood-burner']?></option>
                </select>
            </div>

            <label class="col-sm-2 col-sm-2 control-label"><?= L10N['index']['installation']['consommationSensor']?></label></label>
            <div class="col-sm-10" style="margin-bottom: 10px;">
                <input required="required" type="number" class="col-sm-8 form-control" name="consommationHotwaterSensor" />
            </div>

            <label class="col-sm-2 col-sm-2 control-label"><?= L10N['index']['installation']['boilerTemperatureSensor']?></label></label>
            <div class="col-sm-10" style="margin-bottom: 10px;">
                <input required="required" type="number" class="col-sm-8 form-control" name="boilerTemperatureSensor" />
            </div>
            <label class="col-sm-2 col-sm-2 control-label"><?= L10N['index']['installation']['positionNote']?></label>
            <div class="col-sm-10" style="margin-bottom: 10px;">
                <textarea class="col-sm-8 form-control" name="hotwaterNotePosition"></textarea>
            </div>

            <!-- 25mo autorises -->
            <input type="hidden" name="MAX_FILE_SIZE" value="26214400" />

            <label class="col-sm-2 col-sm-2 control-label"><?= L10N['index']['installation']['picture']?></label>
            <div class="col-sm-10" style="margin-bottom: 10px;">
                <input type="file" style="margin-bottom: 20px;" class="col-sm-8 form-control" name="pictureHotwater" />
            </div>
        </div>

        <!-- -------------------------------------------------------------------------------------------- -->

        <!-- Charging Borne -->
        <!-- PROJET EVIP
        <label class="control-label col-sm-12" style="font-size: x-large; margin-bottom: 20px;"><?= L10N['index']['installation']['equipmentEnergyDefinitionChargingBorne']?></label>

        <div class="form-group">
            <label class="col-sm-2 col-sm-2 control-label"><?= L10N['index']['installation']['chargingBorne']?></label>
            <div class="col-sm-10" style="margin-bottom: 10px;">
                <select name="chargingBorne" class="col-sm-8 form-control">
                    <option value="yes"><?= L10N['index']['installation']['yes']?></option>
                    <option value="no"><?= L10N['index']['installation']['no']?></option>
                </select>
            </div>

            <label class="col-sm-2 col-sm-2 control-label">Capteur consommation</label></label>
            <div class="col-sm-10" style="margin-bottom: 10px;">
                <input type="number" class="col-sm-8 form-control" name="consommationSensorChargingBorne" />
            </div>

            <label class="col-sm-2 col-sm-2 control-label">Capteur eau chaude</label></label>
            <div class="col-sm-10" style="margin-bottom: 10px;">
                <input type="number" class="col-sm-8 form-control" name="HotWaterSensor" />
            </div>

            <label class="col-sm-2 col-sm-2 control-label"><?= L10N['index']['installation']['positionNote']?></label>
            <div class="col-sm-10" style="margin-bottom: 10px;">
                <textarea class="col-sm-8 form-control" name="positionNoteChargingBorne"></textarea>
            </div>
        </div>
-->
        <!-- -------------------------------------------------------------------------------------------- -->

        <!-- Solar panel -->

        <label class="control-label col-sm-12" style="font-size: x-large; margin-bottom: 20px;"><?= L10N['index']['installation']['equipmentEnergyDefinitionSolarPanel']?></label>

        <div class="form-group">

            <label class="col-sm-2 col-sm-2 control-label"><?= L10N['index']['installation']['solarPanel']?></label>
            <div class="col-sm-10" style="margin-bottom: 10px;">
                <select id="solarPanelSelect" name="solarPanel" class="col-sm-8 form-control" onChange="disabledOrEnable(this)">
                    <option value="no"><?= L10N['index']['installation']['no']?></option>
                    <option value="yes"><?= L10N['index']['installation']['yes']?></option>
                </select>
            </div>

            <label class="col-sm-2 col-sm-2 control-label"><?= L10N['index']['installation']['productionSensor']?></label></label>
            <div class="col-sm-10" style="margin-bottom: 10px;">
                <input id="productionSensor" disabled="disabled" type="number" class="col-sm-8 form-control" name="productionSensor" />
            </div>

            <label class="col-sm-2 col-sm-2 control-label"><?= L10N['index']['installation']['positionNote']?></label>
            <div class="col-sm-10" style="margin-bottom: 10px;">
                <textarea id="positionNoteSolarPanel" disabled="disabled" class="col-sm-8 form-control" name="solarPanelNotePosition"></textarea>
            </div>

        </div>

        <!-- -------------------------------------------------------------------------------------------- -->

        <label class="control-label col-sm-12" style="font-size: x-large; margin-bottom: 20px;"><?= L10N['index']['installation']['generalInformation']?></label>

        <div class="form-group">

            <label class="col-sm-2 col-sm-2 control-label"><?= L10N['index']['installation']['address']?></label>
            <div class="col-sm-10" style="margin-bottom: 10px;">
                <input required="required" class="col-sm-8 form-control" name="address" />
            </div>
            <label class="col-sm-2 col-sm-2 control-label"><?= L10N['index']['installation']['npa']?></label>
            <div class="col-sm-10" style="margin-bottom: 10px;">
                <input required="required" type="number" class="col-sm-8 form-control" name="npa" />
            </div>
            <label class="col-sm-2 col-sm-2 control-label"><?= L10N['index']['installation']['city']?></label>
            <div class="col-sm-10" style="margin-bottom: 10px;">
                <input required="required" class="col-sm-8 form-control" name="city" />
            </div>
            <label class="col-sm-2 col-sm-2 control-label"><?= L10N['index']['installation']['generalNote']?></label>
            <div class="col-sm-10" style="margin-bottom: 10px;">
                <textarea class="col-sm-8 form-control" style="margin-bottom: 10px;" name="generalNote"></textarea>
            </div>
        </div>

        <button class="btn btn-theme02 btn-block" type="submit"><?= L10N['index']['installation']['link']?></button>

    </form>
</div>

<script>
    window.onload = function() {

        solarPanel.addEventListener("onchange", disabledOrEnable)

        $("#formLinkGatewayUser").submit(function (event) {
            att = $(this).serialize();

            $.post("linkUserGateway", att, function (data) {
                data = JSON.parse(data);

                if (data) {
                    alert("<?= L10N['index']['installation']['alertLinUserGatewaySuccess']?>");
                    window.location.reload();
                }
                else {
                    alert("<?= L10N['index']['installation']['alertLinUserGatewayFailed']?>");
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