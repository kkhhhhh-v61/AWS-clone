<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>
    <head>
        <link href="../css/adminaccount.css" rel="stylesheet" type="text/css"/>
        <meta charset="UTF-8">
        <title>Histogram | Eversummer Florist</title>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Total Sales of Products', 'Quantity Of Sold'],
          ['Caps', 250],
          ['Clothes', 275],
          ['Pants', 300],
          ['Sneakers', 400],
          ['Shorts', 700]
          ]);

        var options = {
          title: 'Sneaker Vault Total Sales',
          legend: { position: 'none' },
        };

        var chart = new google.visualization.Histogram(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script> 
    </head>
    <body>
        <?php include './adminheader.php'; ?>

        <div class="tittle">
            <p>Home/Admin/</p></br>
            <p class="bold"><b>HISTOGRAM</b></p>
        </div>
    <center><div id="chart_div" style="width: 900px; height: 500px;"></div></center>
</body>
</html>
