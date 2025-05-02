<!DOCTYPE html>

<html>

<head>
    <meta charset="UTF-8">
    <link href="../css/admin.css" rel="stylesheet" type="text/css" />
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
        $get_products = "SELECT p.*, c.category_title, b.brand_title 
                        FROM products p 
                        JOIN categories c ON p.category_id = c.category_id 
                        JOIN brands b ON p.brand_id = b.brand_id 
                        WHERE p.product_name LIKE '%$search_query%' 
                        ORDER BY p.date DESC";
    } else {
        // if no search query was submitted, retrieve all products
        $get_products = "SELECT p.*, c.category_title, b.brand_title 
                        FROM products p 
                        JOIN categories c ON p.category_id = c.category_id 
                        JOIN brands b ON p.brand_id = b.brand_id 
                        ORDER BY p.date DESC";
    }

    $result = mysqli_query($con, $get_products);
    $number = 0;
    ?>

    <div class="search-container">
        <form method="GET">
            <center><input type="text" placeholder="Search by Product Name" name="search">
                <button class="searchBtn" type="submit"><ion-icon class="search-outline" name="search-outline"></ion-icon></button>
            </center>
        </form>
    </div>

    <div class="product-display">
        <table class="product-display-table">
            <thead>
                <tr>
                    <td>No</td>
                    <td>Product Name</td>
                    <td>Price</td>
                    <td>Description</td>
                    <td>Keywords</td>
                    <td>Category</td>
                    <td>Brand</td>
                    <td>Action</td>
                </tr>
            </thead>
            <?php
            while ($row = mysqli_fetch_assoc($result)) {
                $product_id = $row['product_id'];
                $product_name = $row['product_name'];
                $product_price = $row['product_price'];
                $product_description = $row['product_description'];
                $product_keywords = $row['product_keywords'];
                $category_title = $row['category_title'];
                $brand_title = $row['brand_title'];
                $number++;
            ?>
                <tr>
                    <td><?php echo $number ?></td>
                    <td><?php echo $product_name ?></td>
                    <td>RM <?php echo $product_price ?></td>
                    <td><?php echo $product_description ?></td>
                    <td><?php echo $product_keywords ?></td>
                    <td><?php echo $category_title ?></td>
                    <td><?php echo $brand_title ?></td>
                    <td>
                        <a class='btn' href='editproduct.php?id=<?php echo $product_id ?>'>Edit</a>
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