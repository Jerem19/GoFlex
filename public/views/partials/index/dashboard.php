
<div class="row mt col-lg-12 form-panel">
    <div style="text-align: center;">
        <div class="dashboardTitleSize">
            <p><?= L10N['index']['dashboard']['electricalConsumption']?></p>
        </div>
        <span class="fa fa-bolt dashboardFaSize"></span>
        <p class="dashboardTextSize"><?= L10N['index']['dashboard']['textConsumptionElec']?></p>
        <div id="electricConsumption"  class="dashboardNumberSize">
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
        <div class="dashboardNumberSize" id="consumptionHeatPump">
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
        </div>

    </div>
</div>



<script>

    window.onload = function() {

        function ajaxError (elementId) {
            document.getElementById(elementId).innerHTML = "<?= $l10n["chart"]["noData"] ?>";
        }

        var urls = {
            "consumptionHeatPump": 'kW',
            "hotwaterTemperature": '°',
            "insideTemp": '°',
            "electricConsumption": 'kW'
        };

        for (const i in urls) {
            $.ajax({
                url : i,
                type : 'POST',
                success : function(data) {
                    if (data && Array.isArray(data)) {
                        document.getElementById(i).innerHTML = data[0]['value'] + urls[i] +
                            "<br/><p style=\"font-size: 15px;\">" + new Date(data[0]["time"]).toISOString().substr(0,16) + "</p>";
                    }
                    else ajaxError(i);
                },
                error: function () {
                    ajaxError(i);
                }
            });
        }
    }

</script>