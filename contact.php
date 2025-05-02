<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <link href="../css/contact.css" rel="stylesheet" type="text/css"/>
        
        <title>Contact Us | Sneaker Vault</title>
    </head>
    <body>
        <?php include './header.php'; ?>
        
        <nav>
            <a href="terms.php">T&C</a>
            <a href="shipping.php">SHIPPING</a>
            <a href="privacypolicy.php">PRIVACY POLICY</a>
        </nav>

        <div class="tittle">
            <p>Home/</p></br>
            <p class="bold"><b>CONTACT US</b></p>   
        </div>
        
        <p class="texta">Got something in mind? Need assistance?<br>
            Drop us a message and we’ll get back to you.</p>

        <div class="container2">
            <div class="container">
                <div class="fontsz"
                     <label for="text">NAME</label><br>
                    <input type="text" name="text" id="text" maxlength="14" minlength="6" required>
                    <br><label for="email">EMAIL</label><br>
                    <input type="email" name="email" id="email" maxlength="35" required>
                    <br><label for="text">PHONE NUMBER</label><br>
                    <input type="text" name="phoneno" id="phoneno" maxlength="12" minlength="9" required>
                </div>    
            </div>
            <div class="fontsz2"
                 <br><label for="text">MESSAGE</label><br>
                <textarea id="area" name="area" rows="2" cols="123" ></textarea></div>
        </div>

        <br><button class="btn4">SUBMIT</button>
        
        <?php include './footer.php'; ?>
    </body>
</html>



