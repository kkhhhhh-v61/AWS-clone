<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <link href="../css/admin.css" rel="stylesheet" type="text/css"/>
        <title>Edit Categories | Eversummer Florist</title>
    </head>
    <body>
        <?php
        include './adminheader.php';
        include '../config/connect.php';

        if (isset($_GET['id'])) {
            $edit_id = $_GET['id'];
            $get_data = "Select * from categories where category_id = $edit_id";
            $result = mysqli_query($con, $get_data);
            $row = mysqli_fetch_assoc($result);
            $category_title = $row['category_title'];
        }
        ?>

        <div class="pageContent">
            <p>Home/Admin/</p></br>
            <p class="bold"><b>EDIT CATEGORIES</b></p>
        </div>

        <form action="" method="POST">
            <div class="container2">
                <div class="container">
                    <div class='fontsz'>
                        <input type="text" name="cat_title" id="insCat" value="<?php echo $category_title ?>" required>
                    </div>    
                    <div class="logbtn">
                        <br><input type="submit" value="UPDATE" class="insBut" name="update_cat" />
                    </div>
                </div>
            </div>
        </form>

        <!-- editing products -->
        <?php
        if (isset($_POST['update_cat'])) {
            $category_title = mysqli_real_escape_string($con, $_POST['cat_title']);

            //checking for fields empty or not
            if ($category_title == '') {
                echo"<script>alert('Please fill all the fields and continue the process')</script>";
            } else {
                //query to update products
                $update_cat = "update categories set category_title='$category_title' where category_id=$edit_id";
                $result_update = mysqli_query($con, $update_cat);
                if ($result_update) {
                    echo "<script>alert('Categories updated successfully')</script>";
                    echo "<script>window.open('./viewcategory.php','_self')</script>";
                }
            }
        }
        ?>
    </body>
</html>
