<?php
@session_start();
include ("functions/common_function.php"); // Include common functions
// Call the functions
remove_cart_item($con);
update_cart_item($con);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link href="../css/admin.css" rel="stylesheet" type="text/css"/>
    <title>Cart | Sneaker Vault</title>
</head>

<body>
<?php
include './header.php';

// Check if user is logged in
if (!isset($_SESSION["username"])) {
    echo "<script>alert('Please log in to access your cart.')</script>";
    echo "<script>window.location.href='./login.php';</script>";
}
?>

<div class="pageContent">
    <p>Home/</p></br>
    <p class="bold"><b>CART</b></p>
</div>

<div class="product-display">
    <form action="cart.php" method="POST">
        <table class="product-display-table">
            <thead>
            <tr>
                <td>Product Name</td>
                <td>Product Image</td>
                <td>Quantity</td>
                <td>Unit Price</td>
                <td>Remove</td>
                <td>Action</td>
            </tr>
            </thead>

            <tbody>
            <?php
            global $con;
            $get_ip_add = getIPAddress();
            $total_price = 0;
            $cart_query = "SELECT * FROM cart_details WHERE ip_address = '$get_ip_add'";
            $result = mysqli_query($con, $cart_query);
            while ($row = mysqli_fetch_array($result)) {
                $product_id = $row['product_id'];
                $select_products = "SELECT * FROM products WHERE product_id = '$product_id'";
                $result_products = mysqli_query($con, $select_products);
                while ($row_product_price = mysqli_fetch_array($result_products)) {
                    $product_price = $row_product_price['product_price'];
                    $price_table = $row_product_price['product_price'];
                    $product_name = $row_product_price['product_name'];
                    $product_image1 = $row_product_price['product_image1'];
                    $product_values = $product_price * $row['quantity'];
                    $total_price += $product_values;
                    $cart_quantity = $row['quantity'];
                    echo "<tr>";
                    echo "<td>$product_name</td>";
                    echo "<td><img src='../Admin/product_images/$product_image1' width='100px' height='100px'/></td>";
                    echo "<td><input type='number' name='qty[$product_id]' value='$cart_quantity' min='1'></td>";
                    echo "<td>RM $price_table</td>";
                    echo "<td><input type='checkbox' name='removeitem[]' value='$product_id'></td>";
                    echo "<td><input class='btn' type='submit' value='Update' name='update_cart'>";
                    echo "<input class='btn' type='submit' value='Remove' name='remove_cart'></td>";
                    echo "</tr>";
                }
            }
            ?>
            </tbody>
        </table>
        <div>
            <table class="product-display-table">
                <tr>
                    <td><b>Subtotal: RM <?php echo $total_price ?></b></td>
                </tr>
            </table>
            <center>
            <input class="btn" type="submit" value="Continue Shopping" formaction="product.php">
            <input class="btn" type="submit" value="Checkout" formaction="payment.php">
            </center>
        </div>
    </form>
</div>

<?php
include './footer.php';

function remove_cart_item($con) {
    if (isset($_POST['remove_cart'])) {
        // Check if any items are selected for removal
        if(isset($_POST['removeitem'])) {
            foreach ($_POST['removeitem'] as $remove_id) {
                $delete_query = "DELETE FROM cart_details WHERE product_id = $remove_id";
                $run_delete = mysqli_query($con, $delete_query);
                if ($run_delete) {
                    header("Location: cart.php");
                    exit();
                }
            }
        } else {
            // No items selected for removal
            echo "<script>alert('Please select items to remove.')</script>";
        }
    }
}


function update_cart_item($con) {
    if (isset($_POST['update_cart'])) {
        foreach ($_POST['qty'] as $product_id => $quantity) {
            $update_cart = "UPDATE cart_details SET quantity = $quantity WHERE product_id = $product_id";
            $result = mysqli_query($con, $update_cart);
            if (!$result) {
                // Handle update error
                echo "Error updating cart";
            }
        }
    }
}
?>
</body>
</html>