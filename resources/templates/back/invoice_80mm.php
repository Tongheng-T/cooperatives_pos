<?php

require('fpdf/fpdf.php');


include_once 'connectdb.php';

$id = $_GET['id'];
$select = $pdo->prepare("select * from tbl_invoice where invoice_id = $id");
$select->execute();
$row = $select->fetch(PDO::FETCH_OBJ);

$dd = $row->order_date;

$pdf = new FPDF('P', 'mm',array(80,200));

//add new page

$pdf->AddPage();
// $pdf->SetFillColor(123,255,234);
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(60, 8, 'TONGHENG-T', 1, 1, 'C');

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(60, 5, 'Address: Tboung Khmum Province', 0, 1, 'C');
$pdf->Cell(60, 5, 'Phone Number: 0971-898-9721', 0, 1, 'C');
$pdf->Cell(60, 5, 'Email Address: tonghengt@mgail.com', 0, 1, 'C');
$pdf->Cell(60, 5, 'Website: www.tonghengt.com', 0, 1, 'C');


//line(x1,y1,x2,y2)
$pdf->Line(7, 38, 72, 38);
$pdf->Ln(1); //line break

$pdf->SetFont('Arial', 'BI', 8);
$pdf->Cell(20, 4, 'Bill TO: ', 0, 0, '');

$pdf->SetFont('Courier', 'BI', 8);
$pdf->Cell(40, 4, $row->customer_name, 0, 1, '');

$pdf->SetFont('Arial', 'BI', 8);
$pdf->Cell(20, 4, 'Invoice N0: ', 0, 0, '');

$pdf->SetFont('Courier', 'BI', 8);
$pdf->Cell(40, 4, $row->invoice_id, 0, 1, '');

$pdf->SetFont('Arial', 'BI', 8);
$pdf->Cell(20, 4, 'Date: ', 0, 0, '');

$pdf->SetFont('Courier', 'BI', 8);
$pdf->Cell(40, 4, date('d-m-Y', strtotime($dd)), 0, 1, '');
////////////=]=
$pdf->SetX(7);
$pdf->SetFont('Courier', 'B', 8);
$pdf->SetFillColor(208, 208, 208);
$pdf->Cell(34, 5, 'PRODUCT', 1, 0, 'C', true); //190
$pdf->Cell(11, 5, 'QTY', 1, 0, 'C', true);
$pdf->Cell(8, 5, 'PRC', 1, 0, 'C', true);
$pdf->Cell(12, 5, 'TOTAL', 1, 1, 'C', true);

$select = $pdo->prepare("select * from tbl_invoice_details where invoice_id = $id");
$select->execute();
while ($item = $select->fetch(PDO::FETCH_OBJ)) {
    $pdf->SetX(7);
    $pdf->SetFont('Helvetica', 'B', 8);
    $pdf->Cell(34, 5,$item->product_name, 1, 0, 'L'); //190
    $pdf->Cell(11, 5,$item->qty, 1, 0, 'C'); //2
    $pdf->Cell(8, 5,$item->price, 1, 0, 'C'); //100
    $pdf->Cell(12, 5, $item->price*$item->qty, 1, 1, 'C'); //100*2=200
}

//////
$pdf->SetFillColor(208, 208, 208);
$pdf->SetX(7);
$pdf->SetFont('Courier', 'B', 8);
$pdf->Cell(20, 5, '', 0, 0, 'L'); //190
// $pdf->Cell(20, 5, '', 0, 0, 'C');
$pdf->Cell(25, 5, 'SUBTOTAL', 1, 0, 'C', true);
$pdf->Cell(20, 5, $row->subtotal, 1, 1, 'C');

$pdf->SetX(7);
$pdf->SetFont('Courier', 'B', 8);
$pdf->Cell(20, 5, '', 0, 0, 'L'); //190
// $pdf->Cell(20, 5, '', 0, 0, 'C');
$pdf->Cell(25, 5, 'TAX(5%)', 1, 0, 'C');
$pdf->Cell(20, 5, $row->tax, 1, 1, 'C');


$pdf->SetX(7);
$pdf->SetFont('Courier', 'B', 8);
$pdf->Cell(20, 5, '', 0, 0, 'L'); //190
// $pdf->Cell(20, 5, '', 0, 0, 'C');
$pdf->Cell(25, 5, 'DISCOUNT', 1, 0, 'C', true);
$pdf->Cell(20, 5, $row->discount, 1, 1, 'C');

$pdf->SetX(7);
$pdf->SetFont('Courier', 'B', 10);
$pdf->Cell(20, 5, '', 0, 0, 'L'); //190
// $pdf->Cell(20, 5, '', 0, 0, 'C');
$pdf->Cell(25, 5, 'TOTAL', 1, 0, 'C');
$pdf->Cell(20, 5, $row->total, 1, 1, 'C');

$pdf->SetX(7);
$pdf->SetFont('Courier', 'B', 8);
$pdf->Cell(20, 5, '', 0, 0, 'L'); //190
// $pdf->Cell(20, 5, '', 0, 0, 'C');
$pdf->Cell(25, 5, 'DUE', 1, 0, 'C', true);
$pdf->Cell(20, 5, $row->due, 1, 1, 'C');


$pdf->SetX(7);
$pdf->SetFont('Courier', 'B', 8);
$pdf->Cell(20, 5, '', 0, 0, 'L'); //190
// $pdf->Cell(20, 5, '', 0, 0, 'C');
$pdf->Cell(25, 5, 'PAYMENT TYPE', 1, 0, 'C');
$pdf->Cell(20, 5, $row->payment_type, 1, 1, 'C');


$pdf->Cell(20, 5, '', 0, 1, '');
$pdf->SetX(7);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(25, 5, 'Importan Notice: ', 0, 1, '');

$pdf->SetX(7);
$pdf->SetFont('Arial', '', 5);
$pdf->Cell(75, 5, 'No item will be replaced or refunded if you don have the invoice with you.', 0, 2, '');


//output the result
$pdf->Output();
