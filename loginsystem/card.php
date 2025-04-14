<?php
require "../backend/connection.php";

if (isset($_GET["id"])) {
    $enrollee_id = $_GET["id"];

    $sql = "SELECT * FROM `enrolment` WHERE id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("i", $enrollee_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if (!$row) {
        echo "Enrollee not found.";
        exit;
    }
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Enrollee Identity Card</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <style>
            body {
                background-color: #f4f8fa;
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                display: flex;
                justify-content: center;
                align-items: center;
                min-height: 100vh;
                margin: 0;
            }

            .card {
                background-color: #fff;
                border: 1px solid #d1e2ec;
                border-radius: 10px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
                width: 90%; /* Make the card responsive within its container */
                max-width: 500px; /* Set a maximum width */
                margin: 20px;
                overflow: hidden; /* Clip rounded corners properly */
            }

            .card-header {
                background-color: #007bff; /* A more standard primary color */
                color: white;
                padding: 20px;
                text-align: center;
                border-bottom: 2px solid #0056b3;
            }

            .card-header h2 {
                font-size: 1.5em;
                margin-bottom: 5px;
            }

            .card-header h4 {
                font-size: 1.1em;
                margin-bottom: 0;
                font-weight: normal;
            }

            .card-body {
                padding: 20px;
                display: flex;
                flex-direction: column;
                align-items: center;
            }

            .profile-photo-container {
                width: 150px;
                height: 150px;
                border-radius: 50%;
                overflow: hidden;
                margin-bottom: 20px;
                border: 3px solid #e0f2f7;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            }

            .profile-photo {
                width: 100%;
                height: 100%;
                object-fit: cover;
                display: block;
            }

            .details {
                text-align: center;
                width: 100%;
            }

            .details h5 {
                color: #333;
                font-size: 1.4em;
                margin-bottom: 10px;
                font-weight: bold;
            }

            .details p {
                color: #555;
                margin-bottom: 8px;
                font-size: 0.95em;
            }

            .details strong {
                font-weight: bold;
                color: #333;
            }

            .plan-type {
                background-color: #e9ecef;
                color: #495057;
                padding: 8px 15px;
                border-radius: 5px;
                display: inline-block;
                margin-top: 15px;
                font-size: 0.9em;
            }

            .barcode-container {
                margin-top: 20px;
                text-align: center;
                opacity: 0.8; /* Example: Add a placeholder for a barcode */
            }

            .barcode-container p {
                font-size: 0.8em;
                color: #777;
            }

            .footer {
                background-color: #f8f9fa;
                padding: 15px;
                text-align: center;
                font-size: 0.8em;
                color: #6c757d;
                border-top: 1px solid #dee2e6;
            }
        </style>
        <style>
            /* Custom, catchy styles */
            .card-header {
                background: linear-gradient(to right, #007bff, #00bfff); /* Gradient header */
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            }
            .profile-photo-container {
                border-color: #00bfff;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            }
            .details h5 {
                color: #007bff;
            }
            .plan-type {
                background-color: #e0f7fa;
                color: #007bff;
                font-weight: 500;
                border: 1px solid #b3e5fc;
            }
        </style>
    </head>
    <body>
        <div class="container d-flex justify-content-center mt-5">
            <div class="card">
                <div class="card-header">
                    <h2>NONSUCH MEDICARE LIMITED</h2>
                    <h4>Enrollee's Identity Card</h4>
                </div>
                <div class="card-body">
                    <div class="profile-photo-container">
                        <img src="../uploads/<?php echo $row['photo']; ?>" alt="Passport Photograph" class="profile-photo">
                    </div>
                    <div class="details">
                        <h5><?php echo htmlspecialchars($row['sname'] . ' ' . $row['oname']); ?></h5>
                        <p><strong>Organization:</strong> <?php echo htmlspecialchars($row['organization']); ?></p>
                        <p><strong>Policy No:</strong> <?php echo htmlspecialchars($row['policy_no']); ?></p>
                        <p><strong>Phone No:</strong> <?php echo htmlspecialchars($row['phone_no']); ?></p>
                        <p><strong>Email:</strong> <?php echo htmlspecialchars($row['email']); ?></p>
                        <p><strong>Provider:</strong> <?php echo htmlspecialchars($row['e_provider']); ?></p>
                        <p><strong>Gender:</strong> <?php echo htmlspecialchars($row['gender']); ?></p>
                        <p><strong>Location:</strong> <?php echo htmlspecialchars($row['e_location']); ?></p>
                        <?php if (!empty($row['plan_type'])): ?>
                            <div class="plan-type">Plan Type: <?php echo htmlspecialchars($row['plan_type']); ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="barcode-container">
                        <svg width="150" height="50" style="border:1px dashed #ccc;"></svg>
                        <p class="mt-2">Card ID: <?php echo htmlspecialchars($enrollee_id); ?></p>
                    </div>
                </div>
                <div class="footer">
                    Issued on: <?php echo date("F j, Y"); ?>
                </div>
            </div>
        </div>

        <div class="btn-container text-center mt-3">
            <button onclick="window.print()" class="btn btn-primary">Print</button>
            <a href="generate_pdf.php?id=<?php echo $enrollee_id; ?>" class="btn btn-secondary">Download PDF</a>
        </div>

        <script>
            // No changes needed here for separation
        </script>
    </body>
    </html>
    <?php
} else {
    echo "No enrollee ID provided.";
}
?>