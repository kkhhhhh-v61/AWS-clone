<!DOCTYPE html>

<html>

<head>
    <meta charset="UTF-8">
    <link href="../css/admin2.css" rel="stylesheet" type="text/css" />
    <link href="../css/tableSort.css" rel="stylesheet" type="text/css" />
    <title>Blooms Co. | Categories</title>
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
        <h2>VIEW CATEGORIES</h2>
    </div>

    <div class="product-filter-container">
        <form method="GET" class="product-filter-form">
            <div class="search-container">
                <input type="text"
                    placeholder="Search by Category Title"
                    name="search"
                    class="filter-input">
                <button type="submit" class="filter-btn">
                    <ion-icon name="search-outline"></ion-icon>
                </button>
            </div>
        </form>
    </div>

    <div class="order-table-container">
        <table class="order-history-table sortable" id="categoryTable">
            <thead>
                <tr>
                    <th>Category ID</th>
                    <th>Category Title</th>
                    <th class="action-column">Action</th>
                </tr>
            </thead>
            <?php
            if (isset($_GET['search'])) {
                $search_query = $_GET['search'];
                $select_cat = "SELECT * FROM categories WHERE category_title LIKE '%$search_query%' ORDER BY category_id ASC";
            } else {
                $select_cat = "SELECT * FROM categories ORDER BY category_id ASC";
            }
            $result = mysqli_query($con, $select_cat);
            $number = 0;
            while ($row = mysqli_fetch_assoc($result)) {
                $category_id = $row['category_id'];
                $category_title = $row['category_title'];
            ?>
                <tr>
                    <td><?php echo $category_id ?></td>
                    <td><?php echo $category_title ?></td>
                    <td class='action-column'>
                        <a href='editcategory.php?id=<?php echo $category_id ?>' class='action-btn edit'>
                            <ion-icon name='create-outline' class='action-icon'></ion-icon>
                        </a>
                        <a href='#' onclick='showConfirmation(<?php echo $category_id ?>)' class='action-btn delete'>
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
    function showConfirmation(categoryId) {
        if (confirm("Are you sure you want to delete this category?")) {
            // if the user clicks "OK" in the confirmation pop-up, redirect to the delete brand page
            window.location.href = "deletecategory.php?id=" + categoryId;
        } else {
            // if the user clicks "Cancel" in the confirmation pop-up, do nothing
        }
    }
</script>

</html>