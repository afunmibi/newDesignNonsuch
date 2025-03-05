<?php 
require("connection.php");

if(isset($_GET["id"])){
 $enrollee_id = $_GET["id"];

 $sql = "SELECT * FROM `enrolment` WHERE id = ?";
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
        }
        .card {
            border: 2px solid #87ceeb;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .card-header {
            background-color: #87ceeb;
            color: white;
            border-bottom: 2px solid #87ceeb;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }
        .card-body {
            background-color: #e0f7fa;
        }
        .card-title {
            color: #007bb5;
        }
        .card-text {
            color: #007bb5;
        }
        .btn-primary {
            background-color: #87ceeb;
            border-color: #87ceeb;
        }
        .btn-secondary {
            background-color: #007bb5;
            border-color: #007bb5;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="card" style="width: 600px; margin: auto;">
            <div class="card-header text-center">
                <h3>Enrollee's Identity Card</h3>
            </div>
            <div class="card-body d-flex">
                <div class="mr-3">
                    <img src="uploads/<?php echo $row['photo']; ?>" alt="Passport Photograph" class="img-thumbnail" style="width: 150px; height: 150px;">
                    <p class="card-text mt-3"><strong>Plan Type:</strong> <?php echo $row['plan_type']; ?></p>
                </div>
                <div>
                    <h5 class="card-title"><?php echo $row['sname'] . ' ' . $row['oname']; ?></h5>
                    <p class="card-text"><strong>Organization:</strong> <?php echo $row['organization']; ?></p>
                    <p class="card-text"><strong>Policy No:</strong> <?php echo $row['policy_no']; ?></p>
                    <p class="card-text"><strong>Phone No:</strong> <?php echo $row['phone_no']; ?></p>
                    <p class="card-text"><strong>Email:</strong> <?php echo $row['email']; ?></p>
                    <p class="card-text"><strong>Provider:</strong> <?php echo $row['_provider']; ?></p>
                    <p class="card-text"><strong>Gender:</strong> <?php echo $row['gender']; ?></p>
                    <p class="card-text"><strong>Location:</strong> <?php echo $row['_location']; ?></p>
                </div>
            </div> 
        </div>
        <input type="button" value="Print" onclick="window.print()" class="btn btn-primary mt-3">
        <a href="generate_pdf.php?id=<?php echo $enrollee_id; ?>" class="btn btn-secondary mt-3">Download PDF</a>
    </div>
</body>
</html>