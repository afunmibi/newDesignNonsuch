<?php require'connection.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Responsive Table</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
    .table-responsive {
      overflow-x: auto;
    }
    .table th, .table td {
      white-space: nowrap; /* Prevent wrapping */
    }
  </style>
</head>
<body>
<?php include('../../loginsystem/header.php'); ?>
  <div class="container mt-4">
    <div class="table-responsive">
      <table class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>ID</th>
            <th>Name of Enrollee</th>
            <th>NHIA No</th>
            <th>Phone No</th>
            <th>Primary Hospital</th>
            <th>Secondary Hospital</th>
            <th>Primary Hospital Code</th>
            <th>Secondary Hospital Code</th>
            <th>Diagnosis</th>
            <th>Procedure Text</th>
            <th>DOB</th>
            <th>Further Diagnosis</th>
            <th>PA Code</th>
            <th>Staff ID</th>
            <th>Created On</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT * FROM log_enrollees_in";
            $result = mysqli_query($con, $sql);
            while ($row = mysqli_fetch_assoc($result)) {
?>
<tr>
            <td><?php echo $row['id'] ?></td>
            <td><?php echo $row['name_of_enrollee'] ?></td>
            <td><?php echo $row['nhia_no'] ?></td>
            <td><?php echo $row['phone_no'] ?></td>
            <td><?php echo $row['primary_hospital'] ?></td>
            <td><?php echo $row['secondary_hospital'] ?></td>
            <td><?php echo $row['primary_hospital_code'] ?></td>
            <td><?php echo $row['secondary_hospital_code'] ?></td>
            <td><?php echo $row['diagnosis'] ?></td>
            <td><?php echo $row['procedure_text'] ?></td>
            <td><?php echo $row['dob'] ?></td>
            <td><?php echo $row['further_diagnosis'] ?></td>
            <td><?php echo $row['pa_code'] ?></td>
            <td><?php echo $row['staff_id'] ?></td>
            <td><?php echo $row['created_on'] ?></td>
            <td>
              <input type="submit" name="vet_bill" value="Vet Bill" class="btn btn-primary btn-sm">
            </td>
          </tr>
<?php


            }
            
            ?>
         
          
        </tbody>
      </table>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>