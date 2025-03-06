<?php
require_once 'connection.php'; // Include your database connection file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $nhia = $_POST['nhia'];
    $sex = $_POST['sex'];
    $phone = $_POST['phone'];
    $primaryHospital = $_POST['primaryHospital'];
    $secondaryHospital = $_POST['secondaryHospital'];
    $status = $_POST['status'];
    $primaryHospitalCode = $_POST['primaryHospitalCode'];
    $secondaryHospitalCode = $_POST['secondaryHospitalCode'];
    $diagnosis = $_POST['diagnosis'];
    $procedure = $_POST['procedure'];
    $dob = $_POST['dob'];
    $furtherDiagnosis = $_POST['furtherDiagnosis'];

    $sql = "INSERT INTO log_enrollees_in (name_of_enrollee,	nhia_no,	sex,	phone_no,	primary_hospital,	secondary_hospital,	status_position,	primary_hospital_code,secondary_hospital_code,	diagnosis,	procedure_text,	dob,	further_diagnosis) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $con->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("sssssssssssss", $name, $nhia, $sex, $phone, $primaryHospital, $secondaryHospital, $status, $primaryHospitalCode, $secondaryHospitalCode, $diagnosis, $procedure, $dob, $furtherDiagnosis);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Enrollee information saved successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error saving enrollee information: ' . $stmt->error]);
        }
        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Error preparing statement: ' . $con->error]);
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
        .btn-primary:hover{
          background-color: #87CEEB;
          border-color: #87CEEB;
        }
    </style>
</head>
<body>
<?php include('header.php') ;?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-10 form-container">
            <h2 class="text-center mb-4">Enrollee Information</h2>
            <form>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="name" class="form-label">Name of Enrollee</label>
                        <input type="text" class="form-control" id="name" placeholder="Enter name">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="nhia" class="form-label">NHIA No</label>
                        <input type="text" class="form-control" id="nhia" placeholder="Enter NHIA number">
                    </div>
                    <div class="col-md-4 mb-3">
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
                    <div class="col-md-4 mb-3">
                        <label for="phone" class="form-label">Phone No</label>
                        <input type="tel" class="form-control" id="phone" placeholder="Enter phone number">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="primaryHospital" class="form-label">Primary Hospital</label>
                        <input type="text" class="form-control" id="primaryHospital" placeholder="Enter primary hospital">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="secondaryHospital" class="form-label">Secondary Hospital</label>
                        <input type="text" class="form-control" id="secondaryHospital" placeholder="Enter secondary hospital">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Status</label>
                        <div class="form-check">
                          <select name="status" class="col-md-4 mb-3">
                          <option selected>--Select position---</option>
                            <option value="principal">Principal</option>
                            <option value="spouse">Spouse</option>
                            <option value="child_1">Child 1</option>
                            <option value="child_2">Child 2</option>
                          </select>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="primaryHospital" class="form-label">Primary Hospital Code</label>
                        <input type="text" class="form-control" id="primaryHospital" placeholder="Enter primary hospital Code">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="secondaryHospital" class="form-label">Secondary Hospital Code</label>
                        <input type="text" class="form-control" id="secondaryHospital" placeholder="Enter secondary hospital Code">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="diagnosis" class="form-label">Diagnosis</label>
                        <textarea class="form-control" id="diagnosis" rows="3" placeholder="Enter diagnosis"></textarea>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="procedure" class="form-label">Procedure</label>
                        <textarea class="form-control" id="procedure" rows="3" placeholder="Enter procedure"></textarea>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="dob" class="form-label">Date of Birth</label>
                        <input type="date" class="form-control" id="dob">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="furtherDiagnosis" class="form-label">Further Diagnosis</label>
                        <textarea class="form-control" id="furtherDiagnosis" rows="3" placeholder="Enter further diagnosis"></textarea>
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