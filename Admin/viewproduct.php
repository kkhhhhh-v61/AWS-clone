<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <link href="../css/admin.css" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
        <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
        <title>Edit Products | Eversummer Florist</title>
    </head>
    <body>
        <?php
        include './adminheader.php';
        include '../config/connect.php';

// check if a search query was submitted
        if (isset($_GET['search'])) {
            $search_query = $_GET['search'];
            // add the search query to the SQL query as a WHERE clause
            $get_products = "SELECT * FROM products WHERE product_name LIKE '%$search_query%'";
        } else {
            // if no search query was submitted, retrieve all products
            $get_products = "SELECT * FROM products";
        }

        $result = mysqli_query($con, $get_products);
        $number = 0;
        ?>

        <div class="search-container">
            <form method="GET">
                <center><input type="text" placeholder="Search by Product Name" name="search">
                    <button class="searchBtn" type="submit"><ion-icon class="search-outline" name="search-outline"></ion-icon></button></center>
            </form>
        </div>

        <div class="product-display">
            <table class="product-display-table">
                <thead>
                    <tr>
                        <td>No</td>
                        <td>Product Image</td>
                        <td>Product Name</td>
                        <td>Price</td>
                        <td>Action</td>
                    </tr>
                </thead>
                <?php
                while ($row = mysqli_fetch_assoc($result)) {
                    $product_id = $row['product_id'];
                    $product_image1 = $row['product_image1'];
                    $product_name = $row['product_name'];
                    $product_price = $row['product_price'];
                    $number++;
                    ?>
                    <tr>
                        <td><?php echo $number ?></td>
                        <td><img src='../Admin/product_images/<?php echo $product_image1 ?>' width='150px' height='150px'/></td>
                        <td><?php echo $product_name ?></td>
                        <td>RM <?php echo $product_price ?></td>
                        <td><a class='btn' href='editproduct.php?id=<?php echo $product_id ?>'>Edit</a>
                            <a class='btn' href='#' onclick='showConfirmation(<?php echo $product_id ?>)'>Delete</a>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </div>

        <script>
            function showConfirmation(productId) {
                if (confirm("Are you sure you want to delete this product?")) {
                    // if the user clicks "OK" in the confirmation pop-up, redirect to the delete product page
                    window.location.href = "deleteproduct.php?id=" + productId;
                } else {
                    // if the user clicks "Cancel" in the confirmation pop-up, do nothing
                }
            }
        </script>

</html>
