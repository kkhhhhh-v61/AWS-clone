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
        <link href="../css/style.css" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
        <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
        <title>Create Admin Account | Eversummer Florist</title>
    </head>
    <body
    <?php include './adminheader.php'; ?>

        <div class="pageContent">
        <p>Home/Account/</p></br>
        <p class="bold"><b>CREATE ADMIN ACCOUNT</b></p>
    </div>

    <div class="container2">
        <div class="container">
            <form action="" method="post" enctype="multipart/form-data">
                <div class="fontsz">
                    <!--username-->
                    <label for="user_username">ADMIN ID</label><br>
                    <input type="text" name="admin_id" id="admin_id" 
                           placeholder="Enter your username" required="required">

                    <!--pass-->
                    <br><label for="user_password">PASSWORD</label><br>
                    <input type="password" name="admin_password" id="admin_password" 
                           placeholder="Enter your password" required="required">

                    <!--c-pass-->
                    <br><label for="con_user_password">CONFIRM PASSWORD</label><br>
                    <input type="password" name="con_admin_password" id="con_admin_password" 
                           placeholder="Enter your password" required="required">                        
                </div>    

                <div class="logbtn">
                    <br><input type="submit" class="loginbutM" value="REGISTER" name="admin_register">
                </div>
            </form>
        </div>
    </div>

    <div class="create">Have an account?<a href="adminlogin.php">  Login</a></div>    

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
        echo "<script>alert('Admin Registered.')</script>";
    } else {
        echo "<script>alert('Error Registering Admin.')</script>";
    }
}


mysqli_close($con);
?>