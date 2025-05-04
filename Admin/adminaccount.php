<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <link href="../css/admin2.css" rel="stylesheet" type="text/css" />
    <link href="../css/tableSort.css" rel="stylesheet" type="text/css" />
    <title>Blooms Co. | Accounts</title>
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

        .order-history-table th,
        .order-history-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .order-history-table th {
            background-color: #f8f9fa;
            font-weight: 600;
            color: #333;
        }

        .order-history-table tr:hover {
            background-color: #f8f9fa;
        }

        .order-history-table th,
        .order-history-table td {
            text-align: center;
            width: calc(100% / 7);
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

        .profile-image {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
        }
    </style>
</head>

<body>
    <?php
    include './adminheader.php';
    require_once '../config/connect.php';
    ?>

    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <script src="../javascript/tableSort.js"></script>

    <div class="page-header">
        <h2>VIEW USERS ACCOUNT</h2>
    </div>

    <div class="product-filter-container">
        <form method="GET" class="product-filter-form">
            <div class="search-container">
                <input type="text"
                    placeholder="Search by username"
                    name="username"
                    class="filter-input">
                <button type="submit" class="filter-btn">
                    <ion-icon name="search-outline"></ion-icon>
                </button>
            </div>
        </form>
    </div>

    <div class="order-table-container">
        <table class="order-history-table sortable" id="usersTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Profile Picture</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>Contact</th>
                    <th class="action-column">Action</th>
                </tr>
            </thead>
            <?php
            if (isset($_GET['username'])) {
                $search_username = $_GET['username'];
                $select_query = "SELECT * FROM user_table WHERE username LIKE '%$search_username%'";
            } else {
                $select_query = "SELECT * FROM user_table";
            }

            $result = mysqli_query($con, $select_query);
            $number = 0;
            while ($row = mysqli_fetch_assoc($result)) {
                $user_id = $row['user_id'];
                $user_image = $row['user_image'];
                $user_username = $row['username'];
                $user_email = $row['user_email'];
                $user_address = $row['user_address'];
                $user_contact = $row['user_phone'];
                $number++;
            ?>
                <tr>

                    <td><?php echo $user_id ?></td>
                    <td><img src='../php/user_images/<?php echo $user_image ?>' alt='Profile Picture' class='profile-image'></td>
                    <td><?php echo $user_username ?></td>
                    <td><?php echo $user_email ?></td>
                    <td><?php echo $user_address ?></td>
                    <td><?php echo $user_contact ?></td>
                    <td class='action-column'>
                        <a href='editacc.php?id=<?php echo $user_id ?>' class='action-btn edit'>
                            <ion-icon name='create-outline' class='action-icon'></ion-icon>
                        </a>
                        <a href='#' onclick='showConfirmation(<?php echo $user_id ?>)' class='action-btn delete'>
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
    function showConfirmation(userid) {
        if (confirm("Are you sure you want to delete this user?")) {
            // if the user clicks "OK" in the confirmation pop-up, redirect to the delete product page
            window.location.href = "delete.php?id=" + userid;
        } else {
            // if the user clicks "Cancel" in the confirmation pop-up, do nothing
        }
    }
</script>

</html>