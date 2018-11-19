<div id="loading" style="display: none;"></div>
<div class="row mt form-panel" style="text-align: center; font-size: xx-large;">
    <h2 class="head-title"><?= L10N['index']['sidebar']['userGraph'] ?></h2>
</div>

<div class="row mt form-panel">
    <label class="control-label"><?= L10N['index']['checkUserData']['chooseUser'] ?></label>

    <select name="gwId" class="form-control">
        <?php
        $gws = $isInstall ? Gateway::getAllReady() : Gateway::getAllInstalled();
        foreach ($gws as $gw) { ?>
            <option value="<?= $gw->getId() ?>"><?= $gw->getName() ?>
                [<?= $gw->getInstallation()->getUser()->getUsername() ?>]
            </option>
        <?php } ?>
    </select>
</div>

<div class="row mt form-panel" id="info" style="display: <?= empty($gws) ? "none" : "block" ?>">
    <form class='form-horizontal style-form' id="formGw" method='post' enctype="multipart/form-data"><fieldset>
            <div class="form-group">
                <label class="control-label col-sm-12 head-title"><?= $l10n['installation']['systemDefinition'] ?></label>

                <div class="col-sm-12">

                    <div>
                        <img id="loaderConsumptionElect" src="<?= BASE_URL ?>/public/images/loader.gif" style="display: block; margin-left: auto; margin-right: auto; width: 200px;"/>

                        <div id="consumptionElect" style="width: calc(100% - 15px); text-align: center;">
                        </div>
                    </div>


                    <div>
                        <img id="loaderHotwater" src="<?= BASE_URL ?>/public/images/loader.gif" style="display: block; margin-left: auto; margin-right: auto; width: 200px;"/>

                        <div id="hotwaterTemperature" style="width: calc(100% - 15px); text-align: center;">
                        </div>
                    </div>


                    <div>
                        <img id="loaderHeatPump" src="<?= BASE_URL ?>/public/images/loader.gif" style="display: block; margin-left: auto; margin-right: auto; width: 200px;"/>

                        <div id="consumptionHeatPump" style="width: calc(100% - 15px); text-align: center;">
                        </div>
                    </div>


                    <div>
                        <img id="loaderInsideTemp" src="<?= BASE_URL ?>/public/images/loader.gif" style="display: block; margin-left: auto; margin-right: auto; width: 200px;"/>

                        <div id="insideTemp" style="width: calc(100% - 15px); text-align: center;">
                        </div>
                    </div>

                    <div>
                        <img id="loaderProductionElect" src="<?= BASE_URL ?>/public/images/loader.gif"
                             style="display: block; margin-left: auto; margin-right: auto; width: 200px;"/>

                        <div id="productionElect" style="width: calc(100% - 15px); text-align: center;">

                        </div>
                    </div>
                </div>
            </div>


        </fieldset></form>
</div>

<?php loadStyles([
    "3rdparty/lightbox.css"
]); ?>

<script>
    window.onload = function() {

        selectGw = $('select[name="gwId"]');
        var dataUser = 0;


        selectGw.on('change', function () {
            $.ajax({
                url: 'installUser',
                type: 'POST',
                data: { id : $(this).val() },
                success : function (data) {
                    dataUser = data;

                    $.ajax({
                        type: "POST",
                        url: "consumptionElectSpec",
                        data: "idGateway=" + dataUser,
                        timeout: 25000,
                        success: function (data) {
                            dataTime = [];
                            for (var j in data) {
                                d = new Date(data[j]["time"]);

                                if(d.getTimezoneOffset() != 120)
                                {
                                    d.setHours(d.getHours() + 1)
                                }

                                newData = data[j]["sum_count"]/1000

                                dataTime.unshift([new Date(d.toISOString()).getTime(), newData])

                            }
                            Highcharts.StockChart('consumptionElect', {
                                chart: {
                                    events: {
                                        load: function() { document.getElementById("loaderConsumptionElect").style.display = "none"; resizeFooter(); }
                                    }
                                },
                                title: {
                                    text: "<?= $l10n["chart"]["consumptionElect"] ?>"
                                },
                                xAxis: {
                                    ordinal:false
                                },
                                yAxis: {
                                    opposite: false,
                                    title: {
                                        text: "kW"
                                    }
                                },
                                series: [{
                                    data: dataTime,
                                    tooltip: {
                                        valueDecimals: 2
                                    }
                                }],
                                navigator: {
                                    margin: 60,
                                    adaptToUpdatedData: false,
                                },
                                scrollbar: {
                                    liveRedraw: false
                                },
                                rangeSelector: {
                                    floating: true,
                                    selected: 1,
                                    buttons: [{
                                        type: 'day',
                                        count: 1,
                                        text: '1d'
                                    }, {
                                        type: 'day',
                                        count: 2,
                                        text: '2d'
                                    }, {
                                        type: 'day',
                                        count: 7,
                                        text: '7d'
                                    }, {
                                        type: 'day',
                                        count: 15,
                                        text: '15d'
                                    }, {
                                        type: 'all',
                                        text: 'All'
                                    }],
                                    inputEnabled: false // it supports only days
                                }
                            });
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            if (textStatus === "timeout") {
                                document.getElementById("loaderConsumptionElect").style.display = "none";
                                document.getElementById("insideTemp").innerHTML = "<?= $l10n["chart"]["noData"] ?>"
                            }
                        }
                    });



                    $.ajax({
                        type: "POST",
                        url: "consumptionHeatPumpSpec",
                        data: "idGateway=" + dataUser,
                        timeout: 25000,
                        success: function (data) {
                            dataTime = [];
                            for (var j in data) {

                                d = new Date(data[j]["time"]);

                                if(d.getTimezoneOffset() != 120)
                                {
                                    d.setHours(d.getHours() + 1)
                                }

                                newdata = data[j]["sum_count"]/1000;

                                dataTime.unshift([new Date(d.toISOString()).getTime(), newdata])
                            }
                            Highcharts.StockChart('consumptionHeatPump', {
                                chart: {
                                    events: {
                                        load: function() { document.getElementById("loaderHeatPump").style.display = "none"; resizeFooter(); }
                                    }
                                },
                                title: {
                                    text: "<?= $l10n["chart"]["consumptionHeatPump"] ?>"
                                },

                                xAxis: {
                                    ordinal:false
                                },

                                yAxis: {
                                    opposite: false,
                                    title: {
                                        text: "kW"
                                    }
                                },

                                series: [{
                                    data: dataTime,
                                    step: 'left',
                                    tooltip: {
                                        valueDecimals: 2
                                    }
                                }],
                                navigator: {
                                    margin: 60,
                                    adaptToUpdatedData: false,
                                },
                                scrollbar: {
                                    liveRedraw: false
                                },
                                rangeSelector: {
                                    floating: true,
                                    selected: 1,
                                    buttons: [{
                                        type: 'day',
                                        count: 1,
                                        text: '1d'
                                    }, {
                                        type: 'day',
                                        count: 7,
                                        text: '7d'
                                    },
                                        {
                                            type: 'day',
                                            count: 15,
                                            text: '15d'
                                        },
                                        {
                                            type: 'all',
                                            text: 'All'
                                        }],
                                    inputEnabled: false // it supports only days
                                }
                            });
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            if (textStatus === "timeout") {
                                document.getElementById("loaderHeatPump").style.display = "none";
                                document.getElementById("consumptionHeatPump").innerHTML = "<?= $l10n["chart"]["noData"] ?>"
                            }
                        }
                    });

                    $.ajax({
                        type: "POST",
                        url: "hotwaterTemperatureSpec",
                        data: "idGateway=" + dataUser,
                        timeout: 25000,
                        success: function (data) {
                            dataTime = [];
                            for (var j in data) {
                                d = new Date(data[j]["time"]);

                                if(d.getTimezoneOffset() != 120)
                                {
                                    d.setHours(d.getHours() + 1)
                                }
                                dataTime.unshift([new Date(d.toISOString()).getTime(), data[j]["sum_count"]])
                            }
                            Highcharts.StockChart('hotwaterTemperature', {
                                chart: {
                                    events: {
                                        load: function() { document.getElementById("loaderHotwater").style.display = "none"; resizeFooter(); }
                                    }
                                },
                                title: {
                                    text: "<?= $l10n["chart"]["hotwaterTemperature"] ?>"
                                },
                                xAxis: {
                                    ordinal:false
                                },
                                yAxis: {
                                    opposite: false,
                                    title: {
                                        text: "°C"
                                    }
                                },
                                series: [{
                                    data: dataTime,
                                    tooltip: {
                                        valueDecimals: 2
                                    }
                                }],
                                navigator: {
                                    margin: 60,
                                    adaptToUpdatedData: false,
                                },
                                scrollbar: {
                                    liveRedraw: false
                                },
                                rangeSelector: {
                                    floating: true,
                                    selected: 1,
                                    buttons: [{
                                        type: 'day',
                                        count: 1,
                                        text: '1d'
                                    }, {
                                        type: 'day',
                                        count: 7,
                                        text: '7d'
                                    },
                                        {
                                            type: 'day',
                                            count: 15,
                                            text: '15d'
                                        },
                                        {
                                            type: 'all',
                                            text: 'All'
                                        }],
                                    inputEnabled: false // it supports only days
                                }
                            });
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            if (textStatus === "timeout") {
                                document.getElementById("loaderHotwater").style.display = "none";
                                document.getElementById("hotwaterTemperature").innerHTML = "<?= $l10n["chart"]["noData"] ?>"
                            }
                        }
                    });

                    $.ajax({
                        type: "POST",
                        url: "insideTempSpec",
                        data: "idGateway=" + dataUser,
                        timeout: 25000,
                        success: function (data) {
                            dataTime = [];
                            for (var j in data) {
                                d = new Date(data[j]["time"]);

                                if(d.getTimezoneOffset() != 120)
                                {
                                    d.setHours(d.getHours() + 1)
                                }

                                if(data[j]["sum_count"] >= 0 && data[j]["sum_count"] < 50) {
                                    dataTime.unshift([new Date(d.toISOString()).getTime(), data[j]["sum_count"]])
                                }
                            }
                            Highcharts.StockChart('insideTemp', {
                                chart: {
                                    events: {
                                        load: function() { document.getElementById("loaderInsideTemp").style.display = "none"; resizeFooter(); }
                                    }
                                },
                                title: {
                                    text: "<?= $l10n["chart"]["insideTemperature"] ?>"
                                },
                                xAxis: {
                                    ordinal:false
                                },
                                yAxis: {
                                    opposite: false,
                                    title: {
                                        text: "°C"
                                    }
                                },
                                series: [{
                                    data: dataTime,
                                    tooltip: {
                                        valueDecimals: 2
                                    }
                                }],
                                navigator: {
                                    margin: 60,
                                    adaptToUpdatedData: false,
                                },
                                scrollbar: {
                                    liveRedraw: false
                                },
                                rangeSelector: {
                                    floating: true,
                                    selected: 1,
                                    buttons: [{
                                        type: 'day',
                                        count: 1,
                                        text: '1d'
                                    }, {
                                        type: 'day',
                                        count: 7,
                                        text: '7d'
                                    },
                                        {
                                            type: 'day',
                                            count: 15,
                                            text: '15d'
                                        },
                                        {
                                            type: 'all',
                                            text: 'All'
                                        }],
                                    inputEnabled: false // it supports only days
                                }
                            });
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            if (textStatus === "timeout") {
                                document.getElementById("loaderInsideTemp").style.display = "none";
                                document.getElementById("insideTemp").innerHTML = "<?= $l10n["chart"]["noData"] ?>"
                            }
                        }
                    });


                    $.ajax({
                        type: "POST",
                        url: "productionElectSpec",
                        data: "idGateway=" + dataUser,
                        timeout: 25000,
                        success: function (data) {
                            dataTime = [];
                            for (var j in data) {
                                d = new Date(data[j]["time"]);

                                if(d.getTimezoneOffset() != 120)
                                {
                                    d.setHours(d.getHours() + 1)
                                }

                                newData = data[j]["sum_count"]/1000

                                dataTime.unshift([new Date(d.toISOString()).getTime(), newData])
                            }
                            Highcharts.StockChart('productionElect', {
                                chart: {
                                    events: {
                                        load: function() { document.getElementById("loaderProductionElect").style.display = "none"; resizeFooter(); }
                                    }
                                },
                                title: {
                                    text: "<?= $l10n["chart"]["productionElect"] ?>"
                                },
                                xAxis: {
                                    ordinal:false
                                },
                                yAxis: {
                                    opposite: false,
                                    title: {
                                        text: "kW"
                                    }
                                },
                                series: [{
                                    data: dataTime,
                                    tooltip: {
                                        valueDecimals: 2
                                    }
                                }],
                                navigator: {
                                    margin: 60,
                                    adaptToUpdatedData: false,
                                },
                                scrollbar: {
                                    liveRedraw: false
                                },
                                rangeSelector: {
                                    floating: true,
                                    selected: 1,
                                    buttons: [{
                                        type: 'day',
                                        count: 1,
                                        text: '1d'
                                    }, {
                                        type: 'day',
                                        count: 7,
                                        text: '7d'
                                    },
                                        {
                                            type: 'day',
                                            count: 15,
                                            text: '15d'
                                        },
                                        {
                                            type: 'all',
                                            text: 'All'
                                        }],
                                    inputEnabled: false // it supports only days
                                }
                            });
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            if (textStatus === "timeout") {
                                document.getElementById("loaderProductionElect").style.display = "none";
                                document.getElementById("productionElect").innerHTML = "<?= $l10n["chart"]["noData"] ?>"
                            }
                        }
                    });


                }
            });
            document.getElementById("loaderConsumptionElect").style.display = "block";
            document.getElementById("loaderHotwater").style.display = "block";
            document.getElementById("loaderHeatPump").style.display = "block";
            document.getElementById("loaderInsideTemp").style.display = "block";
            document.getElementById("loaderProductionElect").style.display = "block";
            document.getElementById("consumptionElect").innerHTML = "Loading";
            document.getElementById("hotwaterTemperature").innerHTML = "Loading";
            document.getElementById("consumptionHeatPump").innerHTML = "Loading";
            document.getElementById("insideTemp").innerHTML = "Loading";
            document.getElementById("productionElect").innerHTML = "Loading";

        }).change();



    }
</script>

