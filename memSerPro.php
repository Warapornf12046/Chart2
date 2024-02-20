<!DOCTYPE html>
<html>
<head>
    <title>Bar Chart Page</title>
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
    <canvas id="graphCanvas"></canvas>
</div>

<script>
      $(document).ready(function () {
      showGraph();
      });

      function showGraph() {
      $.post("data_memSerPro.php", function (data) {
            console.log(marks);

            var name = ["ใช้บริการ","ซื้อสินค้า"];
            var marks = [0, 0];

            for (var i in data) {
                  marks[0] += data[i].Service_Count;
                  marks[1] += data[i].Product_Count;
            }

            var chartdata = {
                  labels: name,
                  datasets: [
                  {
                        label: 'จำนวนครั้งที่มาใช้บริการและซื้อสินค้า',
                        backgroundColor: ['#FF6384', '#36A2EB'],
                        borderColor: '#BFEA7C',
                        hoverBackgroundColor: ['#FFCF96', '#CDFADB'],
                        hoverBorderColor: '#666666',
                        data: marks
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
