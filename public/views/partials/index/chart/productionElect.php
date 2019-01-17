<div class="row mt col-lg-12 form-panel">
    <img id="loader" src="<?= BASE_URL ?>/public/images/loader.gif" style="display: block; margin-left: auto; margin-right: auto; width: 200px;"/>

    <div id="productionElect" style="width: calc(100% - 15px);"></div>
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

                window.productionElect = Highcharts.StockChart('productionElect', {
                    chart: {
                        events: {
                            load: function() { document.getElementById("loader").style.display = "none"; resizeFooter(); }
                        }
                    },
                    title: {
                        text: "<?= $l10n["chart"]["productionElect"] ?>"
                    },
                    xAxis: {
                        ordinal:false,
                        events: {
                            setExtremes : function (e) {
                                if(e.trigger && this.chart.rangeSelector.buttonOptions[this.chart.rangeSelector.selected].type == "all") {
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
                        type:'area',
                        color:"#f4e842",
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
                        enabled:true,
                        floating: true,
                        selected: 3,
                        /*buttons: [{
                            text: '12h',
                            events: {
                                click: function () {
                                    loadGraph('1s','12h','productionElect');
                                }
                            }
                        }, {
                            text: '1d',
                            events: {
                                click: function () {
                                    loadGraph('1s','1d','productionElect');
                                }
                            }
                        }, {
                            text: '7d',
                            events: {
                                click: function () {
                                    loadGraph('1s','7d','productionElect');
                                }
                            }
                        }, {
                            text: 'All',
                            events: {
                                click: function () {
                                    loadGraph('15m','30d','productionElect');
                                }
                            }
                        }],*/
                        buttons : [{
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
                            count: 7,
                            type: 'day',
                            text: '7d',
                            dataGrouping: {
                                forced: true,
                                units: [['second', [1]]]
                            }
                        },{
                            type: 'all',
                            text: 'All',
                            dataGrouping: {
                                forced: true,
                                units: [['minute', [15]]],
                                smoothed: true
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

                loadData("productionElectLimit", productionElect);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                if (textStatus === "timeout") {
                    document.getElementById("loader").style.display = "none";
                    document.getElementById("productionElect").innerHTML = "<?= $l10n["chart"]["noData"] ?>"
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
        loadGraph('1s','24h','productionElect');
    }
</script>
