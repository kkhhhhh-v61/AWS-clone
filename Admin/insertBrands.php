<!DOCTYPE html>

<html>

<head>
    <meta charset="UTF-8">
    <link href="../css/login.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <title>Blooms Co. | Insert Brand</title>
</head>

<body>
    <?php
    include './adminheader.php';
    include '../config/connect.php';

    if (isset($_POST['insert_brand'])) { //check the condition if click the can access the value below
        $brand_title = $_POST['brand_title']; //store the input value that access ans store inside the variable($category_title)

        //select data from database and check whether the database data match with input field anot
        $select_query = "Select * from brands where brand_title = '$brand_title' ";
        $result_select = mysqli_query($con, $select_query);
        $number = mysqli_num_rows($result_select); //count the number of rows

        if ($number > 0) { //greater than 0 means that already exist
            echo "<script>alert('This brand is already exist')</script>";
        } else { //else able to insert the category inside the table
            $insert_query = "Insert into brands (brand_title) values ('$brand_title')";
            $result = mysqli_query($con, $insert_query);
            if ($result) {
                echo "<script>alert('Brand has been inserted successfully')</script>";
            }
        }
    }
    ?>

    <div class="login-container">
        <div class="login-header">
            <h2 class="login-title">INSERT BRAND</h2>
        </div>

        <form action="" method="POST" class="login-form">
            <div class="form-group">
                <label for="brand_title">BRAND NAME</label>
                <input type="text" name="brand_title" id="brand_title" class="form-control" placeholder="Insert Brand" required>
            </div>

            <div class="form-group">
                <button type="submit" name="insert_brand" class="loginbutM">INSERT</button>
            </div>

            <div class="create">
                <a href="viewbrands.php">VIEW BRANDS</a>
            </div>
        </form>
    </div>
    <?php include '../php/footer.php'; ?>
</body>

</html>