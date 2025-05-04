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
    <link rel="stylesheet" href="../css/adminheader.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
    <script src="https://unpkg.com/ionicons@5.0.0/dist/ionicons.js"></script>
</head>

<body>
    <header class="site-header">
        <div class="top">
            <div class="spacer"></div>
            <div class="logo-container">
                <?php
                $redirectUrl = isset($_SESSION['admin_id']) ? './adminaccount.php' : './adminlogin.php';
                ?>
                <a href="<?php echo $redirectUrl; ?>" class="logo-link">
                    <img class="header-pic" src="../images/whitelogo.png" alt="Logo" usemap="#home-map">
                    <map name="home-map">
                        <area target="" alt="" title="" href="<?php echo $redirectUrl; ?>" coords="-1,-1,499,155" shape="rect">
                    </map>
                </a>
            </div>
            <div class="account-container">
                <?php
                // Authentication status check
                if (isset($_SESSION['admin_id'])) {
                    echo "<a href='./adminlogout.php' class='account'><ion-icon name='log-out-outline'></ion-icon></a>";
                }
                ?>
            </div>
        </div>

        <nav class="main-nav">
            <?php
            if (isset($_SESSION['admin_id'])) {
                echo "<a href='adminaccount.php'>ACCOUNTS</a>
                      <a href='adminproduct.php'>PRODUCTS</a>
                      <a href='insertCategory.php'>CATEGORIES</a>
                      <a href='insertBrands.php'>BRANDS</a>
                      <a href='viewpayment.php'>PAYMENTS</a>
                      <a href='analysis.php'>ANALYSIS</a>";
            }
            ?>
        </nav>
    </header>
</body>

</html>