<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <link href="../css/login.css" rel="stylesheet" type="text/css" />
    <link href="../css/homepage.css" rel="stylesheet" type="text/css" />
    <style>
        .featured-toggle {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .toggle-label {
            cursor: pointer;
            font-weight: 500;
            color: #333;
        }

        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
            border-radius: 34px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }

        input:checked+.slider {
            background-color: #4CAF50;
        }

        input:checked+.slider:before {
            transform: translateX(26px);
        }
    </style>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <title>Blooms Co. | Add Products</title>
</head>

<body>
    <?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    include './adminheader.php';
    include '../config/helper.php';
    include '../config/connect.php';

    if (isset($_POST['insert_product'])) {
        //mysqli_real_escape_string to escape any special characters in the values before inserting them into the database.
        $product_name = mysqli_real_escape_string($con, $_POST['prodName']);
        $prodDesc = mysqli_real_escape_string($con, $_POST['prodDesc']);
        $prodPrice = mysqli_real_escape_string($con, $_POST['prodPrice']);
        $prodKey = mysqli_real_escape_string($con, $_POST['prodKey']);
        $prodCat = mysqli_real_escape_string($con, $_POST['catTitle']);
        $prodBrand = mysqli_real_escape_string($con, $_POST['brandTitle']);
        $isFeatured = isset($_POST['isFeatured']) ? 1 : 0;
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
            $insert_products = "Insert into products (product_name, product_description, product_price, product_keywords, category_id, brand_id, product_image1, product_image2, product_image3, date, status, isFeatured) 
                values ('$product_name','$prodDesc','$prodPrice','$prodKey','$prodCat','$prodBrand','$prodPic1','$prodPic2','$prodPic3',NOW(),'$prodSta',$isFeatured)";
            $result_query = mysqli_query($con, $insert_products);
            if ($result_query) {
                echo "<script>alert('Successfully inserted the products')</script>";
            }
        }
    }
    ?>

    <div class="login-container">
        <div class="login-header">
            <h2 class="login-title">ADD NEW PRODUCT</h2>
        </div>

        <form action="" method="POST" enctype="multipart/form-data" class="login-form">
            <div class="form-group">
                <label for="prodName">PRODUCT NAME</label>
                <input type="text" name="prodName" id="prodName" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="prodDesc">PRODUCT DESCRIPTION</label>
                <input type="text" name="prodDesc" id="prodDesc" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="prodPrice">PRODUCT PRICE</label>
                <input type="text" name="prodPrice" id="prodPrice" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="prodKey">PRODUCT KEYWORDS</label>
                <input type="text" name="prodKey" id="prodKey" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="catTitle">CATEGORY</label>
                <select name="catTitle" id="catTitle" class="form-control" required>
                    <option value="">Select Category</option>
                    <?php
                    $sql = "SELECT * FROM categories ORDER BY category_title ASC";
                    $result = mysqli_query($con, $sql);
                    while ($row = mysqli_fetch_array($result)) {
                        echo "<option value='" . $row['category_id'] . "'>" . $row['category_title'] . "</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="brandTitle">BRAND</label>
                <select name="brandTitle" id="brandTitle" class="form-control" required>
                    <option value="">Select Brand</option>
                    <?php
                    $sql = "SELECT * FROM brands ORDER BY brand_title ASC";
                    $result = mysqli_query($con, $sql);
                    while ($row = mysqli_fetch_array($result)) {
                        echo "<option value='" . $row['brand_id'] . "'>" . $row['brand_title'] . "</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="prodPic1">PRODUCT IMAGE 1</label>
                <input type="file" accept="image/png, image/jpeg, image/jpg" name="prodPic1" id="prodPic1" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="prodPic2">PRODUCT IMAGE 2</label>
                <input type="file" accept="image/png, image/jpeg, image/jpg" name="prodPic2" id="prodPic2" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="prodPic3">PRODUCT IMAGE 3</label>
                <input type="file" accept="image/png, image/jpeg, image/jpg" name="prodPic3" id="prodPic3" class="form-control" required>
            </div>

            <div class="form-group">
                <label>FEATURED PRODUCT</label>
                <div class="featured-toggle">
                    <label class="switch">
                        <input type="checkbox" name="isFeatured" id="isFeatured">
                        <span class="slider"></span>
                    </label>
                </div>
            </div>

            <div class="form-group">
                <button type="submit" name="insert_product" class="loginbutM">INSERT</button>
            </div>

            <div class="create">
                <a href="viewproduct.php">VIEW PRODUCTS</a>
            </div>
        </form>
    </div>
    <?php include '../php/footer.php'; ?>
</body>

</html>