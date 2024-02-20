<!DOCTYPE html>
<html>
<head>
    <title>Bar Chart Page</title>
    <style type="text/css">
        BODY {
            width: 550px;
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

<form id="selectForm">
    <label for="year">Select Year:</label>
    <select id="year" name="year">
        <?php
        // Generate options for years, assuming from 2000 to current year
        $currentYear = date("Y");
        for ($i = 2022; $i <= $currentYear; $i++) {
            echo "<option value='$i'>$i</option>";
        }
        ?>
    </select>
    <label for="month">Select Month:</label>
    <select id="month" name="month">
        <?php
        // Generate options for months
        $months = array(
            1 => "January", 2 => "February", 3 => "March", 4 => "April",
            5 => "May", 6 => "June", 7 => "July", 8 => "August",
            9 => "September", 10 => "October", 11 => "November", 12 => "December"
        );
        foreach ($months as $key => $value) {
            echo "<option value='$key'>$value</option>";
        }
        ?>
    </select>
    <input type="submit" value="Submit">
</form>

    <script>
        $(document).ready(function () {
            // Show graph initially
            showGraph();
        });

        function showGraph() {
            // Get selected year and month
            var year = $("#year").val();
            var month = $("#month").val();

            // Send AJAX request to retrieve data
            $.when(
                $.post("data_pro2.php", { year: year, month: month }),
                $.post("data_ser2.php", { year: year, month: month })
            ).done(function (dataPro, dataSer) {
                // Process data and create chart
                var datasets = [];
                var labels = [];

                // Process product data
                dataPro[0].forEach(function (item) {
                    datasets.push({
                        label: 'Product Counts (' + item.ServiceProduct_Name + ')',
                        backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0'],
                        borderColor: '#BFEA7C',
                        hoverBackgroundColor: '#CDFADB',
                        hoverBorderColor: '#666666',
                        data: [item.Total_Order]
                    });
                    labels.push(item.ServiceProduct_Name);
                });

                // Process service data
                dataSer[0].forEach(function (item) {
                    datasets.push({
                        label: 'Service Counts (' + item.ServiceProduct_Name + ')',
                        backgroundColor: ['#9966FF', '#FFBE98', '#B7C9F2', '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0'],
                        borderColor: '#BFEA7C',
                        hoverBackgroundColor: '#CDFADB',
                        hoverBorderColor: '#666666',
                        data: [item.Usage_Count]
                    });
                    labels.push(item.ServiceProduct_Name);
                });

                var chartdata = {
                    labels: labels,
                    datasets: datasets
                };

                var graphTarget = $("#graphCanvas");

                // Ensure the canvas is empty before drawing
                graphTarget.empty();

                var barGraph = new Chart(graphTarget, {
                    type: 'bar',
                    data: chartdata,
                    options: {
                        scales: {
                            xAxes: [{
                                stacked: true
                            }],
                            yAxes: [{
                                stacked: true,
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
