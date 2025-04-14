<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User's Panel</title>
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
<?php include('header.php') ;?>
<?php
    // if (isset($_SESSION['username'])) {
    //     echo $_SESSION['username'];
    // } else {
    //     echo "User not logged in or username not set."; // Or redirect to login page
    // }
    ?>

    <div class="text-center mx-auto container bordered">
    <h2>Wema Bank</h2>
   <ul>
    <li><a href="enrolment.php">New Registration</a></li>
           <li><a href="displayAll.php">View All Enrollees</a></li>
            <!-- <li><a href="card.php">Download e-id card</a></li> -->
   </ul>
    </div>

    
    
</body>
</html>