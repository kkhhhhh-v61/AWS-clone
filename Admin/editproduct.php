<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <link href="../css/admin.css" rel="stylesheet" type="text/css"/>
        <title>Edit Products | Eversummer Florist</title>
    </head>
    <body>
        <?php
        include './adminheader.php';
        include '../config/connect.php';

        if (isset($_GET['id'])) {
            $edit_id = $_GET['id'];
            $get_data = "Select * from products where product_id = $edit_id";
            $result = mysqli_query($con, $get_data);
            $row = mysqli_fetch_assoc($result);
            $product_name = $row['product_name'];
            $product_description = $row['product_description'];
            $product_price = $row['product_price'];
            $product_keywords = $row['product_keywords'];
            $category_id = $row['category_id'];
            $brand_id = $row['brand_id'];
            $product_image1 = $row['product_image1'];
            $product_image2 = $row['product_image2'];
            $product_image3 = $row['product_image3'];

            //Fetching Category Name
            $select_category = "Select * from categories where category_id=$category_id";
            $result_category = mysqli_query($con, $select_category);
            $row_category = mysqli_fetch_assoc($result_category);
            $category_title = $row_category['category_title'];

            //Fetching Brand Name
            $select_brand = "Select * from brands where brand_id=$brand_id";
            $result_brand = mysqli_query($con, $select_brand);
            $row_brand = mysqli_fetch_assoc($result_brand);
            $brand_title = $row_brand['brand_title'];
        }
        ?>

        <div class="pageContent">
            <p>Home/Admin/</p></br>
            <p class="bold"><b>EDIT PRODUCTS</b></p>
        </div>

        <form action="" method="POST" enctype="multipart/form-data"> <!--To able to store image-->
            <div class="container2">
                <div class="container">
                    <div class='fontsz'>
                        <label for="prodName">PRODUCT NAME</label><br>
                        <input type="text" name="prodName" id="prodName" value="<?php echo $product_name ?>" required>

                        <br><label for="prodDesc">PRODUCT DESCRIPTION</label><br>
                        <input type="text" name="prodDesc" id="prodDesc" value="<?php echo $product_description ?>" required>

                        <br><label for="prodPrice">PRODUCT PRICE</label><br>
                        <input type="text" name="prodPrice" id="prodPrice" value="<?php echo $product_price ?>" required>

                        <br><label for="prodKey">PRODUCT KEYWORDS</label><br>
                        <input type="text" name="prodKey" id="prodKey" value="<?php echo $product_keywords ?>" required>

                        <br><label for="prodCat">PRODUCT CATEGORY</label><br>
                        <br><select name="prodCat" id="prodCat" class="product_category">
                            <option value="<?php echo $category_title ?>"><?php echo $category_title ?></option>
                            <?php
                            $select_category_all = "Select * from categories";
                            $result_category_all = mysqli_query($con, $select_category_all);
                            while ($row_category_all = mysqli_fetch_assoc($result_category_all)) {
                                $category_title = $row_category_all['category_title'];
                                $category_id = $row_category_all['category_id'];
                                echo "<option value='$category_id'>$category_title</option>";
                            }
                            ?>
                        </select>

                        <br><label for="prodBrand">PRODUCT BRANDS</label><br>
                        <br><select name="prodBrand" id="prodBrand" class="product_category">
                            <option value="<?php echo $brand_title ?>"><?php echo $brand_title ?></option>
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
                        <br><input type="submit" value="UPDATE" name="update_product"  class="log" />
                    </div>
                </div>
            </div>
        </form>

        <!-- editing products -->
        <?php
        if (isset($_POST['update_product'])) {
            $product_name = mysqli_real_escape_string($con, $_POST['prodName']);
            $product_description = mysqli_real_escape_string($con, $_POST['prodDesc']);
            $product_price = mysqli_real_escape_string($con, $_POST['prodPrice']);
            $product_keywords = mysqli_real_escape_string($con, $_POST['prodKey']);
            $category_id = mysqli_real_escape_string($con, $_POST['prodCat']);
            $brand_id = mysqli_real_escape_string($con, $_POST['prodBrand']);

            $product_image1 = $_FILES['prodPic1']['name'];
            $product_image2 = $_FILES['prodPic2']['name'];
            $product_image3 = $_FILES['prodPic3']['name'];

            $temp_image1 = $_FILES['prodPic1']['tmp_name'];
            $temp_image2 = $_FILES['prodPic2']['tmp_name'];
            $temp_image3 = $_FILES['prodPic3']['tmp_name'];

            //checking for fields empty or not
            if ($product_name == '' or $product_description == '' or $product_price == '' or $product_keywords == '' or $category_id == '' or $brand_id == '' or $product_image1 == '' or $product_image2 == '' or $product_image3 == '') {
                echo"<script>alert('Please fill all the fields and continue the process')</script>";
            } else {
                move_uploaded_file($temp_image1, "./product_images/$product_image1");
                move_uploaded_file($temp_image2, "./product_images/$product_image2");
                move_uploaded_file($temp_image3, "./product_images/$product_image3");

                //query to update products
                $update_product =  "update products set product_name='$product_name', product_description='$product_description', product_price='$product_price', product_keywords='$product_keywords', category_id='$category_id', brand_id='$brand_id', product_image1='$product_image1', product_image2='$product_image2', product_image3='$product_image3', date=NOW() where product_id=$edit_id";
                $result_update = mysqli_query($con, $update_product);
                if ($result_update) {
                    echo "<script>alert('Product updated successfully')</script>";
                    echo "<script>window.open('./viewproduct.php','_self')</script>";
                }
            }
        }
        ?>
    </body>
</html>
