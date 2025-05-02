<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <link href="../css/admin.css" rel="stylesheet" type="text/css"/>
        <title>Insert Brands | Eversummer Florist</title>
    </head>
    <body>
        <?php
        include './adminheader.php';
        include '../config/connect.php';

        if (isset($_POST['insert_brand'])) { //check the condition if click the can access the value below
            $brand_title = $_POST['brand_title']; //store the input value that access ans store inside the variable($category_title)
            
            //select data from database and check whether the database data match with input field anot
            $select_query = "Select * from brands where brand_title = '$brand_title' ";
            $result_select = mysqli_query($con, $select_query);
            $number = mysqli_num_rows($result_select); //count the number of rows

            if ($number > 0) { //greater than 0 means that already exist
                echo"<script>alert('This brand is already exist')</script>";
            } else { //else able to insert the category inside the table
                $insert_query = "Insert into brands (brand_title) values ('$brand_title')";
                $result = mysqli_query($con, $insert_query);
                if ($result) {
                    echo"<script>alert('Brand has been inserted successfully')</script>";
                }
            }
        }
        ?>
        
        <div class="pageContent">
            <p>Home/Admin/</p></br>
            <p class="bold"><b>INSERT BRANDS</b></p>
        </div>
        
        <form action="" method="POST">
            <div class="container2">
                <div class="container">
                    <div class='fontsz'>
                        <input type="text" name="brand_title" id="insCat" placeholder="Insert Brands" required>
                    </div>    
                    <div class="logbtn">
                        <br><input type="submit" value="INSERT" class="insBut" name="insert_brand" />
                    </div>
                </div>
                <div class="create"><a href="viewbrands.php">VIEW BRANDS</a></div>
            </div>
        </form>
    </body>
</html>
