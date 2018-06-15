<div class="row mt col-lg-12 form-panel" style="margin-bottom: 10px; text-align: center; font-size: xx-large;">
    <?= L10N['index']['sidebar']['dashboard']?>
</div>
<div class="row mt col-lg-12 form-panel">
    <div style="text-align: center;">
        <div class="dashboardTitleSize">
            <p><?= L10N['index']['dashboard']['electricalConsumption']?></p>
        </div>

        <a href="consumptionElect">
        <span class="fa fa-bolt dashboardFaSize"></span>


        <p class="dashboardTextSize"><?= L10N['index']['dashboard']['textConsumptionElec']?></p>
        <div id="consumptionElectSpeed"  class="dashboardNumberSize">
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

<?php
if($user->getInstallations()[0]->Solar()->isExistant())
{

?>
<div class="row mt col-lg-12 form-panel">
    <div style="text-align: center;">
        <div class="dashboardTitleSize">
            <p><?= $l10n["chart"]["productionElect"] ?></p>
</div>

<a href="productionElect">
    <span class="fa fa-thermometer dashboardFaSize"></span>


    <p class="dashboardTextSize"><?= L10N['index']['dashboard']['productionElect']?></p>
    <div class="dashboardNumberSize" id="productionElect">
    </div>
</a>
</div>
</div>
<?php } ?>




<script>

    window.onload = function() {

        function ajaxError (elementId) {
            document.getElementById(elementId).innerHTML = "<?= $l10n["chart"]["noData"] ?>";
        }

        var urls = {
            "consumptionElectSpeed": 'kW',
            "consumptionHeatPump": 'kW',
            "hotwaterTemperature": '°',
            "insideTemp": '°',
            "productionElect": 'kW'
        };

        for (const i in urls) {
            $.ajax({
                url : i,
                type : 'POST',
                success : function(data) {
                    if (data && Array.isArray(data)) {
                        console.log(data);
                        d = new Date(data[0]["time"]).toISOString().substr(0,16);
                        d = d.replace("T", " ");

                        if(i == "consumptionElectSpeed")
                        {
                            document.getElementById(i).innerHTML = data[0]['value']/1000 + urls[i] +
                                "<br/><p style=\"font-size: 15px;\">" + d + "</p>";
                        }
                        else
                        {
                            document.getElementById(i).innerHTML = data[0]['value'] + urls[i] +
                                "<br/><p style=\"font-size: 15px;\">" + d + "</p>";
                        }
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