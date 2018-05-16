<div class="row mt col-lg-12 form-panel">
    <form class='form-horizontal style-form' id="formLinkGatewayUser" method='post' enctype="multipart/form-data">

        <label class="control-label col-sm-12" style="font-size: x-large;"><?= L10N['index']['installation']['systemDefinition']?></label>
        <!-- CLIENT -->
        <label class="control-label col-sm-4"><?= L10N['index']['installation']['clientNumber']?></label>

        <select name="clientNumber" class="col-sm-8 form-control">
            <?php
            foreach($user->getAllUser() as $valueUser)
            {
                echo "<option value=" . $valueUser['userid'] .">" . $valueUser['username'] . "</option>";
            }
            ?>
        </select>

        <!-- INSTALLATION -->
        <label class="control-label col-sm-4"><?= L10N['index']['installation']['boxNumber']?></label>
        <select name="boxNumber" class="col-sm-8 form-control">
            <?php
            foreach($user->getAllGateway() as $valueGateway)
            {
                echo "<option value=" . $valueGateway['gatewayId'] .">" . $valueGateway['name'] . "</option>";
            }
            ?>
        </select>

        <!-- FACTURATION -->
        <label class="control-label col-sm-4"><?= L10N['index']['installation']['facturation']?></label>
        <select name="facturation" class="col-sm-8 form-control">
            <option value="inf"><?= L10N['index']['installation']['lower']?></option>
            <option value="sup"><?= L10N['index']['installation']['higher']?></option>
        </select>

        <!-- SECTEURACTIVITE -->
        <label class="control-label col-sm-4"><?= L10N['index']['installation']['businessSector']?></label>
        <select name="businessSector" class="col-sm-8 form-control">
            <option value="residential"><?= L10N['index']['installation']['residential']?></option>
            <option value="industrial"><?= L10N['index']['installation']['industrial']?></option>
            <option value="tertiary"><?= L10N['index']['installation']['tertiary']?></option>
        </select>

        <!-- -------------------------------------------------------------------------------------------- -->

        <label class="control-label col-sm-12" style="font-size: x-large; margin-top: 50px;"><?= L10N['index']['installation']['equipmentEnergyDefinition']?></label>

        <label class="control-label col-sm-4"><?= L10N['index']['installation']['energyHeat']?></label>
        <select name="energyHeat" class="col-sm-8 form-control">
            <option value="electricity"><?= L10N['index']['installation']['electricity']?></option>
            <option value="gaz"><?= L10N['index']['installation']['gaz']?></option>
            <option value="wood"><?= L10N['index']['installation']['wood']?></option>
        </select>

        <label class="control-label col-sm-4"><?= L10N['index']['installation']['technoHeat']?></label>
        <select name="technoHeat" class="col-sm-8 form-control">
            <option value="pac"><?= L10N['index']['installation']['pac']?></option>
            <option value="boiler"><?= L10N['index']['installation']['boiler']?></option>
            <option value="wood-burner"><?= L10N['index']['installation']['wood-burner']?></option>
        </select>

        <label class="control-label col-sm-4"><?= L10N['index']['installation']['energyHotWater']?></label>
        <select name="energyHotWater" class="col-sm-8 form-control">
            <option value="electricity"><?= L10N['index']['installation']['electricity']?></option>
            <option value="gaz"><?= L10N['index']['installation']['gaz']?></option>
            <option value="wood"><?= L10N['index']['installation']['wood']?></option>
        </select>

        <label class="control-label col-sm-4"><?= L10N['index']['installation']['technoHotWater']?></label>
        <select name="technoHotWater" class="col-sm-8 form-control">
            <option value="pac"><?= L10N['index']['installation']['pac']?></option>
            <option value="boiler"><?= L10N['index']['installation']['boiler']?></option>
            <option value="wood-burner"><?= L10N['index']['installation']['wood-burner']?></option>
        </select>

        <label class="control-label col-sm-4"><?= L10N['index']['installation']['chargingBorne']?></label>
        <select name="chargingBorne" class="col-sm-8 form-control">
            <option value="yes"><?= L10N['index']['installation']['yes']?></option>
            <option value="no"><?= L10N['index']['installation']['no']?></option>
        </select>

        <label class="control-label col-sm-4"><?= L10N['index']['installation']['solarPanel']?></label>
        <select name="solarPanel" class="col-sm-8 form-control">
            <option value="yes"><?= L10N['index']['installation']['yes']?></option>
            <option value="no"><?= L10N['index']['installation']['no']?></option>
        </select>

        <!-- -------------------------------------------------------------------------------------------- -->

        <label class="control-label col-sm-12" style="font-size: x-large; margin-top: 50px;"><?= L10N['index']['installation']['generalInformation']?></label>

        <label class="control-label col-sm-4"><?= L10N['index']['installation']['address']?></label><input required="required" class="col-sm-8 form-control" name="address" />

        <label class="control-label col-sm-4"><?= L10N['index']['installation']['npa']?></label><input required="required" type="number" class="col-sm-8 form-control" name="npa" />

        <label class="control-label col-sm-4"><?= L10N['index']['installation']['city']?></label><input required="required" class="col-sm-8 form-control" name="city" />

        <label class="control-label col-sm-4"><?= L10N['index']['installation']['generalNote']?></label><textarea class="col-sm-8 form-control" name="generalNote"></textarea>

        <label class="control-label col-sm-4"><?= L10N['index']['installation']['positionNote']?></label><textarea class="col-sm-8 form-control" name="positionNote"></textarea>

        <!-- TEMPORAIRE TODO -->
        <input style="display: none;" class="col-sm-8 form-control" name="picture" />
        <!--<label class="control-label col-sm-4"><?= L10N['index']['installation']['picture']?></label><input type="file" style="margin-bottom: 20px;" class="col-sm-8 form-control" name="picture" />-->

        <button class="btn btn-theme02 btn-block" type="submit"><?= L10N['index']['installation']['link']?></button>

    </form>
</div>

<script>
    window.onload = function() {

        $("#formLinkGatewayUser").submit(function (event) {
            att = $(this).serialize();
            alert(att);
            exit();
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
</script>