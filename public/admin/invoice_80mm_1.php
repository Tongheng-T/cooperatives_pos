<?php
require_once("../../resources/config.php");
require('../fpdf/fpdf.php');



$id = $_GET['id'];
$select = query("select * from tbl_invoice where invoice_id = $id");
confirm($select);
$row = $select->fetch_object();

$dd = $row->order_date;

$pdf = new FPDF('P', 'mm',array(80,200));

//add new page

$pdf->AddPage();
// $pdf->SetFillColor(123,255,234);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(60, 9, 'Dambea Agricultural cooperatives', 1, 2, 'C');

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(60, 5, 'Address: Tboung Khmum Province', 0, 1, '');
$pdf->Cell(60, 5, 'Phone Number: 097-2449-391', 0, 1, '');
$pdf->Cell(60, 5, 'Email Address: tonghengt@mgail.com', 0, 1, '');
$pdf->Cell(60, 5, '-', 0, 1, '');


//line(x1,y1,x2,y2)
$pdf->Line(5, 38, 75, 38);
$pdf->Ln(1); //line break

$pdf->SetFont('Arial', 'BI', 8);
$pdf->Cell(20, 4, 'Bill TO: ', 0, 0, '');
$pdf->AddFont('KhmerOSbattambang','','KhmerOSbattambang.php',true);
$pdf->SetFont('KhmerOSbattambang', '', 8);
$pdf->Cell(40, 4,$row->customer_name, 0, 1, '');
// $pdf->Image('productimages/1.jpg',2,1,10);

$pdf->SetFont('Arial', 'BI', 8);
$pdf->Cell(20, 4, 'Invoice N0: ', 0, 0, '');

$pdf->SetFont('Courier', 'BI', 8);
$pdf->Cell(40, 4, $row->invoice_id, 0, 1, '');

$pdf->SetFont('Arial', 'BI', 8);
$pdf->Cell(20, 4, 'Date: ', 0, 0, '');

$pdf->SetFont('Courier', 'BI', 8);
$pdf->Cell(40, 4, date('d-m-Y', strtotime($dd)), 0, 1, '');
////////////=]=
$pdf->SetX(5);
$pdf->SetFont('Courier', 'B', 8);
$pdf->SetFillColor(208, 208, 208);
$pdf->Cell(38, 5, 'PRODUCT', 1, 0, 'C', true); //190
$pdf->Cell(8, 5, 'QTY', 1, 0, 'C', true);
$pdf->Cell(10, 5, 'PRICE', 1, 0, 'C', true);
$pdf->Cell(14, 5, 'TOTAL', 1, 1, 'C', true);

$select = query("select * from tbl_invoice_details where invoice_id = $id");
confirm($select);
while ($item = $select->fetch_object()) {
    $pdf->SetX(5);
    $pdf->SetFont('Helvetica', 'B', 8);
    $pdf->Cell(38, 5,$item->product_name, 1, 0, 'L'); //190
    $pdf->Cell(8, 5,$item->qty, 1, 0, 'C'); //2
    $pdf->Cell(10, 5,$item->price, 1, 0, 'C'); //100
    $pdf->Cell(14, 5, $item->price*$item->qty, 1, 1, 'C'); //100*2=200
}

//////
$pdf->SetFillColor(208, 208, 208);
$pdf->SetX(5);
$pdf->SetFont('Courier', 'B', 8);
$pdf->Cell(24, 5, '', 0, 0, 'L'); //190
// $pdf->Cell(20, 5, '', 0, 0, 'C');
$pdf->Cell(22, 5, 'SUBTOTAL', 1, 0, 'C');
$pdf->Cell(24, 5,'$'. $row->subtotal, 1, 1, 'C');

$pdf->SetX(5);
$pdf->SetFont('Courier', 'B', 8);
$pdf->Cell(24, 5, '', 0, 0, 'L'); //190
// $pdf->Cell(20, 5, '', 0, 0, 'C');
$pdf->Cell(22, 5, 'TAX(5%)', 1, 0, 'C', true);
$pdf->Cell(24, 5, $row->tax, 1, 1, 'C');


$pdf->SetX(5);
$pdf->SetFont('Courier', 'B', 8);
$pdf->Cell(24, 5, '', 0, 0, 'L'); //190
// $pdf->Cell(20, 5, '', 0, 0, 'C');
$pdf->Cell(22, 5, 'DISCOUNT', 1, 0, 'C');
$pdf->Cell(24, 5,'$'. $row->discount, 1, 1, 'C');

$pdf->SetX(5);
$pdf->SetFont('Courier', 'B', 10);
$pdf->Cell(24, 5, '', 0, 0, 'L'); //190
// $pdf->Cell(20, 5, '', 0, 0, 'C');
$pdf->Cell(22, 5, 'TOTAL', 1, 0, 'C', true);
$pdf->Cell(24, 5,'$'. $row->total, 1, 1, 'C', true);

$pdf->SetX(5);
$pdf->SetFont('Courier', 'B', 8);
$pdf->Cell(24, 5, '', 0, 0, 'L'); //190
// $pdf->Cell(20, 5, '', 0, 0, 'C');
$pdf->Cell(22, 5, 'DUE', 1, 0, 'C');
$pdf->Cell(24, 5, $row->due, 1, 1, 'C');


$pdf->SetX(5);
$pdf->SetFont('Courier', 'B', 8);
$pdf->Cell(24, 5, '', 0, 0, 'L'); //190
// $pdf->Cell(20, 5, '', 0, 0, 'C');
$pdf->Cell(22, 5, 'PAYMENT TYPE', 1, 0, 'C', true);
$pdf->Cell(24, 5, $row->payment_type, 1, 1, 'C');


$pdf->Cell(24, 5, '', 0, 1, '');
$pdf->SetX(5);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(24, 5, 'Importan Notice: ', 0, 1, '');

$pdf->SetX(5);
$pdf->SetFont('Arial', '', 5);
$pdf->Cell(75, 5, 'No item will be replaced or refunded if you don have the invoice with you.', 0, 2, '');


//output the result
$pdf->Output();
