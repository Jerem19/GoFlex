<div class="row mt col-lg-12 form-panel">
    <img id="loader" src="<?= BASE_URL ?>/public/images/loader.gif" style="display: block; margin-left: auto; margin-right: auto; width: 200px;"/>

    <div id="productionElect" style="width: calc(100% - 15px);">

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

                    if (data[j]["distinct"] >= 0) {
                        newData = data[j]["distinct"] / 1000;
                        dataTime.unshift([new Date(d.toISOString()).getTime(), newData])
                    }
                }
                Highcharts.StockChart('productionElect', {
                    chart: {
                        events: {
                            load: function() { document.getElementById("loader").style.display = "none"; resizeFooter(); }
                        }
                    },
                    title: {
                        text: "<?= $l10n["chart"]["productionElect"] ?>"
                    },
                    xAxis: {
                        ordinal:false
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
                        adaptToUpdatedData: false
                    },
                    scrollbar: {
                        liveRedraw: false
                    },
                    rangeSelector: {
                        enabled:true,
                        floating: true,
                        selected: 3,
                        buttons: [{
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
                    document.getElementById("productionElect").innerHTML = "<?= $l10n["chart"]["noData"] ?>"
                }
            }
        });
    }
    window.onload = function() {

        loadGraph('15m','7d','productionElect');
    }
</script>
