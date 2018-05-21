
<div class="row mt col-lg-12 form-panel">
    <div style="text-align: center;">
        <div class="dashboardTitleSize">
            <p><?= L10N['index']['dashboard']['electricalConsumption']?></p>
        </div>
        <span class="fa fa-bolt dashboardFaSize"></span>
        <p class="dashboardTextSize"><?= L10N['index']['dashboard']['textConsumptionElec']?></p>
        <div id="ElectricConsumption"  class="dashboardNumberSize">
            <p id="ElectricConsumption"></p>
        </div>
    </div>
</div>

<div class="row mt col-lg-12 form-panel">

    <div style="text-align: center;">
        <div class="dashboardTitleSize">
            <p><?= $l10n["chart"]["consumptionHeatPump"] ?></p>
        </div>

        <span class="fa fa-bolt dashboardFaSize"></span>
        <p class="dashboardTextSize"><?= L10N['index']['dashboard']['textHeatPump']?></p>
        <div class="dashboardNumberSize" id="consumptionPAC" style="">
            <p id="consumptionPACValue"></p>
        </div>
    </div>
</div>

<div class="row mt col-lg-12 form-panel">

    <div style="text-align: center;">
        <div class="dashboardTitleSize">
            <p><?= $l10n["chart"]["hotwaterTemperature"] ?></p>
        </div>

        <span class="fa fa-bath dashboardFaSize"></span>
        <p class="dashboardTextSize"><?= L10N['index']['dashboard']['textHotwaterTemperature']?></p>
        <div class="dashboardNumberSize" id="hotwaterTemperature">
            <p id="hotwaterTemperature"></p>
        </div>

    </div>
</div>

<div class="row mt col-lg-12 form-panel">
    <div style="text-align: center;">
        <div class="dashboardTitleSize">
            <p><?= $l10n["chart"]["insideTemperature"] ?></p>
        </div>

        <span class="fa fa-thermometer dashboardFaSize"></span>
        <p class="dashboardTextSize"><?= L10N['index']['dashboard']['textInsideTemperature']?></p>
        <div class="dashboardNumberSize" id="insideTemp">
            <p id="insideTemp"></p>
        </div>

    </div>
</div>



<script>

    window.onload = function() {

        $.ajax({
            url : 'consumptionHeatPump',
            type : 'POST',
            success : function(data) {
                document.getElementById("consumptionPACValue").innerHTML = data['ConsumptionHeatPump'][0]['value'] + " kW";
            },
            error: function() {
                document.getElementById("consumptionPACValue").innerHTML = "<?= $l10n["chart"]["noData"] ?>";
            }
        });

        $.ajax({
            url : 'hotwaterTemperature',
            type : 'POST',
            success : function(data) {
                document.getElementById("hotwaterTemperature").innerHTML = data['hotwaterTemperature'][0]['value'] + " kW";
            },
            error: function() {
                document.getElementById("hotwaterTemperature").innerHTML = "<?= $l10n["chart"]["noData"] ?>";
            }
        });

        $.ajax({
            url : 'insideTemp',
            type : 'POST',
            success : function(data) {
                document.getElementById("insideTemp").innerHTML = data['insideTemp'][0]['value'] + " kW";
            },
            error: function() {
                document.getElementById("insideTemp").innerHTML = "<?= $l10n["chart"]["noData"] ?>";
            }
        });


        $.ajax({
            url : 'ElectricConsumption',
            type : 'POST',
            success : function(data) {
                document.getElementById("ElectricConsumption").innerHTML = data['ElectricConsumption'][0]['value'] + " kW";
            },
            error: function() {
                document.getElementById("ElectricConsumption").innerHTML = "<?= $l10n["chart"]["noData"] ?>";
            }
        });


    }

</script>