<?php
 //require_once('connections/koneksi.php');
 require_once('html2fpdf.php');
$htmlFile = "http://www.cnn.com"; 
$buffer = file_get_contents($htmlFile); 

$pdf = new HTML2FPDF('P', 'mm', 'Legal'); 
$pdf->AddPage(); 
$pdf->WriteHTML($buffer); 
$pdf->Output('my.pdf', 'F'); 
?>