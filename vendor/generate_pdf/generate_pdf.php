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
                border-radius: 8px; /* Slightly less rounded */
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05); /* Less prominent shadow */
                width: 85%; /* Further reduce width */
                max-width: 400px; /* Further reduce max-width */
                margin: 15px; /* Reduce margin */
                overflow: hidden;
            }

            .card-header {
                background: linear-gradient(to right, #007bff, #00bfff);
                color: white;
                padding: 15px; /* Reduce padding */
                text-align: center;
                border-bottom: 1px solid #0056b3; /* Thinner border */
                box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1); /* Less prominent shadow */
            }

            .card-header h2 {
                font-size: 1.3em; /* Smaller heading */
                margin-bottom: 3px; /* Reduce margin */
            }

            .card-header h4 {
                font-size: 1em; /* Smaller subheading */
                margin-bottom: 0;
                font-weight: normal;
            }

            .card-body {
                padding: 15px; /* Reduce padding */
                display: flex;
                align-items: flex-start;
            }

            .profile-photo-container {
                width: 90px; /* Even smaller photo */
                height: 90px; /* Even smaller photo */
                border-radius: 50%;
                overflow: hidden;
                margin-right: 15px; /* Reduce margin */
                border: 2px solid #e0f2f7; /* Thinner border */
                box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05); /* Less prominent shadow */
                flex-shrink: 0;
            }

            .profile-photo {
                width: 100%;
                height: 100%;
                object-fit: cover;
                display: block;
            }

            .details {
                flex-grow: 1;
            }

            .details h5 {
                color: #007bff;
                font-size: 1.1em; /* Even smaller heading */
                margin-bottom: 6px; /* Reduce margin */
                font-weight: bold;
            }

            .details p {
                color: #555;
                margin-bottom: 4px; /* Reduce margin */
                font-size: 0.8em; /* Smaller font */
                line-height: 1.3; /* Slightly tighter line height */
            }

            .details strong {
                font-weight: bold;
                color: #333;
            }

            .plan-type {
                background-color: #e0f7fa;
                color: #007bff;
                font-weight: 500;
                border: 1px solid #b3e5fc;
                padding: 4px 8px; /* Even smaller padding */
                border-radius: 4px; /* Less rounded */
                display: inline-block;
                margin-top: 8px; /* Reduce margin */
                font-size: 0.75em; /* Smaller font */
            }

            .barcode-container {
                margin-top: 10px; /* Reduce margin */
                text-align: center;
                opacity: 0.7; /* Slightly less prominent */
            }

            .barcode-container svg {
                width: 120px; /* Smaller barcode */
                height: 40px; /* Smaller barcode */
                border: 1px dashed #ccc;
            }

            .barcode-container p {
                font-size: 0.7em; /* Smaller font */
                color: #777;
                margin-top: 2px; /* Reduce margin */
            }

            .footer {
                background-color: #f8f9fa;
                padding: 8px; /* Reduce padding */
                text-align: center;
                font-size: 0.65em; /* Even smaller font */
                color: #6c757d;
                border-top: 1px solid #dee2e6; /* Thinner border */
            }
        </style>
    </head>
    <body>
        <div class="container d-flex justify-content-center mt-4">
            <div class="card">
                <div class="card-header">
                    <h2>NONSUCH MEDICARE LIMITED</h2>
                    <h4>Enrollee's Identity Card</h4>
                </div>
                <div class="card-body">
                    <div class="profile-photo-container">
                        <img src="../../../uploads/<?php echo $row['photo']; ?>" alt="Passport Photograph" class="profile-photo">
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
                </div>
                <div class="footer">
                    Issued on: <?php echo date("F j, Y"); ?>
                </div>
            </div>
        </div>

        <div class="btn-container text-center mt-2">
            <button onclick="window.print()" class="btn btn-primary btn-sm">Print</button>
            <a href="generate_pdf.php?id=<?php echo $enrollee_id; ?>" class="btn btn-secondary btn-sm">Download PDF</a>
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