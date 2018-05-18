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
    <label class="control-label col-sm-12" style="font-size: x-large; margin-bottom: 20px;"><?= L10N['index']['installation']['systemDefinition']?></label>

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
    <div class="col-sm-10" style="margin-bottom: 10px;">
        <textbox class="col-sm-8 form-control" name="businessSector"></textbox>
    </div>

    <!-- -------------------------------------------------------------------------------------------- -->
    <!-- HEAT -->

    <label class="control-label col-sm-12" style="font-size: x-large; margin-bottom: 20px;"><?= L10N['index']['installation']['equipmentEnergyDefinitionHeat']?></label>

    <label class="col-sm-2 col-sm-2 control-label"><?= L10N['index']['installation']['energyHeat']?></label>
    <div class="col-sm-10" style="margin-bottom: 10px;">
        <textbox class="col-sm-8 form-control" name="energyHeat"></textbox>
    </div>




</div>
