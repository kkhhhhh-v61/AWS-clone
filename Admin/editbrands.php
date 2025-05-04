<!DOCTYPE html>

<html>

<head>
    <meta charset="UTF-8">
    <link href="../css/login.css" rel="stylesheet" type="text/css" />
    <link href="../css/homepage.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <title>Blooms Co. | Edit Brand</title>
</head>

<body>
    <?php
    include './adminheader.php';
    include '../config/helper.php';
    include '../config/connect.php';

    if (isset($_GET['id'])) {
        $edit_id = $_GET['id'];
        $get_data = "Select * from brands where brand_id = $edit_id";
        $result = mysqli_query($con, $get_data);
        $row = mysqli_fetch_assoc($result);
        $brand_title = $row['brand_title'];
    }
    ?>

    <div class="login-container">
        <div class="login-header">
            <h2 class="login-title">EDIT BRAND</h2>
        </div>

        <form action="" method="POST" class="login-form">
            <div class="form-group">
                <label for="brand_title">BRAND TITLE</label>
                <input type="text" name="brand_title" id="brand_title" class="form-control" value="<?php echo $brand_title ?>" required>
            </div>

            <div class="form-group">
                <button type="submit" name="update_brand" class="loginbutM">UPDATE</button>
            </div>

            <div class="create">
                <a href="viewbrands.php">BACK TO BRANDS</a>
            </div>
        </form>

        <!-- editing products -->
        <?php
        if (isset($_POST['update_brand'])) {
            $brand_title = mysqli_real_escape_string($con, $_POST['brand_title']);

            //checking for fields empty or not
            if ($brand_title == '') {
                echo "<script>alert('Please fill all the fields')</script>";
            } else {
                //query to update products
                $update_brand = "update brands set brand_title='$brand_title' where brand_id=$edit_id";
                $result_update = mysqli_query($con, $update_brand);
                if ($result_update) {
                    echo "<script>alert('Brand updated successfully')</script>";
                    echo "<script>window.open('./viewbrands.php','_self')</script>";
                }
            }
        }
        ?>
    </div>
    <?php include '../php/footer.php'; ?>
</body>

</html>
</body>

</html>