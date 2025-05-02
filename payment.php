<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <link href="../css/login.css" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
        <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
        <title>PAYMENT |SNEAKER VAULT</title>
    </head>
    <body
    <?php include './header.php'; ?>

    <div class="logintittle">
        <p>Home/</p></br>
        <p class="bold"><b>PAYMENT</b></p>
    </div>

    <div class="container2">
        <div class="container">
            <div class='fontsz'
                <label for="payAmt">TOTAL AMOUNT</label><br>
                <input type="number" name="payAmt" id="payAmt" required>
                <br><label for="payDesc">PAYMENT DESCRIPTION</label><br>
                <textarea id="payDesc" name="payDesc" required></textarea>
                <br><label for="tngID">TOUCH 'n GO EWALLET ID:</label><br>
                <input type="text" name="tngID" id="tngID" required>
            </div>    
            <div class="logbtn">
                <br><a href="orderConfirmation.php"><button class="log">PAY WITH TOUCH 'n GO EWALLET</button></a>
            </div>
        </div>
    </div>
    
    <div class="create"><a href="shipment.php">Back</a></div>
    <script>
                            var paymentForm = document.getElementById('payment-form');
                            paymentForm.addEventListener('submit', function(event) {
                                event.preventDefault();
                                var paymentAmount = document.getElementById('amount').value;
                                var paymentDescription = document.getElementById('description').value;
                                var ewalletId = document.getElementById('ewallet-id').value;
                                var options = {
                                    amount: paymentAmount,
                                    description: paymentDescription,
                                    currency: 'MYR',
                                    mobile_number: ewalletId
                                };
                                TNGDigitalSDK.pay(options, function(response) {
                                    if (response.status === 'success') {
                                    // Handle successful payment
                                    } else {
                                    // Handle payment failure
                                    }
                                });
                            });
                        </script>
    <?php include './footer.php'; ?>
</body>
</html>