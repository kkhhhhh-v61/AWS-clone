<?php
session_start();
include("helper.php"); // assuming you have a separate config file for database connection

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $query = "SELECT * FROM user_table WHERE username = '$username'";
    $result = mysqli_query($con, $query);
    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $email = $row['user_email'];
        $address = $row['user_address'];
        $phone = $row['user_phone'];

        if (isset($_POST['submit'])) {
            $new_email = $_POST['email'];
            $new_address = $_POST['address'];
            $new_phone = $_POST['phone'];
            $update_query = "UPDATE user_table SET user_email = '$new_email', user_address = '$new_address', user_phone = '$new_phone' WHERE username = '$username'";
            $update_result = mysqli_query($con, $update_query);
            if ($update_result) {
                header("Location: accountset.php"); // redirect to dashboard page upon successful update
                exit();
            } else {
                echo "Error: " . mysqli_error($con);
            }
        }
        ?>
        <!DOCTYPE html>
        <html>
            <head>
                <link href="../css/editaccount.css" rel="stylesheet" type="text/css"/>
                <title>Edit Profile</title>
            </head>
            <body>
                <?php include './header.php'; ?>
                <h2>Edit Profile</h2>
                <form method="POST">
                    <div class="container2">
                        <div class="container">
                            <div class="fontsz">
                                <label for="email">Email:</label><br>
                                <input type="email" id="email" name="email" value="<?php echo $email; ?>" required><br><br>
                                <label for="address">Address:</label><br>
                                <input type="text" id="address" name="address" value="<?php echo $address; ?>" required><br><br>
                                <label for="phone">Phone:</label><br>
                                <input type="tel" id="phone" name="phone" value="<?php echo $phone; ?>" required><br><br>
                            </div>
                        </div>
                    </div>
                    <div class="logbtn2">
                        <input class="loginbutM" type="submit" name="submit" value="Save Changes">
                    </div>
                </form>
                <?php include './footer.php'; ?>
            </body>
        </html>
        <?php
    } else {
        echo "Error: User not found.";
    }
} else {
    header("Location: login.php"); // redirect to login page if user is not logged in
    exit();
}
mysqli_close($con);
?>