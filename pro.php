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
    <canvas id="graphCanvasPro"></canvas>
</div>

<script>
    $(document).ready(function () {
        showGraph();
    });

    function showGraph() {
        $.post("data_pro.php", function (data) {
            console.log(data);
            var name = ["รำข้าว","แกลบ","ข้าวท่อน","ข้าวปลาย"];
            var marks = [];

            for (var i in data) {
                // name.push(data[i].ServiceProduct_Name);
                marks.push(data[i].countbran); 
                marks.push(data[i].counthusk); 
                marks.push(data[i].countchunks); 
                marks.push(data[i].countbroken); 
            }

            var chartdata = {
                labels: name,
                datasets: [
                    {
                        label: 'Product Counts',
                        backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0'],
                        borderColor: '#BFEA7C',
                        hoverBackgroundColor: '#CDFADB',
                        hoverBorderColor: '#666666',
                        data: marks
                    }
                ]
            };

            var graphTarget = $("#graphCanvasPro");

            var barGraph = new Chart(graphTarget, {
                type: 'pie',
                data: chartdata
            });
        });
    }
</script>
</body>
</html>
