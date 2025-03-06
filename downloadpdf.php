<?php
require_once 'dompdf/autoload.inc.php'; // Adjust path

use Dompdf\Dompdf;

// Instantiate Dompdf
$dompdf = new Dompdf();

// Load HTML content
$html = '<h1>My PDF</h1><p>This is generated from HTML.</p>';
$dompdf->loadHtml($html);

// (Optional) Set paper size and orientation
$dompdf->setPaper('A4', 'portrait');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
$dompdf->stream('document.pdf', array('Attachment' => 1)); // 1 = Download
?>
