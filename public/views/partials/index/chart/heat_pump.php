<div class="row mt col-lg-12 form-panel">
    <img id="loader" src="<?= BASE_URL ?>/public/images/loader.gif"
         style="display: block; margin-left: auto; margin-right: auto; width: 200px;"/>

    <div id="consumptionHeatPump" style="width: calc(100% - 15px);"></div>
    <div id="graphLoading">Vos données sont en cours de chargement...</div>
</div>

<script>
    function loadGraph(interval, range, url) {
        $.ajax({
            type: "POST",
            url: url,
            data: {
                'range': range,
                'time': interval,
                'offset': 0
            },
            timeout: 45000,
            success: function (data) {
                var dataTime = parse(data);

                window.heatPump = Highcharts.StockChart('consumptionHeatPump', {
                    chart: {
                        events: {
                            load: function () {
                                document.getElementById("loader").style.display = "none";
                                resizeFooter();
                            }
                        }
                    },
                    title: {
                        text: "<?= $l10n["chart"]["consumptionHeatPump"] ?>"
                    },
                    xAxis: {
                        ordinal: false,
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
            error: function (jqXHR, textStatus, errorThrown) {
                if (textStatus === "timeout") {
                    document.getElementById("loader").style.display = "none";
                    document.getElementById("consumptionHeatPump").innerHTML = "<?= $l10n["chart"]["noData"] ?>"
                }
            }
        });
    }

    window.onload = function () {
        loadGraph('1s', '24h', 'consumptionHeatPump');
    }
</script>
