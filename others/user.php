<?php
// session_start();
// if (!isset($_SESSION['username'])) {
//     header("location: index.php");
//     exit; // Important: Add exit to prevent further execution
// }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User's Panel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .wrapper {
            display: flex;
        }

        .sidebar {
            background-color: #333;
            color: white;
            width: 220px;
            height: 100vh;
            position: fixed;
            padding: 20px 0;
        }

        .sidebar h2 {
            text-align: center;
            margin-bottom: 30px;
            text-transform: uppercase;
            font-size: 1.2em;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
        }

        .sidebar ul li {
            padding: 15px 20px;
            transition: background-color 0.3s;
        }

        .sidebar ul li a {
            color: white;
            text-decoration: none;
            display: block;
            transition: color 0.3s;
        }

        .sidebar ul li a i {
            margin-right: 10px;
        }

        .sidebar ul li:hover {
            background-color: #555;
        }

        .sidebar ul li a:hover {
            color: skyblue;
        }

        .header {
            margin-left: 220px;
            width: calc(100% - 220px);
        }

        .admin_header {
            background-color: #333;
            color: white;
            padding: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
        }

        .admin_header h2 {
            font-size: 1.5em;
            margin: 0;
        }

        .admin_header a {
            background-color: skyblue;
            color: white;
            padding: 10px 15px;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .admin_header a:hover {
            background-color: #87CEEB;
        }

        .horizontal_panel {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            margin: 20px;
        }

        .horizontal_inner_panel {
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 10px 20px;
            margin: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
        }

        .horizontal_inner_panel:hover {
            transform: translateY(-3px);
        }

        .horizontal_inner_panel a {
            text-decoration: none;
            color: #333;
        }

        .info {
            padding: 20px;
            margin: 20px;
            background-color: white;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        footer {
            text-align: center;
            padding: 20px;
            background-color: #f0f0f0;
            margin-left: 220px;
            width: calc(100% - 220px);
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                position: static;
                height: auto;
            }

            .header {
                margin-left: 0;
                width: 100%;
            }
            footer{
                margin-left: 0;
                width: 100%;
            }
        }
    </style>
</head>

<body>
<?php include('header.php') ;?>
    <div class="wrapper">
        <aside class="sidebar">
            <h2>User Panel</h2>
            <ul>
                <li><a href="pa_code_approval.php"><i class="fas fa-check-circle"></i> Approve PA code</a></li>
                
                <li><a href="log_request.php"><i class="fas fa-file-alt"></i> Request PA code</a></li>
                <li><a href=""><i class="fas fa-hospital"></i> Check Hospital List</a></li>
                <li><a href="displayAll.php"><i class="fas fa-users"></i> Check Enrollees</a></li>
                <li><a href="vet_bills.php"><i class="fas fa-file-invoice-dollar"></i> Vet bills</a></li>
                <li><a href="enrolment.php"><i class="fas fa-user-plus"></i> Enrolment Form</a></li>
                
            </ul>
        </aside>
        <main class="header">
            <div class="admin_header">
                <h2>Nonsuch Portal Management</h2>
                <a href="logout.php">Logout</a>
            </div>
            <!-- <div class="horizontal_panel">
                <div class="horizontal_inner_panel"><a href="">Claims</a></div>
                <div class="horizontal_inner_panel"><a href="">Call Centre</a></div>
                <div class="horizontal_inner_panel"><a href="">Account</a></div>
                <div class="horizontal_inner_panel"><a href="">HR</a></div>
                <div class="horizontal_inner_panel"><a href="">ICT</a></div>
            </div> -->
            <div class="info">
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Nemo officiis repellat iure magnam id incidunt iusto eos porro mollitia rem, consectetur totam sunt distinctio velit facere cumque soluta nostrum. Dolor architecto dicta alias temporibus obcaec