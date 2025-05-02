<?php require_once './helper.php'; ?>
<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <link href="../css/login.css" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
        <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
        <title>Create Account | Sneaker Vault</title>
    </head>
    <body
    <?php include './header.php'; ?>

        <div class="pageContent">
        <p>Home/Account/</p></br>
        <p class="bold"><b>CREATE ACCOUNT</b></p>
    </div>

    <div class="container2">
        <div class="container">
            <form action="" method="post" enctype="multipart/form-data">
                <div class="fontsz">
                    <!--username-->
                    <label for="user_username">USERNAME</label><br>
                    <input type="text" name="user_username" id="user_username" 
                           placeholder="Enter your username" required="required" minlength="5">

                    <!--email-->
                    <br><label for="user_email">EMAIL</label><br>
                    <input type="email" name="user_email" id="user_email" 
                           placeholder="Enter your email" required="required" >

                    <!--image-->
                    <br><label for="user_image">PROFILE PICTURE (optional)</label><br>
                    <input type="file" name="user_image" id="user_image">

                    <!--user add-->
                    <br><label for="user_address">ADDRESS</label><br>
                    <input type="text" name="user_address" id="user_address" 
                           placeholder="Enter your address" required="required">

                    <!--user contact-->
                    <br><label for="user_conatct">CONTACT</label><br>
                    <input type="text" name="user_contact" id="user_conatct" 
                           placeholder="Enter your contact" required="required" minlength="7"
                           pattern="\d{7,}" title="Do not include 'space' in your contact">



                    <!--pass-->
                    <br><label for="user_password">PASSWORD</label><br>
                    <input type="password" name="user_password" id="user_password" 
                           placeholder="Enter your password" required="required" minlength="7">

                    <!--c-pass-->
                    <br><label for="con_user_password">CONFIRM PASSWORD</label><br>
                    <input type="password" name="con_user_password" id="con_user_password" 
                           placeholder="Enter your password" required="required" minlength="7">                        
                </div>    

                <div class="logbtn">
                    <br><input type="submit" class="loginbutM" value="REGISTER" name="user_register">
                </div>
            </form>
        </div>
    </div>

    <div class="create">Have an account?<a href="login.php">  Login</a></div>    

</body>
</html>

<?php
// Check if the form is submitted
if (isset($_POST['user_register'])) {
    $user_username = $_POST['user_username'];
    $user_email = $_POST['user_email'];
    $user_password = $_POST['user_password'];
    $hash_password = password_hash($user_password, PASSWORD_DEFAULT);
    $con_user_password = $_POST['con_user_password'];
    $user_address = $_POST['user_address'];
    $user_contact = $_POST['user_contact'];

    // Check if username exists in the database
    $select_username_query = "SELECT * FROM user_table WHERE username='$user_username'";
    $result_username = mysqli_query($con, $select_username_query);
    $rows_username = mysqli_num_rows($result_username);

    // Check if email exists in the database
    $select_email_query = "SELECT * FROM user_table WHERE user_email='$user_email'";
    $result_email = mysqli_query($con, $select_email_query);
    $rows_email = mysqli_num_rows($result_email);

    // Check if phone number exists in the database
    $select_phone_query = "SELECT * FROM user_table WHERE user_phone='$user_contact'";
    $result_phone = mysqli_query($con, $select_phone_query);
    $rows_phone = mysqli_num_rows($result_phone);

    $pattern = "/^\d{7,}$/"; // 7 or more digits
    if (!preg_match($pattern, $user_contact)) {
        echo "<script>alert('Invalid contact number.')</script>";
    }

    // If username already exists, display an error message
    if ($rows_username > 0) {
        echo "<script>alert('Username already exists.')</script>";
    }
    // If email already exists, display an error message
    else if ($rows_email > 0) {
        echo "<script>alert('Email already exists.')</script>";
    }
    // If phone number already exists, display an error message
    else if ($rows_phone > 0) {
        echo "<script>alert('Phone number already exists.')</script>";
    }
    // If passwords don't match, display an error message
    else if ($user_password != $con_user_password) {
        echo "<script>alert('Password did not match.')</script>";
    }
    // If everything is valid, insert user data into the table
    else {
        // Upload user image
        $user_image = $_FILES['user_image']['name'];
        $user_image_tmp = $_FILES['user_image']['tmp_name'];

        if (!empty($user_image)) {
            move_uploaded_file($user_image_tmp, "./php/user_images/$user_image");
        } else {
            $user_image = "default.png";
        }

        // Insert user data into the table
        $insert_query = "INSERT INTO user_table (username, user_email, user_password, user_image, user_address, user_phone) 
                    VALUES ('$user_username', '$user_email', '$hash_password', '$user_image', '$user_address', '$user_contact')";
        $sql_execute = mysqli_query($con, $insert_query);

        if ($sql_execute) {
            echo "<script>alert('User is Registered!.')</script>";
        } else {
            echo "<script>alert('Error Registering User.')</script>";
        }
    }
}

mysqli_close($con);
?>