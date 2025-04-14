<?php
require_once '../backend/connection.php'; // Include your database connection file
// SQL query to fetch data from the tables
$sql = "SELECT 
            e.name AS name_of_enrollee, 
            e.nhia_no, 
            e.pa_code, 
            e.diagnosis, 
            e.procedure, 
            e.phone_no,
        s.name_of_services,
            s.nhia_tariff AS service_nhia_tariff,
            s.hmo_claimed AS service_hmo_claimed,
            s.qty AS service_qty,
            s.total AS service_total,
        d.name_of_drug,
            d.nhia_tariff AS drug_nhia_tariff,
            d.hmo_claimed AS drug_hmo_claimed,
            d.qty AS drug_qty,
            d.total AS drug_total
        FROM 
            log_enrollees_in e
        LEFT JOIN 
            e_service_entry s ON e.pa_code = s.pa_code
        LEFT JOIN 
             e_drug_entry d ON e.pa_code = d.pa_code";

$result = $con->query($sql);

if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        echo "Enrollee Name: " . $row["name_of_enrollee"]. "<br>";
        echo "NHIA No: " . $row["nhia_no"]. "<br>";
        echo "PA Code: " . $row["pa_code"]. "<br>";
        echo "Diagnosis: " . $row["diagnosis"]. "<br>";
        echo "Procedure: " . $row["procedure"]. "<br>";
        echo "Phone No: " . $row["phone_no"]. "<br>";
        echo "Service Name: " . $row["name_of_service"]. "<br>";
        echo "Service NHIA Tariff: " . $row["service_nhia_tariff"]. "<br>";
        echo "Service HMO Claimed: " . $row["service_hmo_claimed"]. "<br>";
        echo "Service Qty: " . $row["service_qty"]. "<br>";
        echo "Service Total: " . $row["service_total"]. "<br>";
        echo "Drug Name: " . $row["name_of_drugs"]. "<br>";
        echo "Drug NHIA Tariff: " . $row["drug_nhia_tariff"]. "<br>";
        echo "Drug HMO Claimed: " . $row["drug_hmo_claimed"]. "<br>";
        echo "Drug Qty: " . $row["drug_qty"]. "<br>";
        echo "Drug Total: " . $row["drug_total"]. "<br><br>";
    }
} else {
    echo "0 results";
}

$conn->close();
?>