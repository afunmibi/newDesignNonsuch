<?php
require 'vendor/autoload.php';
require 'connection.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Set the header row
$sheet->setCellValue('A1', 'Id');
$sheet->setCellValue('B1', 'SurName');
$sheet->setCellValue('C1', 'Other Names');
$sheet->setCellValue('D1', 'Policy No.');
$sheet->setCellValue('E1', 'Phone');
$sheet->setCellValue('F1', 'Photo');
$sheet->setCellValue('G1', 'Status');

// Fetch data from the database
$sql = "SELECT * FROM `enrolment`";
$result = mysqli_query($con, $sql);
$rowNumber = 2; // Start from the second row

while ($row = mysqli_fetch_assoc($result)) {
    $sheet->setCellValue('A' . $rowNumber, $row['id']);
    $sheet->setCellValue('B' . $rowNumber, $row['sname']);
    $sheet->setCellValue('C' . $rowNumber, $row['oname']);
    $sheet->setCellValue('D' . $rowNumber, $row['policy_no']);
    $sheet->setCellValue('E' . $rowNumber, $row['phone_no']);
    $sheet->setCellValue('F' . $rowNumber, $row['photo']);
    $sheet->setCellValue('G' . $rowNumber, $row['reg_status']);
    $rowNumber++;
}

// Set the headers to force download
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="enrollee_details.xlsx"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
?>
<?php require "connection.php"; ?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Enrollee Details</title>
  <link rel="stylesheet" type="text/css" href="bootstrap-5.3.3\dist\css\bootstrap.min.css">
  <style>
    .table-responsive {
      overflow-x: auto;
    }
  </style>
</head>
<body>
  <!-- insert header -->
  <?php include('header.php'); ?>

  <div class="container">
    <h1 class="text-center">Enrollee Details</h1>
  
    <a href="generate_pdf.php" class="btn btn-primary mx-3 mb-4">Generate PDF</a>
    <a href="enrolment.php" class="btn btn-primary mx-3 mb-4">Add New Enrollee</a>
    <a href="generate_excel.php" class="btn btn-primary mx-3 mb-4">Download Excel</a>
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
          <?php 
          $sql = "SELECT * FROM `enrolment`";
          $result = mysqli_query($con, $sql);
          while ($row = mysqli_fetch_assoc($result)) {
            ?>
            <tr>
              <td><?php echo $row['id']; ?></td>
              <td><?php echo $row['sname']; ?></td>
              <td><?php echo $row['oname']; ?></td>
              <td><?php echo $row['policy_no']; ?></td>
              <td><?php echo $row['phone_no']; ?></td>
              <td><img width="30px" src="uploads/<?php echo $row['photo']; ?>"></td>
              <td><?php echo $row['reg_status']; ?></td>
              <td>
                <a href="card.php?id=<?php echo $row['id']; ?>"><button class="btn btn-success btn-sm" name="view_enrollee_details">View</button></a>
                <a href="update.php?id=<?php echo $row['id']; ?>"><button class="btn btn-info btn-sm" name="update_enrollee_details">Edit</button></a>
                <a href="delete.php?id=<?php echo $row['id']; ?>"><button name="delete_enrollee_details" class="btn btn-danger btn-sm">Delete</button></a>
              </td>
            </tr>
            <?php
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</body>
</html>