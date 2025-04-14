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
    <h2>NHIA Activities </h2>
   <ul>
    <li><a href="e_log_request.php"><i class="fas fa-file-alt"></i> Request PA code</a></li>
    <li><a href="e_display.php">Vet Bills</a></li>
    <!-- <li><a href="pa_code_approval.php"><i class="fas fa-check-circle"></i> Approve PA code</a></li> -->
    <li><a href="check_vet_bill_underwriter.php"><i class="fas fa-file-invoice-dollar"></i> Check Vetted Bill</a></li>
    <!-- <li><a href="approval_bills.php"><i class="fas fa-file-invoice"></i> Approve Bills</a></li> -->
          <!-- <li><a href="card.php">Download e-id card</a></li> -->
   </ul>
    </div>

    
    
</body>
</html>