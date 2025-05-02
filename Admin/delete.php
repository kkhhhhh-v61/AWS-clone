<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Delete Products | Eversummer Florist</title>
    </head>
    <body>
        <?php
        include './adminheader.php';
        include 'helper.php';

        if (isset($_GET['id'])) {
            $delete_id = $_GET['id'];

            //delete query
            $delete_user = "Delete from user_table where user_id=$delete_id";
            $result_user = mysqli_query($con, $delete_user);
            if ($result_user) {
                echo "<script>alert('User deleted successfully')</script>";
                echo "<script>window.open('./adminaccount.php','_self')</script>";
            }
        }
        ?>


    </body>
</html>