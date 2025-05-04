<!DOCTYPE html>

<html>

<head>
    <meta charset="UTF-8">
    <link href="../css/admin2.css" rel="stylesheet" type="text/css" />
    <link href="../css/tableSort.css" rel="stylesheet" type="text/css" />
    <title>Blooms Co. | Brands</title>
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
            max-width: 1200px;
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
            width: calc(100% / 3);
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

        .action-column .action-btn.edit {
            background-color: #28a745;
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
    include '../config/helper.php';
    include '../config/connect.php';
    ?>

    <div class="page-header">
        <h2>VIEW BRANDS</h2>
    </div>

    <div class="product-filter-container">
        <form method="GET" class="product-filter-form">
            <div class="search-container">
                <input type="text"
                    placeholder="Search by Brand Title"
                    name="search"
                    class="filter-input">
                <button type="submit" class="filter-btn">
                    <ion-icon name="search-outline"></ion-icon>
                </button>
            </div>
        </form>
    </div>

    <div class="order-table-container">
        <table class="order-history-table sortable" id="brandsTable">
            <thead>
                <tr>
                    <th>Brand ID</th>
                    <th>Brand Title</th>
                    <th class="action-column">Action</th>
                </tr>
            </thead>
            <?php
            if (isset($_GET['search'])) {
                $search_query = $_GET['search'];
                $select_brands = "SELECT * FROM brands WHERE brand_title LIKE '%$search_query%' ORDER BY brand_id ASC";
            } else {
                $select_brands = "SELECT * FROM brands ORDER BY brand_id ASC";
            }
            $result = mysqli_query($con, $select_brands);
            while ($row = mysqli_fetch_assoc($result)) {
                $brand_id = $row['brand_id'];
                $brand_title = $row['brand_title'];
            ?>
                <tr>
                    <td><?php echo $brand_id ?></td>
                    <td><?php echo $brand_title ?></td>
                    <td class='action-column'>
                        <a href='editbrands.php?id=<?php echo $brand_id ?>' class='action-btn edit'>
                            <ion-icon name='create-outline' class='action-icon'></ion-icon>
                        </a>
                        <a href='#' onclick='showConfirmation(<?php echo $brand_id ?>)' class='action-btn delete'>
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

    <script>
        function showConfirmation(id) {
            if (confirm('Are you sure you want to delete this brand?')) {
                window.location.href = 'deletebrands.php?id=' + id;
            }
        }
    </script>
</body>

</html>