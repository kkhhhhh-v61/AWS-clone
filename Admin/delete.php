<?php
@session_start();
include './adminheader.php';
include '../config/helper.php';

if (isset($_GET['id'])) {
    $delete_id = $_GET['id'];

    // Try to delete the user
    $delete_query = "DELETE FROM user_table WHERE user_id = $delete_id";

    try {
        $result = mysqli_query($con, $delete_query);
        if ($result) {
            echo "<script>alert('User deleted successfully')</script>";
            echo "<script>window.open('./adminaccount.php','_self')</script>";
        }
    } catch (mysqli_sql_exception $e) {
        // Check if the error is due to foreign key constraint
        if ($e->getCode() === 1451) { // Error code for foreign key constraint
            // Check which table is causing the constraint
            $error_message = $e->getMessage();
            if (strpos($error_message, 'cart_details') !== false) {
                echo "<script>alert('Cannot delete user because they have items in the cart. Please remove the items first.')</script>";
            } elseif (strpos($error_message, 'orders') !== false) {
                echo "<script>alert('Cannot delete user because they have placed orders. Please delete the orders first.')</script>";
            } else {
                echo "<script>alert('Cannot delete user because they are being used in the system. Please check all references and remove them first.')</script>";
            }
            echo "<script>window.open('./adminaccount.php','_self')</script>";
        } else {
            // For other database errors
            echo "<script>alert('An error occurred while deleting the user. Please try again.')</script>";
            echo "<script>window.open('./adminaccount.php','_self')</script>";
        }
    }
}
