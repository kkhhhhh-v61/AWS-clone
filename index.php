<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Project/PHP/PHPProject.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
        <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
        <title>Homepage | Ever Summer Florist</title>
    </head>
    <body>
        <?php include './header.php'; ?>
        <!-- Slideshow container -->
        <div class="slideshow-container">

            <!--resize image in photos to fit properly width:600 height:271-->

            <div class="mySlides fade">
                <center>
                    <div class="pic1">
                        <a href="#">
                            <img src="../images/slide1.png" width="1280px" height="533px">
                        </a>
                    </div>
                </center>
            </div>

            <div class="mySlides fade">
                <center>
                    <div class="pic1">
                        <a href="#">
                            <img src="../images/slides2.jpg" width="1280px" height="533px">
                        </a>
                    </div>
                </center>
            </div>

            <div class="mySlides fade">
                <center>
                    <div class="pic1">
                        <a href="#">
                            <img src="../images/Slides3.png" width="1280px" height="533px">
                        </a>
                    </div>
                </center>
            </div>

            <!-- Next and previous buttons -->
            <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
            <a class="next" onclick="plusSlides(1)">&#10095;</a>
        </div>

        <div class="pageContent">
            <p class="bold"><b>BEST SELLING</b></p>
        </div>

        <div class="product-list-container">
            <div class="product-list">
                <div class="product">
                    <img class="product-list-pic" src="../images/bloomthis-bouquet-mika-graduation-bear-bouquet-1080x1080-01.jpg" usemap="#sneaker5-map">
                    <map name="sneaker5-map">
                        <area href="http://localhost:8000/productDetails.php?product_id=56" coords="-1,1,997,998" shape="rect">
                    </map>
                    <p class="product-list-name">Graduation Bear Bouquet</p>
                    <p class="product-list-brand">Blooms Co.</p>
                    <p class="product-list-price">RM 139.00</p>
                </div>

                <div class="product">
                    <img class="product-list-pic" src="../images/bloomthis-bouquet-calypso-sunflower-rose-bouquet-1080x1080-01_889f28e6-2f29-4ceb-8148-b274a22c6374.jpg" usemap="#short2-map">
                    <map name="short2-map">
                        <area href="http://localhost:8000/productDetails.php?product_id=53" coords="-1,1,997,998" shape="rect">
                    </map>
                    <p class="product-list-name">Calypso Sunflower & Rose Bouquet</p>
                    <p class="product-list-brand">Blooms Co.</p>
                    <p class="product-list-price">RM 179.00</p>
                </div>

                <div class="product">
                    <img class="product-list-pic" src="../images/bloomthis-bouquet-cheyenne-1080x1080-01_744d1f8e-b6cb-4a7a-ba11-94dc116d908f.jpg" usemap="#cap3-map">
                    <map name="cap3-map">
                        <area href="http://localhost:8000/productDetails.php?product_id=47" coords="-1,1,997,998" shape="rect">
                    </map>
                    <p class="product-list-name">Cheyenne</p>
                    <p class="product-list-brand">Blooms Co.</p>
                    <p class="product-list-price">RM 169.00</p>
                </div>

                <div class="product">
                    <img class="product-list-pic" src="../images/bloomthis-bouquet-sadie-white-1080x1080-01_fc3937f3-a6be-462d-9963-cdf2a10dde7d.jpg" usemap="#pants1-map">
                    <map name="pants1-map">
                        <area href="http://localhost:8000/productDetails.php?product_id=48" coords="-1,1,997,998" shape="rect">
                    </map>
                    <p class="product-list-name">Sadie White</p>
                    <p class="product-list-brand">Blooms Co.</p>
                    <p class="product-list-price">RM 109.00</p>
                </div>

                <div class="product">
                    <img class="product-list-pic" src="../images/bloomthis-hat-box-tinkerbell-sunflower-mini-flower-box-1080x1080-02.jpg" usemap="#sneaker1-map">
                    <map name="sneaker1-map">
                        <area href="http://localhost:8000/productDetails.php?product_id=55" coords="-1,1,997,998" shape="rect">
                    </map>
                    <p class="product-list-name">Tinkerbell Sunflower Mini Flower Box</p>
                    <p class="product-list-brand">Blooms Co.</p>
                    <p class="product-list-price">RM 99.00</p>
                </div>

                <div class="product">
                    <img class="product-list-pic" src="../images/bloomthis-bouquet-madelyn-white-1080x1080-01.jpg" usemap="#shirt1-map">
                    <map name="shirt1-map">
                        <area href="http://localhost:8000/productDetails.php?product_id=51" coords="-1,1,997,998" shape="rect">
                    </map>
                    <p class="product-list-name">Madelyn White</p>
                    <p class="product-list-brand">Blooms Co.</p>
                    <p class="product-list-price">RM 109.00</p>
                </div>

                <div class="product">
                    <img class="product-list-pic" src="../images/bloomthis-bouquet-janice-babys-breath-bouquet-1080x1080-01.jpg" usemap="#sneaker14-map">
                    <map name="sneaker14-map">
                        <area href="http://localhost:8000/productDetails.php?product_id=52" coords="-1,1,997,998" shape="rect">
                    </map>
                    <p class="product-list-name">Baby Breath Bouquet</p>
                    <p class="product-list-brand">Blooms Co.</p>
                    <p class="product-list-price">RM 89.00</p>
                </div>

                <div class="product">
                    <img class="product-list-pic" src="../images/bloomthis-bouquet-annabeth-pink-lily-bouquet-1080x1080-01.jpg" usemap="#short4-map">
                    <map name="short4-map">
                        <area href="http://localhost:8000/productDetails.php?product_id=44" coords="-1,1,997,998" shape="rect">
                    </map>
                    <p class="product-list-name">Annabeth Pink Lily Bouquet</p>
                    <p class="product-list-brand">Blooms Co.</p>
                    <p class="product-list-price">RM 209.00</p>
                </div>

                <div class="product">
                    <img class="product-list-pic" src="../images/bloomthis-bouquet-amelia-1080x1080-01.jpg" usemap="#pants4-map">
                    <map name="pants4-map">
                        <area href="http://localhost:8000/productDetails.php?product_id=54" coords="-1,1,997,998" shape="rect">
                    </map>
                    <p class="product-list-name">Amelia</p>
                    <p class="product-list-brand">Blooms Co.</p>
                    <p class="product-list-price">RM 99.00</p>
                </div>

                <div class="product">
                    <img class="product-list-pic" src="../images/bloomthis-bouquet-esther-white-1080x1080-01.jpg" usemap="#shirt5-map">
                    <map name="shirt5-map">
                    </map>
                    <p class="product-list-name">Esther White</p>
                    <p class="product-list-brand">Blooms Co.</p>
                    <p class="product-list-price">RM 109.00</p>
                </div>
            </div>
            <center><a href="product.php"><button type = "button" class = "view-all-btn">VIEW ALL</button></a></center>
        </div>

    

    <script>
        let slideIndex = 1;
        showSlides(slideIndex);

        function plusSlides(n) {
            showSlides(slideIndex += n);
        }

        function currentSlide(n) {
            showSlides(slideIndex = n);
        }

        function showSlides(n) {
            let i;
            let slides = document.getElementsByClassName("mySlides");
            let dots = document.getElementsByClassName("dot");
            if (n > slides.length) {
                slideIndex = 1
            }
            if (n < 1) {
                slideIndex = slides.length
            }
            for (i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";
            }
            for (i = 0; i < dots.length; i++) {
                dots[i].className = dots[i].className.replace(" active", "");
            }
            slides[slideIndex - 1].style.display = "block";
            dots[slideIndex - 1].className += " active";
        }
    </script>
    <?php include './footer.php'; ?>
</body>
</html>
