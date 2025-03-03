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
  $date_captured =  date("Y-m-d:h:i:s");

$file_name = $_FILES['photo']['name'];
$file_tmp = $_FILES['photo']['tmp_name'];
$file_size = $_FILES['photo']['size'];
$file_store= "uploads/".basename($file_name);

if (!move_uploaded_file($file_tmp, $file_store)) {
  echo 'Error uploading image';
}else{

$stmt = $con->prepare("insert into `enrolment`(organization, sname, oname, policy_no, phone_no, email,provider, gender, plan_type, location,dob,no_of_dependant, reg_status, alternate_no,date_captured, photo
) values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)") ;
$stmt->bind_param('ssssssssssssssss',$organization, $sname, $oname, $policy_no, $phone_no,$email,$provider,$gender, $plan_type, $location,$dob,$no_of_dependant, $reg_status, $alternate_no,$date_captured, $file_name);
if($stmt->execute()){
  // echo "Data Saved";
   header("Location:displayAll.php");
}else{
  // echo 'Data not saved';
  header("Location:enrolment.php");
};

}

}
;

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
		<form action="#" method="post" enctype="multipart/form-data">
			<div class="container text-center">
  <div class="row">
    <div class="col-md-4 col-sm-6 mb-2">
    	<label>Organization</label>
      <input type="organization" name="organization" class="form-control" name="organization" id="" placeholder="organization">
    </div>
    <div class="col-md-4 col-sm-6 mb-2 ">
    	<label>Surname</label>
      <input type="organization" name="sname" class="form-control" id="sname" placeholder="Surname">
    </div>
    <div class="col-md-4 col-sm-6 mb-2">
    	<label>Other Names</label>
       <input type="organization" name="oname" class="form-control"  id="oname" placeholder="Other Names">
    </div>
      </div>
       <div class="row">
    <div class="col-md-4 col-sm-6 mb-2">
    	<label>Policy No</label>
      <input type="organization" name="policy_no" class="form-control"  id="policy_no" placeholder="Policy No">
    </div>
    <div class="col-md-4 col-sm-6 mb-2">
    	<label>Phone No</label>
      <input type="organization" name="phone_no" class="form-control"  id="phone_no" placeholder="Phone No">
    </div>
    <div class="col-md-4 col-sm-6 mb-2">
    	<label>Location</label>
       <input type="organization" name="location" class="form-control"  id="location" placeholder="Location">
    </div>
      </div>
       <div class="row">
    <div class="col-md-4 col-sm-6 mb-2">
    	<label>Email Address</label>
      <input type="organization" name="email" class="form-control"  id="email" placeholder="Email Address">
    </div>
    <div class="col-md-4 col-sm-6 mb-2">
    	<label>Provider</label>
      <input type="organization" name="provider" class="form-control"  id="provider" placeholder="Provider">
    </div>

    
    <div class="col-md-4 col-sm-6 mb-2">
      <label>Alternate No</label>
     <input type="text" name=" alternate_no" placeholder="Alternate No">
    </div>
      </div>
      <div class="row">
    <div class="col-md-4 col-sm-6 mb-2">
      <label>Plan Type</label>
      <select name="plan_type">
          <option selected>--select plan--</option>
          <option value="Gold">Gold</option>
          <option value="Silver">Silver</option>
          <option value="Platinum">Platinum</option>
        </select>
    </div>
    <div class="col-md-4 col-sm-6 mb-2">
      <label>Date of Birth</label>
      <input type="date" name=" dob" required>
    </div>
    
    <div class="col-md-4 col-sm-6 mb-2">
      <label>Number of Dependant</label>
       <input type="number" name=" no_of_dependant" placeholder="Number of Dependant">
      
    </div>
      </div>

      <div class="row mb-2">
    <div class="col-md-4 col-sm-6 mb-2">
      <label>Registration Status</label>
      <select name="reg_status">
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
       <input type="file" name=" photo" required>
      
    </div>
      </div>
       <div class="row mb-2">
         <input type="submit" name="submit_details" value="Submit Details" class=" btn btn-primary submit_details_btn" >
       </div>
</div>
		</form>
	</div>
<script src="assets/jquery-3.7.1.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" ></script>
    <script >
      $(document).ready(function(){
        $('form').submit(function(e){
          e.preventDefault();
          var formData =$(this).serialize(); 
        
        $.ajax({
          url: "enrolment.php",
          method: "POST",
          data: formData,
          success: function(response){
            if(response){
            $('#display').text(response); 
            }else{
              $('#display').test('No response from the server');
            }
            
          }
        })
      })})
    </script>
</body>
</html>