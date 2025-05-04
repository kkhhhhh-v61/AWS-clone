<?php
@session_start();
include '../config/connect.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Get user ID from session
$user_id = $_SESSION['user_id'];

// Search functionality
$search_query = "";
if (isset($_GET['search'])) {
    $search_query = $_GET['search'];
}

// Get order status filter
$status_filter = "";
if (isset($_GET['status'])) {
    $status_filter = $_GET['status'];
}

// Get date range filter
$start_date = "";
$end_date = "";
if (isset($_GET['start_date']) && isset($_GET['end_date'])) {
    $start_date = $_GET['start_date'];
    $end_date = $_GET['end_date'];
}

// Build the query based on filters
$query = "SELECT o.*, u.username, u.user_email, u.user_address, u.user_phone 
          FROM orders o 
          JOIN user_table u ON o.user_id = u.user_id 
          WHERE o.user_id = $user_id";

// Add search filter
if (!empty($search_query)) {
    $query .= " AND (o.invoice_number LIKE '%$search_query%' 
                 OR u.username LIKE '%$search_query%' 
                 OR u.user_email LIKE '%$search_query%')";
}

// Add status filter
if (!empty($status_filter)) {
    $query .= " AND o.payment_status = '$status_filter'";
}

// Add date range filter
if (!empty($start_date) && !empty($end_date)) {
    $query .= " AND o.order_date BETWEEN '$start_date' AND '$end_date'";
}

// Order by date (newest first)
$query .= " ORDER BY o.order_date DESC";

$result = mysqli_query($con, $query);
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <link href="../css/style.css" rel="stylesheet" type="text/css" />
    <link href="../css/homepage.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <script src="../javascript/tableSort.js"></script>
    <title>Blooms Co. | Order History</title>
</head>

<body>
    <?php include './header.php'; ?>
    <div class="page-header">
        <h2>ORDER HISTORY</h2>
    </div>

    <!-- Order History Section -->
    <div class="homepage-section">

        <div class="product-filter-container">
            <form method="GET" class="product-filter-form" id="orderFilterForm">
                <div class="filter-group search-group" style="grid-column: 2 / span 3;">
                    <div class="search-container">
                        <input type="text"
                            placeholder="Search by invoice number, username, or email"
                            name="search"
                            value="<?php echo htmlspecialchars($search_query); ?>"
                            class="filter-input">
                        <button type="submit" class="filter-btn">
                            <ion-icon name="search-outline"></ion-icon>
                        </button>
                    </div>
                </div>

                <div class="filter-group" style="grid-column: 1;">
                    <label for="status" class="filter-label">Status:</label>
                    <select name="status" id="status" class="filter-select">
                        <option value="">All Status</option>
                        <option value="Paid" <?php echo $status_filter == 'Paid' ? 'selected' : ''; ?>>Paid</option>
                        <option value="Pending" <?php echo $status_filter == 'Pending' ? 'selected' : ''; ?>>Pending</option>
                        <option value="Cancelled" <?php echo $status_filter == 'Cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                    </select>
                </div>

                <div class="filter-group" style="grid-column: 2 / span 2;">
                    <label for="date_range" class="filter-label">Date Range:</label>
                    <div class="date-range-picker">
                        <input type="date"
                            name="start_date"
                            id="start_date"
                            value="<?php echo htmlspecialchars($start_date); ?>"
                            class="date-input">
                        <span class="date-separator">to</span>
                        <input type="date"
                            name="end_date"
                            id="end_date"
                            value="<?php echo htmlspecialchars($end_date); ?>"
                            class="date-input">
                    </div>
                </div>

                <div class="filter-group" style="grid-column: 2;">
                    <div class="filter-buttons">
                        <button type="submit" class="filter-apply-btn">Apply Filters</button>
                        <button type="button" class="filter-reset-btn" onclick="resetFilters()">Reset Filters</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="order-table-container">
            <table class="order-history-table sortable" id="orderHistoryTable">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Invoice Number</th>
                        <th>Order Date</th>
                        <th>Payment Status</th>
                        <th>Total Amount</th>
                        <th>View Details</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($row = mysqli_fetch_assoc($result)) {
                        $order_id = $row['order_id'];
                        $invoice_number = $row['invoice_number'];
                        $order_date = $row['order_date'];
                        $payment_status = $row['payment_status'];

                        // Get total amount for this order
                        $total_query = "SELECT SUM(od.quantity * p.product_price) as total_amount
                                 FROM order_details od 
                                 JOIN products p ON od.product_id = p.product_id 
                                 WHERE od.order_id = $order_id";
                        $total_result = mysqli_query($con, $total_query);
                        $total_row = mysqli_fetch_assoc($total_result);
                        $total_amount = $total_row['total_amount'];
                    ?>
                        <tr>
                            <td><?php echo $order_id; ?></td>
                            <td><?php echo $invoice_number; ?></td>
                            <td><?php echo date('d/m/Y H:i', strtotime($order_date)); ?></td>
                            <td>
                                <span class="status-badge <?php echo strtolower($payment_status); ?>">
                                    <?php echo $payment_status; ?>
                                </span>
                            </td>
                            <td>RM <?php echo number_format($total_amount, 2); ?></td>
                            <td>
                                <a href="orderDetails.php?id=<?php echo $order_id; ?>" class="btn view-details-btn">View Details</a>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="footer-container">
        <?php include './footer.php'; ?>
    </div>

    <style>
        .product-filter-container {
            margin: 30px auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            max-width: 1200px;
            width: 100%;
        }

        .product-filter-form {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            padding: 20px;
        }

        .filter-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
            align-items: center;
            gap: 10px;
        }

        .filter-group.search-group {
            width: 100%;
            max-width: 400px;
        }

        .search-container {
            display: flex;
            align-items: center;
            gap: 10px;
            width: 250%;
        }

        .filter-input {
            width: 100%;
            flex: 1;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
            outline: none;
        }

        .filter-input:focus {
            border-color: #4CAF50;
            box-shadow: 0 0 0 2px rgba(76, 175, 80, 0.2);
        }

        .filter-btn {
            padding: 10px;
            background: #333;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #4CAF50;
        }

        .filter-btn:hover {
            background: #2E7D32;
        }

        .filter-btn ion-icon {
            font-size: 18px;
        }

        .filter-label {
            font-weight: 500;
            color: #333;
        }

        .filter-input,
        .filter-select,
        .date-input {
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
            width: 200px;
        }

        .filter-select:focus,
        .date-input:focus {
            outline: none;
            border-color: #4CAF50;
            box-shadow: 0 0 0 2px rgba(76, 175, 80, 0.2);
        }

        .filter-apply-btn,
        .filter-reset-btn {
            padding: 6px 12px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 500;
            font-size: 13px;
            transition: all 0.3s ease;
            width: auto;
        }

        .filter-apply-btn {
            background: #4CAF50;
            color: white;
        }

        .filter-reset-btn {
            background: #fff;
            color: #4CAF50;
            border: 1px solid #4CAF50;
            margin-left: 10px;
        }

        .filter-buttons {
            display: flex;
            gap: 10px;
            justify-content: center;
            width: 100%;
        }

        .date-range-picker {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .date-separator {
            color: #666;
            font-size: 14px;
        }

        .filter-buttons-container {
            display: flex;
            justify-content: center;
            margin-top: 20px;
            width: 100%;
        }

        .order-table-container {
            margin: 30px auto 0;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            max-width: 1200px;
        }

        .order-history-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .order-history-table th,
        .order-history-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .order-history-table th {
            background-color: #f5f5f5;
            font-weight: 600;
        }

        .order-history-table tr:hover {
            background-color: #f9f9f9;
        }

        .order-history-table .status-badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-weight: 500;
        }

        .order-history-table .status-badge.Paid {
            background-color: #4CAF50;
            color: white;
        }

        .order-history-table .status-badge.Pending {
            background-color: #FFC107;
            color: #333;
        }

        .order-history-table .status-badge.Cancelled {
            background-color: #f44336;
            color: white;
        }

        .order-history-table .total-amount {
            font-weight: 600;
            color: #4CAF50;
        }

        .order-history-table .order-actions {
            display: flex;
            gap: 10px;
        }

        .order-actions button {
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: 0.3s;
        }

        .order-actions .view-btn {
            background: #4CAF50;
            color: white;
        }

        .order-actions .cancel-btn {
            background: #f44336;
            color: white;
        }

        .order-actions .view-btn:hover {
            background: #45a049;
        }

        .order-actions .cancel-btn:hover {
            background: #da190b;
        }

        .order-history-table .no-orders {
            text-align: center;
            padding: 20px;
            color: #666;
        }

        @media (max-width: 768px) {
            .order-filter-form {
                flex-direction: column;
            }

            .filter-group {
                width: 100%;
                justify-content: space-between;
            }

            .filter-input,
            .filter-select,
            .date-input {
                width: 100%;
            }

            .date-range-picker {
                width: 100%;
            }

            .filter-apply-btn,
            .filter-reset-btn {
                width: 100%;
                margin-top: 10px;
            }
        }
    </style>

    <script>
        function resetFilters() {
            document.getElementById('status').value = '';
            document.getElementById('start_date').value = '';
            document.getElementById('end_date').value = '';
            document.querySelector('.filter-input').value = '';
            document.querySelector('.order-filter-form').submit();
        }
    </script>
</body>

</html>