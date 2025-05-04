<!DOCTYPE html>

<html>

<head>
    <meta charset="UTF-8">
    <link href="../css/login.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <title>Blooms Co. | Insert Category</title>
</head>

<body>
    <?php
    include './adminheader.php';
    include '../config/helper.php';
    include '../config/connect.php';

    if (isset($_POST['insert_cat'])) { //check the condition if click the can access the value below
        $category_title = $_POST['cat_title']; //store the input value that access ans store inside the variable($category_title)
        //select data from database and check whether the database data match with input field anot
        $select_query = "Select * from categories where category_title = '$category_title' ";
        $result_select = mysqli_query($con, $select_query);
        $number = mysqli_num_rows($result_select); //count the number of rows

        if ($number > 0) { //greater than 0 means that already exist
            echo "<script>alert('This category is already exist')</script>";
        } else { //else able to insert the category inside the table
            $insert_query = "Insert into categories (category_title) values ('$category_title')";
            $result = mysqli_query($con, $insert_query);
            if ($result) {
                echo "<script>alert('Category has been inserted successfully')</script>";
            }
        }
    }
    ?>

    <div class="login-container">
        <div class="login-header">
            <h2 class="login-title">INSERT CATEGORY</h2>
        </div>

        <form action="" method="POST" class="login-form">
            <div class="form-group">
                <label for="cat_title">CATEGORY NAME</label>
                <input type="text" name="cat_title" id="cat_title" class="form-control" placeholder="Insert Category" required>
            </div>

            <div class="form-group">
                <button type="submit" name="insert_cat" class="loginbutM">INSERT</button>
            </div>

            <div class="create">
                <a href="viewcategory.php">VIEW CATEGORIES</a>
            </div>
        </form>
    </div>
    <?php include '../php/footer.php'; ?>
</body>

</html>