<?php
include '../config/connect.php';

// Get total sales by category
$category_query = "SELECT c.category_title, SUM(od.quantity * p.product_price) as total_sales
                  FROM order_details od
                  JOIN products p ON od.product_id = p.product_id
                  JOIN categories c ON p.category_id = c.category_id
                  GROUP BY c.category_title";
$category_result = mysqli_query($con, $category_query);
$category_count = mysqli_num_rows($category_result);

// Get product sales data
$sales_query = "SELECT p.product_name, SUM(od.quantity) as total_quantity
               FROM order_details od
               JOIN products p ON od.product_id = p.product_id
               GROUP BY p.product_name
               ORDER BY total_quantity DESC
               LIMIT 10";
$sales_result = mysqli_query($con, $sales_query);
$sales_count = mysqli_num_rows($sales_result);


?>

<!DOCTYPE html>
<html>

<head>
    <link href="../css/admin2.css" rel="stylesheet" type="text/css" />
    <link href="../css/tableSort.css" rel="stylesheet" type="text/css" />
    <meta charset="UTF-8">
    <title>Blooms Co. | Analysis</title>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <style>
        .page-header {
            text-align: center;
            margin: 20px 0;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
        }

        .analysis-container {
            margin: 30px auto;
            padding: 20px 40px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            width: 1800px;
            display: flex;
            justify-content: space-between;
        }

        .chart-container {
            flex: 1;
            min-width: 800px;
            max-width: 800px;
            text-align: center;
            padding: 0 20px;
        }
    </style>
</head>

<body>
    <?php
    include './adminheader.php';
    ?>

    <div class="page-header">
        <h1>Analysis</h1>
    </div>

    <div class="container">
        <script type="text/javascript">
            // First Pie Chart - Total Sales by Category
            google.charts.load('current', {
                'packages': ['corechart']
            });
            google.charts.setOnLoadCallback(drawPieChart);

            function drawPieChart() {
                var data = google.visualization.arrayToDataTable([
                    ['Category', 'Total Sales']
                    <?php
                    if ($category_count > 0) {
                        while ($row = mysqli_fetch_assoc($category_result)) {
                            echo ",['" . $row['category_title'] . "', " . $row['total_sales'] . "]";
                        }
                    } else {
                        echo ",['No Data', 0]";
                    }
                    ?>
                ]);

                var options = {
                    backgroundColor: '#f8f9fa',
                    legend: {
                        position: 'right',
                        textStyle: {
                            color: '#333',
                            fontSize: 12
                        }
                    },
                    pieSliceText: 'value',
                    slices: {
                        0: {
                            color: '#4CAF50'
                        },
                        1: {
                            color: '#2196F3'
                        },
                        2: {
                            color: '#FFC107'
                        },
                        3: {
                            color: '#9C27B0'
                        },
                        4: {
                            color: '#FF5722'
                        }
                    }
                };

                var chart = new google.visualization.PieChart(document.getElementById('piechart1'));
                chart.draw(data, options);
            }

            // Histogram - Top 10 Products by Sales Quantity
            google.charts.load("current", {
                packages: ["corechart"]
            });
            google.charts.setOnLoadCallback(drawHistogram);

            function drawHistogram() {
                var data = google.visualization.arrayToDataTable([
                    ['Product', 'Quantity Sold']
                    <?php
                    if ($sales_count > 0) {
                        while ($row = mysqli_fetch_assoc($sales_result)) {
                            echo ",['" . $row['product_name'] . "', " . $row['total_quantity'] . "]";
                        }
                    } else {
                        echo ",['No Data', 0]";
                    }
                    ?>
                ]);

                var options = {
                    backgroundColor: '#f8f9fa',
                    legend: 'none',
                    vAxis: {
                        title: 'Quantity Sold',
                        titleTextStyle: {
                            color: '#333',
                            fontSize: 14
                        },
                        format: '0',
                        gridlines: {
                            count: 10
                        }
                    },
                    hAxis: {
                        title: 'Products',
                        titleTextStyle: {
                            color: '#333',
                            fontSize: 14
                        }
                    },
                    colors: ['#4CAF50', '#2196F3', '#FFC107', '#9C27B0', '#FF5722', '#00BCD4', '#FF9800', '#795548', '#607D8B', '#E91E63']
                };

                var chart = new google.visualization.ColumnChart(document.getElementById('histogram'));
                chart.draw(data, options);
            }
        </script>
    </div>
    <div class="analysis-container">
        <div class="chart-container">
            <h2>Total Sales by Category in Price</h2>
            <?php if ($category_count == 0): ?>
                <p style="text-align: center; padding: 20px; color: #666;">No sales data available for categories.</p>
            <?php else: ?>
                <div id="piechart1" style="width: 800px; height: 550px;"></div>
            <?php endif; ?>
        </div>

        <div class="chart-container">
            <h2>Top 10 Products by Sales Quantity</h2>
            <?php if ($sales_count == 0): ?>
                <p style="text-align: center; padding: 20px; color: #666;">No sales data available for products.</p>
            <?php else: ?>
                <div id="histogram" style="width: 800px; height: 550px;"></div>
            <?php endif; ?>
        </div>


    </div>
    <?php include '../php/footer.php'; ?>
</body>

</html>