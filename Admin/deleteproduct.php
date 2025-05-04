<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
  header("Location: adminlogin.php");
  exit();
}

// Check if product_id is set and is numeric
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
  header("Location: viewproduct.php?error=Invalid+product+ID");
  exit();
}

// Get product_id from URL
$product_id = (int)$_GET['id'];

// Include database connection
include '../config/connect.php';

// Check if connection is successful
if (!$con) {
  die("Connection failed: " . mysqli_connect_error());
}

// Start transaction
if (!mysqli_begin_transaction($con)) {
  die("Transaction failed: " . mysqli_error($con));
}

try {
  // Check if product exists
  $stmt = mysqli_prepare($con, "SELECT product_id FROM products WHERE product_id = ?");
  mysqli_stmt_bind_param($stmt, "i", $product_id);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);

  if (mysqli_num_rows($result) == 0) {
    throw new Exception("Product not found");
  }

  // Delete from cart_details first (if any entries exist)
  $stmt = mysqli_prepare($con, "DELETE FROM cart_details WHERE product_id = ?");
  mysqli_stmt_bind_param($stmt, "i", $product_id);
  mysqli_stmt_execute($stmt);

  // Delete from order_details (if any entries exist)
  $stmt = mysqli_prepare($con, "DELETE FROM order_details WHERE product_id = ?");
  mysqli_stmt_bind_param($stmt, "i", $product_id);
  mysqli_stmt_execute($stmt);

  // Delete from product_sales (if exists)
  $stmt = mysqli_prepare($con, "DELETE FROM product_sales WHERE product_id = ?");
  mysqli_stmt_bind_param($stmt, "i", $product_id);
  mysqli_stmt_execute($stmt);

  // Delete the product
  $stmt = mysqli_prepare($con, "DELETE FROM products WHERE product_id = ?");
  mysqli_stmt_bind_param($stmt, "i", $product_id);
  mysqli_stmt_execute($stmt);

  // Check if deletion was successful
  if (mysqli_stmt_affected_rows($stmt) <= 0) {
    throw new Exception("Failed to delete product");
  }

  // Commit transaction
  if (!mysqli_commit($con)) {
    throw new Exception("Commit failed: " . mysqli_error($con));
  }

  // Redirect back to viewproduct.php with success message
  header("Location: viewproduct.php?message=Product+deleted+successfully");
  exit();
} catch (Exception $e) {
  // Rollback transaction on error
  if (!mysqli_rollback($con)) {
    error_log("Rollback failed: " . mysqli_error($con));
  }

  // Log the error
  error_log("Delete failed: " . $e->getMessage());

  // Get the error message for display
  $error_message = urlencode($e->getMessage());

  // Redirect back to viewproduct.php with error message
  header("Location: viewproduct.php?error=" . $error_message);
  exit();
} finally {
  // Close connection
  if (isset($stmt)) {
    mysqli_stmt_close($stmt);
  }
  mysqli_close($con);
}
