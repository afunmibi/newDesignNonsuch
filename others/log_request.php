<?php
session_start();
require_once 'connection.php'; // Include your database connection file
$hmo_code = "051/";
$prog_code= "NHIA";
$random = random_int(1, 9999);
// $staff_id= $_SESSION['staff_id'];
$pa_code = $hmo_code.'/'.$prog_code.'/'.$random;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name_of_enrollee = $_POST['name'];
    $nhia_no = $_POST['nhia'];
    $sex = $_POST['sex'];
    $phone_no = $_POST['phone'];
    $primary_hospital = $_POST['primaryHospital'];
    $secondary_hospital = $_POST['secondaryHospital'];
    $status_position = $_POST['status'];
    $primary_hospital_code = $_POST['primary_hospital_code'];
    $secondary_hospital_code = $_POST['secondary_hospital_code'];
    $diagnosis = $_POST['diagnosis'];
    $procedure_text = $_POST['procedure'];
    $dob = $_POST['dob'];
    $further_diagnosis = $_POST['further_diagnosis'];
    $pa_code = $pa_code;
    $staff_id = null;
    

    $sql = "INSERT INTO `log_enrollees_in` (name_of_enrollee,nhia_no,sex,phone_no,primary_hospital,
    secondary_hospital,status_position,primary_hospital_code,secondary_hospital_code,	
    diagnosis,procedure_text,dob,further_diagnosis, pa_code) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?)";
    $stmt = $con->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("ssssssssssssss", $name_of_enrollee, $nhia_no, $sex, $phone_no,  $primary_hospital, 
        $secondary_hospital, $status_position, $primary_hospital_code, $secondary_hospital_code, $diagnosis, 
        $procedure_text, $dob, $further_diagnosis,$pa_code);
    } else {
        die($con->error);
    };
    if ($stmt->execute()) {
        echo 'Record saved';
    } else {
        echo 'Record not saved' . $stmt->error;
    }

    $con->close();
    // } else {
    // echo json_encode(['success' => false, 'message' => 'Invalid request.'.$con->error]);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enrollee Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f0f8ff;
        }

        .form-container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }

        .form-control:focus {
            border-color: skyblue;
            box-shadow: 0 0 0 0.2rem rgba(135, 206, 250, 0.25);
        }

        .btn-primary {
            background-color: skyblue;
            border-color: skyblue;
        }

        .btn-primary:hover {
            background-color: #87CEEB;
            border-color: #87CEEB;
        }
    </style>
</head>

<body>
    <?php include('header.php'); ?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10 form-container">
                <h2 class="text-center mb-4">Log Enrollee Information for PA Code</h2>
                <form action="#" method="post">
                    <div class="row">
                        <div class="col-md-4 mb-2">
                            <label for="name" class="form-label">Name of Enrollee</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter name">
                        </div>
                        <div class="col-md-4 mb-2">
                            <label for="nhia" class="form-label">NHIA No</label>
                            <input type="text" class="form-control" id="nhia" name="nhia" placeholder="Enter NHIA number">
                        </div>
                        <div class="col-md-4 mb-2">
                            <label class="form-label">Sex</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="sex" id="male" value="male">
                                <label class="form-check-label" for="male">Male</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="sex" id="female" value="female">
                                <label class="form-check-label" for="female">Female</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-2">
                            <label for="phone" class="form-label">Phone No</label>
                            <input type="tel" class="form-control" name="phone" id="phone" placeholder="Enter phone number">
                        </div>
                        <div class="col-md-4 mb-2">
                            <label for="primaryHospital" class="form-label">Primary Hospital</label>
                            <input type="text" class="form-control" name="primaryHospital" id="primaryHospital" placeholder="Enter primary hospital">
                        </div>
                        <div class="col-md-4 mb-2">
                            <label for="secondaryHospital" class="form-label">Secondary Hospital</label>
                            <input type="text" class="form-control" name="secondaryHospital" id="secondaryHospital" placeholder="Enter secondary hospital">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-2">
                            <label class="form-label">Status</label>
                            <div class="form-check">
                                <select name="status" class="col-md-4 mb-2">
                                    <option selected>--Select position---</option>
                                    <option value="principal">Principal</option>
                                    <option value="spouse">Spouse</option>
                                    <option value="child_1">Child 1</option>
                                    <option value="child_2">Child 2</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 mb-2">
                            <label for="primaryHospital" class="form-label">Primary Hospital Code</label>
                            <input type="text" class="form-control" name="primary_hospital_code" id="primaryHospital-code" placeholder="Enter primary hospital Code">
                        </div>
                        <div class="col-md-4 mb-2">
                            <label for="secondaryHospital" class="form-label">Secondary Hospital Code</label>
                            <input type="text" class="form-control" name="secondary_hospital_code" id="secondaryHospital_code" placeholder="Enter secondary hospital Code">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-2">
                            <label for="diagnosis" class="form-label">Diagnosis</label>
                            <textarea class="form-control" name="diagnosis" id="diagnosis" rows="3" placeholder="Enter diagnosis"></textarea>
                        </div>
                        <div class="col-md-4 mb-2">
                            <label for="procedure" class="form-label">Procedure</label>
                            <textarea class="form-control" name="procedure" id="procedure" rows="3" placeholder="Enter procedure"></textarea>
                        </div>
                        <div class="col-md-4 mb-2">
                            <label for="dob" class="form-label">Date of Birth</label>
                            <input type="date" class="form-control" id="dob" name="dob">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-2">
                            <label for="furtherDiagnosis" class="form-label">Further Diagnosis</label>
                            <textarea class="form-control" name="further_diagnosis" id="furtherDiagnosis" rows="3" placeholder="Enter further diagnosis"></textarea>
                        </div>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#enrolleeForm').submit(function(e) {
                e.preventDefault();

                $.ajax({
                    type: 'POST',
                    url: 'process_enrollee.php',
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            alert(response.message);
                            $('#enrolleeForm')[0].reset(); // Reset the form
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function() {
                        alert('An error occurred during the AJAX request.');
                    }
                });
            });
        });
    </script>
</body>

</html>