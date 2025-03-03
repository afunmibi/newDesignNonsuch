	<?php 
	require('connection.php');
	if (isset($_POST['staff_details_submit'])) {
		$username= htmlspecialchars($_POST['username']);
		$username= strtolower($username);
		$password= htmlspecialchars($_POST['password']);
		$usertype= htmlspecialchars($_POST['role']);
		$staff_id= htmlspecialchars($_POST['staff_id']);
		$usertype = strtolower($usertype);
		$password =password_hash($password, PASSWORD_DEFAULT);

		$file_name = $_FILES['staff_photo']['name'];
		$file_tmp = $_FILES['staff_photo']['tmp_name'];
		$store = "uploads/".basename($file_name);


if (!move_uploaded_file($file_tmp, $store)) {
	echo "Photo not uploaded";
}else{

$sql = "insert into login (username, password, usertype, staff_id, photo) values ('$username','$password','$usertype', '$staff_id', '$file_name' )";
		$result = mysqli_query($con, $sql);
 
 if ($result) {
 	echo 'Data inserted';
 }else{
 	echo "Data not inserted";
 }

}
		;
	}
	?>
	<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Insert Staff Details</title>
	<style type="text/css">
		.wrapper_staff{
			margin: auto;
			width: 600px;
			padding: 20px;
			background-color: #f4f4f4;
			margin-top: 50px;
			border-radius: 5px;
			display: flex;
			flex-wrap: wrap;
			justify-content: center;
			box-shadow: 10px 10px 15px rgba(0, 0, 0, 0.6);
		}
		input, label{
			margin: 5px;
			padding: 3.5px;

		}
		.staff_details_submit{
			background-color: skyblue;
			padding: 10px;
			margin:10px ;
			border-radius: 5px;
			cursor:pointer ;
			margin: auto;	
			text-align: center;	
			outline: none;	
		}
		.staff_details_submit:hover
		{
			background-color: blue;
			color: white;			
		}
	</style>
</head>
<body>
	<div class="wrapper_staff">
		<form action="#" method="post" enctype="multipart/form-data">
			<h3>Staff Portal Registration</h3> <a href="index.php">Back to Login</a>
			<table>
				<tr>
			<td><label>Username</label>
			<input type="text" name="username" placeholder="Username"></td>
			<td><label>Password</label>
			<input type="password" name="password" placeholder="Password"></td>
				</tr>
				<tr>
			<td>
				<label>Role</label>
			<select name="role">
				<option value="admin">Admin</option>
				<option value="user">User</option>
				<option value="md">MD</option>
				<option value="gm">GM</option>

			</select>
			</td><td>
			<label>Staff Id</label>
			<input type="text" name="staff_id" placeholder="Staff Id"></td>

			</tr>
			<tr>
				<td>
					<label>Staff Photo</label>
			<input type="file" name="staff_photo" ></td>
			</tr>
			</table>
			<input type="submit" name="staff_details_submit" value="submit" class="staff_details_submit">
		</form>
	</div>

</body>
</html>