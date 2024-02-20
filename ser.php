<?php include('include/config.php'); ?>

<!DOCTYPE html>
<html>
<head>
    <title>Piechart Page</title>
    <style type="text/css">
        BODY {
            width: 550PX;
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
    <canvas id="graphCanvasSer"></canvas>
</div>

<script>
    $(document).ready(function () {
        showGraph();
    });

    function showGraph() {
        $.post("data_ser.php", function (data) {
            console.log(data);
            var name = [];
            var marks = [];

            for (var i in data) {
                name.push(data[i].ServiceProduct_Name);
                marks.push(data[i].Usage_Count); // แก้ไขจาก TotalService เป็น Usage_Count
            }

            var chartdata = {
                labels: name,
                datasets: [
                    {
                        label: 'Service Counts',
                        backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FFBE98','#B7C9F2'],
                        borderColor: '#BFEA7C',
                        hoverBackgroundColor: '#CDFADB',
                        hoverBorderColor: '#666666',
                        data: marks
                    }
                ]
            };

            var graphTarget = $("#graphCanvasSer");

            var barGraph = new Chart(graphTarget, {
                type: 'pie',
                data: chartdata
            });
        });
    }
</script>
</body>
</html>
