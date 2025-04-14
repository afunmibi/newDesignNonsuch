<?php
session_start();
require_once '../backend/connection.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Debug file paths
echo "Document Root: " . $_SERVER['DOCUMENT_ROOT'] . "<br>";
echo "Current Script: " . __FILE__ . "<br>";

$hmo_code = "051/";
$prog_code = "NHIA";
$random = random_int(1, 9999);
$pa_code = $hmo_code.'/'.$prog_code.'/'.$random;

// Step handling
$step = isset($_GET['step']) ? $_GET['step'] : 1;

// Store temporary data in session
if (!isset($_SESSION['enrollee_data'])) {
    $_SESSION['enrollee_data'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    switch($step) {
        case 1:
            $_SESSION['enrollee_data']['personal_info'] = [
                'name' => $_POST['name'],
                'nhia' => $_POST['nhia'],
                'sex' => $_POST['sex'],
                'phone' => $_POST['phone'],
                'dob' => $_POST['dob']
            ];
            header("Location: e_vet_bills.php?step=2");
            exit;

        case 2:
            $_SESSION['enrollee_data']['hospital_info'] = [
                'primary_hospital' => $_POST['primaryHospital'],
                'secondary_hospital' => $_POST['secondaryHospital'],
                'primary_hospital_code' => $_POST['primary_hospital_code'],
                'secondary_hospital_code' => $_POST['secondary_hospital_code'],
                'status' => $_POST['status']
            ];
            header("Location: e_vet_bills.php?step=3");
            exit;

        case 3:
            // Final step - save complete data
            $final_data = array_merge(
                $_SESSION['enrollee_data']['personal_info'], 
                $_SESSION['enrollee_data']['hospital_info']
            );

            $final_data['diagnosis'] = $_POST['diagnosis'];
            $final_data['procedure'] = $_POST['procedure'];
            $final_data['further_diagnosis'] = $_POST['further_diagnosis'];
            $final_data['pa_code'] = $pa_code;
            $final_data['staff_id'] = $_SESSION['info']['staff_id'];

            $sql = "INSERT INTO `log_enrollees_in` (
                name_of_enrollee, nhia_no, sex, phone_no, 
                primary_hospital, secondary_hospital, 
                status_position, primary_hospital_code, 
                secondary_hospital_code, diagnosis, 
                procedure_text, dob, further_diagnosis, 
                pa_code, staff_id
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            $stmt = $con->prepare($sql);
            $stmt->bind_param(
                "sssssssssssssss", 
                $final_data['name'], $final_data['nhia'], 
                $final_data['sex'], $final_data['phone'], 
                $final_data['primary_hospital'], 
                $final_data['secondary_hospital'], 
                $final_data['status'], 
                $final_data['primary_hospital_code'], 
                $final_data['secondary_hospital_code'], 
                $final_data['diagnosis'], 
                $final_data['procedure'], 
                $final_data['dob'], 
                $final_data['further_diagnosis'], 
                $final_data['pa_code'], 
                $final_data['staff_id']
            );

            if ($stmt->execute()) {
                // Clear session data
                unset($_SESSION['enrollee_data']);
                header("Location: success.php");
                exit;
            } else {
                $error = "Error saving record: " . $stmt->error;
            }
            break;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Multi-Step Enrollee Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include('../loginsystem/header.php'); ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-10 form-container">
            <?php if ($step == 1): ?>
                <h2 class="text-center mb-4">Personal Information</h2>
                <form action="" method="post">
                    <div class="row">
                        <div class="col-md-4 mb-2">
                            <label for="name" class="form-label">Name of Enrollee</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter name" required>
                        </div>
                        <div class="col-md-4 mb-2">
                            <label for="nhia" class="form-label">NHIA No</label>
                            <input type="text" class="form-control" id="nhia" name="nhia" placeholder="Enter NHIA number" required>
                        </div>
                        <div class="col-md-4 mb-2">
                            <label class="form-label">Sex</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="sex" id="male" value="male" required>
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
                            <input type="tel" class="form-control" name="phone" id="phone" placeholder="Enter phone number" required>
                        </div>
                        <div class="col-md-4 mb-2">
                            <label for="dob" class="form-label">Date of Birth</label>
                            <input type="date" class="form-control" id="dob" name="dob" required>
                        </div>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Next</button>
                    </div>
                </form>
            <?php elseif ($step == 2): ?>
                <h2 class="text-center mb-4">Hospital Information</h2>
                <form action="" method="post">
                    <div class="row">
                        <div class="col-md-4 mb-2">
                            <label for="primaryHospital" class="form-label">Primary Hospital</label>
                            <input type="text" class="form-control" name="primaryHospital" id="primaryHospital" placeholder="Enter primary hospital" required>
                        </div>
                        <div class="col-md-4 mb-2">
                            <label for="secondaryHospital" class="form-label">Secondary Hospital</label>
                            <input type="text" class="form-control" name="secondaryHospital" id="secondaryHospital" placeholder="Enter secondary hospital">
                        </div>
                        <div class="col-md-4 mb-2">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-control" required>
                                <option value="">--Select position---</option>
                                <option value="principal">Principal</option>
                                <option value="spouse">Spouse</option>
                                <option value="child_1">Child 1</option>
                                <option value="child_2">Child 2</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <label for="primaryHospital-code" class="form-label">Primary Hospital Code</label>
                            <input type="text" class="form-control" name="primary_hospital_code" id="primaryHospital-code" placeholder="Enter primary hospital Code" required>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label for="secondaryHospital_code" class="form-label">Secondary Hospital Code</label>
                            <input type="text" class="form-control" name="secondary_hospital_code" id="secondaryHospital_code" placeholder="Enter secondary hospital Code">
                        </div>
                    </div>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-between">
                        <a href="enrollee_form.php?step=1" class="btn btn-secondary">Previous</a>
                        <button type="submit" class="btn btn-primary">Next</button>
                    </div>
                </form>
            <?php elseif ($step == 3): ?>
                <h2 class="text-center mb-4">Medical Information</h2>
                <form action="" method="post">
                    <div class="row">
                        <div class="col-md-4 mb-2">
                            <label for="diagnosis" class="form-label">Diagnosis</label>
                            <textarea class="form-control" name="diagnosis" id="diagnosis" rows="3" placeholder="Enter diagnosis" required></textarea>
                        </div>
                        <div class="col-md-4 mb-2">
                            <label for="procedure" class="form-label">Procedure</label>
                            <textarea class="form-control" name="procedure" id="procedure" rows="3" placeholder="Enter procedure" required></textarea>
                        </div>
                        <div class="col-md-4 mb-2">
                            <label for="furtherDiagnosis" class="form-label">Further Diagnosis</label>
                            <textarea class="form-control" name="further_diagnosis" id="furtherDiagnosis" rows="3" placeholder="Enter further diagnosis"></textarea>
                        </div>
                    </div>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-between">
                        <a href="enrollee_form.php?step=2" class="btn btn-secondary">Previous</a>
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </form>
            <?php endif; ?>
        </div>
    </div>
</div>

