<div class="row">
    <div class="mt col-lg-12 col-xl-4 col-md-12 form-panel">

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
                <p><?= $l10n["chart"]["consumptionHeatPump"] ?></p>
            </div>
            <a href="consumptionHeatPump">
                <span class="fa fa-fire dashboardFaSize"></span>


                <!--<p class="dashboardTextSize"><?//= L10N['index']['dashboard']['textHeatPump']?></p>-->

                <div class="dashboardNumberSize" id="consumptionHeatPumpSpeed">

                </div></a>
        </div>
    </div>
    <div class="mt col-lg-12 col-xl-7 col-md-12 form-panel">
        <p class="dashboardTitleSize" style="text-align: center"> Données historiques</p>
        <hr>
        <div id="historicData"></div>
    </div>
</div>
<div class="row">
    <div class="mt col-lg-12 col-xl-4 col-md-12 form-panel">

        <p class="dashboardTitleSize" style="text-align: center"> Température en temps réel</p>
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
    <div class="mt col-lg-12 col-xl-4 col-md-12 form-panel">
        <p class="dashboardTitleSize" style="text-align: center"> Index de votre compteur</p>
        <hr>
    </div>
    <div class="mt col-lg-12 col-xl-3 col-md-12 form-panel">
        <p class="dashboardTitleSize" style="text-align: center"> Eco'gestes</p>
        <hr>
    </div>
</div>

<?php
if($user->getInstallations()[0]->Solar()->isExistant())
{

    ?>
    <div class="row mt col-lg-5 form-panel">
        <div style="text-align: center;">
            <div class="dashboardTitleSize">
                <p><?= $l10n["chart"]["productionElect"] ?></p>
            </div>

            <a href="productionElect">
                <span class="fa fa-certificate dashboardFaSize"></span>


                <p class="dashboardTextSize"><?= L10N['index']['dashboard']['productionElect']?></p>
                <div class="dashboardNumberSize" id="productionElectSpeed">
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
            "consumptionElectSpeed": ' kW',
            "consumptionHeatPumpSpeed": ' kW',
            "hotwaterTemperatureSpeed": ' °C',
            "insideTempSpeed": ' °C',
            "productionElectSpeed": ' kW',
            "insideTemp": ' kW'
        };
        var insideArray =[];
        var boilerArray = [];
        var electArray = [];
        var heatPumpArray = [];
        var boiler;
        var electConsumption;
        var heatPumpConsumption;

        for (const i in urls) {

            $.ajax({
                url : i,
                type : 'POST',
                success : function(data) {
                    if (data && Array.isArray(data)) {
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

        $.ajax({
            type: "POST",
            url: "hotwaterTemperatureHistory",
            success : function (data) {
                boiler = data;
            },
            error: function () {
                ajaxError('TEST');
            }

        });

        $.ajax({
            type: "POST",
            url: "consumptionElectHistory",
            success : function (data) {
                electConsumption = data;
                console.log(electConsumption);
            },
            error: function () {
                ajaxError('TEST');
            }

        });

        $.ajax({
            type: "POST",
            url: "consumptionHeatPumpHistory",
            success : function (data) {
                heatPumpConsumption = data;
            },
            error: function () {
                ajaxError('TEST');
            }

        });


        $.ajax({
            type: "POST",
            url: "insideTempHistory",
            timeout: 45000,
            success : function (data) {
                for(let index = 0;index< data.length;index++)
                {
                    d = new Date(data[index]["time"]);
                    if(d.getTimezoneOffset() == 120)
                    {
                        d.setHours(d.getHours() + 1)
                    }
                    else {
                        d.setHours(d.getHours() + 2)
                    }
                    insideArray.unshift([new Date(d.toISOString()).getTime(), data[index]["sum_count"]])
                }
                for(let index = 0;index< boiler.length;index++)
                {
                    d = new Date(boiler[index]["time"]);

                    if(d.getTimezoneOffset() == 120)
                    {
                        d.setHours(d.getHours() + 1)
                    }
                    else {
                        d.setHours(d.getHours() + 2)
                    }
                    boilerArray.unshift([new Date(d.toISOString()).getTime(), boiler[index]["sum_count"]])
                }

                for(let index = 0;index< electConsumption.length;index++)
                {
                    d = new Date(electConsumption[index]["time"]);

                    if(d.getTimezoneOffset() == 120)
                    {
                        d.setHours(d.getHours() + 1)
                    }
                    else {
                        d.setHours(d.getHours() + 2)
                    }
                    electArray.unshift([new Date(d.toISOString()).getTime(), electConsumption[index]["sum_count"]])
                }

                for(let index = 0;index< heatPumpConsumption.length;index++)
                {
                    d = new Date(heatPumpConsumption[index]["time"]);

                    if(d.getTimezoneOffset() == 120)
                    {
                        d.setHours(d.getHours() + 1)
                    }
                    else {
                        d.setHours(d.getHours() + 2)
                    }
                    if(heatPumpConsumption[index]["sum_count"] >= 0)
                    {
                        heatPumpArray.unshift([new Date(d.toISOString()).getTime(), heatPumpConsumption[index]["sum_count"]])
                    }

                }

                Highcharts.StockChart('historicData', {
                    chart: {
                        height:300+ 'px',
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
                        selected: 1,
                        inputEnabled: false,
                        buttonTheme: {
                            visibility: 'hidden'
                        },
                        labelStyle: {
                            visibility: 'hidden'
                        }
                    },
                    tooltip: {
                        shared: false
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
                            yAxis:1
                        },
                        {
                            name: 'Pompe à chaleur',
                            type: 'area',
                            data: heatPumpArray,
                            index:2,
                            yAxis:1
                        },
                        {
                            name: 'Intérieur',
                            type: 'line',
                            data: insideArray,
                            index:3,
                            yAxis:0
                        },
                        {
                            name: 'Boiler',
                            type: 'line',
                            data: boilerArray,
                            index:4,
                            yAxis:0
                        },
                    ]


                });

            },
            error: function () {
                ajaxError('TEST');
            }
        });

    }

</script>
