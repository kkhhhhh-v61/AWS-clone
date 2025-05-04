<?php
@session_start();
include '../config/connect.php';
include("../functions/common_function.php"); // Include common functions
// Call the functions
remove_cart_item($con);
update_cart_item($con);
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <link href="../css/style.css" rel="stylesheet" type="text/css" />
    <link href="../css/cart.css" rel="stylesheet" type="text/css" />
    <link href="../css/tableSort.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <script src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <script src="../javascript/tableSort.js"></script>
    <title>Blooms Co. | Cart</title>
</head>

<body>
    <?php
    include './header.php';

    // Check if user is logged in
    if (!isset($_SESSION["username"])) {
        echo "<script nomodule src='https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js'></script>";
        echo "<script src='../javascript/tableSort.js'></script>";
        echo "<script>alert('Please log in to access your cart.')</script>";
        echo "<script>window.location.href='./login.php';</script>";
    }
    ?>

    <div class="pageContent">
        <p class="bold"><b>CART</b></p>
    </div>

    <div class="product-display">
        <form action="cart.php" method="POST">
            <div class="cart-table">
                <table class="product-display-table sortable" id="cartTable">
                    <thead>
                        <tr>
                            <th>Item #</th>
                            <th>Product Details</th>
                            <th class="numeric">Unit Price</th>
                            <th class="numeric">Quantity</th>
                            <th class="numeric">Subtotal</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        global $con;
                        $get_ip_add = getIPAddress();
                        $total_price = 0;
                        $cart_query = "SELECT * FROM cart_details WHERE ip_address = '$get_ip_add'";
                        $result = mysqli_query($con, $cart_query);
                        $i = 1;

                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_array($result)) {
                                $product_id = $row['product_id'];
                                $select_products = "SELECT * FROM products WHERE product_id = '$product_id'";
                                $result_products = mysqli_query($con, $select_products);
                                while ($row_product_price = mysqli_fetch_array($result_products)) {
                                    $product_price = $row_product_price['product_price'];
                                    $price_table = number_format($product_price, 2);
                                    $product_name = $row_product_price['product_name'];
                                    $product_image1 = $row_product_price['product_image1'];
                                    $product_values = number_format($product_price * $row['quantity'], 2);
                                    $total_price += $product_price * $row['quantity'];
                                    $cart_quantity = $row['quantity'];
                                    echo "<tr>";
                                    echo "<td>$i</td>";
                                    echo "<td>$product_name</td>";
                                    echo "<td class='numeric'>$price_table</td>";
                                    echo "<td class='quantity-cell'>";
                                    echo "<button class='quantity-btn decrease' type='submit' name='decrease' value='$product_id'><ion-icon name='remove-circle-outline'></ion-icon></button>";
                                    echo "<span class='quantity-value'>$cart_quantity</span>";
                                    echo "<button class='quantity-btn increase' type='submit' name='increase' value='$product_id'><ion-icon name='add-circle-outline'></ion-icon></button>";
                                    echo "</td>";
                                    echo "<td class='numeric'>$product_values</td>";
                                    echo "<td><button class='remove-btn' type='submit' name='remove_cart' value='$product_id' title='Remove item'>";
                                    echo "<ion-icon name='trash-outline'></ion-icon>";
                                    echo "</button></td>";
                                    echo "</tr>";
                                    $i++;
                                }
                            }
                        } else {
                            echo "<tr><td colspan='6' class='empty-cart'>Your cart is empty. Add some items to get started!</td></tr>";
                        }
                        ?>

                    </tbody>
                </table>

                <div class="subtotal">
                    <p>Total Cart Value: RM <?php echo number_format($total_price, 2) ?></p>
                </div>

                <div class="cart-actions">
                    <input class="btn" type="submit" value="Continue Shopping" formaction="./product.php">
                    <input class="btn" type="submit" value="Checkout" formaction="./payment.php">
                </div>

            </div>
        </form>
    </div>

    <?php
    include './footer.php';

    function remove_cart_item($con)
    {
        if (isset($_POST['remove_cart'])) {
            $product_id = $_POST['remove_cart'];
            $get_ip_add = getIPAddress();

            // Delete from cart_details
            $delete_query = "DELETE FROM cart_details WHERE product_id = '$product_id' AND ip_address = '$get_ip_add'";
            $run_delete = mysqli_query($con, $delete_query);

            // Refresh the page
            echo "<script>window.location.href = 'cart.php';</script>";
        }
    }

    function update_cart_item($con)
    {
        if (isset($_POST['decrease']) || isset($_POST['increase'])) {
            $product_id = isset($_POST['decrease']) ? $_POST['decrease'] : $_POST['increase'];
            $get_ip_add = getIPAddress();

            // Get current quantity
            $current_query = "SELECT quantity FROM cart_details WHERE product_id = '$product_id' AND ip_address = '$get_ip_add'";
            $current_result = mysqli_query($con, $current_query);
            $current_row = mysqli_fetch_array($current_result);
            $current_quantity = $current_row['quantity'];

            // Update quantity based on button type
            if (isset($_POST['decrease'])) {
                $new_quantity = max(1, $current_quantity - 1);
            } else {
                $new_quantity = $current_quantity + 1;
            }

            // Update the database
            $update_query = "UPDATE cart_details SET quantity = '$new_quantity' WHERE product_id = '$product_id' AND ip_address = '$get_ip_add'";
            $run_update = mysqli_query($con, $update_query);

            // Refresh the page
            echo "<script>window.location.href = 'cart.php';</script>";
        }
    }
    ?>
</body>

</html>