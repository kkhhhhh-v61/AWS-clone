<?php
@session_start();
include '../config/connect.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Get order ID from URL
if (!isset($_GET['id'])) {
    header("Location: orderHistory.php");
    exit();
}

$order_id = $_GET['id'];

// Get order details
$order_query = "SELECT o.*, u.username, u.user_email, u.user_address, u.user_phone 
              FROM orders o 
              JOIN user_table u ON o.user_id = u.user_id 
              WHERE o.order_id = $order_id AND o.user_id = $_SESSION[user_id]";
$order_result = mysqli_query($con, $order_query);
$order = mysqli_fetch_assoc($order_result);

// Get order items
$items_query = "SELECT p.product_name, p.product_price, p.product_image1, 
                      od.quantity, 
                      (od.quantity * p.product_price) as item_total
               FROM order_details od 
               JOIN products p ON od.product_id = p.product_id 
               WHERE od.order_id = $order_id";
$items_result = mysqli_query($con, $items_query);
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <link href="../css/style.css" rel="stylesheet" type="text/css" />
    <link href="../css/login.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <title>Blooms Co. | Order Details</title>
</head>

<body>
    <?php include './header.php'; ?>

    <div class="login-container">
        <div class="form-group">
            <div class="login-header">
                <h2 class="login-title">ORDER DETAILS</h2>
            </div>

            <div class="order-container">
                <div class="order-summary">
                    <h2>Order Summary</h2>
                    <div class="order-info">
                        <p><strong>Order Number:</strong> <?php echo $order['invoice_number']; ?></p>
                        <p><strong>Order Date:</strong> <?php echo date('d/m/Y H:i', strtotime($order['order_date'])); ?></p>
                        <p><strong>Payment Status:</strong>
                            <span class="status-badge <?php echo strtolower($order['payment_status']); ?>">
                                <?php echo $order['payment_status']; ?>
                            </span>
                        </p>
                    </div>

                    <div class="customer-info">
                        <h3>Customer Information</h3>
                        <p><strong>Name:</strong> <?php echo $order['username']; ?></p>
                        <p><strong>Email:</strong> <?php echo $order['user_email']; ?></p>
                        <p><strong>Address:</strong> <?php echo $order['user_address']; ?></p>
                        <p><strong>Phone:</strong> <?php echo $order['user_phone']; ?></p>
                    </div>
                </div>

                <div class="order-items">
                    <h2>Order Items</h2>
                    <div class="items-container">
                        <?php
                        $total_amount = 0;
                        while ($item = mysqli_fetch_assoc($items_result)) {
                            $total_amount += $item['item_total'];
                        ?>
                            <div class="item-card">
                                <div class="item-image">
                                    <img src="../Admin/product_images/<?php echo $item['product_image1']; ?>"
                                        alt="<?php echo $item['product_name']; ?>"
                                        width="100" height="100">
                                </div>
                                <div class="item-details">
                                    <h3><?php echo $item['product_name']; ?></h3>
                                    <p><strong>Price:</strong> RM <?php echo number_format($item['product_price'], 2); ?></p>
                                    <p><strong>Quantity:</strong> <?php echo $item['quantity']; ?></p>
                                    <p><strong>Subtotal:</strong> RM <?php echo number_format($item['item_total'], 2); ?></p>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                    </div>

                    <div class="order-total">
                        <h3>Order Summary</h3>
                        <p><strong>Total Items:</strong> <?php echo mysqli_num_rows($items_result); ?></p>
                        <p><strong>Total Amount:</strong> RM <?php echo number_format($total_amount, 2); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include './footer.php'; ?>

    <style>
        .login-container {
            max-width: 1200px;
            margin: 50px auto;
        }

        .order-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: 30px;
        }

        .order-summary,
        .order-items {
            background: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
        }

        .order-info,
        .customer-info {
            margin-bottom: 20px;
        }

        .order-info p,
        .customer-info p {
            margin: 8px 0;
        }

        .items-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
        }

        .item-card {
            background: white;
            padding: 15px;
            border-radius: 8px;
            display: flex;
            gap: 15px;
        }

        .item-image img {
            object-fit: cover;
            border-radius: 4px;
        }

        .item-details h3 {
            margin: 0 0 10px 0;
            font-size: 16px;
        }

        .item-details p {
            margin: 5px 0;
        }

        .order-total {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin-top: 20px;
        }

        .order-total p {
            margin: 10px 0;
            font-size: 16px;
        }

        .status-badge {
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 12px;
        }

        .paid {
            background-color: #4CAF50;
            color: white;
        }

        .pending {
            background-color: #FFC107;
            color: black;
        }

        .cancelled {
            background-color: #F44336;
            color: white;
        }
    </style>
</body>

</html>