<div class="row mt col-lg-12 form-panel">
    <div id="electricConsumption" class="synchronized-chart" style="width: calc(100% - 15px);">
    </div>
</div>

<script>
    window.onload = function() {

        $.post("electricConsumption", function (data) {

            dataTime = [];
            for (var j in data) {
                dataTime.unshift([new Date(data[j]["time"]).getTime(), data[j]["value"]])
            }
            Highcharts.StockChart('electricConsumption', {
                    title: {
                        text: "<?= $l10n["chart"]["electricalConsumption"] ?>"
                    },
                    yAxis: {
                        opposite: false,
                        title: {
                            text: "<?= $l10n["chart"]["electricalConsumption"] ?>"
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
                        inputEnabled: false // it supports only days
                    }
                }
            );
        });
    }

</script>
