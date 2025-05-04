<?php require_once '../config/connect.php'; ?>
<!DOCTYPE html>

<html>

<head>
    <meta charset="UTF-8">
    <link href="../css/login.css" rel="stylesheet" type="text/css" />
    <link href="../css/style.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <script>
        function togglePasswordVisibility(inputId) {
            const input = document.getElementById(inputId);
            const icon = input.nextElementSibling.querySelector('ion-icon');

            if (input.type === "password") {
                input.type = "text";
                icon.name = "eye-outline";
            } else {
                input.type = "password";
                icon.name = "eye-off-outline";
            }
        }
    </script>
    <title>Blooms Co. | Admin Registration</title>
</head>

<body
    <?php include './adminheader.php'; ?>

    <div class="login-container">
    <div class="login-header">
        <h2 class="login-title">ADMIN REGISTRATION</h2>
    </div>

    <form action="" method="post" enctype="multipart/form-data" class="login-form">
        <div class="form-group">
            <label for="admin_id">ADMIN ID</label>
            <input type="text" name="admin_id" id="admin_id" class="form-control" required>
        </div>

        <div class="form-group password-toggle">
            <label for="admin_password">PASSWORD</label>
            <div class="password-input-container">
                <input type="password" name="admin_password" id="admin_password" class="form-control" required>
                <button type="button" class="toggle-password" onclick="togglePasswordVisibility('admin_password')">
                    <ion-icon name="eye-outline"></ion-icon>
                </button>
            </div>
        </div>

        <div class="form-group password-toggle">
            <label for="con_admin_password">CONFIRM PASSWORD</label>
            <div class="password-input-container">
                <input type="password" name="con_admin_password" id="con_admin_password" class="form-control" required>
                <button type="button" class="toggle-password" onclick="togglePasswordVisibility('con_admin_password')">
                    <ion-icon name="eye-outline"></ion-icon>
                </button>
            </div>
        </div>

        <div class="form-group">
            <button type="submit" name="admin_register" class="loginbutM">REGISTER</button>
        </div>

        <div class="create">
            Have an account? <a href="adminlogin.php">Login</a>
        </div>
    </form>
    </div>
    <?php include '../php/footer.php'; ?>
</body>

</html>

<?php
// Check if the form is submitted
if (isset($_POST['admin_register'])) {
    $admin_id = $_POST['admin_id'];
    $admin_password = $_POST['admin_password'];
    $hash_password = password_hash($admin_password, PASSWORD_DEFAULT);
    $con_admin_password = $_POST['con_admin_password'];

    // Check if id exists in the database
    $select_id_query = "SELECT * FROM admin_table WHERE admin_id='$admin_id'";
    $result_id = mysqli_query($con, $select_id_query);
    $rows_id = mysqli_num_rows($result_id);

    // If username already exists, display an error message
    if ($rows_id > 0) {
        echo "<script>alert('ID already exists.')</script>";
    }

    // If passwords don't match, display an error message
    else if ($admin_password != $con_admin_password) {
        echo "<script>alert('Password did not match.')</script>";
    }

    // Insert user data into the table
    $insert_query = "INSERT INTO admin_table (admin_id, admin_password) 
                    VALUES ('$admin_id', '$hash_password')";
    $sql_execute = mysqli_query($con, $insert_query);

    if ($sql_execute) {
        echo "<script>alert('Admin Registered successfully! Redirecting to login page...')</script>";
        echo "<script>window.location.href = 'adminlogin.php';</script>";
    } else {
        echo "<script>alert('Error Registering Admin.')</script>";
    }
}


mysqli_close($con);
?>