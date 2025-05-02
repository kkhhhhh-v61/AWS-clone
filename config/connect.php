<?php

include '../config/helper.php';

// Create connection
$con = mysqli_connect($host, $username, $password, $db_name);

// Check connection
if (mysqli_connect_errno()) {
    die("Connection failed: " . mysqli_connect_error());
}
