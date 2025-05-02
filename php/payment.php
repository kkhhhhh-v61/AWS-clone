<!DOCTYPE html>

<html>

<head>
    <meta charset="UTF-8">
    <link href="../css/login.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <title>PAYMENT |SNEAKER VAULT</title>
</head>

<body>
    <?php
    @session_start();
    include '../config/helper.php';
    include '../functions/common_function.php';

    // Get total amount from cart
    $get_ip_add = getIPAddress();
    $cart_query = "SELECT * FROM cart_details WHERE ip_address = '$get_ip_add'";
    $result = mysqli_query($con, $cart_query);
    $total_price = 0;

    while ($row = mysqli_fetch_array($result)) {
        $product_id = $row['product_id'];
        $select_products = "SELECT * FROM products WHERE product_id = '$product_id'";
        $result_products = mysqli_query($con, $select_products);
        $row_product_price = mysqli_fetch_array($result_products);
        $product_price = $row_product_price['product_price'];
        $total_price += $product_price * $row['quantity'];
    }

    // Process payment
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['payAmt'])) {
        $paymentAmount = $_POST['payAmt'];
        $paymentDescription = $_POST['payDesc'];
        $tngID = $_POST['tngID'];

        // Verify payment amount matches cart total
        if ($paymentAmount != $total_price) {
            echo "<script>alert('Payment amount must match the total cart amount (RM $total_price)')</script>";
            echo "<script>window.location.href='./cart.php';</script>";
            exit();
        }

        // Get user ID
        $username = $_SESSION['username'];
        $user_query = "SELECT user_id FROM user_table WHERE username = '$username'";
        $user_result = mysqli_query($con, $user_query);
        $user_row = mysqli_fetch_array($user_result);
        $user_id = $user_row['user_id'];

        // Generate invoice number
        $invoice_number = 'INV-' . date('YmdHis');

        // Insert order
        $order_query = "INSERT INTO orders (user_id, invoice_number, payment_status) 
                   VALUES ($user_id, '$invoice_number', 'Paid')";
        mysqli_query($con, $order_query);
        $order_id = mysqli_insert_id($con);

        // Insert order details
        $cart_query = "SELECT * FROM cart_details WHERE ip_address = '$get_ip_add'";
        $result = mysqli_query($con, $cart_query);

        while ($row = mysqli_fetch_array($result)) {
            $product_id = $row['product_id'];
            $quantity = $row['quantity'];

            $order_detail_query = "INSERT INTO order_details (order_id, product_id, quantity) 
                              VALUES ($order_id, $product_id, $quantity)";
            mysqli_query($con, $order_detail_query);
        }

        // Clear cart
        $clear_cart_query = "DELETE FROM cart_details WHERE ip_address = '$get_ip_add'";
        mysqli_query($con, $clear_cart_query);

        // Redirect to confirmation
        echo "<script>window.location.href='./orderConfirmation.php?order_id=$order_id';</script>";
        exit();
    }
    ?>
    <?php include './header.php'; ?>

    <div class="logintittle">
        <p>Home/</p></br>
        <p class="bold"><b>PAYMENT</b></p>
    </div>

    <div class="container2">
        <div class="container">
            <form id="payment-form" method="POST" action="">
                <div class='fontsz'>
                    <label for="payAmt">TOTAL AMOUNT</label><br>
                    <input type="number" name="payAmt" id="payAmt" value="<?php echo $total_price; ?>" readonly>
                    <br><label for="payDesc">PAYMENT DESCRIPTION</label><br>
                    <textarea id="payDesc" name="payDesc" required>Payment for Sneaker Vault order</textarea>
                    <br><label for="tngID">TOUCH 'n GO EWALLET ID:</label><br>
                    <input type="text" name="tngID" id="tngID" required>
                </div>
                <div class="logbtn">
                    <br><button class="log" type="submit">PAY WITH TOUCH 'n GO EWALLET</button>
                </div>
            </form>
        </div>
    </div>

    <div class="create"><a href="cart.php">Back</a></div>
    <?php include './footer.php'; ?>
</body>

</html>