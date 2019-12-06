<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

<div id="container1"></div>
<div id="container2"></div>

<?php
    echo "Teste";
?>

<script src="../recursos/js/jquery-3.4.1.min.js"></script>
<script src="../recursos/Highcharts-7.2.1/code/highcharts.js"></script>

<script type="text/javascript">
$(function() {
    var colors = Highcharts.getOptions().colors,
    categories = [
        'Chrome',
        'Firefox',
        'Internet Explorer',
        'Safari',
        'Edge',
        'Opera',
        'Other'
    ],
    data = [
        {
            y: 62.74,
            color: colors[2],
            drilldown: {
                name: 'Chrome',
                categories: [
                    'Chrome v65.0',
                    'Chrome v64.0',
                    'Chrome v63.0',
                    'Chrome v62.0',
                    'Chrome v61.0',
                    'Chrome v60.0',
                    'Chrome v59.0',
                    'Chrome v58.0',
                    'Chrome v57.0',
                    'Chrome v56.0',
                    'Chrome v55.0',
                    'Chrome v54.0',
                    'Chrome v51.0',
                    'Chrome v49.0',
                    'Chrome v48.0',
                    'Chrome v47.0',
                    'Chrome v43.0',
                    'Chrome v29.0'
                ],
                data: [
                    0.1,
                    1.3,
                    53.02,
                    1.4,
                    0.88,
                    0.56,
                    0.45,
                    0.49,
                    0.32,
                    0.29,
                    0.79,
                    0.18,
                    0.13,
                    2.16,
                    0.13,
                    0.11,
                    0.17,
                    0.26
                ]
            }
        },
        {
            y: 10.57,
            color: colors[1],
            drilldown: {
                name: 'Firefox',
                categories: [
                    'Firefox v58.0',
                    'Firefox v57.0',
                    'Firefox v56.0',
                    'Firefox v55.0',
                    'Firefox v54.0',
                    'Firefox v52.0',
                    'Firefox v51.0',
                    'Firefox v50.0',
                    'Firefox v48.0',
                    'Firefox v47.0'
                ],
                data: [
                    1.02,
                    7.36,
                    0.35,
                    0.11,
                    0.1,
                    0.95,
                    0.15,
                    0.1,
                    0.31,
                    0.12
                ]
            }
        },
        {
            y: 7.23,
            color: colors[0],
            drilldown: {
                name: 'Internet Explorer',
                categories: [
                    'Internet Explorer v11.0',
                    'Internet Explorer v10.0',
                    'Internet Explorer v9.0',
                    'Internet Explorer v8.0'
                ],
                data: [
                    6.2,
                    0.29,
                    0.27,
                    0.47
                ]
            }
        },
        {
            y: 5.58,
            color: colors[3],
            drilldown: {
                name: 'Safari',
                categories: [
                    'Safari v11.0',
                    'Safari v10.1',
                    'Safari v10.0',
                    'Safari v9.1',
                    'Safari v9.0',
                    'Safari v5.1'
                ],
                data: [
                    3.39,
                    0.96,
                    0.36,
                    0.54,
                    0.13,
                    0.2
                ]
            }
        },
        {
            y: 4.02,
            color: colors[5],
            drilldown: {
                name: 'Edge',
                categories: [
                    'Edge v16',
                    'Edge v15',
                    'Edge v14',
                    'Edge v13'
                ],
                data: [
                    2.6,
                    0.92,
                    0.4,
                    0.1
                ]
            }
        },
        {
            y: 1.92,
            color: colors[4],
            drilldown: {
                name: 'Opera',
                categories: [
                    'Opera v50.0',
                    'Opera v49.0',
                    'Opera v12.1'
                ],
                data: [
                    0.96,
                    0.82,
                    0.14
                ]
            }
        },
        {
            y: 7.62,
            color: colors[6],
            drilldown: {
                name: 'Other',
                categories: [
                    'Other'
                ],
                data: [
                    7.62
                ]
            }
        }
    ],
    browserData = [],
    versionsData = [],
    i,
    j,
    dataLen = data.length,
    drillDataLen,
    brightness;


    // Build the data arrays
    for (i = 0; i < dataLen; i += 1) {

        // add browser data
        browserData.push({
            name: categories[i],
            y: data[i].y,
            color: data[i].color
        });

        // add version data
        drillDataLen = data[i].drilldown.data.length;
        for (j = 0; j < drillDataLen; j += 1) {
            brightness = 0.2 - (j / drillDataLen) / 5;
            versionsData.push({
                name: data[i].drilldown.categories[j],
                y: data[i].drilldown.data[j],
                color: Highcharts.Color(data[i].color).brighten(brightness).get()
            });
        }
    }

    // Create the chart
    Highcharts.chart('container1', {
        chart: {
            type: 'pie'
        },
        title: {
            text: 'Browser market share, January, 2018'
        },
        subtitle: {
            text: 'Source: <a href="http://statcounter.com" target="_blank">statcounter.com</a>'
        },
        plotOptions: {
            pie: {
                shadow: false,
                center: ['50%', '50%']
            }
        },
        tooltip: {
            valueSuffix: '%'
        },
        series: [{
            name: 'Browsers',
            data: browserData,
            size: '60%',
            dataLabels: {
                formatter: function () {
                    return this.y > 5 ? this.point.name : null;
                },
                color: '#ffffff',
                distance: -30
            }
        }, {
            name: 'Versions',
            data: versionsData,
            size: '80%',
            innerSize: '60%',
            dataLabels: {
                formatter: function () {
                    // display only if larger than 1
                    return this.y > 1 ? '<b>' + this.point.name + ':</b> ' +
                        this.y + '%' : null;
                }
            },
            id: 'versions'
        }],
        responsive: {
            rules: [{
                condition: {
                    maxWidth: 400
                },
                chartOptions: {
                    series: [{
                    }, {
                        id: 'versions',
                        dataLabels: {
                            enabled: false
                        }
                    }]
                }
            }]
        }
    });

    //----drilldown
    // Create the chart
    Highcharts.chart('container2', {
    chart: {
        type: 'pie'
    },
    title: {
        text: 'Browser market shares. January, 2018'
    },
    subtitle: {
        text: 'Click the slices to view versions. Source: <a href="http://statcounter.com" target="_blank">statcounter.com</a>'
    },
    plotOptions: {
        series: {
            dataLabels: {
                enabled: true,
                format: '{point.name}: {point.y:.1f}%'
            }
        }
    },

    tooltip: {
        headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
        pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> of total<br/>'
    },

    series: [
        {
            name: "Browsers",
            colorByPoint: true,
            data: [
                {
                    name: "Chrome",
                    y: 62.74,
                    drilldown: "Chrome"
                },
                {
                    name: "Firefox",
                    y: 10.57,
                    drilldown: "Firefox"
                },
                {
                    name: "Internet Explorer",
                    y: 7.23,
                    drilldown: "Internet Explorer"
                },
                {
                    name: "Safari",
                    y: 5.58,
                    drilldown: "Safari"
                },
                {
                    name: "Edge",
                    y: 4.02,
                    drilldown: "Edge"
                },
                {
                    name: "Opera",
                    y: 1.92,
                    drilldown: "Opera"
                },
                {
                    name: "Other",
                    y: 7.62,
                    drilldown: null
                }
            ]
        }
    ],
    drilldown: {
        series: [
            {
                name: "Chrome",
                id: "Chrome",
                data: [
                    [
                        "v65.0",
                        0.1
                    ],
                    [
                        "v64.0",
                        1.3
                    ],
                    [
                        "v63.0",
                        53.02
                    ],
                    [
                        "v62.0",
                        1.4
                    ],
                    [
                        "v61.0",
                        0.88
                    ],
                    [
                        "v60.0",
                        0.56
                    ],
                    [
                        "v59.0",
                        0.45
                    ],
                    [
                        "v58.0",
                        0.49
                    ],
                    [
                        "v57.0",
                        0.32
                    ],
                    [
                        "v56.0",
                        0.29
                    ],
                    [
                        "v55.0",
                        0.79
                    ],
                    [
                        "v54.0",
                        0.18
                    ],
                    [
                        "v51.0",
                        0.13
                    ],
                    [
                        "v49.0",
                        2.16
                    ],
                    [
                        "v48.0",
                        0.13
                    ],
                    [
                        "v47.0",
                        0.11
                    ],
                    [
                        "v43.0",
                        0.17
                    ],
                    [
                        "v29.0",
                        0.26
                    ]
                ]
            },
            {
                name: "Firefox",
                id: "Firefox",
                data: [
                    [
                        "v58.0",
                        1.02
                    ],
                    [
                        "v57.0",
                        7.36
                    ],
                    [
                        "v56.0",
                        0.35
                    ],
                    [
                        "v55.0",
                        0.11
                    ],
                    [
                        "v54.0",
                        0.1
                    ],
                    [
                        "v52.0",
                        0.95
                    ],
                    [
                        "v51.0",
                        0.15
                    ],
                    [
                        "v50.0",
                        0.1
                    ],
                    [
                        "v48.0",
                        0.31
                    ],
                    [
                        "v47.0",
                        0.12
                    ]
                ]
            },
            {
                name: "Internet Explorer",
                id: "Internet Explorer",
                data: [
                    [
                        "v11.0",
                        6.2
                    ],
                    [
                        "v10.0",
                        0.29
                    ],
                    [
                        "v9.0",
                        0.27
                    ],
                    [
                        "v8.0",
                        0.47
                    ]
                ]
            },
            {
                name: "Safari",
                id: "Safari",
                data: [
                    [
                        "v11.0",
                        3.39
                    ],
                    [
                        "v10.1",
                        0.96
                    ],
                    [
                        "v10.0",
                        0.36
                    ],
                    [
                        "v9.1",
                        0.54
                    ],
                    [
                        "v9.0",
                        0.13
                    ],
                    [
                        "v5.1",
                        0.2
                    ]
                ]
            },
            {
                name: "Edge",
                id: "Edge",
                data: [
                    [
                        "v16",
                        2.6
                    ],
                    [
                        "v15",
                        0.92
                    ],
                    [
                        "v14",
                        0.4
                    ],
                    [
                        "v13",
                        0.1
                    ]
                ]
            },
            {
                name: "Opera",
                id: "Opera",
                data: [
                    [
                        "v50.0",
                        0.96
                    ],
                    [
                        "v49.0",
                        0.82
                    ],
                    [
                        "v12.1",
                        0.14
                    ]
                ]
            }
        ]
    }
});
});
</script>

</body>
</html>


