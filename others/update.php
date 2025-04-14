<?php 
require('connection.php');
if (isset($_POST['update_enrollee_details'])) {
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
  $id = htmlspecialchars($_GET['id']);
  $file_name = $_FILES['photo']['name'];
  $file_tmp = $_FILES['photo']['tmp_name'];
  $file_size = $_FILES['photo']['size'];
  $file_store = "uploads/" . basename($file_name);

  // Check if the file already exists and unlink it
  if (file_exists($file_store)) {
    unlink($file_store);
  }

  if (!move_uploaded_file($file_tmp, $file_store)) {
    echo 'Error uploading image';
  } else {

    $stmt = $con->prepare("UPDATE enrolment SET organization=?, sname=?, oname=?, policy_no=?, phone_no=?, email=?, _provider=?, gender=?, plan_type=?, _location=?, dob=?, no_of_dependant=?, reg_status=?, alternate_no=?, date_captured=?, photo=? WHERE id=?");
    $stmt->bind_param('ssssssssssssssssi', $organization,$sname, $oname, $policy_no, $phone_no, $email, $provider, $gender, $plan_type, $location, $dob, $no_of_dependant, $reg_status, $alternate_no, $date_captured, $file_name, $id);
    if ($stmt->execute()) {
      header("Location:displayAll.php");
    } else {
      header("Location:enrolment.php");
    }
  }
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
</head>
<body>
	<!-- insert header -->
	<?php include('header.php'); ?>
	<div class="container border-1">
    <div id="display"></div>
    <?php 
     $id= htmlspecialchars( $_GET['id']);

     $sql = "select * from enrolment";
    //  $stmt = $con->prepare($sql);
    //  $stmt->bind_param("i",$id);
    //  $stmt->execute();
    //  $stmt->store_result();
    //  $stmt->close();
    $result = mysqli_query($con, $sql); 
    $row = mysqli_fetch_assoc($result);

    ?>
		<form action="#" method="post" enctype="multipart/form-data">
			<div class="container text-center">
  <div class="row">
    <div class="col-md-4 col-sm-6 mb-2">
    	<label>Organization</label>
      <input type="text" name="organization" class="form-control" name="organization" id="" placeholder="organization" value="<?php echo $row['organization'] ?>">
    </div>
    <div class="col-md-4 col-sm-6 mb-2 ">
    	<label>Surname</label>
      <input type="text" name="sname" class="form-control" id="sname" placeholder="Surname"value="<?php echo $row['sname'] ?>" >
    </div>
    <div class="col-md-4 col-sm-6 mb-2">
    	<label>Other Names</label>
       <input type="text" name="oname" class="form-control"  id="oname" placeholder="Other Names" value="<?php echo $row['oname'] ?>">
    </div>
      </div>
       <div class="row">
    <div class="col-md-4 col-sm-6 mb-2">
    	<label>Policy No</label>
      <input type="text" name="policy_no" class="form-control"  id="policy_no" placeholder="Policy No" value="<?php echo $row['policy_no'] ?>">
    </div>
    <div class="col-md-4 col-sm-6 mb-2">
    	<label>Phone No</label>
      <input type="text" name="phone_no" class="form-control"  id="phone_no" placeholder="Phone No" value="<?php echo $row['phone_no'] ?>">
    </div>
    <div class="col-md-4 col-sm-6 mb-2">
    	<label>Location</label>
       <input type="text" name="location" class="form-control"  id="location" placeholder="Location" value="<?php echo $row['_location'] ?>">
    </div>
      </div>
       <div class="row">
    <div class="col-md-4 col-sm-6 mb-2">
    	<label>Email Address</label>
      <input type="text" name="email" class="form-control"  id="email" placeholder="Email Address" value="<?php echo $row['email'] ?>">
    </div>
    <div class="col-md-4 col-sm-6 mb-2">
    	<label>Provider</label>
      <input type="text" name="provider" class="form-control"  id="provider" placeholder="Provider" value="<?php echo $row['_provider'] ?>">
    </div>

    
    <div class="col-md-4 col-sm-6 mb-2">
      <label>Alternate No</label>
     <input type="text" name=" alternate_no" placeholder="Alternate No" value="<?php echo $row['alternate_no'] ?>">
    </div>
      </div>
      <div class="row">
    <div class="col-md-4 col-sm-6 mb-2">
      <label>Plan Type</label>
      <select name="plan_type" value="<?php echo $row['plan_type'] ?>">
          <option selected>--select plan--</option>
          <option value="Gold">Gold</option>
          <option value="Silver">Silver</option>
          <option value="Platinum">Platinum</option>
        </select>
    </div>
    <div class="col-md-4 col-sm-6 mb-2">
      <label>Date of Birth</label>
      <input type="date" name=" dob" required value="<?php echo $row['dob'] ?>">
    </div>
    
    <div class="col-md-4 col-sm-6 mb-2">
      <label>Number of Dependant</label>
       <input type="number" name=" no_of_dependant" placeholder="Number of Dependant" value="<?php echo $row['no_of_dependant'] ?>">
      
    </div>
      </div>

      <div class="row mb-2">
    <div class="col-md-4 col-sm-6 mb-2">
      <label>Registration Status</label>
      <select name="reg_status" value="<?php echo $row['reg_status'] ?>">
      <option value="active" selected>--Select Reg Status--</option>    
      <option value="active">Active</option>
          <option value="inactive">InActive</option>
        </select>
    </div>
    
    <div class="col-md-4 col-sm-6 mb-2">
      <label>Gender</label>
       <input type="radio" name="gender" value="Female">Female
        <input type="radio" name="gender" value="Male">Male
    </div>
    <div class="col-md-4 col-sm-6 mb-2">
      <label>Passport Photograph</label>
       <input type="file" name=" photo" required value="<?php echo $row['photo'] ?>">
      
    </div>
      </div>
       <div class="row mb-2">
         <input type="submit" name="update_enrollee_details" value="Update Details" class=" btn btn-primary submit_details_btn" >
       </div>
</div>
		</form>
	</div>
<script src="assets/jquery-3.7.1.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" ></script>
   
</body>
</html>