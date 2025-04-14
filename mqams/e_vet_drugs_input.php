<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../backend/connection.php'; // Include your database connection file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pa_code = $_GET['pa_code'] ?? null;
    $success = true;
    $error_messages = [];
    $total_hcf_claimed_submitted = $_POST['total_hcf_claimed'] ?? 0;
    $total_amount_due_submitted = $_POST['total_amount_due'] ?? 0;

    if (isset($_POST['name_of_drug']) && is_array($_POST['name_of_drug'])) {
        $name_of_drug_array = $_POST['name_of_drug'];
        $nhia_tariff_array = $_POST['nhia_tariff'];
        $hcf_amount_claimed_array = $_POST['hcf_amount_claimed'];
        $amount_due_array = $_POST['amount_due'];
        $qty_array = $_POST['qty'];
        $tenPercent_array = $_POST['tenPercent'];
        $remarks_array = $_POST['remarks'];

        // Prepare the SQL statement outside the loop for efficiency and security
        $sql = "INSERT INTO e_drug_entry (pa_code, name_of_drug, nhia_tariff, hcf_amount_claimed, amount_due, tenPercent, qty, remarks)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $con->prepare($sql);

        if ($stmt) {
            for ($i = 0; $i < count($name_of_drug_array); $i++) {
                $name_of_drug = $con->real_escape_string($name_of_drug_array[$i]);
                $nhia_tariff = $con->real_escape_string($nhia_tariff_array[$i]);
                $hcf_amount_claimed = $con->real_escape_string($hcf_amount_claimed_array[$i]);
                $amount_due = $con->real_escape_string($amount_due_array[$i]);
                $qty = $con->real_escape_string($qty_array[$i]);
                $tenPercent = $con->real_escape_string($tenPercent_array[$i]);
                $remarks = $con->real_escape_string($remarks_array[$i]);

                // Bind parameters
                $stmt->bind_param("ssdsssss", $pa_code, $name_of_drug, $nhia_tariff, $hcf_amount_claimed, $amount_due, $tenPercent, $qty, $remarks);

                if (!$stmt->execute()) {
                    echo "Error inserting drug '$name_of_drug': " . $stmt->error . "<br>";
                    $success = false;
                    $error_messages[] = "Failed to insert record for drug: $name_of_drug. Error: " . $stmt->error;
                }
            }
            $stmt->close();

            // Update totals in a separate query (consider the table structure)
            if ($success) {
                $totals_sql = "UPDATE e_drug_entry
                                   SET total_hcf_claimed = ?,
                                       total_amount_due = ?
                                 WHERE pa_code = ?";
                $totals_stmt = $con->prepare($totals_sql);
                if ($totals_stmt) {
                    $totals_stmt->bind_param("dds", $total_hcf_claimed_submitted, $total_amount_due_submitted, $pa_code);
                    if (!$totals_stmt->execute()) {
                        echo "Error updating totals: " . $totals_stmt->error . "<br>";
                        $success = false;
                        $error_messages[] = "Failed to update totals. Error: " . $totals_stmt->error;
                    }
                    $totals_stmt->close();
                } else {
                    echo "Error preparing totals update statement: " . $con->error . "<br>";
                    $success = false;
                    $error_messages[] = "Failed to prepare totals update statement: " . $con->error;
                }
            }
        } else {
            echo "Error preparing insert statement: " . $con->error . "<br>";
            $success = false;
            $error_messages[] = "Failed to prepare insert statement: " . $con->error;
        }

        if ($success) {
            echo 'Record received. Thank you for vetting.....';
            header('Location: e_display.php');
            exit();
        } else {
            echo "<div class='alert alert-danger'><strong>Error!</strong> ";
            foreach ($error_messages as $message) {
                echo $message . "<br>";
            }
            echo "</div>";
        }
    }
}

// Close the database connection
$con->close();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Service Entry Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .form-container {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }
        .table th, .table td {
            text-align: center;
        }
        .btn-primary {
            margin-top: 10px;
        }
        .btn-success {
            margin-top: 10px;
        }
        .alert-danger {
            margin-top: 20px;
        }
    </style>
</head>
<body>
<?php include('../loginsystem/header.php'); ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-10 form-container">
            <h2 class="text-center mb-4">Drugs Entry for PA Code: <?php echo htmlspecialchars($_GET['pa_code'] ?? 'N/A'); ?></h2>
            <form id="drugForm" method="post" action="">
    <table class="table" id="drugTable">
        <thead>
            <tr>
                <th>Name of Drug</th>
                <th>NHIA Tariff</th>
                <th>HCF Amount Claimed</th>
                <th>Amount Due</th>
                <th>Qty</th>
                <th>10%</th>
                <th>Total</th>
                <th>Remarks</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2" class="text-end"><strong>Total:</strong></td>
                <td id="hcfAmountClaimedTotal" name='hcfAmountClaimedTotal'>0.00</td>
                <td id="amountDueTotal" >0.00</td>
                <td></td>
                <td id="tenPercentTotal">0.00</td>
                <td id="grandTotal">0.00</td>
                <td></td>
            </tr>
            <tr>
                <td colspan="8" class="text-end">
                    <input type="hidden" name="total_hcf_claimed" id="totalHcfClaimedHidden" value="0.00">
                    <input type="hidden" name="total_amount_due" id="totalAmountDueHidden" value="0.00">
                    <button type="button" id="addButton" class="btn btn-primary">Add Drug</button>
                    <button type="submit" class="btn btn-success" name="e_submit">Submit Drugs</button>
                </td>
            </tr>
        </tfoot>
    </table>
</form>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#addButton').click(function() {
        var newRow = '<tr>' +
            '<td><input type="text" name="name_of_drug[]" class="form-control"></td>' +
            '<td><input type="number" name="nhia_tariff[]" class="form-control nhia-tariff"></td>' +
            '<td><input type="number" name="hcf_amount_claimed[]" class="form-control hcf_amount_claimed"></td>' +
            '<td><span class="amount_due_display">0.00</span><input type="hidden" name="amount_due[]" class="amount_due_hidden"></td>' +
            '<td><input type="number" name="qty[]" class="form-control qty"></td>' +
            '<td><span class="tenPercent_display">0.00</span><input type="hidden" name="tenPercent[]" class="tenPercent_hidden"></td>' +
            '<td class="total_row">0.00</td>' +
            '<td><input type="text" name="remarks[]" class="form-control"></td>' +
            '</tr>';
        $('#drugTable tbody').append(newRow);
        updateAllTotals();
    });

    $('#drugTable').on('input', '.nhia-tariff, .qty, .hcf_amount_claimed', function() {
        updateRow($(this).closest('tr'));
        updateAllTotals();
    });

    function updateRow(row) {
        var nhiaTariff = parseFloat(row.find('.nhia-tariff').val()) || 0;
        var qty = parseFloat(row.find('.qty').val()) || 0;
        var hcfAmountClaimed = parseFloat(row.find('.hcf_amount_claimed').val()) || 0;
        var tenPercentCalc = 0.10;
        var tenPercentTotal = nhiaTariff * qty * tenPercentCalc;
        var amountDue = (nhiaTariff * qty) - tenPercentTotal;
        var rowTotal = amountDue; // Assuming "Total" in the table means the Amount Due after discount

        row.find('.amount_due_display').text(amountDue.toFixed(2));
        row.find('.amount_due_hidden').val(amountDue.toFixed(2));
        row.find('.tenPercent_display').text(tenPercentTotal.toFixed(2));
        row.find('.tenPercent_hidden').val(tenPercentTotal.toFixed(2));
        row.find('.total_row').text(rowTotal.toFixed(2));
    }

    function updateAllTotals() {
        var hcfTotal = 0;
        var amountDueTotal = 0;
        var grandTotal = 0;
        var tenPercentGrandTotal = 0;

        $('#drugTable tbody tr').each(function() {
            hcfTotal += parseFloat($(this).find('.hcf_amount_claimed').val()) || 0;
            amountDueTotal += parseFloat($(this).find('.amount_due_hidden').val()) || 0;
            grandTotal += parseFloat($(this).find('.total_row').text()) || 0;
            tenPercentGrandTotal += parseFloat($(this).find('.tenPercent_hidden').val()) || 0;
        });

        $('#hcfAmountClaimedTotal').text(hcfTotal.toFixed(2));
        $('#amountDueTotal').text(amountDueTotal.toFixed(2));
        $('#grandTotal').text(grandTotal.toFixed(2));
        $('#tenPercentTotal').text(tenPercentGrandTotal.toFixed(2));

        $('#totalHcfClaimedHidden').val(hcfTotal.toFixed(2));
        $('#totalAmountDueHidden').val(amountDueTotal.toFixed(2));
    }

    updateAllTotals(); // Initialize totals on page load
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>