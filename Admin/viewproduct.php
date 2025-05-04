<?php @session_start(); ?>
<!DOCTYPE html>

<html>

<head>
  <meta charset="UTF-8">
  <link href="../css/admin2.css" rel="stylesheet" type="text/css" />
  <link href="../css/tableSort.css" rel="stylesheet" type="text/css" />
  <link href="../css/_variables.css" rel="stylesheet" type="text/css" />
  <link href="../css/style.css" rel="stylesheet" type="text/css" />
  <link href="../css/adminheader.css" rel="stylesheet" type="text/css" />

  <title>Blooms Co. | Products</title>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
  <script src="../javascript/tableSort.js"></script>
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
      max-width: 1800px;
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
      max-width: 1800px;
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

    .order-history-table {
      width: 100%;
      border-collapse: collapse;
      margin: 20px 0;
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
      width: calc(100% / 10);
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

    .action-column .action-btn.delete {
      background-color: #dc3545;
      color: white;
    }

    /* Image column styling */
    .product-image {
      width: 50px;
      height: 50px;
      object-fit: cover;
    }

    .action-column .action-btn.edit {
      background-color: #28a745;
      color: white;
    }

    .action-column .action-btn.delete {
      background-color: #dc3545;
      color: white;
    }

    .product-image {
      width: 100px;
      height: 100px;
      border-radius: 4px;
      object-fit: cover;
    }
  </style>
</head>

<body>
  <?php
  include './adminheader.php';
  include '../config/connect.php';
  ?>

  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
  <script src="../javascript/tableSort.js"></script>

  <div class="page-header">
    <h2>VIEW PRODUCTS</h2>
  </div>

  <div class="product-filter-container">
    <form method="GET" class="product-filter-form">
      <div class="search-container">
        <input type="text"
          placeholder="Search by Product Name"
          name="search"
          class="filter-input">
        <button type="submit" class="filter-btn">
          <ion-icon name="search-outline"></ion-icon>
        </button>
      </div>
    </form>
  </div>

  <div class="order-table-container">
    <table class="order-history-table sortable" id="productTable">
      <thead>
        <tr>
          <th>Product ID</th>
          <th>Product Name</th>
          <th>Description</th>
          <th>Price</th>
          <th>Keywords</th>
          <th>Category</th>
          <th>Brand</th>
          <th>Featured</th>
          <th>Date</th>
          <th class="action-column">Action</th>
        </tr>
      </thead>
      <?php
      if (isset($_GET['search'])) {
        $search_query = $_GET['search'];
        $get_products = "SELECT p.*, c.category_title, b.brand_title 
                                FROM products p 
                                JOIN categories c ON p.category_id = c.category_id 
                                JOIN brands b ON p.brand_id = b.brand_id 
                                WHERE p.product_name LIKE '%$search_query%' 
                                ORDER BY p.product_id ASC";
      } else {
        $get_products = "SELECT p.*, c.category_title, b.brand_title 
                                FROM products p 
                                JOIN categories c ON p.category_id = c.category_id 
                                JOIN brands b ON p.brand_id = b.brand_id 
                                ORDER BY p.product_id ASC";
      }

      $result = mysqli_query($con, $get_products);
      while ($row = mysqli_fetch_assoc($result)) {
        $product_id = $row['product_id'];
        $product_name = $row['product_name'];
        $product_description = $row['product_description'];
        $product_price = $row['product_price'];
        $product_keywords = $row['product_keywords'];
        $category_title = $row['category_title'];
        $brand_title = $row['brand_title'];
        $product_image1 = $row['product_image1'];
        $product_image2 = $row['product_image2'];
        $product_image3 = $row['product_image3'];
        $isFeatured = $row['isFeatured'];
        $date = $row['date'];
      ?>
        <tr>
          <td><?php echo $product_id ?></td>
          <td><?php echo $product_name ?></td>
          <td><?php echo $product_description ?></td>
          <td><?php echo $product_price ?></td>
          <td><?php echo $product_keywords ?></td>
          <td><?php echo $category_title ?></td>
          <td><?php echo $brand_title ?></td>
          <td><?php echo $isFeatured ? 'Yes' : 'No' ?></td>
          <td><?php echo date('Y-m-d H:i:s', strtotime($date)) ?></td>
          <td class='action-column'>
            <a href='editproduct.php?id=<?php echo $product_id ?>' class='action-btn edit'>
              <ion-icon name='create-outline' class='action-icon'></ion-icon>
            </a>
            <a href='#' onclick='showConfirmation(<?php echo $product_id ?>)' class='action-btn delete'>
              <ion-icon name='trash-outline' class='action-icon'></ion-icon>
            </a>
          </td>
        </tr>
      <?php
      }
      ?>
    </table>
  </div>

  <script>
    function showConfirmation(productId) {
      if (confirm("Are you sure you want to delete this product?")) {
        window.location.href = "deleteproduct.php?id=" + productId;
      }
    }
  </script>

  <?php include '../php/footer.php'; ?>
</body>

</html>