<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../backend/connection.php';
$pa_code = $_GET['pa_code'];
$sql = "SELECT * FROM log_enrollees_in WHERE pa_code= '$pa_code' limit 1";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);
// var_dump($row);
// $pa_code= addslashes( $row['pa_code']);

// Temporarily comment out header include for debugging
// include('../loginsystem/header.php');
// Check if the form is submitted

                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        $name_of_enrollee = $_POST['name'];
                        $nhia_no = $_POST['nhia'];
                        $phone_no = $_POST['phone'];
                        $primary_hospital = $_POST['primaryHospital'];
                        $secondary_hospital = $_POST['secondaryHospital'];
                        $primary_hospital_code = $_POST['primary_hospital_code'];
                        $secondary_hospital_code = $_POST['secondary_hospital_code'];
                        $diagnosis = $_POST['diagnosis'];
                        $procedure_text = $_POST['procedure'];
                        $further_diagnosis = $_POST['further_diagnosis'];
                        $no_of_days_admission =$_POST['no_of_days_admission'];
                        $bill_vetted_by = $_SESSION['info']['username'];
                        $created_on = date('Y-m-d H:i:s');
                        $month_of_bill = $_POST['month_of_bill'];
                        $month_of_bill = date('Y-m-d', strtotime($month_of_bill)); // Convert to MySQL date format
                    
                        $pa_code = $row['pa_code']; // Ensure you have the pa_code for the WHERE clause
                    
                        $stmt = $con->prepare("UPDATE log_enrollees_in SET name_of_enrollee= ?, nhia_no =?, phone_no=?, primary_hospital=?,
                                                                    secondary_hospital=?, primary_hospital_code=?, secondary_hospital_code=?, diagnosis=?, procedure_text=?,
                                                                    further_diagnosis=?, no_of_days_admission=?, bill_vetted_by=?, created_on=?, month_of_bill=? WHERE pa_code=? ");
                        $stmt->bind_param('sssssssssssssss',$name_of_enrollee,$nhia_no,$phone_no,
                                            $primary_hospital,$secondary_hospital, $primary_hospital_code,
                                            $secondary_hospital_code,  $diagnosis, $procedure_text,
                                            $further_diagnosis, $no_of_days_admission, $bill_vetted_by, $created_on,
                                            $month_of_bill, $pa_code); // Corrected bind_param
                    
                        $update_successful = $stmt->execute();    // var_dump($update_successful); // Check if execute returns true
                        // die();

                        if($update_successful){
                            header('Location: e_vet_Service.php?pa_code=' . $pa_code);
                            exit();
                            // echo '<div class="alert alert-success alert-dismissible fade show" role="alert">Updated!<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                            // echo '<script>setTimeout(function(){ window.location.href = "e_vetService.php?pa_code=' . $pa_code . '"; }, 1200);</script>';
                        } else {
                            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">Error: '.$con->error.'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                        }
                    };

                    // Close the statement and connection   
                    
                    $con->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Enrollee Details | Nonsuch Medicare</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Basic responsive table styles */
        .table-responsive {
            overflow-x: auto;
        }

        .form-container {
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        .form-title {
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .form-control {
            width: 100%;
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
            line-height: 1.5;
            color: #495057;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        .form-control:focus {
            color: #495057;
            background-color: #fff;
            border-color: #80bdff;
            outline: 0;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        .readonly-field {
            background-color: #e9ecef;
            opacity: 1;
        }

        .btn-primary {
            color: #fff;
            background-color: #007bff;
            border-color: #007bff;
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
            border-radius: 0.25rem;
            cursor: pointer;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .alert {
            margin-bottom: 1rem;
            padding: 0.75rem 1.25rem;
            border: 1px solid transparent;
            border-radius: 0.25rem;
        }

        .alert-success {
            color: #155724;
            background-color: #d4edda;
            border-color: #c3e6cb;
        }

        .alert-danger {
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
        }

        .btn-close {
            float: right;
            font-size: 1.5rem;
            font-weight: bold;
            line-height: 1;
            color: #000;
            text-shadow: 0 1px 0 #fff;
            opacity: .5;
            text-decoration: none;
        }

        .btn-close:hover {
            opacity: .75;
            cursor: pointer;
        }

        /* Responsive adjustments */
        @media (min-width: 992px) {
            .form-container {
                width: 80%; /* Adjust width for larger screens */
            }
        }
    </style>
</head>

<body>
    <?php // include('../loginsystem/header.php'); ?>
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="form-container">
                <h2 class="text-center form-title">
                    <i class="fas fa-user-edit me-2"></i> Update Enrollee Details
                </h2>
                <form action="" method="post">
                    

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th>Name</th>
                                    <td>
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" value="<?php echo htmlspecialchars($row['name_of_enrollee']); ?>" required>
                                    </td>
                                    <th>NHIA No</th>
                                    <td>
                                        <input type="text" class="form-control" id="nhia" name="nhia" placeholder="Enter NHIA No" value="<?php echo htmlspecialchars($row['nhia_no']); ?>">
                                    </td>
                                </tr>
                                <tr>
                                    <th>Phone</th>
                                    <td>
                                        <input type="tel" class="form-control" name="phone" id="phone" placeholder="Enter Phone" value="<?php echo htmlspecialchars($row['phone_no']); ?>">
                                    </td>
                                    <th>Sex</th>
                                    <td>
                                        <input type="text" class="form-control readonly-field" value="<?php echo htmlspecialchars($row['sex']); ?>" readonly>
                                    </td>
                                </tr>
                                <tr>
                                    <th>DOB</th>
                                    <td>
                                        <input type="text" class="form-control readonly-field" value="<?php echo htmlspecialchars($row['dob']); ?>" readonly>
                                    </td>
                                    <th>Days of Admission</th>
                                    <td>
                                        <input type="number" class="form-control" name="no_of_days_admission" id="no_of_days_admission" placeholder="Enter Days" >
                                    </td>
                                </tr>
                                <tr>
                                    <th>Primary Hospital</th>
                                    <td>
                                        <input type="text" class="form-control" name="primaryHospital" id="primaryHospital" placeholder="Enter Primary Hospital" value="<?php echo htmlspecialchars($row['primary_hospital']); ?>">
                                    </td>
                                    <th>Secondary Hospital</th>
                                    <td>
                                        <input type="text" class="form-control" name="secondaryHospital" id="secondaryHospital" placeholder="Enter Secondary Hospital" value="<?php echo htmlspecialchars($row['secondary_hospital']); ?>">
                                    </td>
                                </tr>
                                <tr>
                                    <th>Primary Code</th>
                                    <td>
                                        <input type="text" class="form-control" name="primary_hospital_code" id="primaryHospital-code" placeholder="Enter Primary Code" value="<?php echo htmlspecialchars($row['primary_hospital_code']); ?>">
                                    </td>
                                    <th>Secondary Code</th>
                                    <td>
                                        <input type="text" class="form-control" name="secondary_hospital_code" id="secondaryHospital_code" placeholder="Enter Secondary Code" value="<?php echo htmlspecialchars($row['secondary_hospital_code']); ?>">
                                    </td>
                                </tr>
                                <tr>
                                    <th colspan="1">Diagnosis</th>
                                    <td colspan="3">
                                        <textarea class="form-control" name="diagnosis" id="diagnosis" rows="2" placeholder="Enter Diagnosis"><?php echo htmlspecialchars($row['diagnosis']); ?></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <th colspan="1">Procedure</th>
                                    <td colspan="3">
                                        <textarea class="form-control" name="procedure" id="procedure" rows="2" placeholder="Enter Procedure"><?php echo htmlspecialchars($row['procedure_text']); ?></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <th colspan="1">Further Diagnosis</th>
                                    <td colspan="3">
                                        <textarea class="form-control" name="further_diagnosis" id="furtherDiagnosis" rows="2" placeholder="Enter Further Diagnosis"><?php echo htmlspecialchars($row['further_diagnosis']); ?></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <th colspan="1">Bill for the Month</th>
                                    <td colspan="3">
                                    <input type="date" class="form-control" name="month_of_bill" id="month_of_bill" placeholder="Write the Month on the bill">
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4" class="text-center">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save me-2"></i> Update & Proceed
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>