<?php
require_once '../config/connect.php';

// Get best selling products (top 5 based on sales)
$best_selling_query = "SELECT p.*, b.brand_title as brand_name
                      FROM products p 
                      JOIN product_sales ps ON p.product_id = ps.product_id 
                      JOIN brands b ON p.brand_id = b.brand_id
                      ORDER BY ps.total_quantity_sold DESC 
                      LIMIT 5";
$best_selling_result = $con->query($best_selling_query);
$best_selling = $best_selling_result->fetch_all(MYSQLI_ASSOC);

// Get featured products (top 5)
$featured_query = "SELECT p.*, b.brand_title as brand_name
                  FROM products p 
                  JOIN brands b ON p.brand_id = b.brand_id
                  WHERE isFeatured = 1 
                  ORDER BY date DESC 
                  LIMIT 5";
$featured_result = $con->query($featured_query);
$featured = $featured_result->fetch_all(MYSQLI_ASSOC);

// Get new arrivals (top 5 based on date)
$new_arrivals_query = "SELECT p.*, b.brand_title as brand_name
                      FROM products p 
                      JOIN brands b ON p.brand_id = b.brand_id
                      ORDER BY date DESC 
                      LIMIT 5";
$new_arrivals_result = $con->query($new_arrivals_query);
$new_arrivals = $new_arrivals_result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
    <link rel="stylesheet" href="../css/homepage.css">
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <title>Blooms Co. | Homepage</title>
</head>

<body>
    <?php include './header.php'; ?>
    <div class="page-header">
        <h2>HOME</h2>
    </div>
    <!-- Slideshow container -->
    <div class="slideshow-container">
        <div class="slideshow-wrapper">
            <!-- Slideshow Images -->
            <div class="mySlides">
                <div class="slide-image">
                    <img src="../images/slides1.png" alt="Slide 1">
                </div>
            </div>

            <div class="mySlides">
                <div class="slide-image">
                    <img src="../images/slides2.jpg" alt="Slide 2">
                </div>
            </div>

            <div class="mySlides">
                <div class="slide-image">
                    <img src="../images/slides3.png" alt="Slide 3">
                </div>
            </div>
        </div>

        <!-- Next and previous buttons -->
        <div class="slideshow-nav-prev">
            <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
        </div>
        <div class="slideshow-nav-next">
            <a class="next" onclick="plusSlides(1)">&#10095;</a>
        </div>

        <!-- The dots/circles -->
        <div class="slideshow-dots">
            <span class="dot" onclick="currentSlide(1)"></span>
            <span class="dot" onclick="currentSlide(2)"></span>
            <span class="dot" onclick="currentSlide(3)"></span>
        </div>
    </div>

    <!-- Best Selling Section -->
    <div class="homepage-section">
        <h2 class="homepage-section-title">Best Selling</h2>
        <div class="product-grid-container">
            <div class="product-grid">
                <?php foreach ($best_selling as $product): ?>
                    <div class="product-card" onclick="window.location.href='productDetails.php?product_id=<?php echo $product['product_id']; ?>'">
                        <div class="product-overlay"></div>
                        <img class="product-image" src="../images/<?php echo htmlspecialchars($product['product_image1']); ?>" alt="<?php echo htmlspecialchars($product['product_name']); ?>">
                        <div class="product-card-content">
                            <p class="product-name"><?php echo htmlspecialchars($product['product_name']); ?></p>
                            <p class="product-brand"><?php echo htmlspecialchars($product['brand_name']); ?></p>
                            <p class="product-price"><?php echo number_format($product['product_price'], 2); ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- Featured Section -->
    <div class="homepage-section">
        <h2 class="homepage-section-title">Featured Products</h2>
        <div class="product-grid-container">
            <div class="product-grid">
                <?php foreach ($featured as $product): ?>
                    <div class="product-card" onclick="window.location.href='productDetails.php?product_id=<?php echo $product['product_id']; ?>'">
                        <div class="product-overlay"></div>
                        <img class="product-image" src="../images/<?php echo htmlspecialchars($product['product_image1']); ?>" alt="<?php echo htmlspecialchars($product['product_name']); ?>">
                        <div class="product-card-content">
                            <p class="product-name"><?php echo htmlspecialchars($product['product_name']); ?></p>
                            <p class="product-brand"><?php echo htmlspecialchars($product['brand_name']); ?></p>
                            <p class="product-price"><?php echo number_format($product['product_price'], 2); ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- New Arrivals Section -->
    <div class="homepage-section">
        <h2 class="homepage-section-title">New Arrivals</h2>
        <div class="product-grid-container">
            <div class="product-grid">
                <?php foreach ($new_arrivals as $product): ?>
                    <div class="product-card" onclick="window.location.href='productDetails.php?product_id=<?php echo $product['product_id']; ?>'">
                        <div class="product-overlay"></div>
                        <img class="product-image" src="../images/<?php echo htmlspecialchars($product['product_image1']); ?>" alt="<?php echo htmlspecialchars($product['product_name']); ?>">
                        <div class="product-card-content">
                            <p class="product-name"><?php echo htmlspecialchars($product['product_name']); ?></p>
                            <p class="product-brand"><?php echo htmlspecialchars($product['brand_name']); ?></p>
                            <p class="product-price"><?php echo number_format($product['product_price'], 2); ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <script>
        var slideIndex = 1;
        var slideshowInterval;
        var isPaused = false;

        // Start the slideshow
        showSlides(slideIndex);
        startSlideshow();

        // Add hover events
        var slideshowContainer = document.querySelector('.slideshow-container');
        slideshowContainer.addEventListener('mouseenter', pauseSlideshow);
        slideshowContainer.addEventListener('mouseleave', resumeSlideshow);

        function plusSlides(n) {
            showSlides(slideIndex += n);
            resetTimer();
        }

        function currentSlide(n) {
            showSlides(slideIndex = n);
            resetTimer();
        }

        function showSlides(n) {
            var i;
            var slides = document.getElementsByClassName("mySlides");
            var dots = document.getElementsByClassName("dot");

            // Reset all slides
            for (i = 0; i < slides.length; i++) {
                slides[i].classList.remove('active');
                slides[i].style.display = "none";
            }

            // Handle edge cases
            if (n > slides.length) {
                n = 1;
            }
            if (n < 1) {
                n = slides.length;
            }

            // Show the current slide
            slides[n - 1].style.display = "block";
            slides[n - 1].classList.add('active');

            // Update dots
            for (i = 0; i < dots.length; i++) {
                dots[i].className = dots[i].className.replace(" active", "");
            }
            dots[n - 1].className += " active";

            // Update slide index
            slideIndex = n;
        }

        function startSlideshow() {
            if (!isPaused) {
                slideshowInterval = setInterval(function() {
                    plusSlides(1);
                }, 5000); // Change slide every 5 seconds
            }
        }

        function pauseSlideshow() {
            isPaused = true;
            clearInterval(slideshowInterval);
        }

        function resumeSlideshow() {
            isPaused = false;
            startSlideshow();
        }

        function resetTimer() {
            pauseSlideshow();
            resumeSlideshow();
        }
    </script>
    <?php include './footer.php'; ?>
</body>

</html>