<?php 
session_start();
include('../loginsystem/header.php') 
;?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin's Panel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        ul{
            list-style: none;
        }
        ul> li{
            padding: 10px;
        }
       
    </style>
</head>

<body>

<?php
    // if (isset($_SESSION['username'])) {
    //     echo $_SESSION['username'];
    // } else {
    //     echo "User not logged in or username not set."; // Or redirect to login page
    // }
    ?>
<a href="../loginsystem/admin.php">Back</a>
    <div class="text-center mx-auto container bordered">
    <h2> Activities </h2>
   <ul>
    <li><a href="nhia.php"><i class="fas fa-file-alt"></i> NHIA Activities</a></li>
    
   </ul>
    </div>
    <div class="text-center mx-auto container bordered">
    <h2>NYSC Activities </h2>
   <ul>
    <li><a href="nysc.php"><i class="fas fa-file-alt"></i> NYSC Activities</a></li>
    
   </ul>
    </div>
    <div class="text-center mx-auto container bordered">
    <h2>PHIS Activities </h2>
   <ul>
    <li><a href="phis.php"><i class="fas fa-file-alt"></i> PHIS Activities</a></li>
    
   </ul>
    </div>

    
    
</body>
</html>