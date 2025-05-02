<?php
require_once './helper.php';

// Start the session
session_start();

// Handle form submission
if (isset($_POST['change_password'])) {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_new_password = $_POST['confirm_new_password'];

    // Verify user credentials
    $select_query = "SELECT * FROM user_table WHERE username = '{$_SESSION['username']}'";
    $result = mysqli_query($con, $select_query);

    if ($result) {
        $row_data = mysqli_fetch_assoc($result);
        if ($row_data) {
            if (password_verify($current_password, $row_data['user_password'])) {
                if ($new_password === $confirm_new_password) {
                    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                    $update_query = "UPDATE user_table SET user_password = '$hashed_password' WHERE username = '{$_SESSION['username']}'";
                    $update_result = mysqli_query($con, $update_query);

                    if ($update_result) {
                        echo "<script>alert('Password changed successfully')</script>";
                    } else {
                        echo "<script>alert('Failed to update password')</script>";
                    }
                } else {
                    echo "<script>alert('New passwords do not match')</script>";
                }
            } else {
                echo "<script>alert('Incorrect current password')</script>";
            }
        } else {
            echo "<script>alert('User not found')</script>";
        }
    } else {
        echo "<script>alert('Failed to fetch user data')</script>";
    }
}
?>

<?php
require_once './helper.php';
?>
<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link href="../css/accountset.css" rel="stylesheet" type="text/css"/>
        <title>Account | Sneaker Vault</title>
    </head>
    <body>
        <?php include './header.php'; ?>
        <div class="tittle">
            <p>Home/</p></br>
            <p class="bold"><b>ACCOUNT</b></p>
        </div>

        <div class="settingstitle">GENERAL INFORMATION
            <hr class="solid">
        </div>

        <?php
        $username = $_SESSION['username'];
        $user_image_query = "SELECT user_image FROM user_table WHERE username = '$username'";
        $user_image_result = mysqli_query($con, $user_image_query);
        if ($user_image_result && mysqli_num_rows($user_image_result) > 0) {
            $row = mysqli_fetch_assoc($user_image_result);
            $user_image = $row['user_image'];
            echo "<center><img src='./php/user_images/$user_image' class='pic' alt='Profile Picture'></center>";
        }
        ?>

        <div class="totals">
            <div class="line">
                <label>USERNAME</label>
                <?php
                $username = $_SESSION['username'];
                $user_info_query = "SELECT username FROM user_table WHERE username = '$username'";
                $user_info_result = mysqli_query($con, $user_info_query);
                if ($user_info_result && mysqli_num_rows($user_info_result) > 0) {
                    $row = mysqli_fetch_assoc($user_info_result);
                    $username = $row['username'];
                    echo "<div class='text' id='username'>$username</div>";
                }
                ?>
            </div>
        </div>

        <div class="totals">
            <div class="line">
                <label>EMAIL</label>
                <?php
                $username = $_SESSION['username'];
                $email_query = "SELECT user_email FROM user_table WHERE username = '$username'";
                $email_result = mysqli_query($con, $email_query);
                if ($email_result && mysqli_num_rows($email_result) > 0) {
                    $row = mysqli_fetch_assoc($email_result);
                    $email = $row['user_email'];
                    echo "<div class='text' id='email'>$email</div>";
                }
                ?>

            </div>
        </div>

        <div class="totals">
            <div class="line">
                <label>DELIVERY ADDRESS</label>
                <?php
                $username = $_SESSION['username'];
                $address_query = "SELECT user_address FROM user_table WHERE username = '$username'";
                $address_result = mysqli_query($con, $address_query);
                if ($address_result && mysqli_num_rows($address_result) > 0) {
                    $row = mysqli_fetch_assoc($address_result);
                    $address = $row['user_address'];
                    echo "<div class='text' id='add'>$address</div>";
                }
                ?>

            </div>
        </div>

        <div class="totals">
            <div class="line">
                <label>CONTACT</label>
                <?php
                $username = $_SESSION['username'];
                $contact_query = "SELECT user_phone FROM user_table WHERE username = '$username'";
                $contact_result = mysqli_query($con, $contact_query);
                if ($contact_result && mysqli_num_rows($contact_result) > 0) {
                    $row = mysqli_fetch_assoc($contact_result);
                    $contact = $row['user_phone'];
                    echo "<div class='text' id='phoneno'>$contact</div>";
                }
                ?>

            </div>
        </div>
        <form action="edit_account.php" method="post">
            <div class="logbtn">
                <br>
                <input type="submit" class="btn4" value="EDIT INFORMATION" name="change_password">
            </div>
        </form>


        <div class="settingstitle2">CHANGE PASSWORD
            <hr class="solid">
        </div>

        <form action="" method="post">
            <div class="container2">
                <div class="container">
                    <div class="fontsz">
                        <label for="current_password">CURRENT PASSWORD</label><br>
                        <input type="password" name="current_password" id="current_password" placeholder="Enter your current password" required="required">
                        <br>
                        <label for="new_password">NEW PASSWORD</label><br>
                        <input type="password" name="new_password" id="new_password" placeholder="Enter your new password" required="required">
                        <br>
                        <label for="confirm_new_password">CONFIRM NEW PASSWORD</label><br>
                        <input type="password" name="confirm_new_password" id="confirm_new_password" placeholder="Confirm your new password" required="required">
                    </div>
                </div>
            </div>
            <div class="logbtn">
                <br>
                <input type="submit" class="btn3" value="CHANGE PASSWORD" name="change_password">
            </div>
        </form>

        <?php include './footer.php'; ?>
         </body>
</html>