<?php
require_once '../config/connect.php';
// Start the session
@session_start();

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
    <link href="../css/login.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <title>Blooms Co. | Admin Login</title>
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('admin_password');
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
</head>

<body>
    <?php include './adminheader.php'; ?>

    <div class="login-container">
        <div class="login-header">
            <h2 class="login-title">ADMIN LOGIN</h2>
        </div>

        <form action="" method="post" class="login-form">
            <div class="form-group">
                <label for="admin_ID">ADMIN ID</label>
                <input type="text" name="admin_ID" id="admin_ID" class="form-control" required>
            </div>

            <div class="form-group password-toggle">
                <label for="admin_password">PASSWORD</label>
                <div class="password-input-container">
                    <input type="password" name="admin_password" id="admin_password" class="form-control" required>
                    <button type="button" class="toggle-password" onclick="togglePassword()">
                        <ion-icon name="eye-outline"></ion-icon>
                    </button>
                </div>
            </div>

            <div class="form-group">
                <button type="submit" name="admin_login" class="loginbutM">LOGIN</button>
            </div>

            <div class="create">
                New Admin? <a href="registeradmin.php">Register</a>
            </div>
        </form>
    </div>

    <?php include '../php/footer.php'; ?>
</body>

</html>