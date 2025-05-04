<!DOCTYPE html>

<html>

<head>
    <meta charset="UTF-8">
    <link href="../css/login.css" rel="stylesheet" type="text/css" />
    <link href="../css/homepage.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <title>Blooms Co. | Edit Category</title>
</head>

<body>
    <?php
    include './adminheader.php';
    include '../config/helper.php';
    include '../config/connect.php';

    if (isset($_GET['id'])) {
        $edit_id = $_GET['id'];
        $get_data = "Select * from categories where category_id = $edit_id";
        $result = mysqli_query($con, $get_data);
        $row = mysqli_fetch_assoc($result);
        $category_title = $row['category_title'];
    }
    ?>

    <div class="login-container">
        <div class="login-header">
            <h2 class="login-title">EDIT CATEGORY</h2>
        </div>

        <form action="" method="POST" class="login-form">
            <div class="form-group">
                <label for="cat_title">CATEGORY TITLE</label>
                <input type="text" name="cat_title" id="cat_title" class="form-control" value="<?php echo $category_title ?>" required>
            </div>

            <div class="form-group">
                <button type="submit" name="update_cat" class="loginbutM">UPDATE</button>
            </div>

            <div class="create">
                <a href="viewcategory.php">BACK TO CATEGORIES</a>
            </div>
        </form>

        <!-- editing products -->
        <?php
        if (isset($_POST['update_cat'])) {
            $category_title = mysqli_real_escape_string($con, $_POST['cat_title']);

            //checking for fields empty or not
            if ($category_title == '') {
                echo "<script>alert('Please fill all the fields')</script>";
            } else {
                //query to update products
                $update_cat = "update categories set category_title='$category_title' where category_id=$edit_id";
                $result_update = mysqli_query($con, $update_cat);
                if ($result_update) {
                    echo "<script>alert('Category updated successfully')</script>";
                    echo "<script>window.open('./viewcategory.php','_self')</script>";
                }
            }
        }
        ?>
    </div>
    <?php include '../php/footer.php'; ?>
</body>

</html>