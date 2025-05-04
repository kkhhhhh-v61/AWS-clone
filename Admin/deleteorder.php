<?php
@session_start();
include './adminheader.php';
include '../config/connect.php';

if (isset($_GET['id'])) {
  $delete_id = $_GET['id'];

  // First delete from order_details
  $delete_details_query = "DELETE FROM order_details WHERE order_id = $delete_id";

  try {
    $details_result = mysqli_query($con, $delete_details_query);
    if ($details_result) {
      // Then delete from orders
      $delete_query = "DELETE FROM orders WHERE order_id = $delete_id";

      try {
        $order_result = mysqli_query($con, $delete_query);
        if ($order_result) {
          echo "<script>alert('Order deleted successfully')</script>";
          echo "<script>window.open('./viewpayment.php','_self')</script>";
        } else {
          echo "<script>alert('Error deleting order. Please try again.')</script>";
          echo "<script>window.open('./viewpayment.php','_self')</script>";
        }
      } catch (mysqli_sql_exception $e) {
        echo "<script>alert('Error deleting order: " . mysqli_error($con) . "')</script>";
        echo "<script>window.open('./viewpayment.php','_self')</script>";
      }
    } else {
      echo "<script>alert('Error deleting order details. Please try again.')</script>";
      echo "<script>window.open('./viewpayment.php','_self')</script>";
    }
  } catch (mysqli_sql_exception $e) {
    echo "<script>alert('Error deleting order details: " . mysqli_error($con) . "')</script>";
    echo "<script>window.open('./viewpayment.php','_self')</script>";
  }
}
