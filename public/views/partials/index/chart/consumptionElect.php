<div class="row mt col-lg-12 form-panel">
    <img id="loader" src="<?= BASE_URL ?>/public/images/loader.gif" style="display: block; margin-left: auto; margin-right: auto; width: 200px;" />

    <div id="consumptionElect" style="width: calc(100% - 15px);"></div>
    <div id="graphLoading"><?= $l10n["chart"]["loadingData"] ?></div>
</div>
<div class="row mt col-lg-12 form-panel">
    <div style="width:75%;font-size:15px;margin:auto;text-align:center;">
        <p style="width:75%;margin:auto;text-align:left;"><?= $l10n["chart"]["consumptionElectInfo"] ?></p>

        <img style="margin:20px 0px;max-width:100%;" src="<?= BASE_URL ?>/public/images/info/consumption.png"/>

        <p style="width:75%;margin:auto;text-align:left;display:flex;align-items:center;">
            <img style="max-height:100px;max-width:25%;float:left;" src="<?= BASE_URL ?>/public/images/eco-reflexes.png" />
            <?= $l10n["chart"]["consumptionElectTip"] ?>
        </p><br style="clear: both" /><br />
        <p style="width:75%;margin:auto;text-align:left;"><?= $l10n["chart"]["consumptionElectNote"] ?></p>
    </div>
</div>

<script>
    window.onload = function() {
        //loadGraph('5s', '24h', 'consumptionElect');

        $.ajax({
            type: "POST",
            url: DATA_URL+"consumptionElect",
            data: {
                'range': "24h",
                'time': "5s",
                'offset': 0
            },
            timeout: 45000,
            success: function(data) {
                var dataTime = parse(data);

                window.consumptionElect = Highcharts.StockChart('consumptionElect', {
                    chart: {
                        events: {
                            load: function() {
                                document.getElementById("loader").style.display = "none";
                                resizeFooter();
                            }
                        }
                    },
                    title: {
                        text: "<?= $l10n["chart"]["consumptionElect"] ?>"
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
                        adaptToUpdatedData: false
                    },
                    plotOptions: {
                        line: {
                            dataGrouping: {
                                enabled: true,
                                units: [[
                                    'second', [5, 10, 15, 30]
                                ], [
                                    'minute', [1, 2, 5, 10, 15, 30]
                                ], [
                                    'hour', [1, 2, 3, 4, 6, 8, 12]
                                ], [
                                    'day', [1]
                                ]]
                            },
                            states: {
                                hover: {
                                    lineWidthPlus: 0
                                }
                            }
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
                            count: 12,
                            type: 'hour',
                            text: '12h',
                            dataGrouping: {
                                forced: true,
                                units: [['second', [5]]]
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
                                units: [['day', [1]]],
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

                loadData("consumptionElect", consumptionElect);
            },
            error: function(jqXHR, textStatus) {
                if(textStatus === "timeout") {
                    document.getElementById("loader").style.display = "none";
                    document.getElementById("consumptionElect").innerHTML = "<?= $l10n["chart"]["noData"] ?>";
                }
            }
        });
    };
</script>