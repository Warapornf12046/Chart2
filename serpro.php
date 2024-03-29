<!DOCTYPE html>
<html>
<head>
    <title>Bar Chart Page</title>
    <style type="text/css">
        BODY {
            width: 550px; /* ปรับให้เป็นตัวพิมพ์เล็ก */
        }

        #chart-container {
            width: 100%;
            height: auto;
        }
    </style>
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/Chart.min.js"></script>
</head>
<body>
<div id="chart-container">
    <canvas id="graphCanvas"></canvas>
</div>

<script>
$(document).ready(function () {
    showGraph();
});

function showGraph() {
    $.when(
        $.post("data_pro.php"),
        $.post("data_ser.php")
    ).done(function (dataPro, dataSer) {
        console.log(dataPro);
        console.log(dataSer);

        var name = ["มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"];

        var marks1 = [];
        var marks2 = [];

        for (var i in dataPro[0]) {
            marks1.push(dataPro[0][i]);
        }

        for (var i in dataSer[0]) {
            marks2.push(dataSer[0][i].Usage_Count);
        }

        var chartdata = {
            labels: name,
            datasets: [
                {
                    label: 'Product Counts',
                    backgroundColor: '#FF6384',
                    borderColor: '#BFEA7C',
                    hoverBackgroundColor: '#FFCF96',
                    hoverBorderColor: '#666666',
                    data: marks1
                },
                {
                    label: 'Service Counts',
                    backgroundColor: '#36A2EB',
                    borderColor: '#BFEA7C',
                    hoverBackgroundColor: '#CDFADB',
                    hoverBorderColor: '#666666',
                    data: marks2
                }
            ]
        };

        var graphTarget = $("#graphCanvas");

        var barGraph = new Chart(graphTarget, {
            type: 'bar',
            data: chartdata,
            options: {
                scales: {
                    xAxes: [{
                        stacked: false
                    }],
                    yAxes: [{
                        stacked: false,
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    });
}
</script>
</body>
</html>
