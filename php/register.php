<?php require_once '../config/connect.php'; ?>
<!DOCTYPE html>

<html>

<head>
    <meta charset="UTF-8">
    <link href="../css/login.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <title>Blooms Co. | Register</title>
</head>

<body
    <?php include './header.php'; ?>
    <div class="login-container">
    <div class="login-header">
        <h2 class="login-title">CREATE ACCOUNT</h2>
    </div>

    <form action="" method="post" enctype="multipart/form-data" class="login-form">
        <div class="form-group">
            <label for="user_username">USERNAME</label>
            <input type="text" name="user_username" id="user_username" class="form-control" required minlength="5">
        </div>

        <div class="form-group">
            <label for="user_email">EMAIL</label>
            <input type="email" name="user_email" id="user_email" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="user_image">PROFILE PICTURE (optional)</label>
            <input type="file" name="user_image" id="user_image" class="form-control">
        </div>

        <div class="form-group">
            <label for="user_address">ADDRESS</label>
            <input type="text" name="user_address" id="user_address" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="user_contact">CONTACT</label>
            <input type="text" name="user_contact" id="user_contact" class="form-control" required minlength="7" pattern="\d{7,}" title="Do not include 'space' in your contact">
        </div>

        <div class="form-group password-toggle">
            <label for="user_password">PASSWORD</label>
            <div class="password-input-container">
                <input type="password" name="user_password" id="user_password" class="form-control" required minlength="7">
                <button type="button" class="toggle-password" onclick="togglePasswordVisibility()">
                    <ion-icon name="eye-outline"></ion-icon>
                </button>
            </div>
        </div>

        <div class="form-group password-toggle">
            <label for="con_user_password">CONFIRM PASSWORD</label>
            <div class="password-input-container">
                <input type="password" name="con_user_password" id="con_user_password" class="form-control" required minlength="7">
                <button type="button" class="toggle-password" onclick="togglePasswordVisibility2()">
                    <ion-icon name="eye-outline"></ion-icon>
                </button>
            </div>
        </div>

        <div class="form-group">
            <button type="submit" name="user_register" class="loginbutM">REGISTER</button>
        </div>

        <div class="create">
            Have an account? <a href="login.php">Login</a>
        </div>
    </form>
    </div>
    <?php include './footer.php'; ?>

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
        $upload_dir = "../php/user_images/"; // Path relative to register.php

        if (!empty($user_image)) {
            // Ensure the upload directory exists
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            // Move the uploaded file
            if (move_uploaded_file($user_image_tmp, $upload_dir . $user_image)) {
                "<script>console.log('Profile picture uploaded successfully.')</script>";
            } else {
                "<script>console.log('Error uploading profile picture.')</script>";
                $user_image = "default.png";
            }
        } else {
            $user_image = "default.png";
            // Ensure default.png exists in the user_images directory
            if (!file_exists($upload_dir . "default.png")) {
                copy("../php/default.png", $upload_dir . "default.png");
            }
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