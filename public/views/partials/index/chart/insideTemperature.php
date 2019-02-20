<div class="row mt col-lg-12 form-panel">
    <img id="loader" src="<?= BASE_URL ?>/public/images/loader.gif" style="display: block; margin-left: auto; margin-right: auto; width: 200px;" />

    <div id="insideTemp" style="width: calc(100% - 15px);"></div>
    <div id="graphLoading">Vos données sont en cours de chargement...</div>
</div>
<div class="row mt col-lg-12 form-panel">
    <div style="width:75%;font-size:15px;margin:auto;text-align:center;">
        <p style="width:75%;margin:auto;text-align:left;">Cette mesure est  prise sur par un petit boîtier  fonctionnant sur pile et posé dans votre logement. Vous pouvez le déplacer mais gardez le dans une pièce dite à vivre. Evitez de le placer au soleil car la mesure sera faussée.</p>

        <img style="margin:20px 0px;max-width:100%;" src="<?= BASE_URL ?>/public/images/info/thermometer.png"/>

        <p style="width:75%;margin:auto;text-align:left;display:flex;align-items:center;">
            <img style="height:100px;float:left;" src="<?= BASE_URL ?>/public/images/eco-reflexes.png" />
            TIP: En moyenne, un degré supplémentaire sur votre consigne de chauffage représente une consommation d'énergie supplémentaire de 7%. Contrôlez les températures des pièces à vivre : 23°C dans la salle de bain, 20°C dans la salle de séjour, 17°C dans les chambres à coucher et le couloir.
        </p>
    </div>
</div>

<script>
    window.onload = function() {
        //loadGraph('1s', '24h', 'insideTemp');

        $.ajax({
            type: "POST",
            url: "insideTemp",
            data: {
                'range': "24h",
                'time': "1s",
                'offset': 0
            },
            timeout: 45000,
            success: function(data) {
                var dataTime = parse(data, 0, 50);

                window.insideTemp = Highcharts.StockChart('insideTemp', {
                    chart: {
                        events: {
                            load: function() {
                                document.getElementById("loader").style.display = "none";
                                resizeFooter();
                            }
                        }
                    },
                    title: {
                        text: "<?= $l10n["chart"]["insideTemperature"] ?>"
                    },
                    xAxis: {
                        ordinal: false,
                        events: {
                            setExtremes: function(e) {
                                if(e.trigger === "rangeSelectorButton" && this.chart.rangeSelector.buttonOptions[this.chart.rangeSelector.selected].type === "all") {
                                    var ex = this.chart.xAxis[0].getExtremes();
                                    this.chart.xAxis[0].setExtremes(ex.dataMax, ex.dataMax);
                                }
                            }
                        }
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
                        adaptToUpdatedData: false
                    },
                    scrollbar: {
                        liveRedraw: false
                    },
                    rangeSelector: {
                        enabled: true,
                        floating: true,
                        selected: 3,
                        buttons: [{
                            count: 12,
                            type: 'hour',
                            text: '12h',
                            dataGrouping: {
                                forced: true,
                                units: [['second', [1]]]
                            }
                        }, {
                            count: 1,
                            type: 'day',
                            text: '1d',
                            dataGrouping: {
                                forced: true,
                                units: [['minute', [1]]]
                            }
                        }, {
                            count: 7,
                            type: 'day',
                            text: '7d',
                            dataGrouping: {
                                forced: true,
                                units: [['minute', [15]]]
                            }
                        }, {
                            type: 'all',
                            text: 'All',
                            dataGrouping: {
                                forced: true,
                                units: [['hour', [12]]],
                                smoothed: true
                            }
                        }],
                        buttonTheme: {
                            height: 18,
                            padding: 2,
                            width: 20 + '%',
                            zIndex: 7
                        },
                        inputEnabled: false // it supports only days
                    }
                });

                loadData("insideTempLimit", insideTemp, 0, 50);
            },
            error: function(jqXHR, textStatus) {
                if(textStatus === "timeout") {
                    document.getElementById("loader").style.display = "none";
                    document.getElementById("insideTemp").innerHTML = "<?= $l10n["chart"]["noData"] ?>";
                }
            }
        });
    };
</script>