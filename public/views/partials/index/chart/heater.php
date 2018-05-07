<div class="row mt col-lg-12 form-panel">
    <div id="heater" class="synchronized-chart" style="width: calc(100% - 15px);">
    </div>

    <script>
        window.onload = function() {
            $.post("heater", function (data) {

                $.each(data, function(i, val) {
                    dataTime = [];
                    time = 0;
                    for (var j in val) {
                        dataTime.unshift([new Date(val[j]["time"]).getTime(), val[j]["value"]])
                    }
                    Highcharts.StockChart('heater', {
                            title: {
                                text: i
                            },
                            yAxis: {
                                opposite: false,
                                title: {
                                    text: "<?= $l10n["chart"]["temperature"] ?>"
                                }
                            },
                            series: [{
                                data: dataTime,
                                tooltip: {
                                    valueDecimals: 2
                                }
                            }],
                            navigator: {
                                margin: 60
                            },

                            rangeSelector: {
                                floating: true,
                                selected : 2,
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
                                }]
                            }
                        }
                    );
                });
            });
        };
    </script>
</div>