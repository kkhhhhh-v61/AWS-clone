<?php
@session_start();
include '../config/connect.php';

// Function to update product sales
function updateProductSales($con, $product_id, $quantity)
{
  // Check if product exists in sales table
  $check_query = "SELECT * FROM product_sales WHERE product_id = $product_id";
  $check_result = mysqli_query($con, $check_query);

  if (mysqli_num_rows($check_result) > 0) {
    // Update existing record
    $update_query = "UPDATE product_sales 
                        SET total_quantity_sold = total_quantity_sold + $quantity 
                        WHERE product_id = $product_id";
  } else {
    // Insert new record
    $update_query = "INSERT INTO product_sales (product_id, total_quantity_sold) 
                        VALUES ($product_id, $quantity)";
  }

  mysqli_query($con, $update_query);
}

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit();
}

// Get order ID from URL
if (isset($_GET['order_id'])) {
  $order_id = $_GET['order_id'];

  // Get order details
  $order_query = "SELECT o.*, u.username, u.user_email, u.user_address, u.user_phone 
                   FROM orders o 
                   JOIN user_table u ON o.user_id = u.user_id 
                   WHERE o.order_id = $order_id";
  $order_result = mysqli_query($con, $order_query);
  $order = mysqli_fetch_array($order_result);

  // Get order items and update sales data
  $items_query = "SELECT p.product_id, p.product_name, p.product_price, od.quantity 
                   FROM order_details od 
                   JOIN products p ON od.product_id = p.product_id 
                   WHERE od.order_id = $order_id";
  $items_result = mysqli_query($con, $items_query);

  // Update product sales for each item
  while ($item = mysqli_fetch_array($items_result)) {
    updateProductSales($con, $item['product_id'], $item['quantity']);
  }

  // Reset the result pointer to the beginning
  mysqli_data_seek($items_result, 0);
}
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
  <link href="../css/style.css" rel="stylesheet" type="text/css" />
  <link href="../css/login.css" rel="stylesheet" type="text/css" />
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
  <title>Blooms Co. | Order Confirmation</title>
  <style>
    .buttons {
      display: flex;
      gap: 10px;
      justify-content: center;
      margin-top: 20px;
    }

    .btn:hover {
      text-decoration: none;
    }
  </style>
</head>

<body>
  <?php include './header.php'; ?>

  <div class="login-container">
    <div class="login-header">
      <h2 class="login-title">ORDER CONFIRMATION</h2>
    </div>

    <div class="login-form">
      <div class="form-group">
        <h2>Order Summary</h2>
        <div class="order-info">
          <p><strong>Order Number:</strong> <?php echo $order['invoice_number']; ?></p>
          <p><strong>Order Date:</strong> <?php echo date('d/m/Y H:i', strtotime($order['order_date'])); ?></p>
          <p><strong>Payment Status:</strong> <?php echo $order['payment_status']; ?></p>
        </div>
      </div>

      <div class="form-group">
        <h3>Customer Information</h3>
        <div class="customer-info">
          <p><strong>Name:</strong> <?php echo $order['username']; ?></p>
          <p><strong>Email:</strong> <?php echo $order['user_email']; ?></p>
          <p><strong>Address:</strong> <?php echo $order['user_address']; ?></p>
          <p><strong>Phone:</strong> <?php echo $order['user_phone']; ?></p>
        </div>
      </div>

      <div class="form-group">
        <h3>Order Items</h3>
        <?php
        $total_amount = 0;
        while ($item = mysqli_fetch_array($items_result)) {
          $total_amount += $item['product_price'] * $item['quantity'];
        ?>
          <div class="order-item">
            <p><strong><?php echo $item['product_name']; ?></strong></p>
            <p>Quantity: <?php echo $item['quantity']; ?></p>
            <p>Price: RM <?php echo number_format($item['product_price'], 2); ?></p>
            <p>Subtotal: RM <?php echo number_format($item['product_price'] * $item['quantity'], 2); ?></p>
          </div>
        <?php
        }
        ?>

        <div class="order-total">
          <h3>Order Summary</h3>
          <p><strong>Total Items:</strong> <?php echo mysqli_num_rows($items_result); ?></p>
          <p><strong>Total Amount:</strong> RM <?php echo number_format($total_amount, 2); ?></p>
        </div>
      </div>

      <div class="form-group">
        <div class="pageConfirm">
          <p class="bold"><b>Thank You for Your Purchase!</b></p>
          <p>Your order has been successfully processed.</p>
        </div>

        <div class="buttons">
          <a href="./homepage.php" class="btn">Continue Shopping</a>
          <a href="./orderHistory.php" class="btn">View Order History</a>
        </div>
      </div>
    </div>
  </div>

  <?php include './footer.php'; ?>
  </div>
</body>

</html>