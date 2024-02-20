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
        $.post("data_memSerPro.php", function (data) {
            console.log(data);
            var name = ["ใช้บริการ","ซื้อสินค้า"];
            var marks = [];

            for (var i in data) {
                marks.push(data[i].Service_Count);
                marks.push(data[i].Product_Count); 
            }

            var chartdata = {
                labels: name,
                datasets: [
                    {
                        label: 'จำนวนครั้งที่มาใช้บริการ',
                        backgroundColor: '#FF6384',
                        borderColor: '#BFEA7C',
                        hoverBackgroundColor: '#FFCF96',
                        hoverBorderColor: '#666666',
                        data: [marks[0], 0] // ใช้บริการเป็นแท่งแรก และให้แท่งซื้อสินค้าเป็น 0
                    },
                    {
                        label: 'จำนวนครั้งที่มาซื้อสินค้า',
                        backgroundColor: '#36A2EB',
                        borderColor: '#BFEA7C',
                        hoverBackgroundColor: '#CDFADB',
                        hoverBorderColor: '#666666',
                        data: [0, marks[1]] // ใช้บริการเป็น 0 และซื้อสินค้าเป็นแท่งที่สอง
                    }
                ]
            };

            var graphTarget = $("#graphCanvasPro");

            var barGraph = new Chart(graphTarget, {
                type: 'bar',
                data: chartdata
            });
        });
    }
</script>
</body>
</html>
