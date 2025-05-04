<?php
require_once '../config/connect.php';

// Start the session
session_start();

// Check if the user is already logged in
if (isset($_SESSION['user_id'])) {
    header('Location: ./homepage.php');
    exit;
}

// Handle form submission
if (isset($_POST['user_login'])) {
    $user_username = mysqli_real_escape_string($con, $_POST['user_username']);
    $user_password = $_POST['user_password'];

    // Verify user credentials
    $select_query = "SELECT * FROM user_table WHERE username = '$user_username'";
    $result = mysqli_query($con, $select_query);

    if ($result) {
        $row_data = mysqli_fetch_assoc($result);
        if ($row_data) {
            if (password_verify($user_password, $row_data['user_password'])) {
                // Set session variables
                $_SESSION['username'] = $row_data['username'];
                $_SESSION['user_id'] = $row_data['user_id'];
                // Redirect to the homepage
                header('Location: ./homepage.php');
                exit;
            } else {
                // Add error message
                $error = "Invalid username or password";
            }
        } else {
            // Add error message
            $error = "Invalid username or password";
        }
    } else {
        // Add error message
        $error = "Invalid username or password";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <link href="../css/login.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <title>Blooms Co. | Login</title>
    <style>
        .error-message {
            color: #ff4444;
            background-color: #fff2f2;
            padding: 10px;
            border-radius: 5px;
            margin-top: 10px;
            text-align: center;
        }
    </style>
</head>

<body>
    <?php include './header.php'; ?>

    <div class="login-container">
        <div class="login-header">
            <h2 class="login-title">LOGIN</h2>
        </div>

        <form action="" method="post" class="login-form">
            <div class="form-group">
                <label for="user_username">USERNAME</label>
                <input type="text" name="user_username" id="user_username" class="form-control" required>
            </div>

            <div class="form-group password-toggle">
                <label for="user_password">PASSWORD</label>
                <div class="password-input-container">
                    <input type="password" name="user_password" id="user_password" class="form-control" required>
                    <button type="button" class="toggle-password" onclick="togglePasswordVisibility()">
                        <ion-icon name="eye-outline"></ion-icon>
                    </button>
                </div>
            </div>

            <div class="form-group">
                <button type="submit" name="user_login" class="loginbutM">LOGIN</button>
            </div>

            <?php if (isset($error)) { ?>
                <div class="error-message">
                    <?php echo $error; ?>
                </div>
            <?php } ?>

            <div class="create">
                Don't have an account? <a href="./register.php">Register</a>
            </div>
        </form>
    </div>

    <script>
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('user_password');
            const toggleButton = document.querySelector('.toggle-password');
            const icon = toggleButton.querySelector('ion-icon');

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                icon.name = "eye-off-outline";
            } else {
                passwordInput.type = "password";
                icon.name = "eye-outline";
            }
        }
    </script>

    <?php include './footer.php'; ?>
</body>

</html>