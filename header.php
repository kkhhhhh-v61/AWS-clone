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
        <link href="../css/style.css" rel="stylesheet" type="text/css"/>
        <title>Header</title>
    </head>
    <body>
        <div class="top">
            <a href="#" class="search"><ion-icon name="search-outline"></ion-icon></a>
            <ul><img class="header-pic" src="../images/whitelogo.png" usemap="#home-map">
                <map name="home-map">
                    <area target="" alt="" title="" href="index.php" coords="-1,-1,499,155" shape="rect">
                </map>
            </ul>

            <?php
// Check if the session variable is set
            if (isset($_SESSION['username'])) {
                // if the session variable dont have, show the logout button
                echo "<a href='logout.php' class='account'>Logout</a>";
            } else {
                // if the session variable dont have, show the login button
                echo "<a href='login.php' class='account'>Login</a>";
            }
            ?>



            <a href="cart.php" class="account">𝐂𝐚𝐫𝐭</a>
        </div>

        <nav>
            <a href="index.php">HOME</a>
            <a href="product.php">PRODUCT</a>
            <a href="contact.php">CONTACT US</a>
            <?php
            if (isset($_SESSION['username'])) {
                echo "<a href='accountset.php'>ACCOUNT</a>";
            }
            ?>         
        </nav>
         </body>
</html>

