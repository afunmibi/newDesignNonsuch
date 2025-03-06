<?php require"connection.php";



// }else{
//   echo "Record not found";
// }
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <title></title>
  <style>
    .table-responsive {
      overflow-x: auto;
    }
  </style>
</head>
<body>
  <!-- insert header -->
  <?php include'header.php'; ?>
<body>
  <div class="container">
    <h1 class="text-center">Enrollee Details</h1>
    
  <a href="generate_pdf.php" class="btn btn-primary mx-3 mb-4">Generate PDF</a>
<a href="enrolment.php" class="btn btn-primary mx-3 mb-4">Add New Enrollee</a>
  <div class="container-fluid table-responsive">
<table class="table table-bordered">
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
      <a href="card.php?id=<?php echo $row['id'];?>"><button class="btn btn-success btn-sm" name="view_enrollee_details">View</button></a>
      <a href="update.php?id=<?php echo $row['id'];?>"><button class="btn btn-info btn-sm" name="update_enrollee_details">Edit</button></a>
      <a href="delete.php?id=<?php echo $row['id'];?>"><button name="delete_enrollee_details" class="btn btn-danger btn-sm">Delete</button></a>
    </td>
    </tr>
  <?php
}
    ?>
    </tr>   
  </tbody>
  </div>
</table>  

</div>
</div>
</body>
</html>