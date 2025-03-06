<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Drug Information Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .fixed-row {
            display: grid;
            grid-template-columns: repeat(6, 1fr); /* 6 columns */
            gap: 10px;
            margin-bottom: 10px;
        }
        .fixed-row label {
            display: none; /* Hide labels for each cell */
        }
        .fixed-row input {
            width: 100%;
        }
        .total-row {
          display: grid;
          grid-template-columns: repeat(6, 1fr);
          gap: 10px;
          font-weight: bold;
        }
        .total-row div:first-child{
          text-align: right;
        }
        @media (max-width: 768px) {
            .fixed-row {
                grid-template-columns: repeat(auto-fit, minmax(100px, 1fr)); /* Responsive columns */
            }
            .total-row {
                grid-template-columns: repeat(auto-fit, minmax(100px, 1fr));
            }
        }
    </style>
</head>
<body>
<?php include('header.php') ;?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <h2 class="text-center mb-4">Drug Information</h2>
            <form id="drugForm">
                <div class="fixed-row">
                    <label>Name of Drugs</label>
                    <label>NHIA Tariff</label>
                    <label>Price</label>
                    <label>Qty</label>
                    <label>HCF Price</label>
                    <label>Total</label>

                    <input type="text" name="nameOfDrugs[]" placeholder="Drug Name">
                    <input type="number" name="nhiaTariff[]" placeholder="NHIA Tariff">
                    <input type="number" name="price[]" placeholder="Price">
                    <input type="number" name="qty[]" placeholder="Qty">
                    <input type="number" name="hcfPrice[]" placeholder="HCF Price">
                    <input type="number" name="total[]" placeholder="Total" readonly>

                    <input type="text" name="nameOfDrugs[]" placeholder="Drug Name">
                    <input type="number" name="nhiaTariff[]" placeholder="NHIA Tariff">
                    <input type="number" name="price[]" placeholder="Price">
                    <input type="number" name="qty[]" placeholder="Qty">
                    <input type="number" name="hcfPrice[]" placeholder="HCF Price">
                    <input type="number" name="total[]" placeholder="Total" readonly>

                    <input type="text" name="nameOfDrugs[]" placeholder="Drug Name">
                    <input type="number" name="nhiaTariff[]" placeholder="NHIA Tariff">
                    <input type="number" name="price[]" placeholder="Price">
                    <input type="number" name="qty[]" placeholder="Qty">
                    <input type="number" name="hcfPrice[]" placeholder="HCF Price">
                    <input type="number" name="total[]" placeholder="Total" readonly>
                </div>

                <div class="total-row">
                    <div>Total:</div>
                    <div id="totalNameOfDrugs"></div>
                    <div id="totalNhiaTariff"></div>
                    <div id="totalPrice"></div>
                    <div id="totalQty"></div>
                    <div id="totalHcfPrice"></div>
                    <div id="grandTotal"></div>
                </div>

                <button type="button" class="btn btn-primary" onclick="calculateTotals()">Calculate Totals</button>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function calculateTotals() {
        const nameOfDrugs = document.getElementsByName('nameOfDrugs[]');
        const nhiaTariffs = document.getElementsByName('nhiaTariff[]');
        const prices = document.getElementsByName('price[]');
        const qtys = document.getElementsByName('qty[]');
        const hcfPrices = document.getElementsByName('hcfPrice[]');
        const totals = document.getElementsByName('total[]');

        let totalNhiaTariff = 0;
        let totalPrice = 0;
        let totalQty = 0;
        let totalHcfPrice = 0;
        let grandTotal = 0;

        for (let i = 0; i < nameOfDrugs.length; i++) {
            const price = parseFloat(prices[i].value) || 0;
            const qty = parseFloat(qtys[i].value) || 0;
            const hcfPrice = parseFloat(hcfPrices[i].value) || 0;

            const total = price * qty;
            totals[i].value = total.toFixed(2);

            totalNhiaTariff += parseFloat(nhiaTariffs[i].value) || 0;
            totalPrice += price;
            totalQty += qty;
            totalHcfPrice += hcfPrice;
            grandTotal += total;
        }

        document.getElementById('totalNhiaTariff').textContent = totalNhiaTariff.toFixed(2);
        document.getElementById('totalPrice').textContent = totalPrice.toFixed(2);
        document.getElementById('totalQty').textContent = totalQty.toFixed(2);
        document.getElementById('totalHcfPrice').textContent = totalHcfPrice.toFixed(2);
        document.getElementById('grandTotal').textContent = grandTotal.toFixed(2);
    }
</script>
</body>
</html>