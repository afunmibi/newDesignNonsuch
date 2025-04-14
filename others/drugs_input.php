<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Drug Entry Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            background-color: #f0f8ff;
        }
        .form-container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }
        .form-control:focus {
            border-color: skyblue;
            box-shadow: 0 0 0 0.2rem rgba(135, 206, 250, 0.25);
        }
        .btn-primary {
          background-color: skyblue;
          border-color: skyblue;
        }
        .btn-primary:hover{
          background-color: #87CEEB;
          border-color: #87CEEB;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-10 form-container">
            <h2 class="text-center mb-4">Drug Entry</h2>
            <form id="drugForm">
                <table class="table" id="drugTable">
                    <thead>
                        <tr>
                            <th>Name of Drugs</th>
                            <th>NHIA Tariff</th>
                            <th>Price</th>
                            <th>Qty</th>
                            <th>HCF Price</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        </tbody>
                    <tfoot>
                      <tr>
                        <td colspan="5" class="text-end"><strong>Total:</strong></td>
                        <td id="grandTotal">0.00</td>
                      </tr>
                    </tfoot>
                </table>
                <button type="button" id="addButton" class="btn btn-primary">Add</button>
                <button type="submit" class="btn btn-success">Submit</button>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#addButton').click(function() {
        var newRow = '<tr>' +
            '<td><input type="text" name="name_of_drugs[]" class="form-control"></td>' +
            '<td><input type="number" name="nhia_tariff[]" class="form-control nhia-tariff"></td>' +
            '<td><input type="number" name="price[]" class="form-control price"></td>' +
            '<td><input type="number" name="qty[]" class="form-control qty"></td>' +
            '<td><input type="number" name="hcf_price[]" class="form-control hcf-price"></td>' +
            '<td class="total">0.00</td>' +
            '</tr>';
        $('#drugTable tbody').append(newRow);
        updateTotals();
    });

    $('#drugTable').on('input', '.nhia-tariff, .price, .qty, .hcf-price', function() {
        updateRowTotal($(this).closest('tr'));
        updateTotals();
    });

    function updateRowTotal(row) {
        var nhiaTariff = parseFloat(row.find('.nhia-tariff').val()) || 0;
        var price = parseFloat(row.find('.price').val()) || 0;
        var qty = parseFloat(row.find('.qty').val()) || 0;
        var hcfPrice = parseFloat(row.find('.hcf-price').val()) || 0;

        var total = (nhiaTariff + price + qty + hcfPrice).toFixed(2);
        row.find('.total').text(total);
    }

    function updateTotals() {
        var grandTotal = 0;
        $('#drugTable tbody tr').each(function() {
            grandTotal += parseFloat($(this).find('.total').text()) || 0;
        });
        $('#grandTotal').text(grandTotal.toFixed(2));
    }

    $('#drugForm').submit(function(e) {
      e.preventDefault();
      var formData = $(this).serialize();
      console.log(formData);
      //Here is where you would make an ajax request
      alert("Form data has been logged to console. In a real application, you would send this to the server.");
    });

});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>