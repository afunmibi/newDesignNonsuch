<?php
require "../backend/connection.php";
if (isset($_POST['staff_details_submit'])) {
    $username = htmlspecialchars($_POST['username']);
    $username = strtolower($username);
    $password = htmlspecialchars($_POST['password']);
    $usertype = htmlspecialchars($_POST['role']);
    $staff_id = htmlspecialchars($_POST['staff_id']);
    $usertype = strtolower($usertype);
    $password = password_hash($password, PASSWORD_DEFAULT);

    $file_name = $_FILES['staff_photo']['name'];
    $file_tmp = $_FILES['staff_photo']['tmp_name'];
    $store = "../uploads/" . basename($file_name);

    if (!move_uploaded_file($file_tmp, $store)) {
        echo "<div class='alert alert-danger'>Failed to upload photo.</div>";
    } else {
        $sql = "INSERT INTO login (username, password, usertype, staff_id, photo) VALUES (?, ?, ?, ?, ?)";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("sssss", $username, $password, $usertype, $staff_id, $file_name);
        $result = $stmt->execute();

        if ($result) {
            echo "<div class='alert alert-success'>Staff details registered successfully!</div>";
        } else {
            echo "<div class='alert alert-danger'>Registration failed. Error: " . $con->error . "</div>";
        }
        $stmt->close();
    }
    $con->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Staff Registration</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Reduced sizes and increased select padding */
        body {
            background: linear-gradient(135deg, #f0f2f0, #e0e0e0);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }

        .registration-container {
            background-color: #fff;
            padding: 30px; /* Reduced padding */
            border-radius: 10px; /* Slightly less rounded */
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1); /* Less prominent shadow */
            width: 90%;
            max-width: 450px; /* Reduced max-width */
        }

        .registration-header {
            text-align: center;
            margin-bottom: 20px; /* Reduced margin */
            color: #333;
        }

        .registration-header h2 {
            font-size: 2em; /* Smaller title */
            margin-bottom: 8px; /* Reduced margin */
            color: #007bff;
        }

        .registration-header p {
            font-size: 1em; /* Smaller subtitle */
            color: #666;
        }

        .form-group {
            margin-bottom: 20px; /* Reduced margin */
        }

        .form-group label {
            display: block;
            margin-bottom: 6px; /* Reduced margin */
            font-weight: 500;
            color: #555;
            font-size: 0.95rem; /* Slightly smaller label */
        }

        .form-control {
            width: 100%;
            padding: 10px 12px; /* Reduced padding */
            border: 1px solid #ddd;
            border-radius: 5px; /* Slightly less rounded */
            box-sizing: border-box;
            font-size: 0.9rem; /* Smaller font */
            transition: border-color 0.3s ease;
        }

        .form-control:focus {
            border-color: #007bff;
            outline: none;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        .form-control::placeholder {
            color: #aaa;
            opacity: 1;
            font-size: 0.9rem; /* Smaller placeholder font */
        }

        .form-control-file {
            padding: 8px 0; /* Reduced padding */
            font-size: 0.9rem; /* Smaller font */
        }

        .btn-primary {
            background-color: #007bff;
            color: #fff;
            padding: 10px 18px; /* Reduced padding */
            border: none;
            border-radius: 5px; /* Slightly less rounded */
            cursor: pointer;
            font-size: 1rem; /* Slightly smaller button font */
            transition: background-color 0.3s ease, transform 0.2s ease;
            width: 100%;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            transform: translateY(-1px); /* Less pronounced lift */
            box-shadow: 0 3px 5px rgba(0, 0, 0, 0.1); /* Less prominent shadow */
        }

        .alert {
            padding: 12px; /* Reduced padding */
            margin-bottom: 15px; /* Reduced margin */
            border-radius: 5px; /* Slightly less rounded */
            font-weight: 500;
            font-size: 0.9rem; /* Smaller alert font */
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 15px; /* Reduced margin */
            color: #007bff;
            text-decoration: none;
            transition: color 0.3s ease;
            font-size: 0.9rem; /* Smaller font */
        }

        .back-link:hover {
            color: #0056b3;
            text-decoration: underline;
        }

        /* Increased padding for select role */
        #role {
            padding: 12px 15px; /* Increased padding */
        }

        /* Responsive adjustments */
        @media (min-width: 576px) {
            .btn-primary {
                width: auto;
            }
        }
    </style>
</head>
<body>
<?php // include('header.php'); // Assuming you have a header file ?>
<div class="container">
    <div class="registration-container">
        <div class="registration-header">
            <h2>Join Our Team</h2>
            <p>Register new staff members here.</p>
        </div>
        <a href="index.php" class="back-link">Back to Login</a>
        <form action="#" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="Enter a unique username">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Create a strong password">
            </div>
            <div class="form-group">
                <label for="role">Role</label>
                <select class="form-control" id="role" name="role">
                    <option value="admin">Administrator</option>
                    <option value="user">General User</option>
                    <option value="md">Managing Director</option>
                    <option value="gm">General Manager</option>
					<option value="underwriter">Underwriter</option>
					<option value="account">Account</option>
					<option value="hr">HR</option>
					<option value="ict">ICT</option>
                </select>
            </div>
            <div class="form-group">
                <label for="staff_id">Staff ID</label>
                <input type="text" class="form-control" id="staff_id" name="staff_id" placeholder="Enter staff identification number">
            </div>
            <div class="form-group">
                <label for="staff_photo">Staff Photo</label>
                <input type="file" class="form-control-file" id="staff_photo" name="staff_photo">
                <small class="form-text text-muted">Please upload a clear passport photograph.</small>
            </div>
            <button type="submit" class="btn btn-primary" name="staff_details_submit">Register Staff</button>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>