<div class="row mt col-lg-12 form-panel">
    <img id="loader" src="<?= BASE_URL ?>/public/images/loader.gif" style="display: block; margin-left: auto; margin-right: auto; width: 200px;"/>

    <div id="consumptionElect" style="width: calc(100% - 15px);">

    </div>

</div>

<script>
    window.onload = function() {
        $.ajax({
            type: "POST",
            url: "consumptionElect",
            timeout: 45000,
            success: function (data) {
                dataTime = [];
                for (var j in data) {
                    d = new Date(data[j]["time"]);
                    d.setHours(d.getHours() + 2);

                    dataTime.unshift([new Date(d.toISOString()).getTime(), data[j]["value"]])

                }
                Highcharts.StockChart('consumptionElect', {
                    chart: {
                        events: {
                            load: function() { document.getElementById("loader").style.display = "none"; resizeFooter(); }
                        }
                    },
                    title: {
                        text: "<?= $l10n["chart"]["consumptionElect"] ?>"
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
</script>
