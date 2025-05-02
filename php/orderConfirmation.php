<?php
@session_start();
include '../config/helper.php';

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

    // Get order items
    $items_query = "SELECT p.product_name, p.product_price, od.quantity 
                   FROM order_details od 
                   JOIN products p ON od.product_id = p.product_id 
                   WHERE od.order_id = $order_id";
    $items_result = mysqli_query($con, $items_query);
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
    <link href="../css/style.css" rel="stylesheet" type="text/css" />
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <title>Order Confirmation | Sneaker Vault</title>
</head>

<body>
    <?php include './header.php'; ?>

    <div class="pageContent">
        <p>Home/Payment/</p></br>
        <p class="bold"><b>ORDER CONFIRMATION</b></p>
    </div>

    <div class="order-container">
        <div class="centered-content">
            <div class="order-details">
                <h2>Order Details</h2>
                <p><strong>Order Number:</strong> <?php echo $order['invoice_number']; ?></p>
                <p><strong>Order Date:</strong> <?php echo date('d/m/Y H:i', strtotime($order['order_date'])); ?></p>
                <p><strong>Payment Status:</strong> <?php echo $order['payment_status']; ?></p>

                <h3>Customer Information</h3>
                <p><strong>Name:</strong> <?php echo $order['username']; ?></p>
                <p><strong>Email:</strong> <?php echo $order['user_email']; ?></p>
                <p><strong>Address:</strong> <?php echo $order['user_address']; ?></p>
                <p><strong>Phone:</strong> <?php echo $order['user_phone']; ?></p>

                <h3>Order Items</h3>
                <div class="order-items">
                    <?php
                    $total_amount = 0;
                    while ($item = mysqli_fetch_array($items_result)) {
                        $total_amount += $item['product_price'] * $item['quantity'];
                    ?>
                        <div class="order-item">
                            <p><strong><?php echo $item['product_name']; ?></strong></p>
                            <p>Quantity: <?php echo $item['quantity']; ?></p>
                            <p>Price: RM <?php echo $item['product_price']; ?></p>
                        </div>
                    <?php } ?>
                </div>
                <div class="order-total">
                    <p><strong>Total Amount Paid:</strong> RM <?php echo number_format($total_amount, 2); ?></p>
                </div>
            </div>
        </div>

        <div class="centered-content">
            <div class="pageConfirm">
                <p class="bold"><b>Thank You for Your Purchase!</b></p>
                <p>Your order has been successfully processed.</p>
            </div>
        </div>

        <div class="centered-content">
            <div class="buttons">
                <a href="./homepage.php"><button class="ok-btn">Continue Shopping</button></a>
                <a href="./accountset.php"><button class="ok-btn">View Order History</button></a>
            </div>
        </div>

        <?php include './footer.php'; ?>
    </div>
</body>

</html>