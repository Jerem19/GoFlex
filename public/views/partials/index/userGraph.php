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


    function loadProductionElect(interval,range,url)
    {
        selectGw = $('select[name="gwId"]');
        var dataUser = 0;
            $.ajax({
                url: 'installUser',
                type: 'POST',
                data: { id : selectGw.val() },
                success : function (data) {
                    dataUser = data;

                    $.ajax({
                        type: "POST",
                        url: url,
                        data:{
                            'range': range,
                            'time': interval,
                            "idGateway": dataUser
                        },
                        timeout: 25000,
                        success: function (data) {
                            dataTime = [];
                            for (var j in data) {
                                d = new Date(data[j]["time"]);

                                if(d.getTimezoneOffset() != 120)
                                {
                                    d.setHours(d.getHours() + 1)
                                }

                                newData = data[j]["distinct"]/1000

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
                                    enabled:true,
                                    floating: true,
                                    selected: 3,
                                    buttons: [{
                                        text: '3h',
                                        events: {
                                            click: function () {
                                                loadProductionElect('1s','3h','productionElectSpec');
                                            }
                                        }
                                    }, {
                                        text: '1d',
                                        events: {
                                            click: function () {
                                                loadProductionElect('1m','1d','productionElectSpec');
                                            }
                                        }
                                    }, {
                                        text: '7d',
                                        events: {
                                            click: function () {
                                                loadProductionElect('15m','7d','productionElectSpec');
                                            }
                                        }
                                    }, {
                                        text: 'All',
                                        events: {
                                            click: function () {
                                                loadProductionElect('1d','1y','productionElectSpecAll');
                                            }
                                        }
                                    }],
                                    buttonTheme:{
                                        height:18,
                                        padding:2,
                                        width:20 + '%',
                                        zIndex:7
                                    },
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


    }

    function loadConsumptionElect(interval,range,url)
    {
        selectGw = $('select[name="gwId"]');
        var dataUser = 0;
            $.ajax({
                url: 'installUser',
                type: 'POST',
                data: { id : selectGw.val() },
                success : function (data) {
                    dataUser = data;

                    $.ajax({
                        type: "POST",
                        url: url,
                        data:{
                            'range': range,
                            'time': interval,
                            "idGateway": dataUser
                        },
                        //timeout: 25000,
                        success: function (data) {
                            dataTime = [];
                            for (var j in data) {
                                d = new Date(data[j]["time"]);

                                if(d.getTimezoneOffset() != 120)
                                {
                                    d.setHours(d.getHours() + 1)
                                }

                                newData = data[j]["distinct"]/1000

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
                                    enabled:true,
                                    floating: true,
                                    selected: 3,
                                    buttons: [{
                                        text: '3h',
                                        events: {
                                            click: function () {
                                                loadConsumptionElect('1s','3h','consumptionElectSpec');
                                            }
                                        }
                                    }, {
                                        text: '1d',
                                        events: {
                                            click: function () {
                                                loadConsumptionElect('1m','1d','consumptionElectSpec');
                                            }
                                        }
                                    }, {
                                        text: '7d',
                                        events: {
                                            click: function () {
                                                loadConsumptionElect('15m','7d','consumptionElectSpec');
                                            }
                                        }
                                    }, {
                                        text: 'All',
                                        events: {
                                            click: function () {
                                                loadConsumptionElect('1d','1y','consumptionElectSpecAll');
                                            }
                                        }
                                    }],
                                    buttonTheme:{
                                        height:18,
                                        padding:2,
                                        width:20 + '%',
                                        zIndex:7
                                    },
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


                }
            });


    }

    function loadBoiler(interval,range,url)
    {

        selectGw = $('select[name="gwId"]');
        var dataUser = 0;
            $.ajax({
                url: 'installUser',
                type: 'POST',
                data: { id : selectGw.val() },
                timeout: 25000,
                success : function (data) {
                    dataUser = data;


                    $.ajax({
                        type: "POST",
                        url: url,
                        data:{
                            'range': range,
                            'time': interval,
                            "idGateway": dataUser
                        },
                        timeout: 25000,
                        success: function (data) {
                            dataTime = [];
                            for (var j in data) {
                                d = new Date(data[j]["time"]);

                                if(d.getTimezoneOffset() != 120)
                                {
                                    d.setHours(d.getHours() + 1)
                                }
                                dataTime.unshift([new Date(d.toISOString()).getTime(), data[j]["distinct"]])
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
                                    enabled:true,
                                    floating: true,
                                    selected: 3,
                                    buttons: [{
                                        text: '3h',
                                        events: {
                                            click: function () {
                                                loadBoiler('1s','3h','hotwaterTemperatureSpec');
                                            }
                                        }
                                    }, {
                                        text: '1d',
                                        events: {
                                            click: function () {
                                                loadBoiler('1m','1d','hotwaterTemperatureSpec');
                                            }
                                        }
                                    }, {
                                        text: '7d',
                                        events: {
                                            click: function () {
                                                loadBoiler('15m','7d','hotwaterTemperatureSpec');
                                            }
                                        }
                                    }, {
                                        text: 'All',
                                        events: {
                                            click: function () {
                                                loadBoiler('1d','1y','hotwaterTemperatureSpecAll');
                                            }
                                        }
                                    }],
                                    buttonTheme:{
                                        height:18,
                                        padding:2,
                                        width:20 + '%',
                                        zIndex:7
                                    },
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



                }
            });


    }

    function loadHeatPump(interval,range,url)
    {

        selectGw = $('select[name="gwId"]');
        var dataUser = 0;
            $.ajax({
                url: 'installUser',
                type: 'POST',
                data: { id : selectGw.val() },
                success : function (data) {
                    dataUser = data;


                    $.ajax({
                        type: "POST",
                        url: url,
                        data:{
                            'range': range,
                            'time': interval,
                            "idGateway": dataUser
                        },
                        //timeout: 25000,
                        success: function (data) {
                            dataTime = [];
                            for (var j in data) {

                                d = new Date(data[j]["time"]);

                                if(d.getTimezoneOffset() != 120)
                                {
                                    d.setHours(d.getHours() + 1)
                                }

                                newdata = data[j]["distinct"]/1000;

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
                                    enabled:true,
                                    floating: true,
                                    selected: 3,
                                    buttons: [{
                                        text: '3h',
                                        events: {
                                            click: function () {
                                                loadHeatPump('1s','3h','consumptionHeatPumpSpec');
                                            }
                                        }
                                    }, {
                                        text: '1d',
                                        events: {
                                            click: function () {
                                                loadHeatPump('1m','1d','consumptionHeatPumpSpec');
                                            }
                                        }
                                    }, {
                                        text: '7d',
                                        events: {
                                            click: function () {
                                                loadHeatPump('15m','7d','consumptionHeatPumpSpec');
                                            }
                                        }
                                    }, {
                                        text: 'All',
                                        events: {
                                            click: function () {
                                                loadHeatPump('1d','1y','consumptionHeatPumpSpecAll');
                                            }
                                        }
                                    }],
                                    buttonTheme:{
                                        height:18,
                                        padding:2,
                                        width:20 + '%',
                                        zIndex:7
                                    },
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

                }
            });

    }

    function loadInsideTemp(interval,range,url)
    {

        selectGw = $('select[name="gwId"]');
        var dataUser = 0;
            $.ajax({
                url: 'installUser',
                type: 'POST',
                data: { id : selectGw.val() },
                success : function (data) {
                    dataUser = data;


                    $.ajax({
                        type: "POST",
                        url: url,
                        data:{
                            'range': range,
                            'time': interval,
                            "idGateway": dataUser
                        },
                        //timeout: 25000,
                        success: function (data) {
                            dataTime = [];
                            for (var j in data) {
                                d = new Date(data[j]["time"]);

                                if(d.getTimezoneOffset() != 120)
                                {
                                    d.setHours(d.getHours() + 1)
                                }

                                if(data[j]["distinct"] >= 0 && data[j]["distinct"] < 50) {
                                    dataTime.unshift([new Date(d.toISOString()).getTime(), data[j]["distinct"]])
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
                                    enabled:true,
                                    floating: true,
                                    selected: 3,
                                    buttons: [{
                                        text: '3h',
                                        events: {
                                            click: function () {
                                                loadInsideTemp('1s','3h','insideTempSpec');
                                            }
                                        }
                                    }, {
                                        text: '1d',
                                        events: {
                                            click: function () {
                                                loadInsideTemp('1m','1d','insideTempSpec');
                                            }
                                        }
                                    }, {
                                        text: '7d',
                                        events: {
                                            click: function () {
                                                loadInsideTemp('15m','7d','insideTempSpec');
                                            }
                                        }
                                    }, {
                                        text: 'All',
                                        events: {
                                            click: function () {
                                                loadInsideTemp('1d','1y','insideTempSpecAll');
                                            }
                                        }
                                    }],
                                    buttonTheme:{
                                        height:18,
                                        padding:2,
                                        width:20 + '%',
                                        zIndex:7
                                    },
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
                }
            });
    }
    window.onload = function() {
        selectGw = $('select[name="gwId"]');
        loadConsumptionElect('15m','7d','consumptionElectSpec');
        loadBoiler('15m','7d','hotwaterTemperatureSpec');
        loadHeatPump('15m','7d','consumptionHeatPumpSpec');
        loadProductionElect('15m','7d','productionElectSpec');

        selectGw.on('change', function () {
            loadConsumptionElect('15m','7d','consumptionElectSpec');
            loadBoiler('15m','7d','hotwaterTemperatureSpec');
            loadHeatPump('15m','7d','consumptionHeatPumpSpec');
            loadInsideTemp('15m','7d','insideTempSpec');
            loadProductionElect('15m','7d','productionElectSpec');
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
    }
</script>

