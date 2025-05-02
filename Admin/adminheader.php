<?php
@session_start();
?>
<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <link href="../css/adminheader.css" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
        <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
        <title>Header</title>
    </head>
    <body>
        <div class="top">
            <ul><img class="header-pic" src="../images/whitelogo.png" usemap="#home-map">
                <map name="home-map">
                    <area target="" alt="" title="" href="adminaccount.php" coords="-1,-1,499,155" shape="rect">
                </map>
            </ul>

            <?php
// Check if the session variable is set
            if (isset($_SESSION['admin_id'])) {
                // if the session variable dont have, show the logout button
                echo "<a href='logoutadmin.php' class='account'><ion-icon name='log-out-outline'></ion-icon></a>";
            } else {
                // if the session variable dont have, show the login button
                echo "<a href='adminlogin.php' class='account'><ion-icon name='log-in-outline'></ion-icon></a>";
            }
            ?>

        </div>

        <nav>
            <?php
            if (isset($_SESSION['admin_id'])) {
                echo "  <a href='adminaccount.php'><ion-icon name='person-circle-outline'></ion-icon>USERS ACCOUNT</a></br>
            <a href='adminproduct.php'><ion-icon name='pricetags-outline'></ion-icon>PRODUCT</a>
            <a href='insertCategory.php'><ion-icon name='apps-outline'></ion-icon>CATEGORIES</a>
            <a href='insertBrands.php'><ion-icon name='bookmark-outline'></ion-icon>BRANDS</a>
            <a href='viewpayment.php'><ion-icon name='cash-outline'></ion-icon>PAYMENT</a>
            <a href='customerBehavior.php'><ion-icon name='analytics-outline'></ion-icon>ANALYSIS</a>
            <a href='histogram.php'><ion-icon name='bar-chart-outline'></ion-icon>HISTOGRAM</a>";
            }
            ?>         
        </nav>
         </body>
</html>

