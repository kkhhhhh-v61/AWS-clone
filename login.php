<?php
require_once './helper.php';
// Start the session
session_start();

// Check if the user is already logged in
if (isset($_SESSION['username'])) {
    // User is already logged in, redirect to the homepage
    header('Location: index.php');
    exit;
}

// Handle form submission
if (isset($_POST['user_login'])) {
    $user_username = $_POST['user_username'];
    $user_password = $_POST['user_password'];

    // Verify user credentials
    $select_query = "SELECT * FROM user_table WHERE username = '$user_username'";
    $result = mysqli_query($con, $select_query);

    if ($result) {
        $row_data = mysqli_fetch_assoc($result);
        if ($row_data) {
            if (password_verify($user_password, $row_data['user_password'])) {
                // Set the 'username' session variable
                $_SESSION['username'] = $row_data['username'];
                // Redirect to the homepage
                header('Location: index.php');
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
        <title>Login | Sneaker Vault</title>
        <script>
            function togglePassword() {
                var passwordInput = document.getElementById('user_password');
                if (passwordInput.type === "password") {
                    passwordInput.type = "text";
                } else {
                    passwordInput.type = "password";
                }
            }
        </script>
    </head>
    <body>
        <?php include './header.php'; ?>

        <div class="logintittle">
            <p>Home/Account/</p></br>
            <p class="bold"><b>LOGIN</b></p>
        </div>

        <form action="" method="post">
            <div class="container2">
                <div class="container">
                    <div class="fontsz">
                        <!--username-->
                        <label for="user_username">USERNAME</label><br>
                        <input type="text" name="user_username" id="user_username" 
                               placeholder="Enter your username" required="required" minlength="5">

                        <!--pass-->
                        <br><label for="user_password">PASSWORD</label><br>
                        <input type="password" name="user_password" id="user_password" 
                               placeholder="Enter your password" required="required" minlength="7">
                        <br><input type="checkbox" onclick="togglePassword()"> Show Password
                    </div>
                </div>
            </div>

            <div class="logbtn2">
                <br><input type="submit" class="loginbutM" value="LOGIN" name="user_login">
            </div>

            <div class="create">Don't have an account?<a href="register.php">  Register</a></div>

        </form>

        <?php include './footer.php'; ?>
    </body>

</html>