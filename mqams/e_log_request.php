<?php
session_start();
require_once '../backend/connection.php';
$hmo_code = "051/";
$prog_code= "NHIA";
$staff_id = $_SESSION['info']['staff_id'];
$monthNumberWithZero = date('m');
$yearShort = date('y');
$generateRandom = mt_rand(1,999999);

$pa_code = $hmo_code.'/'.$prog_code.'/'.$generateRandom. '/' . $monthNumberWithZero . '/' . $yearShort . '/' . $staff_id;
$pa_code = htmlspecialchars($pa_code);


// Initialize variables for form fields
$formData = [
    'step' => 1,
    'name' => '', 'nhia_no' => '', 'sex' => '', 'phone_no' => '','pa_code' => $pa_code,
    'primaryHospital' => '', 'secondaryHospital' => '', 'e_position' => '', // <-- Changed 'status' to 'e_position'
    'primary_hospital_code' => '', 'secondary_hospital_code' => '',
    'diagnosis' => '', 'procedure' => '', 'dob' => '', 'further_diagnosis' => '',
    'staff_id' => $staff_id,
    'amount_due' => [],
    'hcf_amount_claimed' => []
];


$success_message = '';
$error_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $formData = array_merge($formData, $_POST);
    $formData['step'] = isset($_POST['next']) ? (int)$_POST['step'] + 1 : (isset($_POST['previous']) ? (int)$_POST['step'] - 1 : (int)$_POST['step']);

    // Calculate totals if the relevant arrays are present in the POST data
    $total_amount_due = 0;
    if (isset($_POST['amount_due']) && is_array($_POST['amount_due'])) {
        foreach ($_POST['amount_due'] as $amount) {
            if (is_numeric($amount)) {
                $total_amount_due += floatval($amount);
            }
        }
    }
    $total = $total_amount_due; // Assign to 'total' as requested

    $total_hcf_claimed = 0;
    if (isset($_POST['hcf_amount_claimed']) && is_array($_POST['hcf_amount_claimed'])) {
        foreach ($_POST['hcf_amount_claimed'] as $amount) {
            if (is_numeric($amount)) {
                $total_hcf_claimed += floatval($amount);
            }
        }
    }

    if (isset($_POST['submitFinal'])) {
        // Final submission logic
        // $pa_code = $pa_code.'/'.$staff_id;

        $sql = "INSERT INTO `log_enrollees_in` (name_of_enrollee,nhia_no,sex,phone_no,pa_code,primary_hospital,
        secondary_hospital,e_position,primary_hospital_code,secondary_hospital_code,
        diagnosis,procedure_text,dob,further_diagnosis, staff_id, total_amount_due, total_hcf_claimed)
        VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?,?,?,?,?)";
        $stmt = $con->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("ssssssssssssssddd",
                $formData['name'],
                $formData['nhia_no'], // Use $formData['nhia_no'] here
                $formData['sex'],
                $formData['phone_no'], // Use $formData['phone_no'] here
                $formData['pa_code'],
                $formData['primaryHospital'],
                $formData['secondaryHospital'],
                $formData['e_position'],
                $formData['primary_hospital_code'],
                $formData['secondary_hospital_code'],
                $formData['diagnosis'],
                $formData['procedure_text'],
                $formData['dob'],
                $formData['further_diagnosis'],
                $formData['staff_id'], // Use $formData['staff_id'] here
                $total, // Insert calculated total_amount_due
                $total_hcf_claimed // Insert calculated total_hcf_claimed
            );
        } else {
            $error_message = "Database preparation error: " . $con->error;
        };

        if (!$error_message && $stmt->execute()) {
            $success_message = "Enrollee information saved successfully!";
            header("refresh:2;url=e_display.php");
        } else if (!$error_message) {
            $error_message = "Error saving record: " . $stmt->error;
        }
    }
}

$currentStep = isset($formData['step']) ? (int)$formData['step'] : 1;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enrollee Registration | Nonsuch Medicare</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #2c3e50;
            --accent-color: #3498db;
            --light-accent: #ebf5fb;
        }

        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 0.9rem;
        }

        .page-header {
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            color: white;
            padding: 10px 0;
            margin-bottom: 15px;
            border-radius: 0 0 10px 10px;
        }

        .form-container {
            background-color: white;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
            border-top: 3px solid var(--accent-color);
        }

        .form-section {
            padding: 10px;
            margin-bottom: 10px;
            border-bottom: 1px solid #f0f0f0;
        }

        .section-title {
            color: var(--primary-color);
            font-size: 1rem;
            margin-bottom: 10px;
            font-weight: 600;
        }

        .form-control, .form-select {
            padding: 6px 10px;
            font-size: 0.9rem;
        }

        .form-label {
            font-size: 0.85rem;
            margin-bottom: 3px;
        }

        .gender-options {
            display: flex;
            gap: 10px;
        }

        .gender-option {
            padding: 5px 10px;
            border: 1px solid #e1e1e1;
            border-radius: 4px;
            font-size: 0.85rem;
        }

        .gender-option.selected {
            background-color: var(--light-accent);
            border-color: var(--accent-color);
        }

        .btn {
            padding: 6px 12px;
            font-size: 0.85rem;
        }

        .required-field::after {
            content: " *";
            color: #e74c3c;
        }

        .alert {
            padding: 8px 12px;
            margin-bottom: 15px;
            font-size: 0.85rem;
        }

        .form-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 15px;
            padding-top: 10px;
        }

        /* Make form more compact */
        .mb-3 {
            margin-bottom: 0.5rem !important;
        }

        /* Hide sections initially */
        .step-form {
            display: none;
        }

        /* Show the current step */
        .step- <?php echo $currentStep; ?> {
            display: block;
        }

        /* Progress bar */
        .progress-bar-container {
            margin-bottom: 20px;
            border-radius: 5px;
            overflow: hidden;
            background-color: #f0f0f0;
        }

        .progress-bar {
            background-color: var(--accent-color);
            height: 10px;
            width: <?php echo (($currentStep - 1) / 2) * 100; ?>%; /* Adjust based on number of steps */
            border-radius: 5px;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .form-container {
                padding: 10px;
            }
        }
    </style>
</head>

<body>
    <?php include('../loginsystem/header.php'); ?>

    <div class="page-header">
        <div class="container">
            <div class="row">
                <div class="col-md-10 offset-md-1 text-center">
                    <h2><i class="fas fa-user-plus me-2"></i> Enrollee Registration</h2>
                    <small>PA Code: <span class="badge bg-light text-dark"><?php echo htmlspecialchars($hmo_code.'/'.$prog_code.'/'.$staff_id); ?></span></small>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <?php if($success_message): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle me-2"></i> <?php echo $success_message; ?>
                </div>
                <?php endif; ?>

                <?php if($error_message): ?>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle me-2"></i> <?php echo $error_message; ?>
                </div>
                <?php endif; ?>

                <div class="form-container">
                    <div class="progress-bar-container">
                        <div class="progress-bar"></div>
                    </div>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" id="enrolleeForm">
                        <input type="hidden" name="step" value="<?php echo $currentStep; ?>">

                        <div class="step-form step-1">
                            <div class="form-section">
                                <h5 class="section-title"><i class="fas fa-hospital me-2"></i>Hospital Information</h5>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="primaryHospital" class="form-label required-field">Primary Hospital</label>
                                        <input type="text" class="form-control" name="primaryHospital" id="primaryHospital"
                                               placeholder="Primary facility"
                                               value="<?php echo htmlspecialchars($formData['primaryHospital']); ?>" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="primary_hospital_code" class="form-label required-field">Primary Code</label>
                                        <input type="text" class="form-control" name="primary_hospital_code" id="primary_hospital_code"
                                               placeholder="Primary code"
                                               value="<?php echo htmlspecialchars($formData['primary_hospital_code']); ?>" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="secondaryHospital" class="form-label">Secondary Hospital</label>
                                        <input type="text" class="form-control" name="secondaryHospital" id="secondaryHospital"
                                               placeholder="Secondary facility"
                                               value="<?php echo htmlspecialchars($formData['secondaryHospital']); ?>">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="secondary_hospital_code" class="form-label">Secondary Code</label>
                                        <input type="text" class="form-control" name="secondary_hospital_code" id="secondary_hospital_code"
                                               placeholder="Secondary code"
                                               value="<?php echo htmlspecialchars($formData['secondary_hospital_code']); ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="form-footer">
                                <a href="../loginsystem/admin.php" class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-arrow-left"></i> Back
                                </a>
                                <button type="submit" name="next" class="btn btn-sm btn-primary">
                                    Next <i class="fas fa-arrow-right"></i>
                                </button>
                            </div>
                        </div>

                        <div class="step-form step-2">
                            <div class="form-section">
                                <h5 class="section-title"><i class="fas fa-notes-medical me-2"></i>Medical Information</h5>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="diagnosis" class="form-label required-field">Diagnosis</label>
                                        <textarea class="form-control" name="diagnosis" id="diagnosis" rows="3"
                                                  placeholder="Primary diagnosis" required><?php echo htmlspecialchars($formData['diagnosis']); ?></textarea>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="procedure" class="form-label">Procedure</label>
                                        <textarea class="form-control" name="procedure_text" id="procedure" rows="3"
                                                  placeholder="Planned procedures"><?php echo htmlspecialchars($formData['procedure']); ?></textarea>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="furtherDiagnosis" class="form-label">Additional Info</label>
                                        <textarea class="form-control" name="further_diagnosis" id="furtherDiagnosis" rows="3"
                                                  placeholder="Additional information"><?php echo htmlspecialchars($formData['further_diagnosis']); ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="form-footer">
                                <button type="submit" name="previous" class="btn btn-sm btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Previous
                                </button>
                                <button type="submit" name="next" class="btn btn-sm btn-primary">
                                    Next <i class="fas fa-arrow-right"></i>
                                </button>
                            </div>
                        </div>

                        <div class="step-form step-3">
                            <div class="form-section">
                                <h5 class="section-title"><i class="fas fa-user me-2"></i>Personal Information</h5>
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="name" class="form-label required-field">Full Name</label>
                                        <input type="text" class="form-control" id="name" name="name"
                                               placeholder="Full name"
                                               value="<?php echo htmlspecialchars($formData['name']); ?>" required>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="nhia" class="form-label required-field">NHIA Number</label>
                                        <input type="text" class="form-control" id="nhia" name="nhia_no"
                                               placeholder="NHIA ID number"
                                               value="<?php echo htmlspecialchars($formData['nhia_no']); ?>" required>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="phone" class="form-label">Phone</label>
                                        <input type="tel" class="form-control" name="phone_no" id="phone"
                                               placeholder="Contact number"
                                               value="<?php echo htmlspecialchars($formData['phone_no']); ?>">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label required-field">Gender</label>
                                        <div class="gender-options">
                                            <label class="gender-option <?php if($formData['sex'] == 'male') echo 'selected'; ?>">
                                                <input type="radio" name="sex" value="male" class="visually-hidden"
                                                       <?php if($formData['sex'] == 'male') echo 'checked'; ?> required>
                                                <i class="fas fa-mars me-1"></i> Male
                                            </label>
                                            <label class="gender-option <?php if($formData['sex'] == 'female') echo 'selected'; ?>">
                                                <input type="radio" name="sex" value="female" class="visually-hidden"
                                                       <?php if($formData['sex'] == 'female') echo 'checked'; ?>>
                                                <i class="fas fa-venus me-1"></i> Female
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="dob" class="form-label required-field">Date of Birth</label>
                                        <input type="date" class="form-control" id="dob" name="dob"
                                               value="<?php echo htmlspecialchars($formData['dob']); ?>" required>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="e_position" class="form-label required-field">Status</label>
                                        <select name="e_position" id="e_position" class="form-select" required>
                                            <option value="" disabled <?php if(empty($formData['e_position'])) echo 'selected'; ?>>Select status</option>
                                            <option value="principal" <?php if($formData['e_position'] == 'principal') echo 'selected'; ?>>Principal</option>
                                            <option value="spouse" <?php if($formData['e_position'] == 'spouse') echo 'selected'; ?>>Spouse</option>
                                            <option value="child_1" <?php if($formData['e_position'] == 'child_1') echo 'selected'; ?>>Child</option>
                                            <option value="child_2" <?php if($formData['e_position'] == 'child_2') echo 'selected'; ?>>Child 2</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-footer">
                                <button type="submit" name="previous" class="btn btn-sm btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Previous
                                </button>
                                <div>
                                    <button type="reset" class="btn btn-sm btn-secondary me-2">
                                        <i class="fas fa-redo-alt"></i> Reset
                                    </button>
                                    <button type="submit" name="submitFinal" class="btn btn-sm btn-primary">
                                        <i class="fas fa-save"></i> Save
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="step-form step-4">
                            <div class="form-section">
                                <h5 class="section-title"><i class="fas fa-file-invoice-dollar me-2"></i>Claim Details</h5>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Amount Due</label>
                                        <div id="amountDueInputs">
                                            </div>
                                        <button type="button" class="btn btn-sm btn-outline-secondary mt-2" onclick="addAmountDueField()">
                                            <i class="fas fa-plus"></i> Add Amount
                                        </button>
                                        <div class="mt-2">
                                            <strong>Total Amount Due:</strong> <span id="totalAmountDue">0.00</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">HCF Amount Claimed</label>
                                        <div id="hcfClaimedInputs">
                                            </div>
                                        <button type="button" class="btn btn-sm btn-outline-secondary mt-2" onclick="addHcfClaimedField()">
                                            <i class="fas fa-plus"></i> Add Claimed Amount
                                        </button>
                                        <div class="mt-2">
                                            <strong>Total HCF Claimed:</strong> <span id="totalHcfClaimed">0.00</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-footer">
                                <button type="submit" name="previous" class="btn btn-sm btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Previous
                                </button>
                                <div>
                                    <button type="reset" class="btn btn-sm btn-secondary me-2">
                                        <i class="fas fa-redo-alt"></i> Reset
                                    </button>
                                    <button type="submit" name="submitFinal" class="btn btn-sm btn-primary">
                                        <i class="fas fa-save"></i> Save
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            // Gender option selection styling
            $('.gender-option').click(function() {
                $('.gender-option').removeClass('selected');
                $(this).addClass('selected');
                $(this).find('input[type="radio"]').prop('checked', true);
            });

            // Initialize pre-selected gender option
            if ($('input[name="sex"]:checked').length > 0) {
                $('input[name="sex"]:checked').closest('.gender-option').addClass('selected');
            }

            // Form reset handler
            $('button[type="reset"]').click(function() {
                setTimeout(function() {
                    $('.gender-option').removeClass('selected');
                }, 10);
            });

            // Multi-step form navigation
            $('.step-form button[name="next"]').click(function() {
                var currentStep = $(this).closest('.step-form');
                var nextStep = currentStep.next('.step-form');
                if (nextStep.length) {
                    currentStep.hide();
                    nextStep.show();
                    updateProgressBar(parseInt($('input[name="step"]').val()) + 1);
                    $('input[name="step"]').val(parseInt($('input[name="step"]').val()) + 1);
                }
            });

            $('.step-form button[name="previous"]').click(function() {
                var currentStep = $(this).closest('.step-form');
                var prevStep = currentStep.prev('.step-form');
                if (prevStep.length) {
                    currentStep.hide();
                    prevStep.show();
                    updateProgressBar(parseInt($('input[name="step"]').val()) - 1);
                    $('input[name="step"]').val(parseInt($('input[name="step"]').val()) - 1);
                }
            });

            function updateProgressBar(step) {
                var progress = ((step - 1) / 3) * 100; // Assuming 4 steps now
                $('.progress-bar').css('width', progress + '%');
            }

            // Initialize progress bar
            updateProgressBar(<?php echo $currentStep; ?>);

            // Show the initial step
            $('.step-<?php echo $currentStep; ?>').show();
        });

        function addAmountDueField() {
            var container = document.getElementById('amountDueInputs');
            var input = document.createElement('input');
            input.type = 'number';
            input.className = 'form-control form-control-sm mb-2';
            input.name = 'amount_due[]';
            input.placeholder = 'Amount';
            input.addEventListener('input', calculateTotalAmountDue);
            container.appendChild(input);
        }

        function addHcfClaimedField() {
            var container = document.getElementById('hcfClaimedInputs');
            var input = document.createElement('input');
            input.type = 'number';
            input.className = 'form-control form-control-sm mb-2';
            input.name = 'hcf_amount_claimed[]';
            input.placeholder = 'Amount Claimed';
            input.addEventListener('input', calculateTotalHcfClaimed);
            container.appendChild(input);
        }

        function calculateTotalAmountDue() {
            var amountDueInputs = document.querySelectorAll('input[name="amount_due[]"]');
            var total = 0;
            amountDueInputs.forEach(function(input) {
                var value = parseFloat(input.value);
                if (!isNaN(value)) {
                    total += value;
                }
            });
            document.getElementById('totalAmountDue').textContent = total.toFixed(2);
        }

        function calculateTotalHcfClaimed() {
            var hcfClaimedInputs = document.querySelectorAll('input[name="hcf_amount_claimed[]"]');
            var total = 0;
            hcfClaimedInputs.forEach(function(input) {
                var value = parseFloat(input.value);
                if (!isNaN(value)) {
                    total += value;
                }
            });
            document.getElementById('totalHcfClaimed').textContent = total.toFixed(2);
        }

        // Initialize with one amount due and one HCF claimed field on step 4
        $(document).ready(function() {
            if ($('.step-4').is(':visible')) {
                addAmountDueField();
                addHcfClaimedField();
            }
        });

        $('.step-form button[name="next"]').click(function() {
            if ($(this).closest('.step-form').hasClass('step-3') && $('.step-4').length === 0) {
                // Dynamically add step 4 if it doesn't exist
                var newStep4 = `
                    <div class="step-form step-4">
                        <div class="form-section">
                            <h5 class="section-title"><i class="fas fa-file-invoice-dollar me-2"></i>Claim Details</h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Amount Due</label>
                                    <div id="amountDueInputs">
                                        <input type="number" class="form-control form-control-sm mb-2" name="amount_due[]" placeholder="Amount" oninput="calculateTotalAmountDue()">
                                    </div>
                                    <button type="button" class="btn btn-sm btn-outline-secondary mt-2" onclick="addAmountDueField()">
                                        <i class="fas fa-plus"></i> Add Amount
                                    </button>
                                    <div class="mt-2">
                                        <strong>Total Amount Due:</strong> <span id="totalAmountDue">0.00</span>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">HCF Amount Claimed</label>
                                    <div id="hcfClaimedInputs">
                                        <input type="number" class="form-control form-control-sm mb-2" name="hcf_amount_claimed[]" placeholder="Amount Claimed" oninput="calculateTotalHcfClaimed()">
                                    </div>
                                    <button type="button" class="btn btn-sm btn-outline-secondary mt-2" onclick="addHcfClaimedField()">
                                        <i class="fas fa-plus"></i> Add Claimed Amount
                                    </button>
                                    <div class="mt-2">
                                        <strong>Total HCF Claimed:</strong> <span id="totalHcfClaimed">0.00</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-footer">
                            <button type="submit" name="previous" class="btn btn-sm btn-secondary">
                                <i class="fas fa-arrow-left"></i> Previous
                            </button>
                            <div>
                                <button type="reset" class="btn btn-sm btn-secondary me-2">
                                    <i class="fas fa-redo-alt"></i> Reset
                                </button>
                                <button type="submit" name="submitFinal" class="btn btn-sm btn-primary">
                                    <i class="fas fa-save"></i> Save
                                </button>
                            </div>
                        </div>
                    </div>
                `;
                $(this).closest('.form-container form').append(newStep4);
                updateProgressBar(4);
            }
        });
    </script>
</body>
</html>
