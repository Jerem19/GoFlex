<div class="row mt col-lg-12 form-panel">
    <div id="boiler" class="synchronized-chart" style="width: calc(100% - 15px);">
    </div>

    <script>
        window.onload = function() {
            $.post("boiler", function (data) {

                $.each(data, function(i, val) {
                    dataTime = [];
                    for (var j in val) {
                        dataTime.unshift([new Date(val[j]["time"]).getTime(), val[j]["value"]])
                    }

                    $('<div class="">')
                        .appendTo('#boiler')
                        .highcharts({
                            title: {
                                text: i
                            },
                            xAxis: {
                                type: "datetime",
                                title: "Date"
                            },
                            series: [{
                                data: dataTime
                            }]
                        }
                    );
                });
            });
        };
    </script>
</div>