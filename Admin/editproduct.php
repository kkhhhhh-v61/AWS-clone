<!DOCTYPE html>

<html>

<head>
    <meta charset="UTF-8">
    <link href="../css/login.css" rel="stylesheet" type="text/css" />
    <link href="../css/homepage.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <title>Blooms Co. | Edit Product</title>
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

    <div class="login-container">
        <div class="login-header">
            <h2 class="login-title">EDIT PRODUCT</h2>
        </div>

        <form action="" method="POST" enctype="multipart/form-data" class="login-form">
            <div class="form-group">
                <label for="prodName">PRODUCT NAME</label>
                <input type="text" name="prodName" id="prodName" value="<?php echo $product_name ?>" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="prodDesc">PRODUCT DESCRIPTION</label>
                <input type="text" name="prodDesc" id="prodDesc" value="<?php echo $product_description ?>" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="prodPrice">PRODUCT PRICE</label>
                <input type="text" name="prodPrice" id="prodPrice" value="<?php echo $product_price ?>" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="prodKey">PRODUCT KEYWORDS</label>
                <input type="text" name="prodKey" id="prodKey" value="<?php echo $product_keywords ?>" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="prodCat">PRODUCT CATEGORY</label>
                <select name="prodCat" id="prodCat" class="form-control" required>
                    <option value="<?php echo $category_id ?>"><?php echo $category_title ?></option>
                    <?php
                    $select_category_all = "Select * from categories ORDER BY category_title ASC";
                    $result_category_all = mysqli_query($con, $select_category_all);
                    while ($row_category_all = mysqli_fetch_assoc($result_category_all)) {
                        $category_title = $row_category_all['category_title'];
                        $category_id = $row_category_all['category_id'];
                        echo "<option value='$category_id'>$category_title</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="prodBrand">PRODUCT BRAND</label>
                <select name="prodBrand" id="prodBrand" class="form-control" required>
                    <option value="<?php echo $brand_id ?>"><?php echo $brand_title ?></option>
                    <?php
                    $select_query = "Select * from brands ORDER BY brand_title ASC";
                    $result_query = mysqli_query($con, $select_query);
                    while ($row = mysqli_fetch_assoc($result_query)) {
                        $brand_title = $row['brand_title'];
                        $brand_id = $row['brand_id'];
                        echo "<option value='$brand_id'>$brand_title</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="prodPic1">PRODUCT IMAGE 1</label>
                <input type="file" accept="image/png, image/jpeg, image/jpg" name="prodPic1" id="prodPic1" class="form-control" required>
                <input type="hidden" name="current_image1" value="<?php echo $product_image1 ?>">
                <small class="text-muted">Current image: <?php echo $product_image1 ?></small>
            </div>

            <div class="form-group">
                <label for="prodPic2">PRODUCT IMAGE 2</label>
                <input type="file" accept="image/png, image/jpeg, image/jpg" name="prodPic2" id="prodPic2" class="form-control" required>
                <input type="hidden" name="current_image2" value="<?php echo $product_image2 ?>">
                <small class="text-muted">Current image: <?php echo $product_image2 ?></small>
            </div>

            <div class="form-group">
                <label for="prodPic3">PRODUCT IMAGE 3</label>
                <input type="file" accept="image/png, image/jpeg, image/jpg" name="prodPic3" id="prodPic3" class="form-control" required>
                <input type="hidden" name="current_image3" value="<?php echo $product_image3 ?>">
                <small class="text-muted">Current image: <?php echo $product_image3 ?></small>
            </div>

            <div class="form-group">
                <button type="submit" name="update_product" class="loginbutM">UPDATE</button>
            </div>

            <div class="create">
                <a href="viewproduct.php">BACK TO PRODUCTS</a>
            </div>
        </form>
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

        // Get current images from form
        $current_image1 = $_POST['current_image1'];
        $current_image2 = $_POST['current_image2'];
        $current_image3 = $_POST['current_image3'];

        // Check if new images were uploaded
        $new_image1 = $_FILES['prodPic1']['name'];
        $new_image2 = $_FILES['prodPic2']['name'];
        $new_image3 = $_FILES['prodPic3']['name'];

        // If no new image uploaded, use existing image
        $product_image1 = !empty($new_image1) ? $new_image1 : $current_image1;
        $product_image2 = !empty($new_image2) ? $new_image2 : $current_image2;
        $product_image3 = !empty($new_image3) ? $new_image3 : $current_image3;

        // Upload only if new images were provided
        if (!empty($new_image1)) {
            $temp_image1 = $_FILES['prodPic1']['tmp_name'];
            move_uploaded_file($temp_image1, "./product_images/$product_image1");
        }
        if (!empty($new_image2)) {
            $temp_image2 = $_FILES['prodPic2']['tmp_name'];
            move_uploaded_file($temp_image2, "./product_images/$product_image2");
        }
        if (!empty($new_image3)) {
            $temp_image3 = $_FILES['prodPic3']['tmp_name'];
            move_uploaded_file($temp_image3, "./product_images/$product_image3");
        }

        //checking for fields empty or not
        if ($product_name == '' or $product_description == '' or $product_price == '' or $product_keywords == '' or $category_id == '' or $brand_id == '') {
            echo "<script>alert('Please fill all the required fields')</script>";
        } else {
            //query to update products
            $update_product = "update products set product_name='$product_name', product_description='$product_description', product_price='$product_price', product_keywords='$product_keywords', category_id='$category_id', brand_id='$brand_id', product_image1='$product_image1', product_image2='$product_image2', product_image3='$product_image3', date=NOW() where product_id=$edit_id";
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