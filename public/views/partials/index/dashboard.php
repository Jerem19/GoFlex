<!--
<div class="row mt col-lg-12 form-panel">
    <div style="text-align: center;">
        <div style="font-size: 400%;">
            <p><?= L10N['index']['dashboard']['electricalConsumption']?></p>
        </div>
        <div id="ElectricConsumption" style="margin-top: 20px; font-size: 300%;">
            <p id="ElectricConsumption"></p>
        </div>
        <span style="font-size: 500%" class="fa fa-database"></span>

    </div>
</div>
-->
<div class="row mt col-lg-12 form-panel">

    <div style="text-align: center;">
        <div style="font-size: 400%;">
            <p><?= $l10n["chart"]["consumptionHeatPump"] ?></p>
        </div>
        <div id="consumptionPAC" style="margin-top: 20px; font-size: 300%;">
            <p id="consumptionPACValue"></p>
        </div>
        <span style="font-size: 500%" class="fa fa-bolt"></span>
    </div>
</div>

<div class="row mt col-lg-12 form-panel">

    <div style="text-align: center;">
        <div style="font-size: 400%;">
            <p><?= $l10n["chart"]["hotwaterTemperature"] ?></p>
        </div>
        <div id="hotwaterTemperature" style="margin-top: 20px; font-size: 300%;">
            <p id="hotwaterTemperature"></p>
        </div>
        <span style="font-size: 500%" class="fa fa-bath"></span>

    </div>
</div>

<div class="row mt col-lg-12 form-panel">
    <div style="text-align: center;">
        <div style="font-size: 400%;">
            <p><?= $l10n["chart"]["insideTemperature"] ?></p>
        </div>
        <div id="insideTemp" style="margin-top: 20px; font-size: 300%;">
            <p id="insideTemp"></p>
        </div>
        <span style="font-size: 500%" class="fa fa-thermometer"></span>

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