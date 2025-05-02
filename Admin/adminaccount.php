<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <link href="../css/admin2.css" rel="stylesheet" type="text/css"/>
        <title>Edit Products | Eversummer Florist</title>
    </head>
    <body>
        <?php
        include './adminheader.php';
        require_once './helper.php';
        ?>

        <div class="pageContent">
            <p>Home/Admin/</p></br>
            <p class="bold"><b>VIEW USERS ACCOUNT</b></p>
        </div>

        <div class="search-container">
            <form method="GET">
                <center><input type="text" placeholder="Search by username" name="username">
                    <button class="searchBtn" type="submit"><ion-icon class="search-outline" name="search-outline"></ion-icon></button></center>
            </form>
        </div>

        <div class="product-display">
            <table class="product-display-table">
                <thead>
                    <tr>
                        <td>ID</td>
                        <td>Profile Picture</td>
                        <td>Username</td>
                        <td>Email</td>
                        <td>Address</td>
                        <td>Contact</td>
                        <td>Action</td>
                    </tr>
                </thead>
                <?php
                if(isset($_GET['username'])) {
                    $search_username = $_GET['username'];
                    $select_query = "SELECT * FROM user_table WHERE username LIKE '%$search_username%'";
                } else {
                    $select_query = "SELECT * FROM user_table";
                }
                
                $result = mysqli_query($con, $select_query);
                $number = 0;
                while ($row = mysqli_fetch_assoc($result)) {
                    $user_id = $row['user_id'];
                    $user_image = $row['user_image'];
                    $user_username = $row['username'];
                    $user_email = $row['user_email'];
                    $user_address = $row['user_address'];
                    $user_contact = $row['user_phone'];
                    $number++;
                    ?>
                    <tr>
                    
                        <td><?php echo $user_id ?></td>
                        <td><img src='../php/user_images/<?php echo $user_image ?>' width='100px' height='100px'/></td>
                        <td><?php echo $user_username ?></td>
                        <td><?php echo $user_email ?></td>
                        <td><?php echo $user_address ?></td>
                        <td><?php echo $user_contact ?></td>
                        <td><a class='btn' href='editacc.php?acc=<?php echo $user_id ?>'>Edit</a>
                            <a class='btn' href='#' onclick='showConfirmation(<?php echo $user_id ?>)'>Delete</a>
                        </td>
                    </tr>
                    <?php
                }
                ?>

            </table>
        </div>
    </body>
    <script>
        function showConfirmation(userid) {
            if (confirm("Are you sure you want to delete this user?")) {
                // if the user clicks "OK" in the confirmation pop-up, redirect to the delete product page
                window.location.href = "delete.php?id=" + userid;
            } else {
                // if the user clicks "Cancel" in the confirmation pop-up, do nothing
            }
        }
    </script>

</html>