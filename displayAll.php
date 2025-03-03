<?php require("connection.php")?>

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
<body>
  <div class="container-fluid">
    
  
<table class="table table-border-collapse table-responsive">
  <thead>
    <tr>
      <th>Id</th>
      <th>SurName</th>
      <th>Other Names</th>
      <th>Policy No.</th>
      <th>Phone</th>
      <th>Photo</th>
      <th>Status</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <?php 
$sql = "select * from `enrolment` ";
$result = mysqli_query($con, $sql);
while ($row=mysqli_fetch_assoc($result)) {
  ?>
<tr>
      <td><?php echo $row['id'];?></td>
      <td><?php echo $row['sname'];?></td>
      <td><?php echo $row['oname'];?></td>
      <td><?php echo $row['policy_no'];?></td>
      <td><?php echo $row['phone_no'];?></td>
      <td><img width="30px" src="uploads/<?php echo $row['photo'];?>"></td>
      <td><?php echo $row['reg_status'];?></td>
       <td>
      <a href="desiform.php?id=<?php echo $row['id'];?>"><button class="btn btn-success btn-sm" name="view_enrollee_details">View</button></a>
      <a href="edit.php?id=<?php echo $row['id'];?>"><button class="btn btn-info btn-sm">Edit</button></a>
      <a href="displayAll.php?id=<?php echo $row['id'];?>"><button class="btn btn-danger btn-sm">Delete</button></a>
    </td>
    </tr>
  <?php


}

    ?>
    </tr>
    
   
  </tbody>
  </div>
</table>  
</body>
</html>