<?php
ob_start();
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require '../backend/connection.php';

// Initialize variables
$search_results = [];
$enrollee_data = [];
$service_data = [];
$drug_data = [];
$pa_code = null;
$error_message = null;
$success_message = null;
$current_step = 1;

// Search functionality
if (isset($_GET['search_pa_code'])) {
    $search_pa_code = trim($_GET['search_pa_code']);
    if (!empty($search_pa_code)) {
        $search_pa_code = mysqli_real_escape_string($con, $search_pa_code); // Sanitize input
        $search_query = "SELECT pa_code, name_of_enrollee FROM log_enrollees_in WHERE pa_code LIKE '%$search_pa_code%' OR name_of_enrollee LIKE '%$search_pa_code%' LIMIT 10";
        $search_result = mysqli_query($con, $search_query);

        if ($search_result) {
            $search_results = []; // Initialize here to ensure it's reset for each search
            while ($row = mysqli_fetch_assoc($search_result)) {
                $search_results[] = $row;
            }
            mysqli_free_result($search_result);
        }
    }
}

// Fetch data for the three tables based on pa_code
if (isset($_GET['pa_code'])) {
    $pa_code = trim($_GET['pa_code']);
    $pa_code = mysqli_real_escape_string($con, $pa_code); // Sanitize input

    // Fetch data from log_enrollees_in
    $enrollee_query = "SELECT * FROM log_enrollees_in WHERE pa_code = '$pa_code'";
    $enrollee_result = mysqli_query($con, $enrollee_query);
    if ($enrollee_result && mysqli_num_rows($enrollee_result) > 0) {
        $enrollee_data = mysqli_fetch_assoc($enrollee_result);
        mysqli_free_result($enrollee_result);
    } else if ($enrollee_result) {
        $error_message = "<div class='alert alert-warning text-center'>No enrollee data found for PA Code: " . htmlspecialchars($pa_code) . "</div>";
    }

    // Fetch data from e_service_entry
    $service_query = "SELECT * FROM e_service_entry WHERE pa_code = '$pa_code'";
    $service_result = mysqli_query($con, $service_query);
    if ($service_result) {
        while ($row = mysqli_fetch_assoc($service_result)) {
            $service_data[] = $row;
        }
        mysqli_free_result($service_result);
    }

    // Fetch data from e_drug_entry
    $drug_query = "SELECT * FROM e_drug_entry WHERE pa_code = '$pa_code'";
    $drug_result = mysqli_query($con, $drug_query);
    if ($drug_result) {
        while ($row = mysqli_fetch_assoc($drug_result)) {
            $drug_data[] = $row;
        }
        mysqli_free_result($drug_result);
    }
}

// Handle multi-step navigation
if (isset($_GET['step']) && is_numeric($_GET['step'])) {
    $current_step = intval($_GET['step']);
}

// Form processing logic
if (isset($_POST['update_enrollee'])) {
    // Process the enrollee update form
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $nhia = mysqli_real_escape_string($con, $_POST['nhia']);
    $phone = mysqli_real_escape_string($con, $_POST['phone_no']);
    $primaryHospital = mysqli_real_escape_string($con, $_POST['primaryHospital']);
    $secondaryHospital = mysqli_real_escape_string($con, $_POST['secondaryHospital']);
    $primary_hospital_code = mysqli_real_escape_string($con, $_POST['primary_hospital_code']);
    $secondary_hospital_code = mysqli_real_escape_string($con, $_POST['secondary_hospital_code']);
    $diagnosis = mysqli_real_escape_string($con, $_POST['diagnosis']);
    $procedure = mysqli_real_escape_string($con, $_POST['procedure_text']);
    $further_diagnosis = mysqli_real_escape_string($con, $_POST['further_diagnosis']);
    $no_of_days_admission = mysqli_real_escape_string($con, $_POST['no_of_days_admission']);

    $update_enrollee_query = "UPDATE log_enrollees_in SET
                                        name_of_enrollee='$name',
                                        nhia_no='$nhia',
                                        phone_no='$phone',
                                        primary_hospital='$primaryHospital',
                                        secondary_hospital='$secondaryHospital',
                                        primary_hospital_code='$primary_hospital_code',
                                        secondary_hospital_code='$secondary_hospital_code',
                                        diagnosis='$diagnosis',
                                        procedure_text='$procedure',
                                        further_diagnosis='$further_diagnosis',
                                        no_of_days_admission='$no_of_days_admission'
                                     WHERE pa_code='$pa_code'";

    if (mysqli_query($con, $update_enrollee_query)) {
        $success_message = "<div class='alert alert-success text-center'>Enrollee data updated successfully. Proceed to next step.</div>";
        $current_step = 2;
    } else {
        $error_message = "<div class='alert alert-danger text-center'>Error updating enrollee data: " . mysqli_error($con) . "</div>";
    }
} elseif (isset($_POST['e_service_submit'])) {
    // Process the service form submission
    $name_of_services = $_POST['name_of_services'];
    $nhia_tariff = $_POST['nhia_tariff'];
    $hcf_amount_claimed = $_POST['hcf_amount_claimed'];
    $amount_due = $_POST['amount_due'];
    $qty = $_POST['qty'];
    $remarks = $_POST['remarks'];
    // $total_hcf_claimed = $_POST['total_hcf_claimed']; // These totals are calculated client-side
    // $amount_due_total = $_POST['amount_due_total'];
    $service_update_error = false;

    // Loop through each service entry and update in the database
    foreach ($name_of_services as $index => $service) {
        if (empty(trim($service))) continue; // Skip empty rows

        $service = mysqli_real_escape_string($con, $service);
        $nhiaTariff = mysqli_real_escape_string($con, $nhia_tariff[$index]);
        $hcfAmountClaimed = mysqli_real_escape_string($con, $hcf_amount_claimed[$index]);
        $amountDue = mysqli_real_escape_string($con, $amount_due[$index]);
        $qtyValue = mysqli_real_escape_string($con, $qty[$index]);
        $remarksValue = mysqli_real_escape_string($con, $remarks[$index]);

        // Check if the service already exists for this PA code
        $check_query = "SELECT id FROM e_service_entry WHERE pa_code = '$pa_code' AND name_of_service = '$service'";
        $check_result = mysqli_query($con, $check_query);

        if ($check_result && mysqli_num_rows($check_result) > 0) {
            $row_data = mysqli_fetch_assoc($check_result);
            $update_query = "UPDATE e_service_entry SET
                                                nhia_tariff='$nhiaTariff',
                                                hcf_amount_claimed='$hcfAmountClaimed',
                                                amount_due='$amountDue',
                                                qty='$qtyValue',
                                                remarks='$remarksValue'
                                             WHERE id='" . $row_data['id'] . "'";
            if (!mysqli_query($con, $update_query)) {
                $error_message = "Service update failed for: " . htmlspecialchars($service) . " - " . mysqli_error($con);
                $service_update_error = true;
                break;
            }
        } else {
            $insert_query = "INSERT INTO e_service_entry (pa_code, name_of_service, nhia_tariff, hcf_amount_claimed, amount_due, qty, remarks)
                                         VALUES ('$pa_code', '$service', '$nhiaTariff', '$hcfAmountClaimed', '$amountDue', '$qtyValue', '$remarksValue')";
            if (!mysqli_query($con, $insert_query)) {
                $error_message = "Service entry failed for: " . htmlspecialchars($service) . " - " . mysqli_error($con);
                $service_update_error = true;
                break;
            }
        }
    }

    if (!$service_update_error) {
        $success_message = "<div class='alert alert-success text-center'>Service data submitted successfully. Proceed to next step.</div>";
        $current_step = 3;
    }
} elseif (isset($_POST['e_drug_submit'])) {
    // Process the drug form submission
    $name_of_drug = $_POST['name_of_drug'];
    $nhia_tariff_drug = $_POST['nhia_tariff_drug'];
    $hcf_amount_claimed_drug = $_POST['hcf_amount_claimed_drug'];
    $amount_due_drug = $_POST['amount_due_drug'];
    $qty_drug = $_POST['qty_drug'];
    $remarks_drug = $_POST['remarks_drug'];
    // $total_hcf_claimed_drug = $_POST['total_hcf_claimed']; // Calculated client-side
    // $amount_due_total_drug = $_POST['amount_due_total'];
    $drug_update_error = false;

    // Loop through each drug entry and insert/update in the database
    foreach ($name_of_drug as $index => $drug) {
        if (empty(trim($drug))) continue; // Skip empty rows

        $drug = mysqli_real_escape_string($con, $drug);
        $nhiaTariffDrug = mysqli_real_escape_string($con, $nhia_tariff_drug[$index]);
        $hcfAmountClaimedDrug = mysqli_real_escape_string($con, $hcf_amount_claimed_drug[$index]);
        $amountDueDrug = mysqli_real_escape_string($con, $amount_due_drug[$index]);
        $qtyValueDrug = mysqli_real_escape_string($con, $qty_drug[$index]);
        $remarksValueDrug = mysqli_real_escape_string($con, $remarks_drug[$index]);

        // Check if the drug already exists for this PA code
        $check_query = "SELECT id FROM e_drug_entry WHERE pa_code = '$pa_code' AND name_of_drug = '$drug'";
        $check_result = mysqli_query($con, $check_query);

        if ($check_result && mysqli_num_rows($check_result) > 0) {
            $row_data = mysqli_fetch_assoc($check_result);
            $update_drug_query = "UPDATE e_drug_entry SET
                                                nhia_tariff='$nhiaTariffDrug',
                                                hcf_amount_claimed='$hcfAmountClaimedDrug',
                                                amount_due='$amountDueDrug',
                                                qty='$qtyValueDrug',
                                                remarks='$remarksValueDrug'
                                             WHERE id='" . $row_data['id'] . "'";
            if (!mysqli_query($con, $update_drug_query)) {
                $error_message = "Drug update failed for: " . htmlspecialchars($drug) . " - " . mysqli_error($con);
                $drug_update_error = true;
                break;
            }
        } else {
            $insert_drug_query = "INSERT INTO e_drug_entry (pa_code, name_of_drug, nhia_tariff, hcf_amount_claimed, amount_due, qty, remarks)
                                         VALUES ('$pa_code', '$drug', '$nhiaTariffDrug', '$hcfAmountClaimedDrug', '$amountDueDrug', '$qtyValueDrug', '$remarksValueDrug')";
            if (!mysqli_query($con, $insert_drug_query)) {
                $error_message = "Drug entry failed for: " . htmlspecialchars($drug) . " - " . mysqli_error($con);
                $drug_update_error = true;
                break;
            }
        }
    }

    if (!$drug_update_error) {
        $success_message = "<div class='alert alert-success text-center'>Drug data submitted successfully.</div>";
        // Optionally, you can set $current_step to a final confirmation page
    }
} elseif (isset($_POST['final_submit'])) {
    // Handle final submission logic if needed
    $success_message = "<div class='alert alert-info text-center'>Final submission initiated (Pass all tests. logic to be implemented).</div>";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check Vetted Bills | Nonsuch Medicare</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Existing styles remain the same */
        .search-container {
            margin-bottom: 20px;
        }
        .search-results {
            list-style: none;
            padding: 0;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
            background-color: #f9f9f9;
        }
        .search-results li {
            padding: 8px 12px;
            border-bottom: 1px solid #eee;
        }
        .search-results li:last-child {
            border-bottom: none;
        }
        .search-results li a {
            text-decoration: none;
            color: #333;
            display: block;
        }
        .search-results li a:hover {
            background-color: #eee;
        }
        .readonly-field {
            background-color: #f8f9fa;
            cursor: not-allowed;
        }
        .step {
            display: none;
        }
        .step.active {
            display: block;
        }
        .navigation-buttons {
            margin-top: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
    <?php // include('../loginsystem/header.php'); ?>
    <h2 class="text-center">This is Underwritter's page to check vetted bills</h2>
    <div class="container py-4">
        <?php echo $error_message; ?>
        <?php echo $success_message; ?>
        <div class="mb-2">
        <a href="e_display.php">Back to vet more</a>
    </div>
        <div class="search-container">
            <form method="get" class="d-flex">
                <input class="form-control me-2" type="search" placeholder="Search PA Code or Enrollee Name" aria-label="Search" name="search_pa_code" id="search_pa_code">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
            <?php if (!empty($search_results)): ?>
                <ul class="search-results">
                    <?php foreach ($search_results as $result): ?>
                        <li><a href="?pa_code=<?php echo htmlspecialchars($result['pa_code']); ?>&step=1">
                            <?php echo htmlspecialchars($result['pa_code']); ?> - <?php echo htmlspecialchars($result['name_of_enrollee']); ?>
                        </a></li>
                    <?php endforeach; ?>
                </ul>
            <?php elseif (isset($_GET['search_pa_code']) && empty($search_results)): ?>
                <div class='alert alert-info mt-2'>No enrollees found matching your search.</div>
            <?php endif; ?>
        </div>

        <?php if ($pa_code): ?>
        <div class="row justify-content-center">
            <div class="form-container">
                <h2 class="text-center form-title">
                    <i class="fas fa-user-edit me-2"></i> Check Vetted Bills - PA Code: <?php echo htmlspecialchars($pa_code); ?>
                </h2>

                <div id="step-1" class="step <?php if ($current_step == 1) echo 'active'; ?>">
                    <form action="?pa_code=<?php echo htmlspecialchars($pa_code); ?>&step=2" method="post">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th>Name</th>
                                        <td>
                                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" value="<?php echo htmlspecialchars($enrollee_data['name_of_enrollee'] ?? ''); ?>" required>
                                        </td>
                                        <th>NHIA No</th>
                                        <td>
                                            <input type="text" class="form-control" id="nhia" name="nhia" placeholder="Enter NHIA No" value="<?php echo htmlspecialchars($enrollee_data['nhia_no'] ?? ''); ?>">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Phone</th>
                                        <td>
                                            <input type="tel" class="form-control" name="phone_no" id="phone" placeholder="Enter Phone" value="<?php echo htmlspecialchars($enrollee_data['phone_no'] ?? ''); ?>">
                                        </td>
                                        <th>Sex</th>
                                        <td>
                                            <input type="text" class="form-control readonly-field" value="<?php echo htmlspecialchars($enrollee_data['sex'] ?? ''); ?>" readonly>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>DOB</th>
                                        <td>
                                            <input type= "text" class="form-control readonly-field" value="<?php echo htmlspecialchars($enrollee_data['dob'] ?? ''); ?>" readonly>
                                        </td>
                                        <th>Days of Admission</th>
                                        <td>
                                            <input type="number" class="form-control" name="no_of_days_admission" id="no_of_days_admission" placeholder="Enter Days" value="<?php echo htmlspecialchars($enrollee_data['no_of_days_admission'] ?? ''); ?>">
                                        </td></tr>
                                    <tr>
                                        <th>Primary Hospital</th>
                                        <td>
                                            <input type="text" class="form-control" name="primaryHospital" id="primaryHospital" placeholder="Enter Primary Hospital" value="<?php echo htmlspecialchars($enrollee_data['primary_hospital'] ?? ''); ?>">
                                        </td>
                                        <th>Secondary Hospital</th>
                                        <td>
                                            <input type="text" class="form-control" name="secondaryHospital" id="secondaryHospital" placeholder="Enter Secondary Hospital" value="<?php echo htmlspecialchars($enrollee_data['secondary_hospital'] ?? ''); ?>">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Primary Code</th>
                                        <td>
                                            <input type="text" class="form-control" name="primary_hospital_code" id="primaryHospital-code" placeholder="Enter Primary Code" value="<?php echo htmlspecialchars($enrollee_data['primary_hospital_code'] ?? ''); ?>">
                                        </td>
                                        <th>Secondary Code</th>
                                        <td>
                                            <input type="text" class="form-control" name="secondary_hospital_code" id="secondaryHospital_code" placeholder="Enter Secondary Code" value="<?php echo htmlspecialchars($enrollee_data['secondary_hospital_code'] ?? ''); ?>">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th colspan="1">Diagnosis</th>
                                        <td colspan="3">
                                            <textarea class="form-control" name="diagnosis" id="diagnosis" rows="2" placeholder="Enter Diagnosis"><?php echo htmlspecialchars($enrollee_data['diagnosis'] ?? ''); ?></textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th colspan="1">Procedure</th>
                                        <td colspan="3">
                                            <textarea class="form-control" name="procedure_text" id="procedure" rows="2" placeholder="Enter Procedure"><?php echo htmlspecialchars($enrollee_data['procedure_text'] ?? ''); ?></textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th colspan="1">Further Diagnosis</th>
                                        <td colspan="3">
                                            <textarea class="form-control" name="further_diagnosis" id="furtherDiagnosis" rows="2" placeholder="Enter Further Diagnosis"><?php echo htmlspecialchars($enrollee_data['further_diagnosis'] ?? ''); ?></textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" class="text-center">
                                            <button type="submit" class="btn btn-primary" name="update_enrollee" id="update_enrollee">
                                                <i class="fas fa-save me-2"></i> Update & Proceed
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>

                <div id="step-2" class="step <?php if ($current_step == 2) echo 'active'; ?>">
                    <h2 class="text-center mb-4">Services Entry for PA Code: <?php echo htmlspecialchars($pa_code ?? 'N/A'); ?></h2>
                    <form id="serviceForm" method="post" action="?pa_code=<?php echo htmlspecialchars($pa_code); ?>&step=3">
                        <table class="table" id="serviceTable">
                            <thead>
                                <?php if (!empty($service_data)): ?>
                                    <tr>
                                        <th>Name of Service</th>
                                        <th>NHIA Tariff</th>
                                        <th>HCF Amount Claimed</th>
                                        <th>Amount Due</th>
                                        <th>Qty</th>
                                        <th>Total</th>
                                        <th>Remarks</th>
                                    </tr>
                                <?php endif; ?>
                            </thead>
                            <tbody>
                                <?php if (!empty($service_data)): ?>
                                    <?php foreach ($service_data as $serviceRow): ?>
                                        <?php
                                            $nhia_tariff_service = $serviceRow['nhia_tariff'] ?? 0;
                                            $qty_service = $serviceRow['qty'] ?? 0;
                                            $sub_total_service = $nhia_tariff_service * $qty_service;
                                            $total_service = $sub_total_service ;
                                            $amount_due_service = $sub_total_service; // Amount due before deduction
                                        ?>
                                        <tr>
                                            <td><input type="text" name="name_of_services[]" class="form-control service-name" value="<?php echo htmlspecialchars($serviceRow['name_of_service'] ?? ''); ?>" readonly></td>
                                            <td><input type="number" name="nhia_tariff[]" class="form-control nhia-tariff-service" value="<?php echo htmlspecialchars($nhia_tariff_service); ?>"></td>
                                            <td><input type="number" name="hcf_amount_claimed[]" class="form-control hcf-amount-claimed-service" value="<?php echo htmlspecialchars($serviceRow['hcf_amount_claimed'] ?? ''); ?>"></td>
                                            <td><span class="amount_due_display_service"><?php echo htmlspecialchars(number_format($amount_due_service, 2)); ?></span><input type="hidden" name="amount_due[]" class="amount_due_hidden_service" value="<?php echo htmlspecialchars($amount_due_service); ?>"></td>
                                            <td><input type="number" name="qty[]" class="form-control qty-service" value="<?php echo htmlspecialchars($qty_service); ?>"></td>
                                            <td class="total_row_service"><?php echo htmlspecialchars(number_format($total_service, 2)); ?></td>
                                            <td><input type="text" name="remarks[]" class="form-control remarks-service" value="<?php echo htmlspecialchars($serviceRow['remarks'] ?? ''); ?>"></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr><td colspan="7" class="text-center">No services found for this PA Code.</td></tr>
                                <?php endif; ?>
                            </tbody>
                            <tfoot>
                            <tr>
                                <td colspan="2" class="text-end"><strong>Total:</strong></td>
                                <td id="hcfAmountClaimedTotal_service">0.00</td>
                                <td id="amountDueTotal_service">0.00</td>
                                <td></td>
                                <td id="grandTotal_service">0.00</td>
                                <td></td>
                            </tr>

                            </tfoot>
                        </table>
                        <div class="mx-auto p-3 text-center">
                            <button type="submit" class="btn btn-success" name="e_service_submit">Submit Services & Proceed</button>
                        </div>
                        <div class="navigation-buttons">
                            <button type="button" class="btn btn-secondary" onclick="window.location.href='?pa_code=<?php echo htmlspecialchars($pa_code); ?>&step=1'">Previous</button>
                        </div>
                    </form>
                </div>

                <div id="step-3" class="step <?php if ($current_step == 3) echo 'active'; ?>">
                    <h2 class="text-center mb-4">Drug Entry for PA Code: <?php echo htmlspecialchars($pa_code ?? 'N/A'); ?></h2>
                    <form id="drugForm" method="post" action="">
                        <table class="table" id="drugTable">
                            <thead>
                                <?php if (!empty($drug_data)): ?>
                                    <tr>
                                        <th>Name of Drug</th>
                                        <th>NHIA Tariff</th>
                                        <th>HCF Amount Claimed</th>
                                        <th>Amount Due</th>
                                        <th>Qty</th>
                                        <th>10% Deductions</th>
                                        <th>Total</th>
                                        <th>Remarks</th>
                                    </tr>
                                <?php endif; ?>
                            </thead>
                            <tbody>
                                <?php if (!empty($drug_data)): ?>
                                    <?php foreach ($drug_data as $drugRow): ?>
                                        <?php
                                            $nhia_tariff_drug = $drugRow['nhia_tariff'] ?? 0;
                                            $qty_drug = $drugRow['qty'] ?? 0;
                                            $sub_total_drug = $nhia_tariff_drug * $qty_drug;
                                            $ten_percent_deduction_drug = $sub_total_drug * 0.10;
                                            $total_drug = $sub_total_drug - $ten_percent_deduction_drug;
                                            $amount_due_drug = $sub_total_drug; // Amount due before deduction
                                        ?>
                                        <tr>
                                            <td><input type="text" name="name_of_drug[]" class="form-control drug-name" value="<?php echo htmlspecialchars($drugRow['name_of_drug'] ?? ''); ?>" readonly></td>
                                            <td><input type="number" name="nhia_tariff_drug[]" class="form-control nhia-tariff-drug" value="<?php echo htmlspecialchars($nhia_tariff_drug); ?>"></td>
                                            <td><input type="number" name="hcf_amount_claimed_drug[]" class="form-control hcf-amount-claimed-drug" value="<?php echo htmlspecialchars($drugRow['hcf_amount_claimed'] ?? ''); ?>"></td>
                                            <td><span class="amount_due_display_drug"><?php echo htmlspecialchars(number_format($amount_due_drug, 2)); ?></span><input type="hidden" name="amount_due_drug[]" class="amount_due_hidden_drug" value="<?php echo htmlspecialchars($amount_due_drug); ?>"></td>
                                            <td><input type="number" name="qty_drug[]" class="form-control qty-drug" value="<?php echo htmlspecialchars($qty_drug); ?>"></td>
                                            <td><span class="e_10_display_drug"><?php echo htmlspecialchars(number_format($ten_percent_deduction_drug, 2)); ?></span></td>
                                            <td class="total_row_drug"><?php echo htmlspecialchars(number_format($total_drug, 2)); ?></td>
                                            <td><input type="text" name="remarks_drug[]" class="form-control remarks-drug" value="<?php echo htmlspecialchars($drugRow['remarks'] ?? ''); ?>"></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr><td colspan="8" class="text-center">No drugs found for this PA Code.</td></tr>
                                <?php endif; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="2" class="text-end"><strong>Total:</strong></td>
                                    <td id="hcfAmountClaimedTotal_drug">0.00</td>
                                    <td id="amountDueTotal_drug">0.00</td>
                                    <td></td>
                                    <td></td>
                                    <td id="grandTotal_drug">0.00</td>
                                    <td></td>
                                </tr>

                            </tfoot>
                        </table>
                        <div class="mx-auto p-3 text-center">
                            <button type="submit" class="btn btn-success" name="e_drug_submit">Submit Drugs</button>
                        </div>
                        <div class="navigation-buttons">
                            <button type="button" class="btn btn-secondary" onclick="window.location.href='?pa_code=<?php echo htmlspecialchars($pa_code); ?>&step=2'">Previous</button>
                            <button type="submit" class="btn btn-info" name="final_submit">Final Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            function calculateTotals(tableId) {
                let hcfClaimedTotal = 0;
                let amountDueTotal = 0;
                let grandTotal = 0;

                $(`#${tableId} tbody tr`).each(function() {
                    let qty = parseFloat($(this).find('input[name$="[]"]').filter(function() {
                        return this.name.includes('qty');
                    }).val()) || 0;
                    let nhiaTariff = parseFloat($(this).find('input[name$="[]"]').filter(function() {
                        return this.name.includes('nhia_tariff');
                    }).val()) || 0;
                    let hcfClaimed = parseFloat($(this).find('input[name$="[]"]').filter(function() {
                        return this.name.includes('hcf_amount_claimed');
                    }).val()) || 0;
                    let amountDue = qty * nhiaTariff;
                    let deduction = 0;
                    if (tableId === 'drugTable') {
                        deduction = amountDue * 0.10;
                        $(this).find('.e_10_display_drug').text(deduction.toFixed(2));
                    }
                    let rowTotal = amountDue - deduction;

                    $(this).find('.amount_due_display_' + tableId.replace('Table', '').toLowerCase()).text(amountDue.toFixed(2));
                    $(this).find('.amount_due_hidden_' + tableId.replace('Table', '').toLowerCase()).val(amountDue.toFixed(2));
                    $(this).find('.total_row_' + tableId.replace('Table', '').toLowerCase()).text(rowTotal.toFixed(2));

                    hcfClaimedTotal += hcfClaimed;
                    amountDueTotal += amountDue;
                    grandTotal += rowTotal;
                });

                $(`#hcfAmountClaimedTotal_${tableId.replace('Table', '').toLowerCase()}`).text(hcfClaimedTotal.toFixed(2));
                $(`#amountDueTotal_${tableId.replace('Table', '').toLowerCase()}`).text(amountDueTotal.toFixed(2));
                $(`#grandTotal_${tableId.replace('Table', '').toLowerCase()}`).text(grandTotal.toFixed(2));
            }

            // Initial calculation for both tables
            calculateTotals('serviceTable');
            calculateTotals('drugTable');

            // Recalculate totals on input change for service table
            $('#serviceTable tbody').on('input', 'input[name^="nhia_tariff"], input[name^="qty"], input[name^="hcf_amount_claimed"]', function() {
                calculateTotals('serviceTable');
            });

            // Recalculate totals on input change for drug table
            $('#drugTable tbody').on('input', 'input[name^="nhia_tariff_drug"], input[name^="qty_drug"], input[name^="hcf_amount_claimed_drug"]', function() {
                calculateTotals('drugTable');
            });
        });
    </script>
</body>
</html>