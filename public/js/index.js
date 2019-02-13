// Parse the data from the DB to a highchart readable format
function parse(data, min = 0, max = Infinity, field = "distinct") {
    var dataTime = data.map(data => {
        if (data[field] >= min && data[field] < max) {
            var d = new Date(data["time"]);
            if (d.getTimezoneOffset() != 120) d.setHours(d.getHours() + 1);
            return [d.getTime(), data[field]];
        }
    }).filter(v => v);
    return dataTime.reverse();
}

// Load chart data by chunks of 100000
function loadData(url, chart, parseMin = 0, parseMax = Infinity) {
    var rdata = [];
    var l = 100000;
    var m = 500000;

    function loadPart(offset = 0) {
        $.ajax({
            type: "POST",
            url: url,
            data: {
                'range': "365d",
                'time': "1s",
                'offset': offset
            },
            timeout: 45000,
            success: function (data) {
                var dataTime = parse(data, parseMin, parseMax);
                rdata = dataTime.concat(rdata).sort((a, b) => {
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

                if (data.length === l && offset < m) loadPart(offset + l);
                else $("#graphLoading").hide();
            }
        });
    }
    loadPart();
}