<?php require("connection.php");
if(isset($_GET["id"])){
 $enrollee_id = $_GET["id"];

 $sql = "Select * from `enrolment`";
 $result = mysqli_query($con, $sql);
 $row = mysqli_fetch_assoc($result);

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



<div class="card text-center container mx-auto my-5">
  <div class="card-header">
   <h3> Enrollee's Identity Card</h3>
  </div>
  <div class="card-body" >
    <h5 class="card-title">Enrollee's Details</h5>
<div class="inner_card_wrapper" style="display:flex; justify-content: center;">
  <div class="card-wrapper" style="width:20%; margin: 10px; padding: 10px; ">
<img src="uploads/<?php echo $row['photo'];?>" width="100px" class="object-fit-cover">
  </div>
  <div class= "card-wrapper" style="width:50%; margin: 10px; padding: 10px; ">
<table>
  <tr>
    <td class="mx-3 px-5" >Surname: </td>
    <td class="mx-3 px-5"><?php echo $row['sname'];?> </td>
     </tr><tr>
      <td class="mx-3 px-5" >Other Names: </td>
    <td class="mx-3 px-5"><?php echo $row['oname'];?> </td>
     </tr><tr>
      <td class="mx-3 px-5" >Provider: </td>
    <td class="mx-3 px-5"><?php echo $row['provider'];?> </td>
     </tr>
     <tr>
      <td class="mx-3 px-5" >Policy No: </td>
    <td class="mx-3 px-5"><?php echo $row['policy_no'];?> </td>
     </tr>
     <tr>
      <td class="mx-3 px-5" >Date of birth: </td>
    <td class="mx-3 px-5"><?php echo $row['dob'];?> </td>
     </tr>
     <tr>
      <h3><?php echo $row['plan_type'];?></h3>
     </tr>
</table>
  </div>
  
  </div>
</div>


</body>
</html>