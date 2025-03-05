<?php 
require('connection.php');
if (isset($_POST['submit_details'])) {
  $organization = htmlspecialchars($_POST['organization']);
  $sname = htmlspecialchars($_POST['sname']);
  $oname = htmlspecialchars($_POST['oname']);
  $policy_no = htmlspecialchars($_POST['policy_no']);
  $phone_no = htmlspecialchars($_POST['phone_no']);
  $email = htmlspecialchars($_POST['email']);
  $provider = htmlspecialchars($_POST['provider']);
  $gender = htmlspecialchars($_POST['gender']);
  $plan_type = htmlspecialchars($_POST['plan_type']);
  $location = htmlspecialchars($_POST['location']);
  $dob = htmlspecialchars($_POST['dob']);
  $no_of_dependant = htmlspecialchars($_POST['no_of_dependant']);
  $reg_status = htmlspecialchars($_POST['reg_status']);
  $alternate_no = htmlspecialchars($_POST['alternate_no']);
  $date_captured = date("Y-m-d:h:i:s");
  $hmo_no = '051';
  $org_name ='WB';
  $policy_no = $hmo_no.'/'. $org_name.'/'.''.$enrollee_id;
  
  $file_name = $_FILES['photo']['name'];
  $file_tmp = $_FILES['photo']['tmp_name'];
  $file_size = $_FILES['photo']['size'];
  $file_store = "uploads/" . basename($file_name);

  if (!move_uploaded_file($file_tmp, $file_store)) {
    echo 'Error uploading image';
  } else {
    $stmt = $con->prepare("INSERT INTO enrolment (organization, sname, oname, policy_no, phone_no, email, _provider, gender, plan_type, _location, dob, no_of_dependant, reg_status, alternate_no, date_captured, photo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param('ssssssssssssssss', $organization, $sname, $oname, $policy_no, $phone_no, $email, $provider, $gender, $plan_type, $location, $dob, $no_of_dependant, $reg_status, $alternate_no, $date_captured, $file_name);
    if ($stmt->execute()) {
      header("Location:displayAll.php");
    } else {
      echo  "Error: " . $stmt->error;
    }
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <title>Enrolment Form</title>
  <style>
    .form-container {
      background-color: #f8f9fa;
      border: 1px solid #dee2e6;
      border-radius: 10px;
      padding: 20px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .form-header {
      background-color: #007bff;
      color: white;
      padding: 10px;
      border-top-left-radius: 10px;
      border-top-right-radius: 10px;
      margin-bottom: 20px;
    }
    .form-label {
      font-weight: bold;
      color: #007bff;
    }
    .form-control {
      border-radius: 5px;
    }
    .submit-btn {
      background-color: #007bff;
      border-color: #007bff;
      color: white;
    }
  </style>
</head>
<body>
  <!-- insert header -->
  <?php include 'header.php'; ?>

  <div class="container mt-5">
    <div class="form-container">
      <div class="form-header text-center">
        <h3>Enrolment Form</h3>
      </div>
      <form action="#" method="post" enctype="multipart/form-data" id="enrolmentForm">
        <div class="container text-center">
          <div class="row">
            <div class="col-md-4 col-sm-6 mb-2">
              <label class="form-label">Organization</label>
              <input type="text" name="organization" class="form-control" placeholder="Organization">
            </div>
            <div class="col-md-4 col-sm-6 mb-2">
              <label class="form-label">Surname</label>
              <input type="text" name="sname" class="form-control" placeholder="Surname">
            </div>
            <div class="col-md-4 col-sm-6 mb-2">
              <label class="form-label">Other Names</label>
              <input type="text" name="oname" class="form-control" placeholder="Other Names">
            </div>
          </div>
          <div class="row">
            <div class="col-md-4 col-sm-6 mb-2">
              <label class="form-label">Policy No</label>
              <input type="text" name="policy_no" class="form-control" placeholder="Policy No">
            </div>
            <div class="col-md-4 col-sm-6 mb-2">
              <label class="form-label">Phone No</label>
              <input type="text" name="phone_no" class="form-control" placeholder="Phone No">
            </div>
            <div class="col-md-4 col-sm-6 mb-2">
              <label class="form-label">Location</label>
              <input type="text" name="location" class="form-control" placeholder="Location">
            </div>
          </div>
          <div class="row">
            <div class="col-md-4 col-sm-6 mb-2">
              <label class="form-label">Email Address</label>
              <input type="email" name="email" class="form-control" placeholder="Email Address">
            </div>
            <div class="col-md-4 col-sm-6 mb-2">
              <label class="form-label">Provider</label>
              <input type="text" name="provider" class="form-control" placeholder="Provider">
            </div>
            <div class="col-md-4 col-sm-6 mb-2">
              <label class="form-label">Alternate No</label>
              <input type="text" name="alternate_no" class="form-control" placeholder="Alternate No">
            </div>
          </div>
          <div class="row">
            <div class="col-md-4 col-sm-6 mb-2">
              <label class="form-label">Plan Type</label>
              <select name="plan_type" class="form-control">
                <option selected>--select plan--</option>
                <option value="Gold">Gold</option>
                <option value="Silver">Silver</option>
                <option value="Platinum">Platinum</option>
              </select>
            </div>
            <div class="col-md-4 col-sm-6 mb-2">
              <label class="form-label">Date of Birth</label>
              <input type="date" name="dob" class="form-control" required>
            </div>
            <div class="col-md-4 col-sm-6 mb-2">
              <label class="form-label">Number of Dependants</label>
              <input type="number" name="no_of_dependant" class="form-control" placeholder="Number of Dependants">
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-md-4 col-sm-6 mb-2">
              <label class="form-label">Registration Status</label>
              <select name="reg_status" class="form-control">
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
              </select>
            </div>
            <div class="col-md-4 col-sm-6 mb-2">
              <label class="form-label">Gender</label>
              <div class="form-check">
                <input type="radio" name="gender" value="Female" class="form-check-input">
                <label class="form-check-label">Female</label>
              </div>
              <div class="form-check">
                <input type="radio" name="gender" value="Male" class="form-check-input">
                <label class="form-check-label">Male</label>
              </div>
            </div>
            <div class="col-md-4 col-sm-6 mb-2">
              <label class="form-label">Passport Photograph</label>
              <input type="file" name="photo" class="form-control" required>
            </div>
          </div>
          <div class="row mb-2">
            <input type="submit" name="submit_details" value="Submit Details" class="btn btn-primary submit-btn">
          </div>
        </div>
      </form>
    </div>
  </div>
  <script src="assets/jquery-3.7.1.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</body>
</html>