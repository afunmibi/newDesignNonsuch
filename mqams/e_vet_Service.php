<?php
require_once '../backend/connection.php'; // Include your database connection file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
     $pa_code = $_GET['pa_code'] ?? null;
    // $nhia_code = $_GET['nhia_code'] ?? null;
    $success = true;
    $error_messages = [];
    $total_hcf_claimed = 0;
    $total_amount_due = 0;

    if (isset($_POST['name_of_services']) && is_array($_POST['name_of_services'])) {
        $name_of_services_array = $_POST['name_of_services'];
        $nhia_tariff_array = $_POST['nhia_tariff'];
        $hcf_amount_claimed_array = $_POST['hcf_amount_claimed'];
        $amount_due_array = $_POST['amount_due'];
        $qty_array = $_POST['qty'];
        $remarks_array = $_POST['remarks'];
        $total_hcf_claimed= $_POST['total_hcf_claimed'];
        $total_amount_due= $_POST['total_amount_due'];



        for ($i = 0; $i < count($name_of_services_array); $i++) {
            $name_of_services = $con->real_escape_string($name_of_services_array[$i]);
            $nhia_tariff = $con->real_escape_string($nhia_tariff_array[$i]);
            $hcf_amount_claimed = $con->real_escape_string($hcf_amount_claimed_array[$i]);
            $amount_due = $con->real_escape_string($amount_due_array[$i]);
            $qty = $con->real_escape_string($qty_array[$i]);
            $remarks = $con->real_escape_string($remarks_array[$i]);
            // $total_hcf_claimed += floatval($hcf_amount_claimed);
            

            $sql = "INSERT INTO e_service_entry (pa_code, name_of_service, nhia_tariff, hcf_amount_claimed, amount_due, qty, remarks, total_hcf_claimed, total_amount_due )
        VALUES ( '$pa_code', '$name_of_services', '$nhia_tariff', '$hcf_amount_claimed', '$amount_due', '$qty', '$remarks', '$total_hcf_claimed','$total_amount_due')"; 
            // Note: Adjust the SQL query according to your actual table structure and requirements

            if (!$con->query($sql)) {
                echo "Error inserting service '$name_of_services': " . $con->error . "<br>";
                $success = false;
                $error_messages[] = "Failed to insert record for service: $name_of_services. Error: " . $con->error;
            }
        }

        // Update totals in a separate query
        if ($success) {
            $totals_sql = "UPDATE e_service_entry
                           SET total_hcf_claimed = '$total_hcf_claimed_overall',
                               total_amount_due = '$total_amount_due_overall'
                           WHERE pa_code = '$pa_code'";

            if (!$con->query($totals_sql)) {
                echo "Error updating totals: " . $con->error . "<br>";
                $success = false;
                $error_messages[] = "Failed to update totals. Error: " . $con->error;
            }
        }
        // If all insertions are successful, redirect to the desired page
        if ($success) {
            header('Location: e_vet_drugs_input.php?pa_code='.$pa_code);
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

// Close the database connection outside the loop and the main conditional
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
            <h2 class="text-center mb-4">Services Entry for PA Code: <?php echo htmlspecialchars($_GET['pa_code'] ?? 'N/A'); ?></h2>
            <form id="drugForm" method="post" action="">
    <table class="table" id="drugTable">
        <thead>
            <tr>
                <th>Name of Service</th>
                <th>NHIA Tariff</th>
                <th>HCF Amount Claimed</th>
                <th>Amount Due</th>
                <th>Qty</th>
                <th>Total</th>
                <th>Remarks</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2" class="text-end"><strong>Total:</strong></td>
                <td id="hcfAmountClaimedTotal">0.00</td>
                <td id="amountDueTotal">0.00</td>
                <td></td>
                <td id="grandTotal">0.00</td>
                <td></td>
            </tr>
            <tr>
                <td colspan="7" class="text-end">
                    <input type="hidden" name="total_hcf_claimed" id="totalHcfClaimedHidden" value="0.00">
                    <input type="hidden" name="total_amount_due" id="totalAmountDueHidden" value="0.00">
                    <button type="button" id="addButton" class="btn btn-primary">Add Service</button>
                    <a href="e_vet_drugs_input.php?id=<?php echo $row['pa_code'];?>"> <button type="submit" class="btn btn-success" name="e_submit">Submit Services</button></a>
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
            '<td><input type="text" name="name_of_services[]" class="form-control"></td>' +
            '<td><input type="number" name="nhia_tariff[]" class="form-control nhia-tariff"></td>' +
            '<td><input type="number" name="hcf_amount_claimed[]" class="form-control hcf_amount_claimed"></td>' +
            '<td><span class="amount_due_display">0.00</span><input type="hidden" name="amount_due[]" class="amount_due_hidden"></td>' +
            '<td><input type="number" name="qty[]" class="form-control qty"></td>' +
            '<td class="total_row" name="total_amount_due[]"> 0.00 </td>' +
            '<td><input type="text" name="remarks[]" class="form-control"></td>' +
            '</tr>';
        $('#drugTable tbody').append(newRow);
        updateTotals();
        updateHcfAmountClaimedTotal();
        updateAmountDueTotal();
    });

    $('#drugTable').on('input', '.nhia-tariff, .qty, .hcf_amount_claimed', function() {
        updateRowTotal($(this).closest('tr'));
        updateTotals();
        updateHcfAmountClaimedTotal();
        updateAmountDueTotal();
    });

    function updateRowTotal(row) {
        var nhiaTariff = parseFloat(row.find('.nhia-tariff').val()) || 0;
        var qty = parseFloat(row.find('.qty').val()) || 0;
        var hcfAmountClaimed = parseFloat(row.find('.hcf_amount_claimed').val()) || 0;
        var amountDue = parseFloat(row.find('.amount_due_hidden').val()) || 0;

        var subTotal = nhiaTariff * qty;
        var amountDue = subTotal.toFixed(2);
        row.find('.amount_due_display').text(amountDue);
        row.find('.amount_due_hidden').val(amountDue);
        row.find('.total_row').text(amountDue);
    }

    function updateTotals() {
        var grandTotal = 0;
        $('#drugTable tbody tr').each(function() {
            grandTotal += parseFloat($(this).find('.total_row').text()) || 0;
        });
        $('#grandTotal').text(grandTotal.toFixed(2));
    }

    function updateHcfAmountClaimedTotal() {
        var hcfTotal = 0;
        $('#drugTable tbody tr').each(function() {
            hcfTotal += parseFloat($(this).find('.hcf_amount_claimed').val()) || 0;
        });
        $('#hcfAmountClaimedTotal').text(hcfTotal.toFixed(2));
        $('#totalHcfClaimedHidden').val(hcfTotal.toFixed(2)); // Set hidden input value
    }

    function updateAmountDueTotal() {
        var amountDueTotal = 0;
        $('#drugTable tbody tr').each(function() {
            amountDueTotal += parseFloat($(this).find('.amount_due_hidden').val()) || 0;
        });
        $('#amountDueTotal').text(amountDueTotal.toFixed(2));
        $('#totalAmountDueHidden').val(amountDueTotal.toFixed(2)); // Set hidden input value
    }

    updateHcfAmountClaimedTotal();
    updateAmountDueTotal();
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>