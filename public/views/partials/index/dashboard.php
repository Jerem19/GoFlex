<!--
<div class="row mt col-lg-12 form-panel">
    <div style="text-align: center;">
        <div class="dashboardTextSize">
            <p><?= L10N['index']['dashboard']['electricalConsumption']?></p>
        </div>
        <div id="ElectricConsumption"  class="dashboardNumberSize">
            <p id="ElectricConsumption"></p>
        </div>
        <span class="fa fa-database dashboardFaSize"></span>

    </div>
</div>
-->
<div class="row mt col-lg-12 form-panel">

    <div style="text-align: center;">
        <div class="dashboardTextSize">
            <p><?= $l10n["chart"]["consumptionHeatPump"] ?></p>
        </div>
        <div class="dashboardNumberSize" id="consumptionPAC" style="">
            <p id="consumptionPACValue"></p>
        </div>
        <span class="fa fa-bolt dashboardFaSize"></span>
    </div>
</div>

<div class="row mt col-lg-12 form-panel">

    <div style="text-align: center;">
        <div class="dashboardTextSize">
            <p><?= $l10n["chart"]["hotwaterTemperature"] ?></p>
        </div>
        <div class="dashboardNumberSize" id="hotwaterTemperature">
            <p id="hotwaterTemperature"></p>
        </div>
        <span class="fa fa-bath dashboardFaSize"></span>

    </div>
</div>

<div class="row mt col-lg-12 form-panel">
    <div style="text-align: center;">
        <div class="dashboardTextSize">
            <p><?= $l10n["chart"]["insideTemperature"] ?></p>
        </div>
        <div class="dashboardNumberSize" id="insideTemp">
            <p id="insideTemp"></p>
        </div>
        <span class="fa fa-thermometer dashboardFaSize"></span>

    </div>
</div>



<script>

    window.onload = function() {

        $.post("ConsumptionHeatPump", function (data) {
            document.getElementById("consumptionPACValue").innerHTML = data['ConsumptionHeatPump'][0]['value']+ " kW";
            }
        );

        $.post("hotwaterTemperature", function (data) {
                document.getElementById("hotwaterTemperature").innerHTML = data['hotwaterTemperature'][0]['value']+ " °C";
            }
        );

        $.post("insideTemp", function (data) {
                document.getElementById("insideTemp").innerHTML = data['insideTemp'][0]['value'] + " °C";
            }
        );

        $.post("ElectricConsumption", function (data) {
                console.log(data);
                document.getElementById("ElectricConsumption").innerHTML = data['ElectricConsumption'][0]['value'] + " W";
            }
        );


    }

</script>