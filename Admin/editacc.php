<?php require_once './helper.php'; ?>
<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <link href="../css/admin2.css" rel="stylesheet" type="text/css"/>
        <title>Edit Account | Eversummer Florist</title>
    </head>
    <body>
        <?php
        include './adminheader.php';

        if (isset($_GET['acc'])) {
            $edit_id = $_GET['acc'];
            $sql = "SELECT * FROM user_table WHERE user_id = $edit_id";
            $result = mysqli_query($con, $sql);
            $row = mysqli_fetch_assoc($result);
            $user_username = $row['username'];
            $user_email = $row['user_email'];
            $user_address = $row['user_address'];
            $user_contact = $row['user_phone'];
        }
        ?>

        <div class="pageContent">
            <p>Home/Admin/</p></br>
            <p class="bold"><b>EDIT USERS ACCOUNT</b></p>
        </div>

        <form action="" method="POST" enctype="multipart/form-data"> <!--To enable storing of image-->
            <div class="container2">
                <div class="container">
                    <div class='fontsz'>
                        <label for="user_username">USERNAME</label><br>
                        <input type="text" name="user_username" id="user_username" value="<?php echo $user_username ?>" required>

                        <br><label for="user_email">EMAIL</label><br>
                        <input type="text" name="user_email" id="user_email" value="<?php echo $user_email ?>" required>

                        <br><label for="user_address">ADDRESS</label><br>
                        <input type="text" name="user_address" id="user_address" value="<?php echo $user_address ?>" required>

                        <br><label for="user_contact">CONTACT</label><br>
                        <input type="text" name="user_contact" id="user_contact" value="<?php echo $user_contact ?>" required>
                     
                    </div>                      
                </div>
            </div>
            <div class="logbtn2">
                        <br><input type="submit" value="UPDATE" name="update_user" class="btn3" />
                    </div>
        </form>


        <!-- editing products -->
        <?php
        if (isset($_POST['update_user'])) {
            $user_username = mysqli_real_escape_string($con, $_POST['user_username']);
            $user_email = mysqli_real_escape_string($con, $_POST['user_email']);
            $user_address = mysqli_real_escape_string($con, $_POST['user_address']);
            $user_contact = mysqli_real_escape_string($con, $_POST['user_contact']);

            // checking if image is uploaded
            if (!empty($_FILES['user_image']['name'])) {
                $user_image = $_FILES['user_image']['name'];
                $temp_image1 = $_FILES['user_image']['tmp_name'];
                
            }

            // checking for fields empty or not
            if ($user_username == '' or $user_email == '' or $user_address == '' or $user_contact == '') {
                echo "<script>alert('Please fill all the fields and continue the process')</script>";
            } else {
                $update_user = "UPDATE user_table SET username='$user_username', user_email='$user_email', user_address='$user_address', user_phone='$user_contact' WHERE user_id=$edit_id";
                $result_update = mysqli_query($con, $update_user);
                if ($result_update) {
                    echo "<script>alert('User updated successfully')</script>";
                    echo "<script>window.open('./adminaccount.php','_self')</script>";
                }
            }
        }
        ?>

         </body>
</html>