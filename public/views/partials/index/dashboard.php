<div class="row">
    <div class="mt col-lg-12 col-xl-3 col-md-12 form-panel">

        <p class="dashboardTitleSize" style="text-align: center">Consommation en temps réel</p>
        <hr>
        <div style="text-align: center;" class="form-panel divSize">
            <div class="dashboardTextSize">
                <p><?= L10N['index']['dashboard']['electricalConsumption']?></p>
            </div>

            <a href="consumptionElect">
                <span class="fa fa-bolt dashboardFaSize"></span>

                <!--<p class="dashboardTextSize"><?//= L10N['index']['dashboard']['textConsumptionElec']?></p> -->
                <div id="consumptionElectSpeed"  class="dashboardNumberSize">

                </div></a>
        </div>

        <div style="text-align: center;" class="form-panel divSize">
            <div class="dashboardTextSize">
                <p><?= $l10n["dashboard"]["heatPumpConsumption"] ?></p>
            </div>
            <a href="consumptionHeatPump">
                <span class="fa fa-fire dashboardFaSize"></span>

                <!--<p class="dashboardTextSize"><?//= L10N['index']['dashboard']['textHeatPump']?></p>-->

                <div class="dashboardNumberSize" id="consumptionHeatPumpSpeed">

                </div></a>
        </div>
    </div>
    <div class="mt col-lg-12 col-xl-8 col-md-12 form-panel">
        <p class="dashboardTitleSize" style="text-align: center"> <?= L10N['index']['dashboard']['historicData']?></p>
        <hr>
        <div id="historicData"></div>
        <img id="loader" src="<?= BASE_URL ?>/public/images/loader.gif" style="display: block; margin-left: auto; margin-right: auto; width: 200px;"/>
    </div>
</div>

<div class="row">
    <div class="mt col-lg-12 col-xl-3 col-md-12 form-panel">

        <p class="dashboardTitleSize" style="text-align: center"><?= L10N['index']['dashboard']['currentTemperature']?></p>
        <hr>

        <div style="text-align: center;" class="form-panel divSize">
            <div class="dashboardTextSize">
                <p><?= $l10n["chart"]["hotwaterTemperature"] ?></p>
            </div>
            <a href="boiler">
                <span class="fa fa-bath dashboardFaSize"></span>

                <!--<p class="dashboardTextSize"><?//= L10N['index']['dashboard']['textHotwaterTemperature']?></p>-->
                <div class="dashboardNumberSize" id="hotwaterTemperatureSpeed">
                </div>
            </a>
        </div>

        <div style="text-align: center;" class="form-panel divSize">
            <div class="dashboardTextSize">
                <p><?= $l10n["chart"]["insideTemperature"] ?></p>
            </div>

            <a href="insideTemp">
                <span class="fa fa-thermometer dashboardFaSize"></span>

                <!--<p class="dashboardTextSize"><?//= L10N['index']['dashboard']['textInsideTemperature']?></p>-->
                <div class="dashboardNumberSize" id="insideTempSpeed">
                </div>
            </a>
        </div>
    </div>
    <div class="mt col-lg-12 col-xl-5 col-md-12 form-panel">
        <p class="dashboardTitleSize" style="text-align: center"> <?= L10N['index']['dashboard']['meterIndex']?></p>
        <hr>

        <div style="text-align: center;">
            <img style="width: 220px;" src="<?= BASE_URL ?>/public/images/montage.png" />
        </div>

        <div class="indexAlert alert-secondary">
            <strong><span class="fa fa-lightbulb-o"></span> <?= L10N['index']['dashboard']['consumptionTitle']?></strong>
        </div>

        <div class="col col-md-7"><span class="fa fa-user"></span> <?= L10N['index']['dashboard']['yourCoonsumption']?> </div>
        <div id="counterConsumptionOne"  class="dashboardNumberSize" style="text-align: right; font-size: large;">Tarif 1 =</div>
        <div id="counterConsumptionTwo"  class="dashboardNumberSize" style="text-align: right; font-size: large;">Tarif 2 =</div>
        <div style="text-align: center;">

        </div>
        <div class="indexAlert alert-secondary">
            <strong><span class="fa fa-line-chart"></span> Production</strong>
        </div>
        <div class="col col-md-5"><span class="fa fa-battery-full"></span><?= L10N['index']['dashboard']['overagePV']?></div>
        <?php
        if($user->getInstallations()[0]->Solar()->isExistant())
        {
            ?>
            <div id="counterProductionOne"  class="dashboardNumberSize" style="text-align: right;"></div>
            <div id="counterProductionTwo"  class="dashboardNumberSize" style="text-align: right;"></div>
        <?php }
        else{
            ?>
            <div class="dashboardNumberSize" style="text-align: right; font-size: large;">
                <p><?= L10N['index']['dashboard']['noSolarPanel']?></p>
            </div>
        <?php } ?>

    </div>
    <div class="mt col-lg-12 col-xl-3 col-md-12 form-panel">
        <p class="dashboardTitleSize" style="text-align: center"><?= L10N['index']['dashboard']['greenAction']?></p>
        <hr>
        <h2 style="color: limegreen;"> <?= L10N['index']['dashboard']['cleverAction']?></h2>
        <strong>
            <div class="col col-md-12 centered">
                <?= L10N['index']['dashboard']['greenActionText']?>
            </div>
        </strong>
        <img style="width: 202px;" src="<?= BASE_URL ?>/public/images/eco-reflexes.png"/>
        <a href="https://www.esr.ch/fr/ecogestes/index" class="btn btn-success"><?= L10N['index']['dashboard']['moreGreenAction']?></a>
    </div>
</div>
<div class="row">
    <?php
    if($user->getInstallations()[0]->Solar()->isExistant())
    {
        ?>
        <div style="width: 94%;" class="mt col-lg-12 col-xl-11 col-md-12 form-panel">
            <div style="text-align: center;">
                <div class="dashboardTitleSize">
                    <p><?= $l10n["chart"]["productionElect"] ?></p>
                </div>

                <a href="productionElect">
                    <span class="fa fa-certificate dashboardFaSize"></span>

                    <div class="dashboardNumberSize" id="productionElectSpeed">
                    </div>
                </a>
            </div>
        </div>
    <?php } ?>
</div>

<script>

    var graph_buttons = [{
        text: '6 dernieres heures',
        events: {
            click: function () {
                loadGraphLine()
            }
        }
    }, {
        text: 'Daily',
        events: {
            click: function () {
                loadGraphHist("1d")
            }
        }
    }, {
        text: 'Monthly',
        events: {
            click: function () {
                loadGraphHist("30d")
            }
        }
    }, {
        text: 'Yearly',
        events: {
            click: function () {
                loadGraphHist("365d")
            }
        }
    }];

    function loadGraphHist(range)
    {
        var insideArray =[];
        var boilerArray = [];
        var electArray = [];
        var productionElecArray = [];
        var boiler;
        var insideTemp;
        var electConsumption;
        var productionElect;
        var heatPumpConsumption;

        $.when($.ajax({
                type: "POST",
                url: "hotwaterTemperatureHistoryHist",
                data: {
                    range: range
                }
            }),
            $.ajax({
                type: "POST",
                url: "consumptionElectHistoryHist",
                data : {
                    range : range
                }
            }),
            $.ajax({
                type: "POST",
                url: "insideTempHistoryHist",
                data : {
                    range: range
                }
            })
            <?php if($user->getInstallations()[0]->Solar()->isExistant()) { ?>
            ,$.ajax({
                type: "POST",
                url: "productionElectHistoryHist",
                data : {
                    range : range
                }
            })
            <?php } ?>
        ).then(function (hotwater, consumption, inside, production) {

            var boiler = !!hotwater[0] && !!hotwater[0][0] && !!hotwater[0][0]["mean"] ? Math.round(hotwater[0][0]["mean"]*10)/10 : 0;
            var electConsumption = !!consumption[0] && !!consumption[0][0] && !!consumption[0][0]["sum"] ? consumption[0][0]["sum"] : 0;
            var insideTemp = !!inside[0] && !!inside[0][0] && !!inside[0][0]["mean"] ? Math.round(inside[0][0]["mean"]*10)/10 : 0;

            electConsumption = electConsumption/1000;

            Highcharts.chart('historicData', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: ''//'Test bar chart'
                },
                xAxis: {
                    categories: [
                        'Value'
                    ],
                    crosshair: true
                },
                yAxis: [{
                    title: {
                        text: "Température (°C)"
                    },
                    opposite: false
                }, {
                    title:{
                        text: "Puissance (kW)"
                    },
                    opposite: true
                }],
                tooltip: {
                    //headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                    //pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                    //'<td style="padding:0"><b>{point.y:.1f}</b></td></tr>',
                    //footerFormat: '</table>',
                    //shared: true,
                    //useHTML: true
                },
                plotOptions: {
                    column: {
                        pointPadding: 0.2,
                        borderWidth: 0
                    }
                },
                rangeSelector: {
                    buttons: graph_buttons,
                    buttonTheme:{
                        height:18,
                        padding:2,
                        width:20 + '%',
                        zIndex:7
                    },
                    inputEnabled: false,
                    enabled: true
                },
                scrollbar: {
                    enabled: false
                },
                navigator: {
                    enabled: false
                },
                series: [
                    <?php if($user->getInstallations()[0]->Solar()->isExistant()) { ?>
                    {
                        name: 'Production',
                        data: [!!production[0] && !!production[0][0] && !!production[0][0]["sum"] ? production[0][0]["sum"] : 0],
                        yAxis:1,
                        color:"#f4e842"

                    },<?php } ?>
                    {
                        name: 'Consommation',
                        data: [electConsumption],
                        yAxis:1,
                        color:"#95ceff"

                    }, {
                        name: 'Temperature intérieure',
                        data: [insideTemp],
                        yAxis:0,
                        color:"#434348"

                    }, {
                        name: 'Temperature boiler',
                        data: [boiler],
                        yAxis:0,
                        color:"#90ed7d"

                    }]
            });
        }, function () {
            ajaxError('TEST');
        });
    }

    function loadGraphLine()
    {
        $.when(
            $.ajax({
                type: "POST",
                url: "hotwaterTemperatureHistory",
            }),
            $.ajax({
                type: "POST",
                url: "consumptionElectHistory",
            }),
            $.ajax({
                type: "POST",
                url: "insideTempHistory",
            })
            <?php if($user->getInstallations()[0]->Solar()->isExistant()) { ?>
            ,$.ajax({
                type: "POST",
                url: "productionElectHistory",
            })
            <?php } ?>
        ).then(function(hotwater, consumption, inside, production) {
            var insideArray =[];
            var boilerArray = [];
            var electArray = [];
            var productionElecArray = [];
            var index = 0;
            var d;

            hotwater = hotwater[0];
            consumption = consumption[0];
            inside = inside[0];
            production = production ? production[0] :  undefined;
            for(index = 0;index< inside.length;index++)
            {
                d = new Date(inside[index]["time"]);
                if(d.getTimezoneOffset() != 120)
                {
                    d.setHours(d.getHours() + 1)
                }
                insideArray.unshift([new Date(d.toISOString()).getTime(), inside[index]["distinct"]])
            }
            for(index = 0;index< hotwater.length;index++)
            {
                d = new Date(hotwater[index]["time"]);

                if(d.getTimezoneOffset() != 120)
                {
                    d.setHours(d.getHours() + 1)
                }
                boilerArray.unshift([new Date(d.toISOString()).getTime(), hotwater[index]["distinct"]])
            }
            for(index = 0;index< consumption.length;index++)
            {
                d = new Date(consumption[index]["time"]);

                if(d.getTimezoneOffset() != 120)
                {
                    d.setHours(d.getHours() + 1)
                }
                electArray.unshift([new Date(d.toISOString()).getTime(), consumption[index]["distinct"]/1000])
            }

            <?php if($user->getInstallations()[0]->Solar()->isExistant()) { ?>
            for (index = 0; index < production.length; index++)
            {
                d = new Date(production[index]["time"]);

                if (d.getTimezoneOffset() != 120) {
                    d.setHours(d.getHours() + 1)
                }
                if (production[index]["distinct"] >= 0) {
                    productionElecArray.unshift([new Date(d.toISOString()).getTime(), production[index]["distinct"] / 1000])
                }
            }
            <?php } ?>

            Highcharts.StockChart('historicData', {
                chart: {
                    events: {
                        load: function() { document.getElementById("loader").style.display = "none"; resizeFooter(); }
                    },
                    height:350+ 'px'
                },
                title: {
                    text: ''
                },
                credits: {
                    enabled: false
                },
                xAxis: {
                    type:'datetime',
                    title:{
                        text: 'Date'
                    }
                },
                yAxis: [{
                    title: {
                        text: "Température (°C)"
                    },
                    opposite:false
                },
                    {
                        title:{
                            text: "Puissance (kW)"
                        },
                        opposite:true
                    }
                ],
                legend: {
                    enabled: true
                },
                plotOptions: {
                    area: {
                        lineWidth: 0,
                        marker: {
                            enabled: true,
                            symbol: 'circle',
                            radius: 2,
                            states: {
                                hover: {
                                    enabled: true
                                }
                            }
                        }
                    },
                    series: {
                        animation: false,
                        events: {
                            legendItemClick: function () {
                                var visibility = this.visible ? 'visible' : 'hidden';
                            }

                        }
                    }
                },
                rangeSelector: {
                    buttons: graph_buttons,
                    buttonTheme:{
                        height:18,
                        padding:2,
                        width:20 + '%',
                        zIndex:7
                    },
                    inputEnabled: false
                },
                tooltip: {
                    shared: false,
                    valueDecimals: 2
                },
                scrollbar: {
                    enabled: false
                },
                navigator: {
                    enabled: false
                },
                series:[
                    {
                        name: 'Electrique',
                        type: 'area',
                        data: electArray,
                        index:1,
                        yAxis:1,
                        color:"#95ceff"

                    },
                    <?php if($user->getInstallations()[0]->Solar()->isExistant()) { ?>
                    {
                        name: 'Production',
                        type: 'area',
                        data: productionElecArray,
                        index:2,
                        yAxis:1,
                        color:"#f4e842"

                    }, <?php } ?>
                    {
                        name: 'Intérieur',
                        type: 'line',
                        data: insideArray,
                        index:3,
                        yAxis:0,
                        color:"#434348"
                    },
                    {
                        name: 'Boiler',
                        type: 'line',
                        data: boilerArray,
                        index:4,
                        yAxis:0,
                        color:"#90ed7d"
                    }
                ]
            });
        });
    }

    window.onload = function() {

        const kw = 'kW';
        const celsius = '°C';
        const kwH ='kWh';

        var consumptionElectSpeed;
        var timeConsumptionElectSpeed;
        var consumptionHeatPumpSpeed;
        var timeConsumptionHeatPumpSpeed;
        var hotwaterTemperatureSpeed;
        var timeHotwaterTemperatureSpeed;
        var insideTempSpeed;
        var timeInsideTempSpeed;
        var productionElect;
        var counterConsumption1;
        var counterConsumption2;
        var timeCounterConsumption1;
        var timeCounterConsumption2;
        var counterProduction1;
        var counterProduction2;
        var timeCounterProduction1;
        var timeCounterProduction2;



        function ajaxError (elementId) {
            document.getElementById(elementId).innerHTML = "<?= $l10n["chart"]["noData"] ?>";
        }

        loadGraphLine();

        $.ajax({
            url: 'consumptionElectSpeed',
            type: 'POST',
            success: function(data){
                if (data && Array.isArray(data))
                {
                    d = new Date(data[0]["time"]);
                    if(d.getTimezoneOffset() != 120)
                    {
                        d.setHours(d.getHours() + 1)
                    }
                    timeConsumptionElectSpeed = d.toISOString().substr(0, 16);
                    timeConsumptionElectSpeed = timeConsumptionElectSpeed.replace("T", " ");

                    consumptionElectSpeed = data[0]['last']/1000;

                    document.getElementById('consumptionElectSpeed').innerHTML = consumptionElectSpeed + kw + "<br/><p style=\"font-size: 15px;\">" + timeConsumptionElectSpeed + "</p>";
                }
                else ajaxError('consumptionElectSpeed');
            },
            error: function () {
                ajaxError('consumptionElectSpeed');
            }
        });

        $.ajax({
            url: 'productionElectSpeed',
            type: 'POST',
            success: function(data){
                <?php
                if($user->getInstallations()[0]->Solar()->isExistant()) { ?>
                if (data && Array.isArray(data))
                {
                    d = new Date(data[0]["time"]);
                    if(d.getTimezoneOffset() != 120)
                    {
                        d.setHours(d.getHours() + 1)
                    }
                    timeProductionElectSpeed = d.toISOString().substr(0, 16);
                    timeProductionElectSpeed = timeProductionElectSpeed.replace("T", " ");

                    productionElectSpeed = data[0]['last']/1000;

                    document.getElementById('productionElectSpeed').innerHTML = productionElectSpeed + kw + "<br/><p style=\"font-size: 15px;\">" + timeConsumptionElectSpeed + "</p>";
                }
                else ajaxError('productionElectSpeed');
                <?php } ?>
            },
            error: function () {
                ajaxError('productionElectSpeed');
            }
        });

        $.ajax({
            url: 'consumptionHeatPumpSpeed',
            type: 'POST',
            success: function(data){
                if (data && Array.isArray(data))
                {
                    d = new Date(data[0]["time"]);
                    if(d.getTimezoneOffset() != 120)
                    {
                        d.setHours(d.getHours() + 1)
                    }

                    timeConsumptionHeatPumpSpeed = d.toISOString().substr(0, 16);
                    timeConsumptionHeatPumpSpeed = timeConsumptionHeatPumpSpeed.replace("T", " ");

                    consumptionHeatPumpSpeed = Math.round(data[0]['last'])/1000;

                    document.getElementById('consumptionHeatPumpSpeed').innerHTML = consumptionHeatPumpSpeed + kw + "<br/><p style=\"font-size: 15px;\">" + timeConsumptionHeatPumpSpeed + "</p>";
                }
                else ajaxError('consumptionHeatPumpSpeed');
            },
            error: function () {
                ajaxError('consumptionHeatPumpSpeed');
            }
        });

        $.ajax({
            url: 'hotwaterTemperatureSpeed',
            type: 'POST',
            success: function(data){
                if (data && Array.isArray(data))
                {
                    d = new Date(data[0]["time"]);
                    if(d.getTimezoneOffset() != 120)
                    {
                        d.setHours(d.getHours() + 1)
                    }

                    timeHotwaterTemperatureSpeed = d.toISOString().substr(0, 16);
                    timeHotwaterTemperatureSpeed = timeHotwaterTemperatureSpeed.replace("T", " ");

                    hotwaterTemperatureSpeed = Math.round(data[0]['last']*10)/10;

                    document.getElementById('hotwaterTemperatureSpeed').innerHTML = hotwaterTemperatureSpeed + celsius + "<br/><p style=\"font-size: 15px;\">" + timeHotwaterTemperatureSpeed + "</p>";
                }
                else ajaxError('hotwaterTemperatureSpeed');
            },
            error: function () {
                ajaxError('hotwaterTemperatureSpeed');
            }
        });

        $.ajax({
            url: 'insideTempSpeed',
            type: 'POST',
            success: function(data){
                if (data && Array.isArray(data))
                {
                    d = new Date(data[0]["time"]);
                    if(d.getTimezoneOffset() != 120)
                    {
                        d.setHours(d.getHours() + 1)
                    }

                    timeInsideTempSpeed = d.toISOString().substr(0, 16);
                    timeInsideTempSpeed = timeInsideTempSpeed.replace("T", " ");

                    insideTempSpeed = Math.round(data[0]['last']*10)/10;

                    document.getElementById('insideTempSpeed').innerHTML = insideTempSpeed + celsius + "<br/><p style=\"font-size: 15px;\">" + timeInsideTempSpeed + "</p>";
                }
                else ajaxError('insideTempSpeed');
            },
            error: function () {
                ajaxError('insideTempSpeed');
            }
        });

        $.ajax({
            url: 'counterConsumption1',
            type: 'POST',
            success: function(data){
                if (data && Array.isArray(data))
                {
                    d = new Date(data[0]["time"]);
                    if(d.getTimezoneOffset() != 120)
                    {
                        d.setHours(d.getHours() + 1)
                    }

                    timeCounterConsumption1 = d.toISOString().substr(0, 16);
                    timeCounterConsumption1 = timeCounterConsumption1.replace("T", " ");

                    counterConsumption1 = data[0]['last']/1000;

                    document.getElementById('counterConsumptionOne').innerHTML =  "Tarif 1 = " + counterConsumption1 + kwH + "<br/><p style=\"font-size: 15px;\">" + timeCounterConsumption1 + "</p>";
                }
                else ajaxError('counterConsumption');
            },
            error: function () {
                ajaxError('counterConsumption');
            }
        });

        $.ajax({
            url: 'counterConsumption2',
            type: 'POST',
            success: function(data){
                if (data && Array.isArray(data))
                {
                    d = new Date(data[0]["time"]);
                    if(d.getTimezoneOffset() != 120)
                    {
                        d.setHours(d.getHours() + 1)
                    }

                    timeCounterConsumption2 = d.toISOString().substr(0, 16);
                    timeCounterConsumption2 = timeCounterConsumption2.replace("T", " ");

                    counterConsumption2 = data[0]['last']/1000;

                    document.getElementById('counterConsumptionTwo').innerHTML =  "Tarif 2 = " + counterConsumption2 + kwH + "<br/><p style=\"font-size: 15px;\">" + timeCounterConsumption2 + "</p>";
                }
                else ajaxError('counterConsumption');
            },
            error: function () {
                ajaxError('counterConsumption');
            }
        });

        $.ajax({
            url: 'counterProduction1',
            type: 'POST',
            success: function(data){
                if (data && Array.isArray(data))
                {
                    <?php
                    if($user->getInstallations()[0]->Solar()->isExistant())
                    {
                    ?>
                    d = new Date(data[0]["time"]);
                    if(d.getTimezoneOffset() != 120)
                    {
                        d.setHours(d.getHours() + 1)
                    }

                    timeCounterProduction1 = d.toISOString().substr(0, 16);
                    timeCounterProduction1 = timeCounterProduction1.replace("T", " ");

                    counterProduction1 = data[0]['last']/1000;

                    document.getElementById('counterProductionOne').innerHTML = counterProduction1 + kwH +
                        "<br/><p style=\"font-size: 15px;\">" + timeCounterProduction1 + "</p>";

                    <?php
                    }
                    ?>
                }
                else ajaxError('counterProduction');
            },
            error: function () {
                ajaxError('counterProduction');
            }
        });

        $.ajax({
            url: 'counterProduction2',
            type: 'POST',
            success: function(data){
                if (data && Array.isArray(data))
                {
                    <?php
                    if($user->getInstallations()[0]->Solar()->isExistant())
                    {
                    ?>
                    d = new Date(data[0]["time"]);
                    if(d.getTimezoneOffset() != 120)
                    {
                        d.setHours(d.getHours() + 1)
                    }

                    timeCounterProduction2 = d.toISOString().substr(0, 16);
                    timeCounterProduction2 = timeCounterProduction2.replace("T", " ");

                    counterProduction2 = data[0]['last']/1000;

                    document.getElementById('counterProductionTwo').innerHTML = counterProduction2 + kwH +
                        "<br/><p style=\"font-size: 15px;\">" + timeCounterProduction2 + "</p>";

                    <?php
                    }
                    ?>
                }
                else ajaxError('counterProduction');
            },
            error: function () {
                ajaxError('counterProduction');
            }
        });
    }
</script>
