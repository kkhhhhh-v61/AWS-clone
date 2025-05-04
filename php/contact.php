<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <link href="../css/login.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
    <title>Blooms Co. | Contact Us</title>
</head>

<body>
    <?php include './header.php'; ?>

    <nav class="section-nav">
        <div class="nav-container">
            <a href="terms.php" class="nav-link">T&C</a>
            <a href="shipping.php" class="nav-link">SHIPPING</a>
            <a href="privacypolicy.php" class="nav-link">PRIVACY POLICY</a>
        </div>
    </nav>

    <div class="login-container">
        <div class="login-header">
            <h2 class="login-title">CONTACT US</h2>
        </div>

        <form action="" method="post" class="login-form">
            <div class="form-group">
                <label for="name">NAME</label>
                <input type="text" name="name" id="name" class="form-control"
                    maxlength="14" minlength="6" required>
            </div>

            <div class="form-group">
                <label for="email">EMAIL</label>
                <input type="email" name="email" id="email" class="form-control"
                    maxlength="35" required>
            </div>

            <div class="form-group">
                <label for="phone">PHONE NUMBER</label>
                <input type="text" name="phone" id="phone" class="form-control"
                    maxlength="12" minlength="9" required>
            </div>

            <div class="form-group">
                <label for="message">MESSAGE</label>
                <textarea name="message" id="message" class="form-control"
                    rows="4" required></textarea>
            </div>

            <div class="form-group">
                <button type="submit" name="submit" class="loginbutM">SUBMIT</button>
            </div>
        </form>
    </div>

    <?php include './footer.php'; ?>
</body>

</html>