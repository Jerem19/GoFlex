<div class="row mt col-lg-12 form-panel">
    <img id="loader" src="<?= BASE_URL ?>/public/images/loader.gif" style="display: block; margin-left: auto; margin-right: auto; width: 200px;" />

    <div id="consumptionHeatPump" style="width: calc(100% - 15px);"></div>
    <div id="graphLoading">Vos données sont en cours de chargement...</div>
</div>
<div class="row mt col-lg-12 form-panel">
    <div style="width:75%;font-size:15px;margin:auto;text-align:center;">
        <p style="width:75%;margin:auto;text-align:left;">Cette mesure est  prise sur l’alimentation de la pompe à chaleur (PAC) au moyen d’un capteur et l’information est envoyée au boitier GOFLEX par radio.</p>

        <img style="margin:20px 0px;max-width:100%;" src="<?= BASE_URL ?>/public/images/info/heat_pump.png"/>

        <p style="width:75%;margin:auto;text-align:left;display:flex;align-items:center;">
            <img style="height:100px;float:left;" src="<?= BASE_URL ?>/public/images/eco-reflexes.png" />
            TIP: Une pompe à chaleur est économe car elle tire une partie de son énergie de l’environnement. Le coefficient de performance (COP) est un indicateur permettant  de savoir comment fonctionne la PAC: un COP de 3 veut dire que pour 1kWh d’électricité utilisé pour faire fonctionner la PAC, il y a 3kWh d’énergie thermique utile.
        </p>
    </div>
</div>

<script>
    window.onload = function() {
        //loadGraph('1s', '24h', 'consumptionHeatPump');

        $.ajax({
            type: "POST",
            url: "consumptionHeatPump",
            data: {
                'range': "24h",
                'time': "1s",
                'offset': 0
            },
            timeout: 45000,
            success: function(data) {
                var dataTime = parse(data);

                window.heatPump = Highcharts.StockChart('consumptionHeatPump', {
                    chart: {
                        events: {
                            load: function() {
                                document.getElementById("loader").style.display = "none";
                                resizeFooter();
                            }
                        }
                    },
                    title: {
                        text: "<?= $l10n["chart"]["consumptionHeatPump"] ?>"
                    },
                    xAxis: {
                        ordinal: false
                    },
                    yAxis: {
                        opposite: false,
                        title: {
                            text: "kW"
                        }
                    },
                    plotOptions: {
                        line: {
                            dataGrouping: {
                                enabled: false
                            },
                            states: {
                                hover: {
                                    lineWidthPlus: 0
                                }
                            }
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
                        handles: {
                            enabled: false
                        }
                    },
                    scrollbar: {
                        liveRedraw: false
                    },
                    rangeSelector: {
                        enabled: true,
                        floating: true,
                        selected: 0,
                        buttons: [{
                            count: 6,
                            type: 'hour',
                            text: '6h',
                            dataGrouping: {
                                forced: true,
                                units: [['second', [1]]]
                            }
                        }, {
                            count: 12,
                            type: 'hour',
                            text: '12h',
                            dataGrouping: {
                                forced: true,
                                units: [['second', [1]]]
                            }
                        }, {
                            count: 1,
                            type: 'day',
                            text: '1d',
                            dataGrouping: {
                                forced: true,
                                units: [['second', [1]]]
                            }
                        }, {
                            count: 2,
                            type: 'day',
                            text: '2d',
                            dataGrouping: {
                                forced: true,
                                units: [['second', [1]]]
                            }
                        }],
                        buttonTheme: {
                            height: 18,
                            padding: 2,
                            width: 20 + '%',
                            zIndex: 7
                        },
                        inputEnabled: false // it supports only days
                    }
                });

                loadData("consumptionHeatPump", heatPump);
            },
            error: function(jqXHR, textStatus) {
                if(textStatus === "timeout") {
                    document.getElementById("loader").style.display = "none";
                    document.getElementById("consumptionHeatPump").innerHTML = "<?= $l10n["chart"]["noData"] ?>";
                }
            }
        });
    };
</script>