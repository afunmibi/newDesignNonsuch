<?php
require "../backend/connection.php";
// pdf stuff
// require_once 'card.php'; // Adjust path

// use Dompdf\Dompdf;

// // Instantiate Dompdf
// // $dompdf = new Dompdf();

// // Load HTML content
// $html = '<h1>My PDF</h1><p>This is generated from HTML.</p>';
// $dompdf->loadHtml($html);

// // (Optional) Set paper size and orientation
// $dompdf->setPaper('A4', 'portrait');

// // Render the HTML as PDF
// $dompdf->render();

// // Output the generated PDF to Browser
// $dompdf->stream('document.pdf', array('Attachment' => 1)); // 1 = Download
// // pdf codes end;

if (isset($_GET["id"])) {
    $enrollee_id = $_GET["id"];

    $sql = "SELECT * FROM `log_enrollees_in` WHERE id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("i", $enrollee_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
}
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enrollee Identity Card</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f0f8ff;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .card {
            border: 2px solid #87CEEB;
            border-radius: 15px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
            width: 600px;
            margin: 50px auto;
        }

        .card-header {
            background-color: #87CEEB;
            color: white;
            border-bottom: 2px solid #6cb2eb;
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
            padding: 20px;
            text-align: center;
        }

        .card-body {
            background-color: #e0f7fa;
            padding: 30px;
            display: flex;
            align-items: flex-start;
        }

        .profile-photo {
            width: 180px;
            height: 180px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-right: 30px;
        }

        .details {
            flex-grow: 1;
        }

        .details h5 {
            color: #007bb5;
            font-size: 1.8em;
            margin-bottom: 10px;
        }

        .details p {
            color: #007bb5;
            margin-bottom: 8px;
            line-height: 1.6;
        }

        .btn-container {
            text-align: center;
            margin-top: 20px;
        }

        .btn-primary, .btn-secondary {
            background-color: #87CEEB;
            border-color: #6cb2eb;
            padding: 12px 25px;
            border-radius: 8px;
            font-size: 1em;
            transition: background-color 0.3s;
            margin: 0 10px;
        }

        .btn-primary:hover, .btn-secondary:hover {
            background-color: #6cb2eb;
            border-color: #5ba1da;
        }

        .plan-type {
            background-color: #ccebff;
            padding: 8px 15px;
            border-radius: 5px;
            display: inline-block;
            margin-top: 15px;
            color: #007bb5;
            font-weight: 600;
        }
    </style>
</head>
<body>
<?php include('../loginsystem/header.php'); ?>
<div class="container">
    <div class="card">
        <div class="card-header">
        <h2>NONSUCH <span class="details">MEDICARE</span> LIMITED</h2>
            <h4>Enrollee's PA Code Details</h4>
        </div>
        <div class="card-body">
            <!-- <img src="../uploads/<?php echo $row['photo']; ?>" alt="Passport Photograph" class="profile-photo"> -->
            <div class="details">
                <h5>Name of Enrollee <?php echo $row['name_of_enrollee']; ?></h5>
                <!-- <p><strong>Organization:</strong> <?php echo $row['organization']; ?></p> -->
                <p><strong>nhia_no:</strong> <?php echo $row['nhia_no']; ?></p>
                <p><strong>Phone No:</strong> <?php echo $row['phone_no']; ?></p>
                
                <p><strong>Provider:</strong><?php echo $row['primary_hospital'];?></p>
                <p><strong>Sex:</strong> <?php echo $row['sex']; ?></p>
               

            </div>
        </div>
    </div>
    <div class="container text-center"><a href="e_pa_code_approval.php?id=<?php echo $row['id']; ?>"><button
                                                name="pa_code_approval" class="btn btn-primary btn-sm">Approve PA
                                                Code</button></a>
                                        <a href="e_vet_service_inputs.php?id=<?php echo $row['pa_code']; ?>"><button
                                                name="vet_bill" class="btn btn-primary btn-sm">Vet Bill</button></a></div>
    <div class="btn-container">
        <input type="button" value="Print" onclick="window.print()" class="btn btn-primary mt-3">
        <a href="generate_pdf.php?id=<?php echo $enrollee_id; ?>" class="btn btn-secondary mt-3">Download PDF</a>
    </div>
</div>
<p class="text-center">
<a href="e_display.php">Back</a></p>
</body>
</html>