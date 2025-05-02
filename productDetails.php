<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <link href="../css/productDetails.css" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
        <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
        <title>Product Details</title>
    </head>
    <body>
        <?php
        include './header.php';
        include 'config/connect.php';
        include 'functions/common_function.php';
        cart();

        // check if the 'product_id' key exists in the $_GET array
        if (isset($_GET['product_id'])) {
            $id = $_GET['product_id'];

            // fetch the details of the product from the database
            $select_query = "SELECT p.product_id, p.product_name, p.product_description, p.product_price, p.product_image1, p.product_image2, p.product_image3, p.category_id, p.brand_id, b.brand_title 
        FROM products p 
        JOIN brands b ON p.brand_id = b.brand_id
        WHERE p.product_id = '$id'";

            $result_query = mysqli_query($con, $select_query);

            // check if the query was successful and there is at least one row returned
            if (mysqli_num_rows($result_query) > 0) {
                $row = mysqli_fetch_assoc($result_query);
                $prodID = $row['product_id'];
                $prodName = $row['product_name'];
                $prodDesc = $row['product_description'];
                $prodPrice = $row['product_price'];
                $prodPic1 = $row['product_image1'];
                $prodPic2 = $row['product_image2'];
                $prodPic3 = $row['product_image3'];
                $prodCat = $row['category_id'];
                $prodBrand = $row['brand_title'];
                ?>

                <div class="main-wrapper">
                    <div class="container">
                        <div class="product-div">
                            <div class="product-div-left">
                                <div class="img-container">
                                    <img src="../Admin/product_images/<?php echo $row['product_image1']; ?>">
                                </div>
                                <div class="hover-container">
                                    <div>
                                        <img src="../Admin/product_images/<?php echo $row['product_image1']; ?>">
                                    </div>
                                    <div>
                                        <img src="../Admin/product_images/<?php echo $row['product_image2']; ?>">
                                    </div>
                                    <div>
                                        <img src="../Admin/product_images/<?php echo $row['product_image3']; ?>">
                                    </div>
                                </div>
                            </div>

                            <!-- display the product details using the fetched data -->
                            <div class="product-div-right">
                                <span class="product-home">Home /</span>
                                <span class="product-brand"><?php echo $prodBrand; ?></span>
                                <span class="product-name"><?php echo $prodName; ?></span>
                                <span class="product-price">RM <?php echo $prodPrice; ?></span>
                                <div class="btn-groups">
                                    <a href="productDetails.php?add_to_cart=<?php echo $prodID ?>&product_id=<?php echo $prodID ?>" class="add-cart-btn">ADD TO CART</a>
                                </div>

                                <p class="word"><?php echo $prodDesc; ?></p>
                            </div>
                            <?php
                        } else {
                            echo "No product found with ID: $id";
                        }
                    } else {
                        echo "Product ID not provided in URL";
                    }
                    ?>
                </div>
            </div>
        </div>
        <script src = "../javascript/productDetails.js"></script>
        <?php include './footer.php';
        ?>
    </body>
</html>

