<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Blooms Co. | Products</title>
    <link href="../css/style.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="../css/homepage.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <style>
        .error-message {
            padding: 20px;
            background-color: #ffdddd;
            border: 1px solid #ff0000;
            border-radius: 5px;
            margin: 20px auto;
            width: 80%;
            max-width: 600px;
            text-align: center;
            color: #ff0000;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <?php include './header.php'; ?>
    <div class="page-header">
        <h2>PRODUCTS</h2>
    </div>

    <!-- Products Section -->
    <div class="homepage-section">

        <div class="product-filter-container">
            <form method="GET" class="product-filter-form" id="productFilterForm">
                <div class="filter-group search-group">
                    <div class="search-container">
                        <input type="text"
                            placeholder="Search by product name, brand, or description"
                            name="search"
                            class="filter-input">
                        <button type="submit" class="filter-btn">
                            <ion-icon name="search-outline"></ion-icon>
                        </button>
                    </div>
                </div>

                <div class="filter-group">
                    <label for="category" class="filter-label">Category:</label>
                    <select name="category" id="category" class="filter-select">
                        <option value="">All Categories</option>
                        <?php
                        $category_query = "SELECT * FROM categories ORDER BY category_title";
                        $category_result = $con->query($category_query);
                        while ($category = $category_result->fetch_assoc()) {
                            echo "<option value='" . $category['category_id'] . "'>" . htmlspecialchars($category['category_title']) . "</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="filter-group">
                    <label for="brand" class="filter-label">Brand:</label>
                    <select name="brand" id="brand" class="filter-select">
                        <option value="">All Brands</option>
                        <?php
                        $brand_query = "SELECT * FROM brands ORDER BY brand_title";
                        $brand_result = $con->query($brand_query);
                        while ($brand = $brand_result->fetch_assoc()) {
                            echo "<option value='" . $brand['brand_id'] . "'>" . htmlspecialchars($brand['brand_title']) . "</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="filter-group">
                    <label for="price_range" class="filter-label">Price Range:</label>
                    <div class="price-range-picker">
                        <input type="number"
                            name="min_price"
                            id="min_price"
                            placeholder="Min"
                            class="price-input">
                        <span class="price-separator">to</span>
                        <input type="number"
                            name="max_price"
                            id="max_price"
                            placeholder="Max"
                            class="price-input">
                    </div>
                </div>
            </form>

            <div class="filter-buttons-container">
                <div class="filter-buttons">
                    <button type="submit" class="filter-apply-btn">Apply Filters</button>
                    <button type="button" class="filter-reset-btn" onclick="resetProductFilters()">Reset Filters</button>
                </div>
            </div>
            </form>
        </div>

        <div class="product-grid-container">
            <div class="product-grid">
                <?php
                require_once '../config/connect.php';

                // Get filter parameters
                $search = isset($_GET['search']) ? $_GET['search'] : '';
                $category = isset($_GET['category']) ? $_GET['category'] : '';
                $brand = isset($_GET['brand']) ? $_GET['brand'] : '';
                $min_price = isset($_GET['min_price']) ? $_GET['min_price'] : '';
                $max_price = isset($_GET['max_price']) ? $_GET['max_price'] : '';

                // Build the query
                $sql = "SELECT p.*, b.brand_title as brand_name 
                        FROM products p 
                        JOIN brands b ON p.brand_id = b.brand_id 
                        WHERE 1=1";

                // Add search filter
                if (!empty($search)) {
                    $sql .= " AND (p.product_name LIKE '%$search%' 
                                 OR b.brand_title LIKE '%$search%' 
                                 OR p.product_description LIKE '%$search%')";
                }

                // Add category filter
                if (!empty($category)) {
                    $sql .= " AND p.category_id = $category";
                }

                // Add brand filter
                if (!empty($brand)) {
                    $sql .= " AND p.brand_id = $brand";
                }

                // Add price range filter
                if (!empty($min_price)) {
                    $sql .= " AND p.product_price >= $min_price";
                }
                if (!empty($max_price)) {
                    $sql .= " AND p.product_price <= $max_price";
                }

                // Order by date
                $sql .= " ORDER BY p.date DESC";

                $result = $con->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<div class='product-card' onclick='window.location.href=\"productDetails.php?product_id=" . $row['product_id'] . "\"'>";
                        echo "<div class='product-overlay'></div>";
                        echo "<img class='product-image' src='../images/" . $row['product_image1'] . "' alt='" . $row['product_name'] . "'>";
                        echo "<div class='product-card-content'>";
                        echo "<p class='product-name'>" . htmlspecialchars($row['product_name']) . "</p>";
                        echo "<p class='product-brand'>" . htmlspecialchars($row['brand_name']) . "</p>";
                        echo "<p class='product-price'>" . number_format($row['product_price'], 2) . "</p>";
                        echo "</div>";
                        echo "</div>";
                    }
                } else {
                    echo "<div class='error-message'>No products found matching your criteria.</div>";
                }
                $con->close();
                ?>
            </div>
        </div>
    </div>

    <div class="footer-container">
        <?php include './footer.php'; ?>
    </div>

    <script>
        function resetProductFilters() {
            document.getElementById('category').value = '';
            document.getElementById('brand').value = '';
            document.getElementById('min_price').value = '';
            document.getElementById('max_price').value = '';
            document.querySelector('.filter-input').value = '';
            document.getElementById('productFilterForm').submit();
        }

        function applyFilters() {
            const form = document.getElementById('productFilterForm');
            const searchInput = document.querySelector('.filter-input');
            const categorySelect = document.getElementById('category');
            const brandSelect = document.getElementById('brand');
            const minPriceInput = document.getElementById('min_price');
            const maxPriceInput = document.getElementById('max_price');

            // Validate price inputs
            const minPrice = parseFloat(minPriceInput.value) || 0;
            const maxPrice = parseFloat(maxPriceInput.value) || Infinity;

            if (minPrice > maxPrice) {
                alert('Minimum price cannot be greater than maximum price');
                return false;
            }

            form.submit();
        }

        // Prevent form submission on enter key in price inputs
        document.querySelectorAll('.price-input').forEach(input => {
            input.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                }
            });
        });

        // Add click handler for Apply Filters button
        document.querySelector('.filter-apply-btn').addEventListener('click', function(e) {
            e.preventDefault();
            applyFilters();
        });

        // Add click handler for Reset Filters button
        document.querySelector('.filter-reset-btn').addEventListener('click', function(e) {
            e.preventDefault();
            resetProductFilters();
        });
    </script>
</body>

</html>