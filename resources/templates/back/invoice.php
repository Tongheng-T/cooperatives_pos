<?php

require('fpdf/fpdf.php');


$pdf = new FPDF('P', 'mm', 'A4');

//add new page

$pdf->AddPage();
// $pdf->SetFillColor(123,255,234);
$pdf->SetFont('Arial','',16);
$pdf->Cell(80,10,'TONGHENG-T',0,0,'');

$pdf->SetFont('Arial','B',13);
$pdf->Cell(112,10,'INVOICE',0,1,'C');

$pdf->SetFont('Arial','',8);
$pdf->Cell(80,5,'Address: Tboung Khmum Province',0,0,'');

$pdf->SetFont('Arial','',10);
$pdf->Cell(112,5,'Invoice: #12345',0,1,'C');

$pdf->SetFont('Arial','',8);
$pdf->Cell(80,5,'Phone Number: 0971-898-9721',0,0,'');

$pdf->SetFont('Arial','',10);
$pdf->Cell(112,5,'Date: 07-03-2023',0,1,'C');

$pdf->SetFont('Arial','',8);
$pdf->Cell(80,5,'Email Address: tonghengt@gmail.com',0,1,''); 
$pdf->Cell(80,5,'Website: www.tonghengt.com',0,1,'');

//line(x1,y1,x2,y2)
$pdf->Line(2,45,205,45);
$pdf->Line(2,46,205,46);

$pdf->Ln(10); //line break

$pdf->SetFont('Arial','BI',12);
$pdf->Cell(20,10,'Bill TO: ',0,0,'');

$pdf->SetFont('Courier','BI',14);
$pdf->Cell(50,10,'Faizan Khan',0,1,'');

$pdf->Cell(50,5,'',0,1,'');

$pdf->SetFont('Arial','B',12);
$pdf->SetFillColor(208,208,208);
$pdf->Cell(100,8,'PRODUCT',1,0,'C',true); //190
$pdf->Cell(20,8,'QTY',1,0,'C',true);
$pdf->Cell(30,8,'PRICE',1,0,'C',true);
$pdf->Cell(40,8,'TOTAL',1,1,'C',true);


$pdf->SetFont('Arial','B',12);
$pdf->Cell(100,8,'Iphone',1,0,'L'); //190
$pdf->Cell(20,8,'1',1,0,'C');
$pdf->Cell(30,8,'800',1,0,'C');
$pdf->Cell(40,8,'800',1,1,'C');


$pdf->SetFont('Arial','B',12);
$pdf->Cell(100,8,'Iphone',1,0,'L'); //190
$pdf->Cell(20,8,'1',1,0,'C');
$pdf->Cell(30,8,'800',1,0,'C');
$pdf->Cell(40,8,'800',1,1,'C');

$pdf->SetFont('Arial','B',12);
$pdf->Cell(100,8,'Iphone',1,0,'L'); //190
$pdf->Cell(20,8,'1',1,0,'C');
$pdf->Cell(30,8,'800',1,0,'C');
$pdf->Cell(40,8,'800',1,1,'C');



$pdf->SetFont('Arial','B',12);
$pdf->Cell(100,8,'',0,0,'L'); //190
$pdf->Cell(20,8,'',0,0,'C');
$pdf->Cell(30,8,'SubTotal',1,0,'C',true);
$pdf->Cell(40,8,'7866',1,1,'C');
///////////====================

$pdf->SetFont('Arial','B',12);
$pdf->Cell(100,8,'',0,0,'L'); //190
$pdf->Cell(20,8,'',0,0,'C');
$pdf->Cell(30,8,'Tax',1,0,'C',true);
$pdf->Cell(40,8,'7866',1,1,'C');

$pdf->SetFont('Arial','B',12);
$pdf->Cell(100,8,'',0,0,'L'); //190
$pdf->Cell(20,8,'',0,0,'C');
$pdf->Cell(30,8,'Discount',1,0,'C',true);
$pdf->Cell(40,8,'7866',1,1,'C');

$pdf->SetFont('Arial','B',14);
$pdf->Cell(100,8,'',0,0,'L'); //190
$pdf->Cell(20,8,'',0,0,'C');
$pdf->Cell(30,8,'GrandTotal',1,0,'C',true);
$pdf->Cell(40,8,'$'.'7866',1,1,'C');

$pdf->SetFont('Arial','B',12);
$pdf->Cell(100,8,'',0,0,'L'); //190
$pdf->Cell(20,8,'',0,0,'C');
$pdf->Cell(30,8,'Paid',1,0,'C',true);
$pdf->Cell(40,8,'7866',1,1,'C');


$pdf->SetFont('Arial','B',12);
$pdf->Cell(100,8,'',0,0,'L'); //190
$pdf->Cell(20,8,'',0,0,'C');
$pdf->Cell(30,8,'Due',1,0,'C',true);
$pdf->Cell(40,8,'3333',1,1,'C');


$pdf->SetFont('Arial','B',10);
$pdf->Cell(100,8,'',0,0,'L'); //190
$pdf->Cell(20,8,'',0,0,'C');
$pdf->Cell(30,8,'Paymet Type',1,0,'C',true);
$pdf->Cell(40,8,'Cash',1,1,'C');


$pdf->Cell(50,10,'',0,1,'');

$pdf->SetFont('Arial','B',10);
$pdf->Cell(32,10,'Importan Notice: ',0,0,'',true); 


$pdf->SetFont('Arial','',8);
$pdf->Cell(148,10,'No item will be replaced or refunded if you don have the invoice with you. You can refund within 2 days of purchase.',0,0,''); 


//output the result
$pdf->Output();

?>

