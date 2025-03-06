<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nonsuch Medicare</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .navbar-skyblue {
            background-color: #87CEEB; /* Skyblue */
            color: white;
        }
        .navbar-skyblue .navbar-brand, .navbar-skyblue .navbar-text, .navbar-skyblue .nav-link {
          color: white;
        }

        .navbar-skyblue .navbar-brand:hover, .navbar-skyblue .nav-link:hover {
          color: #E0FFFF; /* Light skyblue on hover */
        }

        .navbar-skyblue h1, .navbar-skyblue h3 {
            color: white;
            margin: 0;
            padding: 0;
        }

        .navbar-skyblue .navbar-brand img {
            margin-right: 10px;
        }

        .navbar-skyblue .logout-link {
            background-color: #00BFFF; /* Deeper skyblue for button */
            padding: 8px 15px;
            border-radius: 5px;
            text-decoration: none;
            color: white;
            transition: background-color 0.3s;
        }

        .navbar-skyblue .logout-link:hover {
            background-color: #1E90FF; /* Slightly darker on hover */
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-skyblue">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <!-- <img src="image\ProfileImage2.png" alt="Logo" width="30" height="24" class="d-inline-block align-text-top"> -->
            <h1>NONSUCH MEDICARE LIMITED</h1>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <span class="navbar-text"><h3>Nonsuch Portal</h3></span>
                </li>
                <!-- <li class="nav-item">
                    <a class="logout-link" href="logout.php">Logout</a>
                </li> -->
            </ul>
        </div>
    </div>
</nav>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz2" crossorigin="anonymous"></script>
</body>
</html>