<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nonsuch Medicare</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../dist/bootstrap-5.3.3/dist/css/bootstrap.min.css">
    <style>
        /* Base styles for a cleaner look */
        body {
            font-family: sans-serif;
        }

        .navbar-elegant {
            background-color: #87CEEB; /* Skyblue background for navbar */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05); /* Subtle shadow */
            padding: 15px 20px;
            transition: box-shadow 0.3s ease;
        }
        
/* Unvisited links */
a:link {
    color: blue;
    text-decoration: none;
}

/* Visited links */
a:visited {
    color: purple;
    text-decoration: underline;
}

/* Active links */
a:active {
    color: red;
    text-decoration: none;
    background-color: yellow;
}

/* Hover effect (optional for better user experience) */
a:hover {
    color: green;
    text-decoration: underline;
}


        .navbar-elegant .navbar-brand {
            font-size: 1.75rem;
            font-weight: 600;
            color: #343a40; /* Dark text */
            text-decoration: none;
        }

        .navbar-elegant .navbar-brand:hover {
            color: #007bff; /* Bootstrap primary color on hover */
        }

        .navbar-elegant .navbar-nav .nav-link {
            font-size: 1rem;
            color: #495057; /* Slightly lighter text */
            padding: 10px 15px;
            margin-left: 10px;
            border-radius: 8px;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .navbar-elegant .navbar-nav .nav-link:hover,
        .navbar-elegant .navbar-nav .nav-link.active {
            background-color: #e9ecef; /* Light hover background */
            color: #007bff;
        }

        .navbar-elegant .navbar-toggler {
            border: none;
            padding: 8px 12px;
            font-size: 1.25rem;
            color: #495057;
            background: transparent;
            border-radius: 4px;
        }

        .navbar-elegant .navbar-toggler:focus {
            outline: none;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        /* Specific elements */
        .navbar-elegant .portal-text {
            font-size: 1.1rem;
            color: #6c757d; /* Grayish text */
            margin-right: 15px;
        }

        .navbar-elegant .logout-button {
            background-color: #dc3545; /* Bootstrap danger color */
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            text-decoration: none; /* To style as a link if needed */
        }

        .navbar-elegant .logout-button:hover {
            background-color: #c82333;
        }

        /* Responsive layout adjustments */
        @media (max-width: 992px) {
            .navbar-elegant .navbar-nav {
                margin-top: 10px;
                border-top: 1px solid #eee;
                padding-top: 10px;
            }

            .navbar-elegant .navbar-nav .nav-link {
                margin-left: 0;
                padding: 10px 0;
            }

            .navbar-elegant .d-flex {
                flex-direction: column;
                align-items: flex-start !important;
            }

            .navbar-elegant .portal-text,
            .navbar-elegant .logout-button {
                margin: 10px 0;
            }
        }
        .navbar-elegant{
            position:relative;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-elegant mb-3">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <i class="fas fa-hospital-alt me-2"></i> NONSUCH MEDICARE
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fas fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <!-- <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Services</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">About Us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Contact</a>
                </li>
            </ul> -->
            <div class="d-flex align-items-center">
                <span class="portal-text">Nonsuch Portal</span>
                <a href="logout.php" class="logout-button">
                    <i class="fas fa-sign-out-alt me-1"></i> Logout
                </a>
            </div>
        </div>
    </div>
</nav>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz2" crossorigin="anonymous"></script>
</body>
</html>