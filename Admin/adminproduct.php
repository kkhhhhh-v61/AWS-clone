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
        <title>Add New Products | Eversummer Florist</title>
    </head>
    <body>
        <?php
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
        include './adminheader.php';
	include 'helper.php';
        include '../config/connect.php';

        if (isset($_POST['insert_product'])) {
            //mysqli_real_escape_string to escape any special characters in the values before inserting them into the database.
            $product_name = mysqli_real_escape_string($con, $_POST['prodName']);
            $prodDesc = mysqli_real_escape_string($con, $_POST['prodDesc']);
            $prodPrice = mysqli_real_escape_string($con, $_POST['prodPrice']);
            $prodKey = mysqli_real_escape_string($con, $_POST['prodKey']);
            $prodCat = mysqli_real_escape_string($con, $_POST['prodCat']);
            $prodBrand = mysqli_real_escape_string($con, $_POST['prodBrand']);
            $prodSta = 'true';

            //accessing images
            $prodPic1 = $_FILES['prodPic1']['name'];
            $prodPic2 = $_FILES['prodPic2']['name'];
            $prodPic3 = $_FILES['prodPic3']['name'];

            //accessing image temporary name
            $tempPic1 = $_FILES['prodPic1']['tmp_name'];
            $tempPic2 = $_FILES['prodPic2']['tmp_name'];
            $tempPic3 = $_FILES['prodPic3']['tmp_name'];

            //checking empty condition
            if ($product_name == '' or $prodDesc == '' or $prodPrice == '' or $prodKey == '' or $prodCat == '' or $prodBrand == '' or $prodPic1 == '' or $prodPic2 == '' or $prodPic3 == '') {
                echo "<script>alert('Please fill in all the available fields')</script>";
                exit();
            } else {
                //to move the image into the folder
                move_uploaded_file($tempPic1, "./product_images/$prodPic1");
                move_uploaded_file($tempPic2, "./product_images/$prodPic2");
                move_uploaded_file($tempPic3, "./product_images/$prodPic3");

                //insert query
                $insert_products = "Insert into products (product_name, product_description, product_price, product_keywords, category_id, brand_id, product_image1, product_image2, product_image3, date, status) 
                values ('$product_name','$prodDesc','$prodPrice','$prodKey','$prodCat','$prodBrand','$prodPic1','$prodPic2','$prodPic3',NOW(),'$prodSta')";
                $result_query = mysqli_query($con, $insert_products);
                if ($result_query) {
                    echo"<script>alert('Successfully inserted the products')</script>";
                }
            }
        }
        ?>

        <div class="pageContent">
            <p>Home/Admin/</p></br>
            <p class="bold"><b>ADD NEW PRODUCTS</b></p>
        </div>

        <form action="" method="POST" enctype="multipart/form-data"> <!--To able to store image-->
            <div class="container2">
                <div class="container">
                    <div class='fontsz'>
                        <label for="prodName">PRODUCT NAME</label><br>
                        <input type="text" name="prodName" id="prodName" required>

                        <br><label for="prodDesc">PRODUCT DESCRIPTION</label><br>
                        <input type="text" name="prodDesc" id="prodDesc" required>

                        <br><label for="prodPrice">PRODUCT PRICE</label><br>
                        <input type="text" name="prodPrice" id="prodPrice" required>

                        <br><label for="prodKey">PRODUCT KEYWORDS</label><br>
                        <input type="text" name="prodKey" id="prodKey" required>

                        <br><label for="prodCat">PRODUCT CATEGORY</label><br>
                        <br><select name="prodCat" id="prodCat" class="product_category">
                            <option value="">Select a Category</option>
                            <?php
                            $select_query = "Select * from categories";
                            $result_query = mysqli_query($con, $select_query);
                            while ($row = mysqli_fetch_assoc($result_query)) {
                                $category_title = $row['category_title'];
                                $category_id = $row['category_id'];
                                echo "<option value='$category_id'>$category_title</option>";
                            }
                            ?>
                        </select>

                        <br><label for="prodBrand">PRODUCT BRANDS</label><br>
                        <br><select name="prodBrand" id="prodBrand" class="product_category">
                            <option value="">Select a Brand</option>
                            <?php
                            $select_query = "Select * from brands";
                            $result_query = mysqli_query($con, $select_query);
                            while ($row = mysqli_fetch_assoc($result_query)) {
                                $brand_title = $row['brand_title'];
                                $brand_id = $row['brand_id'];
                                echo "<option value='$brand_id'>$brand_title</option>";
                            }
                            ?>
                        </select>

                        <br><label for="prodPic1">PRODUCT IMAGE 1</label><br>
                        <input type="file" accept="image/png, image/jpeg, image/jpg" name="prodPic1" id="prodPic1" required>

                        <br><label for="prodPic2">PRODUCT IMAGE 2</label><br>
                        <input type="file" accept="image/png, image/jpeg, image/jpg" name="prodPic2" id="prodPic2" required>

                        <br><label for="prodPic3">PRODUCT IMAGE 3</label><br>
                        <input type="file" accept="image/png, image/jpeg, image/jpg" name="prodPic3" id="prodPic3" required>

                    </div>    
                    <div class="logbtn">
                        <br><input type="submit" value="INSERT" name="insert_product"  class="log" />
                    </div>
                </div>
                <div class="create"><a href="viewproduct.php">VIEW PRODUCT</a></div>
            </div>
        </form>
    </body>
</html>
