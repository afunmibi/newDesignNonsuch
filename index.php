<?php

require('backend/connection.php');

// Start the session (important for storing user info)
session_start();

// Security headers
header("X-Frame-Options: DENY");
header("X-XSS-Protection: 1; mode=block");
header("X-Content-Type-Options: nosniff");

// Only show errors in development environment
if ($_SERVER['SERVER_NAME'] === 'localhost' || $_SERVER['SERVER_NAME'] === '127.0.0.1') {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', 0);
    ini_set('display_startup_errors', 0);
    error_reporting(0);
}

// Initialize variables
$error_message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate and sanitize inputs
    $username = isset($_POST['username']) ? mysqli_real_escape_string($con, $_POST['username']) : '';
    $username = strtolower(trim($username));
    $password = $_POST['password']; // Don't sanitize passwords

    // Check if inputs are not empty
    if (empty($username) || empty($password)) {
        $error_message = "Username and password are required.";
    } else {
        // Prepare statement to prevent SQL injection
        $stmt = $con->prepare("SELECT * FROM login WHERE username = ?");
        if (!$stmt) {
            // Log error internally, don't expose to user
            error_log("Database prepare error: " . $con->error);
            $error_message = "An error occurred. Please try again later.";
        } else {
            $stmt->bind_param("s", $username);

            if (!$stmt->execute()) {
                error_log("Database execute error: " . $stmt->error);
                $error_message = "An error occurred. Please try again later.";
            } else {
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();

                // Store the entire row in session as in original code
                $_SESSION['info'] = $row;

                if ($row && password_verify($password, $row['password'])) {
                    // Regenerate session ID to prevent session fixation
                    session_regenerate_id(true);

                    // Redirect based on user type
                    if ($_SESSION['info']['usertype'] == 'admin') {
                        header('Location: loginsystem/admin.php');
                        exit();
                    } elseif ($_SESSION['info']['usertype'] == 'user') {
                        header('Location: loginsystem/user.php');
                        exit();
                    } elseif ($_SESSION['info']['usertype'] == 'md') {
                        header('Location: loginsystem/md.php');
                        exit();
                    } else {
                        $error_message = "User type not recognized.";
                    }
                } else {
                    // Use generic error message for security
                    $error_message = "Invalid username or password.";

                    // Add slight delay to prevent brute force attacks
                    sleep(1);
                }
            }
            $stmt->close();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Nonsuch Medicare Limited Portal Login">
    <title>Nonsuch Medicare Portal - Login</title>
    <link rel="stylesheet" href="dist/bootstrap-5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        .login-card {
            max-width: 450px;
            margin: 2rem auto;
            border-radius: 10px;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }
        .card-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #e3e6f0;
            border-radius: 10px 10px 0 0 !important;
            padding: 1.25rem;
        }
        .form-control:focus {
            border-color: #80bdff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }
        .btn-primary {
            padding: 0.5rem 2rem;
        }
        .error-message {
            color: #dc3545;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body class="bg-light">
    <?php include('loginsystem/header.php'); ?>

    <div class="container py-5">
        <div class="login-card card">
            <div class="card-header text-center">
                <h2 class="mb-0">Nonsuch Medicare Limited</h2>
            </div>
            <div class="card-body p-4">
                <h4 class="card-title text-center mb-4">Portal Login</h4>

                <?php if (!empty($error_message)): ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo htmlspecialchars($error_message); ?>
                </div>
                <?php endif; ?>

                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" class="needs-validation" novalidate>
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-person"></i></span>
                            <input type="text" class="form-control" id="username" name="username" required
                                   autocomplete="username" value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>">
                        </div>
                        <div class="invalid-feedback">Please enter your username.</div>
                    </div>

                    <div class="mb-4">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock"></i></span>
                            <input type="password" class="form-control" id="password" name="password" required autocomplete="current-password">
                        </div>
                        <div class="invalid-feedback">Please enter your password.</div>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">Login</button>
                    </div>
                </form>
            </div>
            <div class="card-footer text-center text-muted py-3">
                This is a demo system. Please report any bugs you observe to 08062328638 through whatsapp. Thank you.
            </div>
        </div>
    </div>

    <script src="dist/bootstrap-5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Enable Bootstrap form validation
        (function() {
            'use strict';

            // Fetch all forms to apply validation styles to
            var forms = document.querySelectorAll('.needs-validation');

            // Loop over them and prevent submission
            Array.prototype.slice.call(forms).forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        })();
    </script>
</body>
</html>