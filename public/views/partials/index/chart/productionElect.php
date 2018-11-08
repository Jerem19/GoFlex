<div class="row mt col-lg-12 form-panel">
    <img id="loader" src="<?= BASE_URL ?>/public/images/loader.gif" style="display: block; margin-left: auto; margin-right: auto; width: 200px;"/>

    <div id="productionElect" style="width: calc(100% - 15px);">

    </div>

</div>

<script>
    window.onload = function() {
        $.ajax({
            type: "POST",
            url: "productionElect",
            timeout: 45000,
            success: function (data) {
                dataTime = [];
                for (var j in data) {
                    d = new Date(data[j]["time"]);

                    if(d.getTimezoneOffset() == 120)
                    {
                        d.setHours(d.getHours() + 1)
                    }
                    else {
                        d.setHours(d.getHours() + 2)
                    }

                    if (data[j]["sum_count"] >= 0) {
                        newData = data[j]["sum_count"] / 1000;
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
                        floating: true,
                        selected: 1,
                        buttons: [{
                            type: 'minute',
                            count: 60,
                            text: '1h',
                            dataGrouping: {
                                forced: true,
                                units: [['minute', [1]]]
                            }
                        }, {
                            type: 'minute',
                            count: 360,
                            text: '6h',
                            dataGrouping: {
                                forced: true,
                                units: [['minute', [15]]]
                            }
                        }, {
                            type: 'day',
                            count: 7,
                            text: '1d',
                            dataGrouping: {
                                forced: true,
                                units: [['hour', [1]]]
                            }
                        }, {
                            type: 'all',
                            text: 'All',
                            dataGrouping: {
                                forced: true,
                                units: [['day', [1]]]
                            }
                        }],
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
</script>
