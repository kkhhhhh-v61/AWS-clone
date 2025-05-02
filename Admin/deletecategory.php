<?php
@session_start();
include './adminheader.php';
include '../config/connect.php';

if (isset($_GET['id'])) {
    $delete_id = $_GET['id'];

    // Try to delete the category
    $delete_query = "DELETE FROM categories WHERE category_id = $delete_id";

    try {
        $result = mysqli_query($con, $delete_query);
        if ($result) {
            echo "<script>alert('Category deleted successfully')</script>";
            echo "<script>window.open('./viewcategory.php','_self')</script>";
        }
    } catch (mysqli_sql_exception $e) {
        // Check if the error is due to foreign key constraint
        if ($e->getCode() === 1451) { // Error code for foreign key constraint
            echo "<script>alert('Cannot delete category because it has products assigned to it. Please delete or reassign the products first.')</script>";
            echo "<script>window.open('./viewcategory.php','_self')</script>";
        } else {
            // For other database errors
            echo "<script>alert('An error occurred while deleting the category. Please try again.')</script>";
            echo "<script>window.open('./viewcategory.php','_self')</script>";
        }
    }
}
