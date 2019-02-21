<div class="row is-flex">
    <div class="col-xs-12 col-xl-3 form-panel flex-fill ml">
        <p class="dashboardTitleSize" style="text-align: center"><?= L10N['index']['dashboard']['currentConsumption'] ?></p>
        <hr class="custom">
        <div style="text-align: center;" class="form-panel divSize">
            <div class="dashboardTextSize">
                <p><?= L10N['index']['dashboard']['electricalConsumption'] ?></p>
            </div>

            <a href="consumptionElect">
                <span class="fa fa-bolt dashboardFaSize"></span>

                <!--<p class="dashboardTextSize"><? //= L10N['index']['dashboard']['textConsumptionElec']?></p> -->
                <div id="consumptionElectSpeed" class="dashboardNumberSize"></div>
            </a>
        </div>

        <div style="text-align: center;" class="form-panel divSize">
            <div class="dashboardTextSize">
                <p><?= $l10n["dashboard"]["heatPumpConsumption"] ?></p>
            </div>
            <a href="consumptionHeatPump">
                <span class="fa fa-fire dashboardFaSize"></span>

                <!--<p class="dashboardTextSize"><? //= L10N['index']['dashboard']['textHeatPump']?></p>-->

                <div class="dashboardNumberSize" id="consumptionHeatPumpSpeed"></div>
            </a>
        </div>
    </div>
    <div class="col-xs-12 col-xl-8 form-panel flex-fill adjusted" style="min-height: 250px;">
        <p class="dashboardTitleSize" style="text-align: center"> <?= L10N['index']['dashboard']['historicData'] ?></p>
        <hr class="custom">
        <div id="inputs" class="mb-10" style="display:none;">
            <div class="one-input">
                <i id="i-oneinput" class="fa fa-calendar" aria-hidden="true"></i>
                <input type="text" id="datepicker" class="form-control"/>
            </div>
            <div class="btn-group" style="float:right;">
                <button id="btn15m" class="btn btn-theme02 active" onclick="byTime('15m');"><i id="i-15m" class="fa fa-check" aria-hidden="true"></i>15 <?= L10N["index"]["dashboard"]["minutes"]?></button>
                <button id="btn1d" class="btn btn-theme02" onclick="byTime('1d');"><i id="i-1d" class="fa fa-check" aria-hidden="true" style="display:none;"></i><?= L10N["index"]["dashboard"]["perDay"]?></button>
            </div>
        </div>
        <div id="historicData"></div>
        <img id="loader" src="<?= BASE_URL ?>/public/images/loader.gif" style="display: block; width: 200px; position: absolute; margin:0 auto; left:0; right:0; top: 40%;" />
    </div>
</div>

<div class="row is-flex">
    <div class="col-xs-12 col-xl-3 form-panel ml">
        <p class="dashboardTitleSize" style="text-align: center"><?= L10N['index']['dashboard']['currentTemperature'] ?></p>
        <hr class="custom">
        <div style="text-align: center;" class="form-panel divSize">
            <div class="dashboardTextSize">
                <p><?= $l10n["chart"]["hotwaterTemperature"] ?></p>
            </div>
            <a href="boiler">
                <span class="fa fa-bath dashboardFaSize"></span>

                <!--<p class="dashboardTextSize"><? //= L10N['index']['dashboard']['textHotwaterTemperature']?></p>-->
                <div class="dashboardNumberSize" id="hotwaterTemperatureSpeed"></div>
            </a>
        </div>

        <div style="text-align: center;" class="form-panel divSize">
            <div class="dashboardTextSize">
                <p><?= $l10n["chart"]["insideTemperature"] ?></p>
            </div>

            <a href="insideTemp">
                <span class="fa fa-thermometer dashboardFaSize"></span>

                <!--<p class="dashboardTextSize"><? //= L10N['index']['dashboard']['textInsideTemperature']?></p>-->
                <div class="dashboardNumberSize" id="insideTempSpeed"></div>
            </a>
        </div>
    </div>

    <?php
    $ml = '';
    $hasSolar = $user->getInstallations()[0]->Solar()->isExistant();
    if ($hasSolar) {
        $ml = 'ml';
        ?>
        <div class="col-xs-12 col-xl-3 form-panel">
            <div style="text-align: center;">
                <div class="dashboardTitleSize">
                    <p><?= $l10n["chart"]["productionElect"] ?></p>
                </div>
                <hr class="custom">
                <div class="pt10p">
                    <a href="productionElect">
                        <span class="fa fa-certificate dashboardFaSize big"></span>
                        <div class="dashboardNumberSize big" id="productionElectSpeed"></div>
                    </a>
                </div>
            </div>
        </div>
    <?php } ?>

    <div class="col-xl-5 col-xs-12 form-panel">
        <p class="dashboardTitleSize" style="text-align: center"> <?= L10N['index']['dashboard']['meterIndex'] ?></p>
        <hr class="custom">

        <div style="text-align: center;">
            <img style="width: 220px;" src="<?= BASE_URL ?>/public/images/montage.png" />
        </div>

        <div class="indexAlert alert-secondary">
            <strong><span class="fa fa-lightbulb-o"></span> <?= L10N['index']['dashboard']['consumptionTitle'] ?></strong>
        </div>

        <div class="col col-md-7"><span class="fa fa-user"></span> <?= L10N['index']['dashboard']['yourCoonsumption'] ?></div>
        <div id="counterConsumptionOne" class="dashboardNumberSize" style="text-align: right; font-size: large;">Tarif 1 =</div>
        <div id="counterConsumptionTwo" class="dashboardNumberSize" style="text-align: right; font-size: large;">Tarif 2 =</div>
        <div style="text-align: center;"></div>

        <div class="indexAlert alert-secondary">
            <strong><span class="fa fa-line-chart"></span> <?= L10N['index']['dashboard']['overagePV'] ?></strong>
        </div>
        <div class="col col-md-5"><span class="fa fa-battery-full"></span><?= L10N['index']['dashboard']['overagePV'] ?></div>
        <?php if ($user->getInstallations()[0]->Solar()->isExistant()) { ?>
            <div id="counterProductionOne" class="dashboardNumberSize" style="text-align: right; font-size: large;">Tarif 1 =</div>
            <div id="counterProductionTwo" class="dashboardNumberSize" style="text-align: right; font-size: large;">Tarif 2 =</div>
        <?php } else { ?>
            <div class="dashboardNumberSize" style="text-align: right; font-size: large;">
                <p><?= L10N['index']['dashboard']['noSolarPanel'] ?></p>
            </div>
        <?php } ?>

    </div>
    <div class="col-xs-12 col-xl-3 form-panel <?= $ml ?>" style="text-align: center">
        <p class="dashboardTitleSize" style="text-align: center"><?= L10N['index']['dashboard']['greenAction'] ?></p>
        <hr class="custom">
        <h2 style="color: limegreen;"> <?= L10N['index']['dashboard']['cleverAction'] ?></h2>
        <strong>
            <div class="col col-md-12 centered">
                <?= L10N['index']['dashboard']['greenActionText'] ?>
            </div>
        </strong>
        <img style="width: 202px; margin: 0 auto;" src="<?= BASE_URL ?>/public/images/eco-reflexes.png" />
        <a href="https://www.esr.ch/fr/ecogestes/index" class="btn btn-success"><?= L10N['index']['dashboard']['moreGreenAction'] ?></a>
    </div>
</div>

<script>
    var picker;

    //range selector options - TO USE : set enable to true - to delete soon if not needed anymore
    const rangeSelector = {
        inputEnabled: false,
        enabled: false
    };

    function loadGraphDate(start, end, interval) {
        document.getElementById("loader").style.display = "block";
        if(window.ajaxReq) ajaxReq.abort();
        window.ajaxReq = when($.ajax({
                type: "POST",
                url: DATA_URL+"hotwaterTemperatureHistoryDate",
                data: {
                    time: interval,
                    start: start,
                    end: end
                }
            }),
            $.ajax({
                type: "POST",
                url: DATA_URL+"consumptionElectHistoryDiff",
                data: {
                    time: interval,
                    start: start,
                    end: end
                }
            }),
            $.ajax({
                type: "POST",
                url: DATA_URL+"insideTempHistoryDate",
                data: {
                    time: interval,
                    start: start,
                    end: end
                }
            })
            <?php if($user->getInstallations()[0]->Solar()->isExistant()) { ?>
            , $.ajax({
                type: "POST",
                url: DATA_URL+"productionElectHistoryDiff",
                data: {
                    time: interval,
                    start: start,
                    end: end
                }
            }) <?php } ?>
        );
        ajaxReq.promise.then(function(hotwater, consumption, inside, production) {
            var insideArray = [];
            var boilerArray = [];
            var electArray = [];
            var productionElecArray = [];
            var index;
            var d;

            hotwater = hotwater[0];
            consumption = consumption[0];
            inside = inside[0];
            production = production ? production[0] : undefined;
            for(index = 0; index < inside.length; index++) {
                d = new Date(inside[index]["time"]);
                if(d.getTimezoneOffset() != 120) d.setHours(d.getHours() + 1);

                insideArray.push([d.getTime(), inside[index]["distinct"]]);
            }
            insideArray = insideArray.reverse();
            for(index = 0; index < hotwater.length; index++) {
                d = new Date(hotwater[index]["time"]);
                if(d.getTimezoneOffset() != 120) d.setHours(d.getHours() + 1);

                boilerArray.push([d.getTime(), hotwater[index]["distinct"]]);
            }
            boilerArray = boilerArray.reverse();
            for(index = 0; index < consumption.length; index++) {
                d = new Date(consumption[index]["time"]);
                if(d.getTimezoneOffset() != 120) d.setHours(d.getHours() + 1);

                electArray.push([d.getTime(), consumption[index]["distinct"]]);
            }
            electArray = electArray.reverse();
            <?php if($user->getInstallations()[0]->Solar()->isExistant()) { ?>
            for(index = 0; index < production.length; index++) {
                if(production[index]["distinct"] >= 0) {
                    d = new Date(production[index]["time"]);
                    if(d.getTimezoneOffset() != 120) d.setHours(d.getHours() + 1);

                    productionElecArray.push([d.getTime(), production[index]["distinct"]]);
                }
            }
            productionElecArray = productionElecArray.reverse();
            <?php } ?>

            window.historic = Highcharts.chart('historicData', {
                chart: {
                    type: 'column',
                    events: {
                        load: function () {
                            document.getElementById("loader").style.display = "none";
                        }
                    },
                },
                title: {
                    text: ''//'Test bar chart'
                },
                xAxis: {
                    type: 'datetime',
                    title: {
                        text: 'Date'
                    }
                },
                yAxis: [{
                    title: {
                        text: "<?= $l10n["dashboard"]["temperatureAvg"] ?> (°C)"
                    },
                    opposite: false
                }, {
                    title: {
                        text: "<?= $l10n["dashboard"]["energy"] ?> (kWh)"
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
                rangeSelector: rangeSelector,
                scrollbar: {
                    enabled: false
                },
                navigator: {
                    enabled: false
                },
                series: [
                    <?php if($user->getInstallations()[0]->Solar()->isExistant()) { ?>
                    {
                        name: '<?= $l10n["chart"]["productionElect"] ?>',
                        data: productionElecArray,
                        yAxis: 1,
                        color: "#f4e842"
                    },<?php } ?>
                    {
                        name: '<?= $l10n["chart"]["consumptionElect"] ?>',
                        data: electArray,
                        yAxis: 1,
                        color: "#A9A9A9"

                    }, {
                        name: '<?= $l10n["chart"]["insideTemperature"] ?>',
                        data: insideArray,
                        yAxis: 0,
                        color: "#90ed7d"

                    }, {
                        name: '<?= $l10n["chart"]["hotwaterTemperature"] ?>',
                        data: boilerArray,
                        yAxis: 0,
                        color: "#95ceff"
                    }]
            });
        });
    }

    function loadGraphLine(start, end, interval) {
        document.getElementById("loader").style.display = "block";
        if(window.ajaxReq) ajaxReq.abort();
        window.ajaxReq = when(
            $.ajax({
                type: "POST",
                url: DATA_URL+"hotwaterTemperatureDate",
                data: {
                    time: interval,
                    start: start,
                    end: end
                }
            }),
            $.ajax({
                type: "POST",
                url: DATA_URL+"consumptionElectDate",
                data: {
                    time: interval,
                    start: start,
                    end: end
                }
            }),
            $.ajax({
                type: "POST",
                url: DATA_URL+"insideTempDate",
                data: {
                    time: interval,
                    start: start,
                    end: end
                }
            })
            <?php if($user->getInstallations()[0]->Solar()->isExistant()) { ?>
            , $.ajax({
                type: "POST",
                url: DATA_URL+"productionElectDate",
                data: {
                    time: interval,
                    start: start,
                    end: end
                }
            }) <?php } ?>
        );
        ajaxReq.promise.then(function(hotwater, consumption, inside, production) {
            var boilerArray = parse(hotwater[0], 30, 120);
            var electArray = parse(consumption[0]);
            var insideArray = parse(inside[0], 0, 50);

            <?php if($user->getInstallations()[0]->Solar()->isExistant()) { ?>
            var productionElecArray = parse(production[0]);
            <?php } ?>

            window.historic = Highcharts.StockChart('historicData', {
                chart: {
                    renderTo: 'historicData',
                    events: {
                        load: function() {
                            document.getElementById("inputs").style.display = "block";
                            document.getElementById("loader").style.display = "none";
                            resizeFooter();
                        }
                    },
                    height: 350 + 'px'
                },
                title: {
                    text: ''
                },
                credits: {
                    enabled: false
                },
                xAxis: {
                    type: 'datetime',
                    title: {
                        text: 'Date'
                    }
                },
                yAxis: [{
                    title: {
                        text: "<?= $l10n["dashboard"]["temperature"] ?> (°C)"
                    },
                    opposite: false
                },
                    {
                        title: {
                            text: "<?= $l10n["dashboard"]["power"] ?> (kW)"
                        },
                        opposite: true
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
                        animation: false
                    }
                },
                rangeSelector: rangeSelector,
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
                series: [
                    {
                        name: '<?= $l10n["chart"]["consumptionElect"] ?>',
                        type: 'area',
                        data: electArray,
                        index: 1,
                        yAxis: 1,
                        color: "#A9A9A9",
                        enabled: false

                    },
                    <?php if($user->getInstallations()[0]->Solar()->isExistant()) { ?>
                    {
                        name: '<?= $l10n["chart"]["productionElect"] ?>',
                        type: 'area',
                        data: productionElecArray,
                        index: 2,
                        yAxis: 1,
                        color: "#f4e842"

                    }, <?php } ?>
                    {
                        name: '<?= $l10n["chart"]["insideTemperature"] ?>',
                        type: 'line',
                        data: insideArray,
                        index: 3,
                        yAxis: 0,
                        color: "#90ed7d",
                        enabled: false
                    },
                    {
                        name: '<?= $l10n["chart"]["hotwaterTemperature"] ?>',
                        type: 'line',
                        data: boilerArray,
                        //index:4,
                        yAxis: 0,
                        color: "#95ceff"
                    }
                ]
            });
        });
    }

    function ajaxError(elementId) {
        document.getElementById(elementId).innerHTML = "<?= $l10n["chart"]["noData"] ?>";
    }

    window.onload = function() {
        var kw = 'kW';
        var celsius = '°C';
        var kwH = 'kWh';

        var d = new Date();
        var e = Date.now();
        var s = new Date(d.getFullYear(), d.getMonth(), d.getDate() - 1).getTime();

        loadGraphLine(s + "ms", e + "ms", "15m");

        $.ajax({
            url: DATA_URL+'consumptionElectSpeed',
            type: 'POST',
            success: function(data) {
                if(data && Array.isArray(data)) {
                    d = new Date(data[0]["time"]);
                    if(d.getTimezoneOffset() != 120) d.setHours(d.getHours() + 1);

                    var timeConsumptionElectSpeed = d.toISOString().substr(0, 16).replace("T", " "),
                        consumptionElectSpeed = data[0]['last'] / 1000;

                    document.getElementById('consumptionElectSpeed').innerHTML = consumptionElectSpeed + kw + "<br/><p style=\"font-size: 15px;\">" + timeConsumptionElectSpeed + "</p>";
                } else ajaxError('consumptionElectSpeed');
            },
            error: function() {
                ajaxError('consumptionElectSpeed');
            }
        });

        <?php if($user->getInstallations()[0]->Solar()->isExistant()) { ?>
        $.ajax({
            url: DATA_URL+'productionElectSpeed',
            type: 'POST',
            success: function(data) {
                if(data && Array.isArray(data)) {
                    d = new Date(data[0]["time"]);
                    if(d.getTimezoneOffset() != 120) d.setHours(d.getHours() + 1);

                    var timeProductionElectSpeed = d.toISOString().substr(0, 16).replace("T", " "),
                        productionElectSpeed = data[0]['last'] / 1000;

                    document.getElementById('productionElectSpeed').innerHTML = productionElectSpeed + kw + "<br/><p style=\"font-size: 15px;\">" + timeProductionElectSpeed + "</p>";
                } else ajaxError('productionElectSpeed');
            },
            error: function() {
                ajaxError('productionElectSpeed');
            }
        });
        <?php } ?>

        $.ajax({
            url: DATA_URL+'consumptionHeatPumpSpeed',
            type: 'POST',
            success: function(data) {
                if(data && Array.isArray(data)) {
                    d = new Date(data[0]["time"]);
                    if(d.getTimezoneOffset() != 120) d.setHours(d.getHours() + 1);

                    var timeConsumptionHeatPumpSpeed = d.toISOString().substr(0, 16).replace("T", " "),
                        consumptionHeatPumpSpeed = Math.round(data[0]['last']) / 1000;

                    document.getElementById('consumptionHeatPumpSpeed').innerHTML = consumptionHeatPumpSpeed + kw + "<br/><p style=\"font-size: 15px;\">" + timeConsumptionHeatPumpSpeed + "</p>";
                } else ajaxError('consumptionHeatPumpSpeed');
            },
            error: function() {
                ajaxError('consumptionHeatPumpSpeed');
            }
        });

        $.ajax({
            url: DATA_URL+'hotwaterTemperatureSpeed',
            type: 'POST',
            success: function(data) {
                if(data && Array.isArray(data)) {
                    d = new Date(data[0]["time"]);
                    if(d.getTimezoneOffset() != 120) d.setHours(d.getHours() + 1);

                    var timeHotwaterTemperatureSpeed = d.toISOString().substr(0, 16).replace("T", " "),
                        hotwaterTemperatureSpeed = Math.round(data[0]['last'] * 10) / 10;

                    document.getElementById('hotwaterTemperatureSpeed').innerHTML = hotwaterTemperatureSpeed + celsius + "<br/><p style=\"font-size: 15px;\">" + timeHotwaterTemperatureSpeed + "</p>";
                } else ajaxError('hotwaterTemperatureSpeed');
            },
            error: function() {
                ajaxError('hotwaterTemperatureSpeed');
            }
        });

        $.ajax({
            url: DATA_URL+'insideTempSpeed',
            type: 'POST',
            success: function(data) {
                if(data && Array.isArray(data)) {
                    d = new Date(data[0]["time"]);
                    if(d.getTimezoneOffset() != 120) d.setHours(d.getHours() + 1);

                    var timeInsideTempSpeed = d.toISOString().substr(0, 16).replace("T", " "),
                        insideTempSpeed = Math.round(data[0]['last'] * 10) / 10;

                    document.getElementById('insideTempSpeed').innerHTML = insideTempSpeed + celsius + "<br/><p style=\"font-size: 15px;\">" + timeInsideTempSpeed + "</p>";
                } else ajaxError('insideTempSpeed');
            },
            error: function() {
                ajaxError('insideTempSpeed');
            }
        });

        $.ajax({
            url: DATA_URL+'counterConsumption1',
            type: 'POST',
            success: function(data) {
                if(data && Array.isArray(data)) {
                    d = new Date(data[0]["time"]);
                    if(d.getTimezoneOffset() != 120) d.setHours(d.getHours() + 1);

                    var timeCounterConsumption1 = d.toISOString().substr(0, 16).replace("T", " "),
                        counterConsumption1 = data[0]['last'] / 1000;

                    document.getElementById('counterConsumptionOne').innerHTML = "Tarif 1 = " + counterConsumption1 + kwH + "<br/><p style=\"font-size: 15px;\">" + timeCounterConsumption1 + "</p>";
                } else ajaxError('counterConsumption');
            },
            error: function() {
                ajaxError('counterConsumption');
            }
        });

        $.ajax({
            url: DATA_URL+'counterConsumption2',
            type: 'POST',
            success: function(data) {
                if(data && Array.isArray(data)) {
                    d = new Date(data[0]["time"]);
                    if(d.getTimezoneOffset() != 120) d.setHours(d.getHours() + 1);

                    var timeCounterConsumption2 = d.toISOString().substr(0, 16).replace("T", " "),
                        counterConsumption2 = data[0]['last'] / 1000;

                    document.getElementById('counterConsumptionTwo').innerHTML = "Tarif 2 = " + counterConsumption2 + kwH + "<br/><p style=\"font-size: 15px;\">" + timeCounterConsumption2 + "</p>";
                } else ajaxError('counterConsumption');
            },
            error: function() {
                ajaxError('counterConsumption');
            }
        });

        <?php if($user->getInstallations()[0]->Solar()->isExistant()) { ?>
        $.ajax({
            url: DATA_URL+'counterProduction1',
            type: 'POST',
            success: function(data) {
                if(data && Array.isArray(data)) {
                    d = new Date(data[0]["time"]);
                    if(d.getTimezoneOffset() != 120) d.setHours(d.getHours() + 1);

                    var timeCounterProduction1 = d.toISOString().substr(0, 16).replace("T", " "),
                        counterProduction1 = data[0]['last'] / 1000;

                    document.getElementById('counterProductionOne').innerHTML = "Tarif 1 = " + counterProduction1 + kwH +
                        "<br/><p style=\"font-size: 15px;\">" + timeCounterProduction1 + "</p>";
                } else ajaxError('counterProduction');
            },
            error: function() {
                ajaxError('counterProduction');
            }
        });

        $.ajax({
            url: DATA_URL+'counterProduction2',
            type: 'POST',
            success: function(data) {
                if(data && Array.isArray(data)) {
                    d = new Date(data[0]["time"]);
                    if(d.getTimezoneOffset() != 120) d.setHours(d.getHours() + 1);

                    var timeCounterProduction2 = d.toISOString().substr(0, 16).replace("T", " "),
                        counterProduction2 = data[0]['last'] / 1000;

                    document.getElementById('counterProductionTwo').innerHTML = "Tarif 2 = " + counterProduction2 + kwH +
                        "<br/><p style=\"font-size: 15px;\">" + timeCounterProduction2 + "</p>";
                } else ajaxError('counterProduction');
            },
            error: function() {
                ajaxError('counterProduction');
            }
        });
        <?php } ?>

        picker = new Lightpick({
            field: document.getElementById('datepicker'),
            singleDate: false,
            onSelect: function(start, end){
                while(window.historic.series.length > 0) window.historic.series[0].remove(true);
                var start = new Date(start.get('year'), start.get('month'), start.get('date'));
                var end = new Date(end.get('year'), end.get('month'), end.get('date'));
                start.setHours(0);
                end.setHours(23);
                start = start.getTime() + "ms";
                end = end.getTime() + "ms";

                if(window.historic.options.chart.type == "column")
                    loadGraphDate(start, end, "1d");
                else loadGraphLine(start, end, "15m");
            }
        });
        var today = new Date();
        picker.setDateRange(today.getDate()-1, today.getDate())
    };

    function byTime(range) {
        var start = picker.getStartDate();
        var end = picker.getEndDate();
        start = new Date(start.get('year'), start.get('month'), start.get('date'));
        end = new Date(end.get('year'), end.get('month'), end.get('date'));
        start.setHours(0, 0, 0);
        end.setHours(23, 59, 59);
        start = start.getTime() + "ms";
        end = end.getTime() + "ms";

        while(window.historic.series.length > 0) window.historic.series[0].remove(true);

        if(range == '15m') {
            $("#i-1d").hide();
            $("#i-15m").show();
            $("#btn15m").addClass('active');
            $("#btn1d").removeClass('active');
            loadGraphLine(start, end, "15m");
        } else if(range == '1d') {
            $("#i-1d").show();
            $("#i-15m").hide();
            $("#btn15m").removeClass('active');
            $("#btn1d").addClass('active');
            loadGraphDate(start, end, "1d");
        }
    }

</script>