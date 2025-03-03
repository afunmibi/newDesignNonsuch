
<?php 
session_start();
require('connection.php');

if($_SERVER['REQUEST_METHOD']=='POST'){
    $username = $_POST['username'];
    $username = strtolower($username);
    $password = $_POST['password'];
    // $password =  password_hash($password, PASSWORD_DEFAULT);
    
    
    $stmt = $con->prepare("SELECT * FROM login WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    
    // print_r($row);
    if ($row && password_verify($password, $row['password'])) {
    if ($row['usertype']=='user') {
      // echo 'This is user on the page';
        $_SESSION['username']=$row;
        header("location: user.php");
    }

    elseif ($row['usertype']=='admin') {
        $_SESSION['admin']=$username;
       // echo 'This is Admin on the page'; 
        header("location: admin.php");
    }
    else{
        echo 'username or password is incorrect';
    }
}}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
	<link rel="stylesheet" type="text/css" href="bootstrap-5.3.3\dist\css\bootstrap.min.css">
</head>
<body>
	<!-- insert header -->
	<?php include('header.php'); ?>

<div class="card text-center container mx-auto my-5">
  <div class="card-header">
   <h2>Nonsuch Medicare Limited</h2>
  </div>
  <div class="card-body">
    <h5 class="card-title">Nonsuch Portal System</h5>
   <form action="#" method="post">
<div>
    <label>Username </label>
    <input type="text" name="username" required>
</div>
<br><br>
<div>
    <label>Password </label>
    <input type="password" name="password" required>
</div> 
<br><br>
    <div>
    
    <input type="submit" value="Login" class="btn btn-primary">
</div></form>
    
  </div>
  <div class="card-footer text-body-secondary">
   This is a Demo, kindly observe bugs and let us know. Thank you. 
  </div>
</div>

</body>
</html>
