<div class="row mt col-lg-12 form-panel" style="margin-bottom: 10px; text-align: center; font-size: xx-large;">
    <?= L10N['index']['sidebar']['dashboard']?>
</div>
<div class="row mt col-lg-12 form-panel">
    <div style="text-align: center;">
        <div class="dashboardTitleSize">
            <p><?= L10N['index']['dashboard']['electricalConsumption']?></p>
        </div>

        <a href="consumption">
        <span class="fa fa-bolt dashboardFaSize"></span>


        <p class="dashboardTextSize"><?= L10N['index']['dashboard']['textConsumptionElec']?></p>
        <div id="electricConsumption"  class="dashboardNumberSize">
        </div></a>
    </div>
</div>

<div class="row mt col-lg-12 form-panel">

    <div style="text-align: center;">
        <div class="dashboardTitleSize">
            <p><?= $l10n["chart"]["consumptionHeatPump"] ?></p>
        </div>
        <a href="consumptionHeatPump">
        <span class="fa fa-bolt dashboardFaSize"></span>


        <p class="dashboardTextSize"><?= L10N['index']['dashboard']['textHeatPump']?></p>

        <div class="dashboardNumberSize" id="consumptionHeatPump">

        </div></a>
    </div>
</div>

<div class="row mt col-lg-12 form-panel">

    <div style="text-align: center;">
        <div class="dashboardTitleSize">
            <p><?= $l10n["chart"]["hotwaterTemperature"] ?></p>
        </div>
        <a href="boiler">
        <span class="fa fa-bath dashboardFaSize"></span>


        <p class="dashboardTextSize"><?= L10N['index']['dashboard']['textHotwaterTemperature']?></p>
        <div class="dashboardNumberSize" id="hotwaterTemperature">
        </div>
        </a>
    </div>
</div>

<div class="row mt col-lg-12 form-panel">
    <div style="text-align: center;">
        <div class="dashboardTitleSize">
            <p><?= $l10n["chart"]["insideTemperature"] ?></p>
        </div>

        <a href="insideTemp">
        <span class="fa fa-thermometer dashboardFaSize"></span>


        <p class="dashboardTextSize"><?= L10N['index']['dashboard']['textInsideTemperature']?></p>
        <div class="dashboardNumberSize" id="insideTemp">
        </div>
        </a>
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
                        d = new Date(data[0]["time"]).toISOString().substr(0,16);
                        d = d.replace("T", " ");

                        document.getElementById(i).innerHTML = data[0]['value'] + urls[i] +
                            "<br/><p style=\"font-size: 15px;\">" + d + "</p>";
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