<?php
//password is 123456789
//AD1001 and so on 
require_once './helper.php';
// Start the session
session_start();

// Check if the user is already logged in
if (isset($_SESSION['admin_id'])) {
    // User is already logged in, redirect to the homepage
    header('Location: adminaccount.php');
    exit;
}

// Handle form submission
if (isset($_POST['admin_login'])) {
    $admin_ID = $_POST['admin_ID'];
    $admin_password = $_POST['admin_password'];

    // Verify user credentials
    $select_query = "SELECT * FROM admin_table WHERE admin_id = '$admin_ID'";
    $result = mysqli_query($con, $select_query);

    if ($result) {
        $row_data = mysqli_fetch_assoc($result);
        if ($row_data) {
            if (password_verify($admin_password, $row_data['admin_password'])) {
                // Set the 'username' session variable
                $_SESSION['admin_id'] = $row_data['admin_id'];
                // Redirect to the homepage
                header('Location: adminaccount.php');
                exit;
            } else {
                echo "<script>alert('Invalid username or password')</script>";
            }
        } else {
            echo "<script>alert('Invalid username or password')</script>";
        }
    } else {
        echo "<script>alert('Invalid username or password')</script>";
    }
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link href="../css/login.css" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
        <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
        <title>Login Admin | Eversummer Florist</title>
        <script>
            function togglePassword() {
                var passwordInput = document.getElementById('admin_password');
                if (passwordInput.type === "password") {
                    passwordInput.type = "text";
                } else {
                    passwordInput.type = "password";
                }
            }
        </script>
    </head>
    <body>
        <?php include './adminheader.php'; ?>

        <div class="logintittle">
            <p>Home/Account/</p></br>
            <p class="bold"><b>ADMIN LOGIN</b></p>
        </div>

        <form action="" method="post">
            <div class="container2">
                <div class="container">
                    <div class="fontsz">
                        <!--username-->
                        <label for="user_username">ADMIN ID</label><br>
                        <input type="text" name="admin_ID" id="admin_ID" 
                               placeholder="Enter your username" required="required">

                        <!--pass-->
                        <br><label for="user_password">PASSWORD</label><br>
                        <input type="password" name="admin_password" id="admin_password" 
                               placeholder="Enter your password" required="required">
                        <br><input type="checkbox" onclick="togglePassword()"> Show Password
                    </div>
                </div>
            </div>

            <div class="logbtn2">
                <br><input type="submit" class="loginbutM" value="LOGIN" name="admin_login">
            </div>

            <div class="create">New Admin?<a href="registeradmin.php">  Register</a></div>
        </form>

    </body>
</html>