<?php
require"connection.php";
if (isset($_GET["id"])) {
    $id_enrollee_details =htmlspecialchars($_GET["id"]);
      $sql = "delete from enrolment where id = '$id_enrollee_details' ";
      $result = mysqli_query($con, $sql);

      if ($result) {
        // echo 'Data deleted';
        header("Location:displayAll.php");
      }
      else{
        // echo 'Deleted ';
        header("Location:displayAll.php");
      }
  
  
  }
?>