<?php

require('fpdf/fpdf.php');


include_once 'connectdb.php';

$id = $_GET['id'];
$select = $pdo->prepare("select * from tbl_invoice where invoice_id = $id");
$select->execute();
$row = $select->fetch(PDO::FETCH_OBJ);

$dd = $row->order_date;

$pdf = new FPDF('P', 'mm', 'A4');

//add new page

$pdf->AddPage();
// $pdf->SetFillColor(123,255,234);
$pdf->SetFont('Arial', '', 16);
$pdf->Cell(80, 10, 'TONGHENG-T', 0, 0, '');

$pdf->SetFont('Arial', 'B', 13);
$pdf->Cell(112, 10, 'INVOICE', 0, 1, 'C');

$pdf->SetFont('Arial', '', 8);
$pdf->Cell(80, 5, 'Address: Tboung Khmum Province', 0, 0, '');

$pdf->SetFont('Arial', '', 10);
$pdf->Cell(112, 5, 'Invoice: ' . $row->invoice_id, 0, 1, 'C');

$pdf->SetFont('Arial', '', 8);
$pdf->Cell(80, 5, 'Phone Number: 0971-898-9721', 0, 0, '');

$pdf->SetFont('Arial', '', 10);
$pdf->Cell(112, 5, 'Date: ' . date('d-m-Y', strtotime($dd)), 0, 1, 'C');

$pdf->SetFont('Arial', '', 8);
$pdf->Cell(80, 5, 'Email Address: tonghengt@gmail.com', 0, 1, '');
$pdf->Cell(80, 5, 'Website: www.tonghengt.com', 0, 1, '');

//line(x1,y1,x2,y2)
$pdf->Line(2, 45, 205, 45);
$pdf->Line(2, 46, 205, 46);

$pdf->Ln(10); //line break

$pdf->SetFont('Arial', 'BI', 12);
$pdf->Cell(20, 10, 'Bill TO: ', 0, 0, '');

$pdf->SetFont('Courier', 'BI', 14);
$pdf->Cell(50, 10, $row->customer_name, 0, 1, '');

$pdf->Cell(50, 5, '', 0, 1, '');

$pdf->SetFont('Arial', 'B', 12);
$pdf->SetFillColor(208, 208, 208);
$pdf->Cell(100, 8, 'PRODUCT', 1, 0, 'C', true); //190
$pdf->Cell(20, 8, 'QTY', 1, 0, 'C', true);
$pdf->Cell(30, 8, 'PRICE', 1, 0, 'C', true);
$pdf->Cell(40, 8, 'TOTAL', 1, 1, 'C', true);

$select = $pdo->prepare("select * from tbl_invoice_details where invoice_id = $id");
$select->execute();
while ($item = $select->fetch(PDO::FETCH_OBJ)) {

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(100, 8,$item->product_name, 1, 0, 'L'); //190
    $pdf->Cell(20, 8,$item->qty, 1, 0, 'C'); //2
    $pdf->Cell(30, 8,$item->price, 1, 0, 'C'); //100
    $pdf->Cell(40, 8, $item->price*$item->qty, 1, 1, 'C'); //100*2=200
}





/////
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(100, 8, '', 0, 0, 'L'); //190
$pdf->Cell(20, 8, '', 0, 0, 'C');
$pdf->Cell(30, 8, 'SubTotal', 1, 0, 'C', true);
$pdf->Cell(40, 8, $row->subtotal, 1, 1, 'C');
///////////====================

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(100, 8, '', 0, 0, 'L'); //190
$pdf->Cell(20, 8, '', 0, 0, 'C');
$pdf->Cell(30, 8, 'Tax', 1, 0, 'C', true);
$pdf->Cell(40, 8, $row->tax, 1, 1, 'C');

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(100, 8, '', 0, 0, 'L'); //190
$pdf->Cell(20, 8, '', 0, 0, 'C');
$pdf->Cell(30, 8, 'Discount', 1, 0, 'C', true);
$pdf->Cell(40, 8, $row->discount, 1, 1, 'C');

$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(100, 8, '', 0, 0, 'L'); //190
$pdf->Cell(20, 8, '', 0, 0, 'C');
$pdf->Cell(30, 8, 'GrandTotal', 1, 0, 'C', true);
$pdf->Cell(40, 8, '$' . $row->total, 1, 1, 'C');

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(100, 8, '', 0, 0, 'L'); //190
$pdf->Cell(20, 8, '', 0, 0, 'C');
$pdf->Cell(30, 8, 'Paid', 1, 0, 'C', true);
$pdf->Cell(40, 8, $row->paid, 1, 1, 'C');


$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(100, 8, '', 0, 0, 'L'); //190
$pdf->Cell(20, 8, '', 0, 0, 'C');
$pdf->Cell(30, 8, 'Due', 1, 0, 'C', true);
$pdf->Cell(40, 8, $row->due, 1, 1, 'C');


$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(100, 8, '', 0, 0, 'L'); //190
$pdf->Cell(20, 8, '', 0, 0, 'C');
$pdf->Cell(30, 8, 'Paymet Type', 1, 0, 'C', true);
$pdf->Cell(40, 8, $row->payment_type, 1, 1, 'C');


$pdf->Cell(50, 10, '', 0, 1, '');

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(32, 10, 'Importan Notice: ', 0, 0, '', true);


$pdf->SetFont('Arial', '', 8);
$pdf->Cell(148, 10, 'No item will be replaced or refunded if you don have the invoice with you. You can refund within 2 days of purchase.', 0, 0, '');


//output the result
$pdf->Output();
