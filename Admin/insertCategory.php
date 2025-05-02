<!DOCTYPE html>

<html>

<head>
    <meta charset="UTF-8">
    <link href="../css/admin.css" rel="stylesheet" type="text/css" />
    <title>Insert Categories | Eversummer Florist</title>
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

    <div class="pageContent">
        <p>Home/Admin/</p></br>
        <p class="bold"><b>INSERT CATEGORIES</b></p>
    </div>

    <form action="" method="POST">
        <div class="container2">
            <div class="container">
                <div class='fontsz'>
                    <input type="text" name="cat_title" id="insCat" placeholder="Insert Categories" required>
                </div>
                <div class="logbtn">
                    <br><input type="submit" value="INSERT" class="insBut" name="insert_cat" />
                </div>
            </div>
            <div class="create"><a href="viewcategory.php">VIEW CATEGORIES</a></div>
        </div>
    </form>
</body>

</html>