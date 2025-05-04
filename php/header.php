<?php
// Start session and include configuration
@session_start();
require_once '../config/connect.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="../css/_variables.css">
    <link rel="stylesheet" href="../css/style.css">
    <script src="https://unpkg.com/ionicons@5.0.0/dist/ionicons.js"></script>
</head>
<body>
    <header class="site-header">
        <div class="top">
            <div class="spacer"></div>
            <div class="logo-container">
                <a href="./homepage.php" class="logo-link">
                    <img class="header-pic" src="../images/whitelogo.png" alt="Logo" usemap="#home-map">
                    <map name="home-map">
                        <area target="" alt="" title="" href="./homepage.php" coords="-1,-1,499,155" shape="rect">
                    </map>
                </a>
            </div>
            <div class="account-container">
                <?php
                // Authentication status check
                if (isset($_SESSION['user_id'])) {
                    echo "<a href='./logout.php' class='account'><ion-icon name='log-out-outline'></ion-icon></a>";
                } else {
                    echo "<a href='./login.php' class='account'><ion-icon name='log-in-outline'></ion-icon></a>";
                }
                ?>
                <a href="./cart.php" class="account"><ion-icon name="cart-outline"></ion-icon></a>
            </div>
        </div>

        <nav class="main-nav">
            <a href="./homepage.php">HOME</a>
            <a href="./product.php">PRODUCT</a>
            <a href="./contact.php">CONTACT US</a>
            <?php
            if (isset($_SESSION['user_id'])) {
                echo "<a href='./accountset.php'>ACCOUNT</a>";
                echo "<a href='./orderHistory.php'>ORDER HISTORY</a>";
            }
            ?>
        </nav>
    </header>
</body>
</html>