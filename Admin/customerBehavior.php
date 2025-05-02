<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>
    <head>
        <link href="../css/adminaccount.css" rel="stylesheet" type="text/css"/>
        <meta charset="UTF-8">
        <title>Customer Behavior Analysis | Eversummer Florist</title>
    </head>
    <body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" style="text-align: center;">
        <?php include './adminheader.php'; ?>

        <div class="tittle">
            <p>Home/Admin/</p></br>
            <p class="bold"><b>CUSTOMER BEHAVIOR ANALYSIS</b></p>
        </div>


        <div style="text-align: center;">
            <table id="table-01" style="border: 0;" cellpadding="0" cellspacing="0">
                <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                <script type="text/javascript">
                    google.charts.load('current', {'packages': ['corechart']});
                    google.charts.setOnLoadCallback(drawChart);

                    function drawChart() {
                        var data = google.visualization.arrayToDataTable([
                            ['Total Sales', 'Month per Year'],
                            ['Caps', 250],
                            ['Clothes', 275],
                            ['Pants', 300],
                            ['Sneakers', 400],
                            ['Shorts', 700]
                        ]);

                        var options = {
                            title: 'Eversummer Florist Total Sales'
                        };

                        var chart = new google.visualization.PieChart(document.getElementById('piechart'));
                        chart.draw(data, options);
                    }
                </script>
                <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                <script type="text/javascript">
                    google.charts.load("current", {packages: ["corechart"]});
                    google.charts.setOnLoadCallback(drawChart);
                    function drawChart() {
                        var data = google.visualization.arrayToDataTable([
                            ['Dinosaur', 'Length'],
                            ['Acrocanthosaurus (top-spined lizard)', 12.2],
                            ['Albertosaurus (Alberta lizard)', 9.1],
                            ['Allosaurus (other lizard)', 12.2],
                            ['Apatosaurus (deceptive lizard)', 22.9],
                            ['Archaeopteryx (ancient wing)', 0.9],
                            ['Argentinosaurus (Argentina lizard)', 36.6],
                            ['Baryonyx (heavy claws)', 9.1],
                            ['Brachiosaurus (arm lizard)', 30.5],
                            ['Ceratosaurus (horned lizard)', 6.1],
                            ['Coelophysis (hollow form)', 2.7],
                            ['Compsognathus (elegant jaw)', 0.9],
                            ['Deinonychus (terrible claw)', 2.7],
                            ['Diplodocus (double beam)', 27.1],
                            ['Dromicelomimus (emu mimic)', 3.4],
                            ['Gallimimus (fowl mimic)', 5.5],
                            ['Mamenchisaurus (Mamenchi lizard)', 21.0],
                            ['Megalosaurus (big lizard)', 7.9],
                            ['Microvenator (small hunter)', 1.2],
                            ['Ornithomimus (bird mimic)', 4.6],
                            ['Oviraptor (egg robber)', 1.5],
                            ['Plateosaurus (flat lizard)', 7.9],
                            ['Sauronithoides (narrow-clawed lizard)', 2.0],
                            ['Seismosaurus (tremor lizard)', 45.7],
                            ['Spinosaurus (spiny lizard)', 12.2],
                            ['Supersaurus (super lizard)', 30.5],
                            ['Tyrannosaurus (tyrant lizard)', 15.2],
                            ['Ultrasaurus (ultra lizard)', 30.5],
                            ['Velociraptor (swift robber)', 1.8]]);

                        var options = {
                            title: 'Lengths of dinosaurs, in meters',
                            legend: {position: 'none'},
                        };

                        var chart = new google.visualization.Histogram(document.getElementById('chart_div'));
                        chart.draw(data, options);
                    }
                </script> 
            </table>
        </div> 
    <center><div id="piechart" style="width: 900px; height: 500px;"></div></center>
</body>
</html>
