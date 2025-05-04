<!DOCTYPE html>

<html>

<head>
    <meta charset="UTF-8">
    <link href="../css/admin2.css" rel="stylesheet" type="text/css" />
    <link href="../css/tableSort.css" rel="stylesheet" type="text/css" />
    <title>Blooms Co. | Payment</title>
    <style>
        .page-header {
            text-align: center;
            margin: 20px 0;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
        }

        .product-filter-container {
            margin: 30px auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            max-width: 1200px;
            width: 100%;
        }

        .search-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0 auto;
        }

        .filter-input {
            padding: 12px 20px;
            border: 1px solid #ddd;
            border-radius: 4px;
            width: 300px;
            font-size: 14px;
            transform: translateY(15%);
        }

        .filter-btn {
            padding: 12px 24px;
            background: #000;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .filter-btn:hover {
            background: #333;
        }

        .order-table-container {
            margin: 30px auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            max-width: 1600px;
            width: 100%;
            overflow-x: auto;
        }

        .order-history-table {
            width: 100%;
            border-collapse: collapse;
            margin: 0;
        }

        .order-history-table th {
            background-color: #f8f9fa;
            font-weight: 600;
            color: #333;
            padding: 12px;
            text-align: left;
        }

        .order-history-table td {
            padding: 12px;
            text-align: left;
        }

        .order-history-table tr:hover {
            background-color: #f8f9fa;
        }

        .order-history-table th,
        .order-history-table td {
            text-align: center;
            width: calc(100% / 7);
        }

        .action-column {
            text-align: center;
            width: 10%;
        }

        .action-column .action-btn {
            padding: 8px;
            margin: 0 5px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
        }

        .action-column .action-btn:hover {
            opacity: 0.9;
        }

        .action-column .action-btn.delete {
            background-color: #dc3545;
        }

        .action-icon {
            font-size: 16px;
        }
    </style>
</head>

<body>
    <?php
    include './adminheader.php';
    include '../config/connect.php';
    ?>
    <div class="page-header">
        <h2>VIEW PAYMENT</h2>
    </div>

    <div class="product-filter-container">
        <form method="GET" class="product-filter-form">
            <div class="search-container">
                <input type="text"
                    placeholder="Search by Invoice Number"
                    name="search"
                    class="filter-input">
                <button type="submit" class="filter-btn">
                    <ion-icon name="search-outline"></ion-icon>
                </button>
            </div>
        </form>
    </div>

    <div class="order-table-container">
        <table class="order-history-table sortable" id="paymentTable">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Invoice Number</th>
                    <th>Customer Name</th>
                    <th>Customer Email</th>
                    <th>Total Amount</th>
                    <th>Quantity</th>
                    <th>Order Date</th>
                    <th>Payment Status</th>
                    <th class="action-column">Action</th>
                </tr>
            </thead>
            <?php
            if (isset($_GET['search'])) {
                $search_query = $_GET['search'];
                $query = "SELECT 
                    o.order_id,
                    o.invoice_number,
                    o.order_date,
                    o.payment_status,
                    u.username,
                    u.user_email,
                    SUM(od.quantity) AS total_quantity,
                    SUM(od.quantity * p.product_price) AS total_amount
                FROM orders o
                JOIN user_table u ON o.user_id = u.user_id
                JOIN order_details od ON o.order_id = od.order_id
                JOIN products p ON od.product_id = p.product_id
                WHERE o.invoice_number LIKE '%$search_query%'
                GROUP BY o.order_id, o.invoice_number, o.order_date, o.payment_status, u.username, u.user_email
                ORDER BY o.order_id ASC";
            } else {
                $query = "SELECT 
                    o.order_id,
                    o.invoice_number,
                    o.order_date,
                    o.payment_status,
                    u.username,
                    u.user_email,
                    SUM(od.quantity) AS total_quantity,
                    SUM(od.quantity * p.product_price) AS total_amount
                FROM orders o
                JOIN user_table u ON o.user_id = u.user_id
                JOIN order_details od ON o.order_id = od.order_id
                JOIN products p ON od.product_id = p.product_id
                GROUP BY o.order_id, o.invoice_number, o.order_date, o.payment_status, u.username, u.user_email
                ORDER BY o.order_id ASC";
            }
            $result = mysqli_query($con, $query);
            $number = 0;
            while ($row = mysqli_fetch_assoc($result)) {
                $order_id = $row['order_id'];
                $invoice_number = $row['invoice_number'];
                $order_date = $row['order_date'];
                $payment_status = $row['payment_status'];
                $username = $row['username'];
                $user_email = $row['user_email'];
                $total_quantity = $row['total_quantity'];
                $total_amount = $row['total_amount'];
            ?>
                <tr>
                    <td><?php echo $order_id ?></td>
                    <td><?php echo $invoice_number ?></td>
                    <td><?php echo $username ?></td>
                    <td><?php echo $user_email ?></td>
                    <td><?php echo number_format($total_amount, 2) ?></td>
                    <td><?php echo $total_quantity ?></td>
                    <td><?php echo date('d/m/Y H:i', strtotime($order_date)) ?></td>
                    <td><?php echo $payment_status ?></td>
                    <td class='action-column'>
                        <a href='#' onclick='showConfirmation(<?php echo $order_id ?>)' class='action-btn delete'>
                            <ion-icon name='trash-outline' class='action-icon'></ion-icon>
                        </a>
                    </td>
                </tr>
            <?php
            }
            ?>
        </table>
    </div>
    <?php include '../php/footer.php'; ?>
</body>
<script>
    function showConfirmation(orderId) {
        if (confirm("Are you sure you want to delete this order? This action cannot be undone.")) {
            // if the user clicks "OK" in the confirmation pop-up, redirect to the delete order page
            window.location.href = "deleteorder.php?id=" + orderId;
        } else {
            // if the user clicks "Cancel" in the confirmation pop-up, do nothing
        }
    }
</script>

</html>