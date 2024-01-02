<?php

// Optionally define the filesystem path to your system fonts
// otherwise tFPDF will use [path to tFPDF]/font/unifont/ directory
// define("_SYSTEM_TTFONTS", "C:/Windows/Fonts/");

require('tfpdf.php');

$pdf = new tFPDF();
$pdf->AddPage();

// Add a Unicode font (uses UTF-8)
$pdf->AddFont('DejaVu','','KhmerOSbattambang.ttf',true);
$pdf->SetFont('DejaVu','',14);
$pdf->Cell(60, 5, 'តុងហេង: www.tonghengt.com', 0, 1, '');

// Load a UTF-8 string from a file and print it
$txt = file_get_contents('HelloWorld.txt');
$pdf->Write(8,$txt);

// Select a standard font (uses windows-1252)
$pdf->SetFont('Arial','',14);
$pdf->Ln(10);
$pdf->Write(5,'The file size of this PDF is only 13 KB.');

$pdf->Output();
?>
