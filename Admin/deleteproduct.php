<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_email'])) {
  header("Location: adminlogin.php");
  exit();
}

// Check if product_id is set
if (!isset($_GET['id'])) {
  header("Location: viewproduct.php");
  exit();
}

// Get product_id from URL
$product_id = $_GET['id'];

// Include database connection
include '../config/connect.php';

// Start transaction
mysqli_begin_transaction($con);

try {
  // Delete from cart_details first (if any entries exist)
  $delete_cart = "DELETE FROM cart_details WHERE product_id = $product_id";
  mysqli_query($con, $delete_cart);

  // Delete from order_details (if any entries exist)
  $delete_order_details = "DELETE FROM order_details WHERE product_id = $product_id";
  mysqli_query($con, $delete_order_details);

  // Delete the product
  $delete_product = "DELETE FROM products WHERE product_id = $product_id";
  mysqli_query($con, $delete_product);

  // Commit transaction
  mysqli_commit($con);

  // Redirect back to viewproduct.php with success message
  header("Location: viewproduct.php?deleted=1");
  exit();
} catch (Exception $e) {
  // Rollback transaction on error
  mysqli_rollback($con);

  // Redirect back to viewproduct.php with error message
  header("Location: viewproduct.php?error=1");
  exit();
}
