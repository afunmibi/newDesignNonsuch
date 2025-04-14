<?php
// download_excel.php
require "../backend/connection.php"; // Include your database connection
 //check and output errors
 ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename=enrollees_details.xls');

$output = '
<table class="table" bordered="1">  
    <tr>  
        <th>Name of Enrollee</th>  
        <th>NHIA No</th>  
        <th>Phone No</th>  
        <th>Primary Hospital</th>  
        <th>Secondary Hospital</th>  
        <th>Primary Hospital Code</th>  
        <th>Secondary Hospital Code</th>  
        <th>Diagnosis</th>  
        <th>Procedure Text</th>  
        <th>Further Diagnosis</th>  
        <th>PA Code</th>  
        <th>Created On</th>  
    </tr>
';

$sql = "SELECT * FROM `log_enrollees_in`";
$result = mysqli_query($con, $sql);

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $output .= '
        <tr>
            <td>' . $row["name_of_enrollee"] . '</td>
            <td>' . $row["nhia_no"] . '</td>
            <td>' . $row["phone_no"] . '</td>
            <td>' . $row["primary_hospital"] . '</td>
            <td>' . $row["secondary_hospital"] . '</td>
            <td>' . $row["primary_hospital_code"] . '</td>
            <td>' . $row["secondary_hospital_code"] . '</td>
            <td>' . $row["diagnosis"] . '</td>
            <td>' . $row["procedure_text"] . '</td>
            <td>' . $row["further_diagnosis"] . '</td>
            <td>' . $row["pa_code"] . '</td>
            <td>2023-10-26 10:00:00</td>
        </tr>
        ';
    }
} else {
    $output .= '<tr><td colspan="12">No data found.</td></tr>'; // Handle no data
}

$output .= '</table>';
echo $output;
exit;
?>