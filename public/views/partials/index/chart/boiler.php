<div class="row mt col-lg-12 form-panel">
    <div id="boiler" class="synchronized-chart" style="width: calc(100% - 15px);">
    </div>

    <script>
        window.onload = function() {

            var charts = [];
            function sync(chartC) {
                var extreme = chartC.xAxis[0].getExtremes();

                for (var i in charts)  {
                    var chart = charts[i];
                    chart.xAxis[0].setExtremes(extreme.min, extreme.max, true, false);
                }

            }

            $.post("boiler", function (data) {

                var id = 0;
                $.each(data, function(i, val) {
                    dataTime = [];
                    for (var j in val["data"]) {
                        dataTime.unshift([new Date(val["data"][j]["time"]).getTime(), val["data"][j]["value"]])
                    }

                    id++;
                    var idDiv = 'chartSync' + id;
                    var div = $('<div class="" id="'+ idDiv +'">').appendTo('#boiler');
                    const chartDiv = new Highcharts.StockChart({
                            chart: {
                                renderTo: idDiv
                            },
                            title: {
                                text: i
                            },
                            xAxis: {
                                type: "datetime",
                                title: "Date"
                            },
                            yAxis: {
                                opposite: false,
                                title: {
                                    text: val.y
                                }
                            },
                            series: [{
                                data: dataTime
                            }],
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
                                }],
                                inputEnabled:false,
                            }
                        }
                    );
                    charts.push(chartDiv);
                    div.on('mousemove', function () {
                        sync(chartDiv);
                    });
                });
            });
        };
    </script>
</div>