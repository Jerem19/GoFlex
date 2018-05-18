<div class="row mt col-lg-12 form-panel">
    <div id="consumptionHeatPump" class="synchronized-chart" style="width: calc(100% - 15px);">
    </div>

</div>
    <script>
        window.onload = function() {

            $.post("consumptionHeatPump", function (data) {
                console.log(data);
                $.each(data, function (i, val) {
                    dataTime = [];
                    for (var j in val) {
                        dataTime.unshift([new Date(val[j]["time"]).getTime(), val[j]["value"]])
                    }
                    Highcharts.StockChart('consumptionHeatPump', {
                            title: {
                                text: i
                            },
                            yAxis: {
                                opposite: false,
                                title: {
                                    text: "<?= $l10n["chart"]["consumptionHeatPump"] ?>"
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
                                    type: 'hour',
                                    count: 1,
                                    text: '1h'
                                }, {
                                    type: 'day',
                                    count: 1,
                                    text: '1d'
                                }, {
                                    type: 'day',
                                    count: 2,
                                    text: '2d'
                                }, {
                                    type: 'month',
                                    count: 1,
                                    text: '1m'
                                }, {
                                    type: 'all',
                                    text: 'All'
                                }],
                                inputEnabled: false, // it supports only days
                            }
                        }
                    );
                });
            });
        }

    </script>
