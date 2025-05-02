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
        <title>View Brands | Eversummer Florist</title>
    </head>
    <body>
        <?php
        include './adminheader.php';
        include '../config/connect.php';
        ?>

        <div class="pageContent">
            <p>Home/Admin/</p></br>
            <p class="bold"><b>VIEW BRANDS</b></p>
        </div>

        <div class="product-display">
            <table class="product-display-table">
                <thead>
                    <tr>
                        <td>No</td>
                        <td>Brands</td>
                        <td>Action</td>
                    </tr>
                </thead>
                <?php
                $select_brand = "Select * from brands";
                $result = mysqli_query($con, $select_brand);
                $number = 0;
                while ($row = mysqli_fetch_assoc($result)) {
                    $brand_id = $row['brand_id'];
                    $brand_title = $row['brand_title'];
                    $number++;
                    ?>
                    <tr>
                        <td><?php echo $number ?></td>
                        <td><?php echo $brand_title ?></td>
                        <td><a class='btn' href='editbrands.php?id=<?php echo $brand_id ?>'>Edit</a>
                            <a class='btn' href='#' onclick='showConfirmation(<?php echo $brand_id ?>)'>Delete</a>
                        </td>
                    </tr>
                    <?php
                }
                ?>
            </table>
        </div>
    </body>
    <script>
        function showConfirmation(brandId) {
            if (confirm("Are you sure you want to delete this brand?")) {
                // if the user clicks "OK" in the confirmation pop-up, redirect to the delete brand page
                window.location.href = "deletebrands.php?id=" + brandId;
            } else {
                // if the user clicks "Cancel" in the confirmation pop-up, do nothing
            }
        }
    </script>

</html>
