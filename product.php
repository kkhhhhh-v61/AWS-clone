<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Product | Sneaker Vault</title>
        <link href="../css/style.css" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
        <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    </head>
    <body>
        <?php
        include './header.php';
        include './config/connect.php';
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
                ?>
            </div>
        </div>
        <?php include './footer.php';
        ?>
    </body>
</html>
