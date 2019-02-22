<div class="row mt col-lg-12 form-panel">
    <img id="loader" src="<?= BASE_URL ?>/public/images/loader.gif" style="display: block; margin-left: auto; margin-right: auto; width: 200px;" />

    <div id="productionElect" style="width: calc(100% - 15px);"></div>
    <div id="graphLoading"><?= $l10n["chart"]["loadingData"] ?></div>
</div>
<div class="row mt col-lg-12 form-panel">
<?php
    include PUBLIC_FOLDER.'views/partials/index/info.php';
    chart_info("productionElect");
?>
</div>

<script>
    window.onload = function() {
        //loadGraph('1s', '24h', 'productionElect');

        $.ajax({
            type: "POST",
            url: DATA_URL+"productionElect",
            data: {
                'range': "24h",
                'time': "1s",
                'offset': 0
            },
            timeout: 45000,
            success: function(data) {
                var dataTime = parse(data);

                window.productionElect = Highcharts.StockChart('productionElect', {
                    chart: {
                        events: {
                            load: function() {
                                document.getElementById("loader").style.display = "none";
                                resizeFooter();
                            }
                        }
                    },
                    title: {
                        text: "<?= $l10n["chart"]["productionElect"] ?>"
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
                        type: 'area',
                        color: "#f4e842",
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
                                units: [['second', [1]]]
                            }
                        }, {
                            count: 7,
                            type: 'day',
                            text: '7d',
                            dataGrouping: {
                                forced: true,
                                units: [['second', [1]]]
                            }
                        }, {
                            type: 'all',
                            text: 'All',
                            dataGrouping: {
                                forced: true,
                                units: [['minute', [15]]],
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

                loadData("productionElectLimit", productionElect);
            },
            error: function(jqXHR, textStatus) {
                if(textStatus === "timeout") {
                    document.getElementById("loader").style.display = "none";
                    document.getElementById("productionElect").innerHTML = "<?= $l10n["chart"]["noData"] ?>";
                }
            }
        });
    };
</script>