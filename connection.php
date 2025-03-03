<?php 
   $con = mysqli_connect('localhost', 'root', '', 'nonsuch_portal');

    if (!$con) {
        die("Error connecting to database: " . mysqli_connect_error($con)); 
        // Use die() and mysqli_connect_error()
    }
?>