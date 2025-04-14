<?php
session_start();
require_once("../backend/connection.php");
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
    <title>Admin's Dashboard</title>
    <link rel="stylesheet" href="../dist/bootstrap-5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
            color: #333;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .wrapper {
            display: flex;
            flex-grow: 1;
        }

        .sidebar {
            background-color: #343a40;
            color: white;
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            padding-top: 20px;
            transition: transform 0.3s ease;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
            z-index: 100;
            transform: translateX(-250px);
            /* Initially hide on mobile */
        }

        .sidebar.open {
            transform: translateX(0);
            /* Show sidebar */
        }

        .sidebar .logo {
            padding: 20px;
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 1px solid #555;
        }

        .sidebar .logo h2 {
            font-size: 1.5em;
            margin: 0;
            text-transform: uppercase;
            font-weight: bold;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
            margin-top: 20px;
        }

        .sidebar ul li a {
            display: block;
            padding: 15px 25px;
            color: white;
            text-decoration: none;
            transition: background-color 0.3s ease;
            border-left: 5px solid transparent;
        }

        .sidebar ul li a i {
            margin-right: 15px;
        }

        .sidebar ul li a:hover,
        .sidebar ul li a.active {
            background-color: #495057;
            border-left-color: #007bff;
        }

        .content-wrapper {
            flex-grow: 1;
            margin-left: 0;
            /* Initially no left margin on mobile */
            padding: 20px;
            transition: margin-left 0.3s ease;
        }

        .admin-header {
            background-color: #fff;
            color: #495057;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            border-bottom: 1px solid #eee;
        }

        .admin-header h2 {
            font-size: 1.75em;
            margin: 0;
            font-weight: bold;
        }

        .admin-header .user-info {
            display: flex;
            align-items: center;
        }

        .admin-header .user-info img {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            margin-left: 10px;
            object-fit: cover;
        }

        .admin-header .logout-btn {
            background-color: #dc3545;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s ease;
            margin-left: 20px;
        }

        .admin-header .logout-btn:hover {
            background-color: #c82333;
        }

        .dashboard-panels {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }

        .dashboard-panel {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 20px;
            transition: transform 0.3s ease;
        }

        .dashboard-panel:hover {
            transform: translateY(-5px);
        }

        .dashboard-panel h3 {
            margin-top: 0;
            margin-bottom: 10px;
            color: #333;
        }

        .dashboard-panel p {
            color: #666;
        }

        .dashboard-panel .panel-link {
            display: block;
            color: #007bff;
            text-decoration: none;
            margin-top: 15px;
            font-weight: bold;
            transition: color 0.3s ease;
        }

        .dashboard-panel .panel-link:hover {
            color: #0056b3;
        }

        .info-section {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        footer {
            text-align: center;
            padding: 20px;
            background-color: #f8f9fa;
            border-top: 1px solid #eee;
        }

        /* Mobile styles */
        @media (max-width: 768px) {
            .content-wrapper {
                margin-left: 0;
                padding: 15px;
            }

            .admin-header .logout-btn {
                padding: 5px 10px;
                /* Reduce padding */
                font-size: 0.8em;
                /* Reduce font size */
                margin-left: 10px;
                /* Reduce left margin */
            }

            .sidebar-toggle-button {
                background-color: #343a40;
                color: white;
                border: none;
                padding: 10px 15px;
                border-radius: 5px;
                position: fixed;
                top: 10px;
                left: 10px;
                z-index: 101;
                cursor: pointer;
                display: block;
            }
        }

        /* Desktop styles */
        @media (min-width: 769px) {
            .sidebar {
                transform: translateX(0);
                /* Show sidebar on desktop */
            }

            .content-wrapper {
                margin-left: 250px;
                /* Adjust content margin for sidebar */
            }

            .sidebar-toggle-button {
                display: none;
                /* Hide toggle button on desktop */
            }
        }

        /* Optional custom styling to adjust spacing or appearance */
        .navbar-nav .nav-item.dropdown .dropdown-menu {
            border: 1px solid rgba(0, 0, 0, 0.15);
            /* Optional border */
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            /* Optional shadow */
            background-color: #898282;
        }

        .navbar-nav .nav-link.dropdown-toggle::after {
            vertical-align: 0.15em;
            /* Adjust arrow alignment */
        }
        @media (max-width: 768px) {
    /* ... other mobile styles ... */
    .wrapper.sidebar-open-mobile .content-wrapper {
        /* Adjust margin or transform if needed */
        /* For instance, you might want to avoid content overlap */
        /* margin-left: 250px; */
    }
    body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f8f9fa;
    color: #333;
    display: flex;
    flex-direction: column;
    min-height: 100vh; /* Ensure the body takes at least the full viewport height */
}

.wrapper {
    display: flex;
    flex-grow: 1; /* Allows the wrapper (content area) to take up available space */
}

footer {
    text-align: center;
    padding: 20px;
    background-color: #f8f9fa;
    border-top: 1px solid #eee;
    /* No need for fixed positioning here */
}

/* ... other styles ... */
}
    </style>
</head>

<body>
    <div class="wrapper">
        <button class="sidebar-toggle-button"><i class="fas fa-bars"></i></button>
        <aside class="sidebar">
    <div class="logo">
        <h2>Nonsuch Admin</h2>
    </div>
    <ul class="navbar-nav">
       
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="claimsDropdown" role="button"
                data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-folder panel-link"></i> Claims Department
            </a>
            <ul class="dropdown-menu" aria-labelledby="claimsDropdown">
                <li><a class="dropdown-item panel-link load-content" href="#" data-url="../mqams/e_log_request.php">Issue PA Code</a></li>
                <li><a class="dropdown-item panel-link load-content" href="#" data-url="../mqams/e_display.php">Vet bills</a></li>
                <li><a class="dropdown-item panel-link load-content" href="#" data-url="../mqams/check_vet_bill_underwriter.php">Check Vetted bills</a></li>
                <li><a class="dropdown-item panel-link load-content" href="#" data-url="../mqams/re_check_vet_bill_gm.php">Recheck Vetted Bills</a></li>
                <li><a class="dropdown-item panel-link load-content" href="#" data-url="claims_approve_payment.php">Approve Bills Payment</a></li>
            </ul>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="accountDropdown" role="button"
                data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-university panel-link"></i> Account Department
            </a>
            <ul class="dropdown-menu" aria-labelledby="accountDropdown">
                <li><a class="dropdown-item panel-link load-content" href="#" data-url="account_issue_paid.php">Issue Paid Bills</a></li>
                <li><a class="dropdown-item panel-link load-content" href="#" data-url="account_download_pdf.php">Download PDF</a></li>
                <li><a class="dropdown-item panel-link load-content" href="#" data-url="account_download_excel.php">Download Excell</a></li>
                <li><a class="dropdown-item panel-link load-content" href="#" data-url="account_recheck_bills.php">Recheck Vetted Bills</a></li>
            </ul>
        </li>
    </ul>
</aside>

<div class="content-wrapper">
    <header class="admin-header">
        <h2>Dashboard</h2>
        <div class="user-info">
            <span>Welcome, <?php echo isset($_SESSION['info']['username']) ? $_SESSION['info']['username'] : 'Guest'; ?></span>
            <img src="../uploads/<?php echo isset($_SESSION['info']['photo']) ? $_SESSION['info']['photo'] : 'default.png'; ?>"
                alt="User Photo">
            <a href="logout.php" class="logout-btn"><i
                    class="fas fa-sign-out-alt btn-sm panel-link load-content"></i> Logout</a>
        </div>
    </header>

    <div id="dashboard-content">
        <div class="dashboard-panels">
            <div class="dashboard-panel">
                <h3><i class="fas fa-hospital-user me-2 panel-link load-content"></i> Enrollees</h3>
                <p>Manage and view all enrolled members.</p>
                <a href="../mqams/enrolleesRegistered.php" class="panel-link panel-link load-content">View
                    Enrollees <i class="fas fa-arrow-right ms-1"></i></a>
            </div>
            <div class="dashboard-panel">
                <h3><i class="fas fa-notes-medical me-2 panel-link load-content"></i> Claims</h3>
                <p>Process and review submitted medical claims.</p>
                <a href="../mqams/manage_claims.php" class="panel-link panel-link load-content">Manage Claims <i
                            class="fas fa-arrow-right ms-1"></i></a>
            </div>
            <div class="dashboard-panel panel-link load-content">
                <h3><i class="fas fa-chart-line me-2 panel-link load-content"></i> Analytics</h3>
                <p>Overview of system statistics and reports.(work in progress)</p>
                <a href="#" class="panel-link panel-link load-content">View Analytics <i
                            class="fas fa-arrow-right ms-1"></i></a>
            </div>
            <div class="dashboard-panel panel-link load-content">
                <h3><i class="fas fa-users-cog me-2 panel-link load-content"></i> User Management</h3>
                <p>Manage admin users and their permissions.</p>
                <a href="insert_staff_details.php" class="panel-link panel-link load-content">Manage Users <i
                            class="fas fa-arrow-right ms-1"></i></a>
            </div>
        </div>

        <section class="info-section panel-link load-content">
            <h3>Quick Information</h3>
            <p>This is your admin dashboard. Here you can quickly access and manage various aspects of the
                Nonsuch Medicare system.</p>
            <ul>
                <li>Use the sidebar to navigate to different sections.</li>
                <li>The panels above provide a quick overview of key areas.</li>
                <li>Stay updated with the latest system information here.</li>
            </ul>
        </section>
    </div>
</div>

    <!-- <footer>
        &copy; <?php echo date("Y"); ?> Nonsuch Medicare. All rights reserved.
    </footer> -->

    <script src="../dist/bootstrap-5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script>
   document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.querySelector('.sidebar');
    const wrapper = document.querySelector('.wrapper'); // Assuming .wrapper is the main container

    if (sidebar && wrapper) {
        // Function to open the sidebar
        function openSidebar() {
            sidebar.classList.add('open');
            // Optionally add a class to the wrapper to adjust content if needed
            wrapper.classList.add('sidebar-open-mobile');
        }

        // Function to close the sidebar
        function closeSidebar() {
            sidebar.classList.remove('open');
            wrapper.classList.remove('sidebar-open-mobile');
        }

        // Event listener for clicks on the wrapper (outside the sidebar)
        wrapper.addEventListener('click', function(event) {
            // Check if the click is NOT inside the sidebar
            if (!sidebar.contains(event.target) && window.innerWidth <= 768) {
                closeSidebar();
            } else if (window.innerWidth <= 768 && !sidebar.classList.contains('open')) {
                openSidebar();
            }
        });

        // Prevent clicks inside the sidebar from immediately closing it if it's open
        sidebar.addEventListener('click', function(event) {
            event.stopPropagation(); // Stop the click from propagating to the wrapper
        });
    }
});
$(document).ready(function() {
    $('.load-content').click(function(e) {
        e.preventDefault(); // Prevent the default link behavior (page reload)

        var url = $(this).data('url'); // Get the URL from the data-url attribute

        if (url) {
            $('#dashboard-content').load(url, function(response, status, xhr) {
                if (status === "error") {
                    var msg = "Sorry but there was an error: ";
                    $("#dashboard-content").html(msg + xhr.status + " " + xhr.statusText);
                }
                // Optional: You can add a callback function here to execute after the content is loaded
                // For example, to initialize any JavaScript within the loaded content
            });
        }
    });
});
</script>
