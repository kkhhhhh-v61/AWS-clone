<?php
// Establish a database connection
$host = "project-db.cufzmwkjncuf.us-east-1.rds.amazonaws.com";
$username = "main";
$password = "project-password";
$db_name = "project";

$con = mysqli_connect($host, $username, $password, $db_name);
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
?>
