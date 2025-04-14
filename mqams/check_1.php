<?php
// Database connection
session_start();
require_once '../backend/connection.php';


// Check if `pa_code` is passed
if (isset($_POST['pa_code'])) {
    $pa_code = $con->real_escape_string($_POST['pa_code']);

    // Query the database
    $query = "SELECT * FROM log_enrollees_in WHERE pa_code = '$pa_code'";
    $result = $con->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo "<h3>Enrollee Details</h3>";
        echo "<table border='1'>
                <tr>
                    <th>Name of Enrollee</th>
                    <th>Sex</th>
                    <th>Phone</th>
                    <th>PA Code</th>
                    <th>PHC</th>
                    <th>PHC Code</th>
                    <th>SHC</th>
                    <th>SHC Code</th>
                    <th>Diagnosis</th>
                    <th>Procedure</th>
                    <th>Further Diagnosis</th>
                    <th>Staff ID</th>
                </tr>
                <tr>
                    <td>{$row['name_of_enrollee']}</td>
                    <td>{$row['sex']}</td>
                    <td>{$row['phone_no']}</td>
                    <td>{$row['pa_code']}</td>
                    <td>{$row['primary_hospital']}</td>
                    <td>{$row['primary_hospital_code']}</td>
                    <td>{$row['secondary_hospital']}</td>
                    <td>{$row['secondary_hospital_code']}</td>
                    <td>{$row['diagnosis']}</td>
                    <td>{$row['procedure_text']}</td>
                    <td>{$row['further_diagnosis']}</td>
                    <td>{$row['staff_id']}</td>
                </tr>
              </table>";

        // Fetch services
        $serviceQuery = "SELECT * FROM e_service_entry WHERE pa_code = '$pa_code'";
        $serviceResult = $con->query($serviceQuery);

        if ($serviceResult->num_rows > 0) {
            echo "<h3>Service Details</h3>";
            echo "<table border='1'>
                    <tr>
                        <th>Name of Service</th>
                        <th>NHIA Tariff</th>
                        <th>HCF Amount Claimed</th>
                        <th>Amount Due</th>
                        <th>Qty</th>
                        <th>Total</th>
                        <th>Remarks</th>
                    </tr>";
            while ($serviceRow = $serviceResult->fetch_assoc()) {
                echo "<tr>
                        <td>{$serviceRow['name_of_service']}</td>
                        <td>{$serviceRow['nhia_tariff']}</td>
                        <td>{$serviceRow['hcf_amount_claimed']}</td>
                        <td>{$serviceRow['amount_due']}</td>
                        <td>{$serviceRow['qty']}</td>
                        <td>{$serviceRow['total']}</td>
                        <td>{$serviceRow['remarks']}</td>
                      </tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No service records found.</p>";
        }

        // Fetch drugs
        $drugQuery = "SELECT * FROM e_drug_entry WHERE pa_code = '$pa_code'";
        $drugResult = $con->query($drugQuery);

        if ($drugResult->num_rows > 0) {
            echo "<h3>Drug Details</h3>";
            echo "<table border='1'>
                    <tr>
                        <th>Name of Drug</th>
                        <th>NHIA Tariff</th>
                        <th>HCF Amount Claimed</th>
                        <th>Amount Due</th>
                        <th>Qty</th>
                        <th>Total</th>
                        <th>Remarks</th>
                    </tr>";
            while ($drugRow = $drugResult->fetch_assoc()) {
                echo "<tr>
                        <td>{$drugRow['name_of_drug']}</td>
                        <td>{$drugRow['nhia_tariff']}</td>
                        <td>{$drugRow['hcf_amount_claimed']}</td>
                        <td>{$drugRow['amount_due']}</td>
                        <td>{$drugRow['qty']}</td>
                        <td>{$drugRow['total']}</td>
                        <td>{$drugRow['remarks']}</td>
                      </tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No drug records found.</p>";
        }
    } else {
        echo "<p>No record found for PA Code: $pa_code</p>";
    }
}

$con->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Search PA Code</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-3">Search PA Code</h2>
        <form action="check_1.php" method="post" class="row g-3 align-items-center">
            <div class="col-auto">
                <label for="pa_code" class="visually-hidden">PA Code</label>
                <input type="text" class="form-control" id="pa_code" name="pa_code" placeholder="Enter PA Code">
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary">Search</button>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz2" crossorigin="anonymous"></script>
</body>
</html>
