<div class="row mt col-lg-12 form-panel">
    <img id="loader" src="<?= BASE_URL ?>/public/images/loader.gif" style="display: block; margin-left: auto; margin-right: auto; width: 200px;" />

    <div id="hotwaterTemperature" style="width: calc(100% - 15px);"></div>
    <div id="graphLoading">Vos données sont en cours de chargement...</div>
</div>

<script>
    window.onload = function() {
        //loadGraph('1s', '24h', 'hotwaterTemperature');

        $.ajax({
            type: "POST",
            url: DATA_URL+"hotwaterTemperature",
            data: {
                'range': "24h",
                'time': "1s",
                'offset': 0
            },
            timeout: 45000,
            success: function(data) {
                var dataTime = parse(data, 30, 120);

                window.hotwaterTemperature = Highcharts.StockChart('hotwaterTemperature', {
                    chart: {
                        events: {
                            load: function() {
                                document.getElementById("loader").style.display = "none";
                                resizeFooter();
                            }
                        }
                    },
                    title: {
                        text: "<?= $l10n["chart"]["hotwaterTemperature"] ?>"
                    },
                    xAxis: {
                        ordinal: false,
                        events: {
                            setExtremes: function(e) {
                                if(e.trigger === "rangeSelectorButton" && this.chart.rangeSelector.buttonOptions[this.chart.rangeSelector.selected].type === "all") {
                                    var ex = this.chart.xAxis[0].getExtremes();
                                    this.chart.xAxis[0].setExtremes(ex.dataMax, ex.dataMax);
                                }
                            }
                        }
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
                        adaptToUpdatedData: false
                    },
                    scrollbar: {
                        liveRedraw: false
                    },
                    rangeSelector: {
                        enabled: true,
                        floating: true,
                        selected: 3,
                        buttons: [{
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
                                units: [['minute', [1]]]
                            }
                        }, {
                            count: 7,
                            type: 'day',
                            text: '7d',
                            dataGrouping: {
                                forced: true,
                                units: [['minute', [15]]]
                            }
                        }, {
                            type: 'all',
                            text: 'All',
                            dataGrouping: {
                                forced: true,
                                units: [['hour', [12]]],
                                smoothed: true
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

                loadData("hotwaterTemperatureLimit", hotwaterTemperature, 30, 120);
            },
            error: function(jqXHR, textStatus) {
                if(textStatus === "timeout") {
                    document.getElementById("loader").style.display = "none";
                    document.getElementById("hotwaterTemperature").innerHTML = "<?= $l10n["chart"]["noData"] ?>";
                }
            }
        });
    };
</script>