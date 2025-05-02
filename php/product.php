<!DOCTYPE html>

<html>

<head>
    <meta charset="UTF-8">
    <title>Product | Sneaker Vault</title>
    <link href="../css/style.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <style>
        .error-message {
            padding: 20px;
            background-color: #ffdddd;
            border: 1px solid #ff0000;
            border-radius: 5px;
            margin: 20px auto;
            width: 80%;
            max-width: 600px;
            text-align: center;
            color: #ff0000;
            font-weight: bold;
        }

        .no-products-message {
            padding: 40px;
            background-color: #f0f0f0;
            border: 1px solid #ddd;
            border-radius: 10px;
            margin: 40px auto;
            width: 80%;
            max-width: 600px;
            text-align: center;
            font-size: 1.2em;
            color: #666;
        }

        .no-products-message p {
            margin: 15px 0;
        }
    </style>
</head>

<body>
    <?php
    include './header.php';
    include '../config/connect.php';
    ?>

    <div class="pageContent">
        <p>Home/Collections/</p></br>
        <p class="bold"><b>PRODUCT</b></p>
    </div>

    <div class="product-list-container">
        <div class="product-list">

            <!--Fetching products-->
            <?php
            $select_query = "SELECT p.product_id, p.product_name, p.product_price, p.product_image1, p.category_id, p.brand_id, b.brand_title 
    FROM products p 
    JOIN brands b ON p.brand_id = b.brand_id 
    ORDER BY RAND()";

            $result_query = mysqli_query($con, $select_query);

            if (!$result_query) {
                echo "<div class='error-message'>Error fetching products: " . mysqli_error($con) . "</div>";
            } else if (mysqli_num_rows($result_query) == 0) {
                echo "<div class='no-products-message'>
                    <p>No products are currently available.</p>
                    <p>Please check back later for new arrivals!</p>
                </div>";
            } else {
                while ($row = mysqli_fetch_assoc($result_query)) {
                    $prodID = $row['product_id'];
                    $prodName = $row['product_name'];
                    $prodPrice = $row['product_price'];
                    $prodPic1 = $row['product_image1'];
                    $prodCat = $row['category_id'];
                    $prodBrand = $row['brand_title'];
                    echo "
        <div class='product'>
            <a href='productDetails.php?product_id=$prodID'>
                <img class='product-list-pic' src='../Admin/product_images/$prodPic1' usemap='#prod$prodID-map'>
            </a>

            <map name='prod$prodID-map'>
                <area href='productDetails.php?product_id=$prodID' coords='0,1,997,999' shape='rect'>
            </map>

            <p class='product-list-name'>$prodName</p>
            <p class='product-list-brand'>$prodBrand</p>
            <p class='product-list-price'>RM $prodPrice</p>
        </div>";
                }
            }
            ?>
        </div>
    </div>
    <?php include './footer.php';
    ?>
</body>

</html>