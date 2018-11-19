<div class="row mt col-lg-12 form-panel">
    <img id="loader" src="<?= BASE_URL ?>/public/images/loader.gif" style="display: block; margin-left: auto; margin-right: auto; width: 200px;"/>

    <div id="insideTemp" style="width: calc(100% - 15px);">

    </div>

</div>

<script>
    function loadGraph(interval,range,url)
    {
        $.ajax({
            type: "POST",
            url: url,
            data:{
                'range': range,
                'time': interval
            },
            timeout: 45000,
            success: function (data) {
                dataTime = [];
                for (var j in data) {
                    d = new Date(data[j]["time"]);

                    if(d.getTimezoneOffset() != 120)
                    {
                        d.setHours(d.getHours() + 1)
                    }

                    if(data[j]["sum_count"] >= 0 && data[j]["sum_count"] < 50)
                    {
                        dataTime.unshift([new Date(d.toISOString()).getTime(), data[j]["sum_count"]])
                    }
                }
                Highcharts.StockChart('insideTemp', {
                    chart: {
                        events: {
                            load: function() { document.getElementById("loader").style.display = "none"; resizeFooter(); }
                        }
                    },
                    title: {
                        text: "<?= $l10n["chart"]["insideTemperature"] ?>"
                    },
                    xAxis: {
                        ordinal:false
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
                        adaptToUpdatedData: false,
                    },
                    scrollbar: {
                        liveRedraw: false
                    },
                    rangeSelector: {
                        enabled:true,
                        floating: true,
                        selected: 3,
                        buttons: [{
                            text: 'court',
                            events: {
                                click: function () {
                                    loadGraph('5s','3h','insideTemp');
                                }
                            }
                        }, {
                            text: 'court moyen',
                            events: {
                                click: function () {
                                    loadGraph('1m','1d','insideTemp');
                                }
                            }
                        }, {
                            text: 'moyen',
                            events: {
                                click: function () {
                                    loadGraph('15m','7d','insideTemp');
                                }
                            }
                        }, {
                            text: 'long',
                            events: {
                                click: function () {
                                    loadGraph('1d','1y','insideTempAll');
                                }
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
            },
            error: function (jqXHR, textStatus, errorThrown) {
                if (textStatus === "timeout") {
                    document.getElementById("loader").style.display = "none";
                    document.getElementById("insideTemp").innerHTML = "<?= $l10n["chart"]["noData"] ?>"
                }
            }
        });
    }
    window.onload = function() {
        loadGraph('15m','7d','insideTemp');
    }
</script>
