<div class="row mt col-lg-12 form-panel">
    <img id="loader" src="<?= BASE_URL ?>/public/images/loader.gif" style="display: block; margin-left: auto; margin-right: auto; width: 200px;"/>

    <div id="consumptionHeatPump" style="width: calc(100% - 15px);"></div>
    <div id="graphLoading">Vos données sont en cours de chargement...</div>
</div>

<script>
    function loadGraph(interval,range,url)
    {
        $.ajax({
            type: "POST",
            url: url,
            data:{
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
                            load: function() { document.getElementById("loader").style.display = "none"; resizeFooter(); }
                        }
                    },
                    title: {
                        text: "<?= $l10n["chart"]["consumptionHeatPump"] ?>"
                    },

                    xAxis: {
                        ordinal:false,
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
                                enabled: true
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
                        },
                    },
                    scrollbar: {
                        liveRedraw: false
                    },
                    rangeSelector: {
                        enabled:true,
                        floating: true,
                        selected: 0,
                        /*buttons: [{
                            text: '6h',
                            events: {
                                click: function () {
                                    loadGraph('1s','6h','consumptionHeatPump');
                                }
                            }
                        }, {
                            text: '1d',
                            enabled:false,
                            events: {
                                click: function () {
                                    loadGraph('1m','1d','consumptionHeatPump');
                                }
                            },
                            dataGrouping:{
                                enabled:false
                            }
                        }, {
                            text: '7d',
                            enabled:false,
                            events: {
                                click: function () {
                                    loadGraph('1m','7d','consumptionHeatPump');
                                }
                            }
                        }, {
                            text: '1y',
                            enabled:false,
                            events: {
                                click: function () {
                                    loadGraph('1d','365d','consumptionHeatPump');
                                }
                            }
                        }],*/
                        buttons : [{
                            count: 6,
                            type: 'hour',
                            text: '6h',
                            dataGrouping: {
                                forced: true,
                                units: [['second', [1]]]
                            }
                        },{
                            count: 12,
                            type: 'hour',
                            text: '12h',
                            dataGrouping: {
                                forced: true,
                                units: [['second', [1]]]
                            }
                        },{
                            count: 1,
                            type: 'day',
                            text: '1d',
                            dataGrouping: {
                                forced: true,
                                units: [['second', [1]]]
                            }
                        },{
                            count: 2,
                            type: 'day',
                            text: '2d',
                            dataGrouping: {
                                forced: true,
                                units: [['second', [1]]]
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

    var rdata = [];
    var l = 100000;
    var m = 500000;
    function loadData(url, chart, offset=0, parseMin = 0, parseMax = Infinity) {
        $.ajax({
            type: "POST",
            url: url,
            data:{
                'range': "365d",
                'time': "1s",
                'offset': offset
            },
            timeout: 45000,
            success: function (data) {

                var dataTime = parse(data, parseMin, parseMax);
                rdata = dataTime.concat(rdata).sort((a,b) => {
                    return a[0] - b[0];
                });

                try {
                    chart.series[0].setData(rdata, false);
                    chart.series[1].setData(rdata);
                } catch (e) {
                    console.log(e);
                    $("#graphLoading").text("Une erreur est survenue");
                    return;
                }

                if(data.length == l && offset < m) loadData(url, chart, offset + l, parseMin, parseMax);
                else $("#graphLoading").hide();
            }
        });
    }

    function parse(data, min=0, max=Infinity) {
        var dataTime = data.map(data => {
            if(data["distinct"] >= min && data["distinct"] < max)
            {
                var d = new Date(data["time"]);
                if(d.getTimezoneOffset() != 120) d.setHours(d.getHours() + 1);
                return [d.getTime(), data["distinct"]];
            }
        }).filter(v => v);
        return dataTime.reverse();
    }

    window.onload = function() {
        loadGraph('1s','24h','consumptionHeatPump');
    }
</script>
