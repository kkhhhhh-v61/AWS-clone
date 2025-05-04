<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <link href="../css/productDetails.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <title>Blooms Co. | Product Details</title>
    <style>
        .page-header {
            text-align: center;
            margin: 20px 0;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
        }

        .login-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .form-group {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 30px;
        }

        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .login-title {
            color: #333;
            font-size: 24px;
            font-weight: 600;
        }

        .product-div-right {
            padding: 20px;
        }

        .product-brand {
            display: block;
            color: #666;
            font-size: 14px;
            margin-bottom: 8px;
        }

        .product-name {
            display: block;
            color: #333;
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 12px;
        }

        .product-price {
            display: block;
            color: #4CAF50;
            font-size: 20px;
            font-weight: 500;
            margin-bottom: 20px;
        }

        .word {
            color: #333;
            font-size: 16px;
            line-height: 1.6;
            margin-top: 20px;
        }

        .img-container {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
            margin-bottom: 20px;
        }

        .img-container img {
            width: 100%;
            height: auto;
            display: block;
        }
    </style>
</head>

<body>
    <?php
    include '../functions/common_function.php';
    include './header.php';
    include '../config/connect.php';

    // Handle cart addition in this file
    if (isset($_GET['add_to_cart'])) {
        cart(); // Process the cart addition
        // Redirect to product.php after processing
        echo "<script>
            alert('Item successfully added to cart');
            window.location.href = 'product.php';
        </script>";
        exit(); // Stop further execution
    }

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

            <div class="page-header">
                <h1>PRODUCT DETAILS</h1>
            </div>

            <div class="login-container">
                <div class="form-group">

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
                            <span class="product-brand"><?php echo $prodBrand; ?></span>
                            <span class="product-name"><?php echo $prodName; ?></span>
                            <span class="product-price">RM <?php echo $prodPrice; ?></span>
                            <div class="btn-groups">
                                <a href="?add_to_cart=<?php echo $prodID ?>&product_id=<?php echo $prodID ?>&quantity=1" class="add-cart-btn">ADD TO CART</a>
                            </div>

                            <p class="word" style="text-align: justify;"><?php echo $prodDesc; ?></p>
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
            <script src="../javascript/productDetails.js"></script>
            <?php include './footer.php';
            ?>
</body>

</html>