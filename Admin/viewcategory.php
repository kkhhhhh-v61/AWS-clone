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
        <title>View Categories | Eversummer Florist</title>
    </head>
    <body>
        <?php
        include './adminheader.php';
	include './helper.php';
        include '../config/connect.php';
        ?>

        <div class="pageContent">
            <p>Home/Admin/</p></br>
            <p class="bold"><b>VIEW CATEGORIES</b></p>
        </div>

        <div class="product-display">
            <table class="product-display-table">
                <thead>
                    <tr>
                        <td>No</td>
                        <td>Category</td>
                        <td>Action</td>
                    </tr>
                </thead>
                <?php
                $select_cat = "Select * from categories";
                $result = mysqli_query($con, $select_cat);
                $number = 0;
                while ($row = mysqli_fetch_assoc($result)) {
                    $category_id = $row['category_id'];
                    $category_title = $row['category_title'];
                    $number++;
                    ?>
                    <tr>
                        <td><?php echo $number ?></td>
                        <td><?php echo $category_title ?></td>
                        <td><a class='btn' href='editcategory.php?id=<?php echo $category_id ?>'>Edit</a>
                            <a class='btn' href='#' onclick='showConfirmation(<?php echo $category_id ?>)'>Delete</a>
                        </td>
                    </tr>
                    <?php
                }
                ?>

            </table>
        </div>
    </body>
    <script>
        function showConfirmation(categoryId) {
            if (confirm("Are you sure you want to delete this category?")) {
                // if the user clicks "OK" in the confirmation pop-up, redirect to the delete brand page
                window.location.href = "deletecategory.php?id=" + categoryId;
            } else {
                // if the user clicks "Cancel" in the confirmation pop-up, do nothing
            }
        }
    </script>
</html>
