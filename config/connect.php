<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */
include '../Admin/helper.php';
include './helper.php';
$con = mysqli_connect($host, $username, $password, $db_name);
if(!$con){
    die(mysqli_error($con));
}
