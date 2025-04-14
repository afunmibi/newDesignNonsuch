<?php require "../backend/connection.php"; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBgGFA56sIdrh5jbrlPNnN0WzWyJ2yhaQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Enrollee Details</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f7f6;
            color: #333;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .container {
            flex-grow: 1;
            padding: 20px;
            max-width: 1200px;
            margin: 20px auto;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #007bff;
            text-align: center;
            margin-bottom: 30px;
        }

        .action-buttons {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
            justify-content: center;
        }

        .btn-primary, .btn-success {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 6px;
            cursor: pointer;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .btn-success {
            background-color: #28a745;
        }

        .btn-primary:hover, .btn-success:hover {
            background-color: #0056b3;
        }

        .table-responsive {
            overflow-x: auto;
            margin-bottom: 20px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            background-color: #fff;
            box-shadow: 0 1px 5px rgba(0, 0, 0, 0.05);
        }

        .table th,
        .table td {
            padding: 12px 8px;
            border: 1px solid #dee2e6;
            font-size: 0.9rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 150px; /* Adjust as needed */
        }

        .table th {
            background-color: #f8f9fa;
            color: #333;
            font-weight: bold;
            text-align: left;
        }

        .table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .table tbody tr:hover {
            background-color: #e9ecef;
            transition: background-color 0.2s ease-in-out;
        }

        .table td a {
            color: #007bff;
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .table td a:hover {
            color: #0056b3;
        }

        .btn-sm {
            padding: 6px 10px;
            font-size: 0.8rem;
            border-radius: 4px;
        }

        .elegant-link {
            color: #007bff;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .elegant-link:hover {
            color: #0056b3;
            text-decoration: underline;
        }

        .info-text {
            color: #6c757d;
            text-align: center;
            margin-bottom: 15px;
            font-size: 0.95rem;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            h1 {
                font-size: 2rem;
                margin-bottom: 20px;
            }

            .action-buttons {
                flex-direction: column;
                align-items: stretch;
            }

            .action-buttons a {
                width: 100%;
            }

            .table th, .table td {
                font-size: 0.8rem;
                padding: 8px 5px;
                max-width: 120px;
            }
        }

        @media (max-width: 576px) {
            h1 {
                font-size: 1.75rem;
            }

            .table th, .table td {
                font-size: 0.7rem;
                padding: 6px 3px;
                max-width: 100px;
            }
        }
    </style>
</head>

<body>
<?php include '../loginsystem/header.php'; ?>
<a href="../loginsystem/admin.php">Back</a>
<div class="container">
    <h1 class="text-center mb-4">Enrollee Management</h1>

    <div class="action-buttons">
        <a href="e_log_request.php" class="btn btn-primary"><i class="fas fa-user-plus me-2"></i> Add New Enrollee</a>
        <a href="download_excel.php" class="btn btn-success"><i class="fas fa-download me-2"></i> Download Spreadsheet</a>
    </div>

    <div class="info-text">
        Click on the <span class="elegant-link">PA Code</span> to vet the bill.
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>Name of Enrollee</th>
                <th>NHIA No</th>
                <th>Phone No</th>
                <th>PA Code</th>
                <th>Primary Hospital</th>
                <th>Secondary Hospital</th>
                <th>Primary Hospital Code</th>
                <th>Secondary Hospital Code</th>
                <th>Diagnosis</th>
                <th>Procedure Text</th>
                <th>Further Diagnosis</th>
                
                <th>Created On</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $sql = "select * from `log_enrollees_in` ";
            $result = mysqli_query($con, $sql);
            while ($row = mysqli_fetch_assoc($result)) {
                ?>
                <tr>
                    <td><?php echo $row['name_of_enrollee']; ?></td>
                    <td><?php echo $row['nhia_no']; ?></td>
                    <td><?php echo $row['phone_no']; ?></td>
                    <td>
                        <a href="../mqams/e_vet_Service.php?pa_code=<?php echo $row['pa_code'];?>" class="elegant-link data-url='' "><?php echo $row['pa_code']; ?></a>
                    </td>
                    <td><?php echo $row['primary_hospital']; ?></td>
                    <td><?php echo $row['secondary_hospital']; ?></td>
                    <td><?php echo $row['primary_hospital_code']; ?></td>
                    <td><?php echo $row['secondary_hospital_code']; ?></td>
                    <td><?php echo $row['diagnosis']; ?></td>
                    <td><?php echo $row['procedure_text']; ?></td>
                    <td><?php echo $row['further_diagnosis']; ?></td>
                    
                    <td><?php echo date("Y-m-d H:i:s", strtotime($row['created_on'])); ?></td>
                    <!-- <td>
                         class="btn btn-success btn-sm"><i class="fas fa-eye me-1"></i> 
                    </td> -->
                </tr>
                <?php
            }
            ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz2"
        crossorigin="anonymous"></script>
</body>

</html>