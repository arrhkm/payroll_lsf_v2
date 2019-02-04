<?php 
#panggil modul PDF
require('./fpdf/fpdf.php');
#----------------end of Modul PDF --------------------
# Koneksi 
require_once('connections/conn_mysqli_procedural.php');
#----------- end of koneksi ---


#------------SEELCT ARCHIVE-----------------
$sql_archive="SELECT * FROM pos_archive WHERE kd_periode='$_REQUEST[kd_periode]' AND kd_project='$_REQUEST[kd_project]'";
$rs_archive=mysqli_query($link, $sql_archive);
$row_archive=mysqli_fetch_assoc($rs_archive);

#SELECT employee & payroll
$sql_emp = "SELECT * FROM pos_payroll WHERE kd_periode='$_REQUEST[kd_periode]' AND kd_project='$_REQUEST[kd_project]'";
$rs_emp = mysqli_query($link, $sql_emp) or die(mysqli_error($link));
#------------------------------------------------------------------------------

class PDF extends FPDF { }

$pdf=new PDF('P','mm','A4');
$pdf->SetMargins(30,10,5);
//$pdf->SetTopMargin(10);
//$pdf->SetButtomMargin(10);
$t_baris=3;//tinggi baris
$pdf->SetFont('arial','',7);
$pdf->AddPage();
$header = array('BAGED ID', 'NAMA', 'JABATAN', 'GAJI', 'WT', 'PT', 'NO. REKENING');
// Column widths
$w = array(20, 35, 35, 25, 10, 10, 30);
     		

$pdf->SetFont('','B',10);
$pdf->SetFillColor(224,224,224);//Grey
$pdf->Cell($w[0]+$w[1]+$w[2]+$w[3]+$w[4]+$w[5]+$w[6],6,"Summary Gaji DW Project $row_project[nama_project]",0,0,'C');
$pdf->Ln();
$pdf->SetFont('','',7);		
for($hi=0;$hi<count($header);$hi++) {
$pdf->Cell($w[$hi],6,$header[$hi],1,0,'C',1);		
}
$pdf->Ln();	  


//:::::::::::::::::::::::    PERULANGAN ALL KARYAWAN  :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
$GAJI_ALL=0; $WT_ALL=0; $PT_ALL=0;
while ($row_emp=mysqli_fetch_assoc($rs_emp)) 
{ 				
//::::::::::::::::::::::::::::::::::::::::::::::  PERULANGAN WAKTU DALAM SATU PERODE :::::::::::::::::::::::::::::::::::::::::::::::::
	$sql_wtpt="SELECT SUM(jam_ev) as WT, SUM(ot) as OT FROM pos_payroll_day
	WHERE emp_id='$row_emp[emp_id]' AND kd_periode=$row_archive[kd_periode] AND kd_project=$row_archive[kd_project]";
	$rs_wt_pt=mysqli_query($link, $sql_wtpt);
	$row_wtpt=mysqli_fetch_assoc($rs_wt_pt);
	$PT=$row_wtpt[WT] + $row_wtpt[OT];
	$GAJI=number_format($row_emp[tg_all],2,',','.');
			
			$pdf->Cell($w[0],$t_baris,$row_emp[emp_id],1,0,'C');
			$pdf->Cell($w[1],$t_baris,$row_emp[emp_name],1,0,'L');
			$pdf->Cell($w[2],$t_baris,$row_emp[jabatan],1,0,'L');
			$pdf->Cell($w[3],$t_baris,$GAJI,1,0,'R');
			$pdf->Cell($w[4],$t_baris,$row_wtpt[WT],1,0,'C');
			$pdf->Cell($w[5],$t_baris,$PT,1,0,'C');
			$pdf->Cell($w[6],$t_baris,$row_emp[no_rekening],1,0,'C');			
			$pdf->Ln();
				
	$GAJI_ALL=$GAJI_ALL + $row_emp[tg_all]; 
	$WT_ALL=$WT_ALL + $row_wtpt[WT]; 
	$PT_ALL= $PT_ALL + $PT;
} 
//:::::::::::::::::::::::::END OF PERULANGAN KARYAWAN :::::::::::::::::::::::::::::::::::::::::
				
		$GAJI_ALL2=number_format($GAJI_ALL,2,',','.');
		
		$pdf->Cell($w[0],$t_baris,'',0,0,'C');
		$pdf->Cell($w[1],$t_baris,'',0,0,'C');
		$pdf->SetFont('','B',7);
		$pdf->Cell($w[2],$t_baris,'Total',1,0,'C');		
		$pdf->Cell($w[3],$t_baris,$GAJI_ALL2,1,0,'R');
		$pdf->Cell($w[4],$t_baris,$WT_ALL,1,0,'C');
		$pdf->Cell($w[5],$t_baris,$PT_ALL,1,0,'C');
		$pdf->SetFont('','',7);
		$pdf->Cell($w[6],$t_baris,'',0,0,'C');
		$pdf->Ln();
		$pdf->Ln();
		
		//----------------------------------------
		$pdf->Cell(30,7,'',0,0,'C');//ADI
		$pdf->Cell(5,7,'',0,0,'C');
		$pdf->Cell(30,7,'',0,0,'C');//Hakim
		$pdf->Cell(5,7,'',0,0,'C');
		$pdf->Cell(30,7,'',0,0,'C');//EMIL
		$pdf->Cell(5,7,'',0,0,'C');
		
		$pdf->Cell(30,7,'',0,0,'C');//JOICE
		$pdf->Cell(5,7,'',0,0,'C');		
		$hari_ini=date("d M Y");
		$pdf->Cell(30,7,"Surabaya, $hari_ini",0,0,'C');//ANDRE
		$pdf->Ln();
		//--------------------------------------------
		//$pdf->Cell(30,7,'',0,0,'C');//ADI
		//$pdf->Cell(5,7,'',0,0,'C');
		//$pdf->Cell(30,7,'',0,0,'C');//Hakim
		//$pdf->Cell(5,7,'',0,0,'C');
		$pdf->Cell(100,7,'Acknowledge By,',0,0,'C');//EMIL
		//$pdf->Cell(5,7,'',0,0,'C');
		//$pdf->Cell(30,7,'',0,0,'C');//JOICE
		$pdf->Cell(5,7,'',0,0,'C');		
		$pdf->Cell(65,7,'Prepared By,',0,0,'C');//ANDRE
		$pdf->Ln();
		$pdf->Ln();
		$pdf->Ln();
		$pdf->Ln();
		//----------------------------------------
		/*$pdf->SetFont('','U','');
		$pdf->Cell(35,3,$row_archive[deputi],0,0,'C');
		$pdf->Cell(10,3,'',0,0,'C');
		$pdf->Cell(35,3,$row_archive[penanggung_jawab],0,0,'C');
		$pdf->Cell(10,3,'',0,0,'C');
		$pdf->Cell(35,3,$row_archive[hrd_manager],0,0,'C');
		$pdf->Cell(10,3,'',0,0,'C');
		$pdf->Cell(35,3,$row_archive[staff],0,0,'C');
		$pdf->Ln();
		*/
		$pdf->SetFont('','U','');
		$pdf->Cell(30,3,$row_archive[deputi],0,0,'C');
		$pdf->Cell(5,3,'',0,0,'C');
		$pdf->Cell(30,3,$row_archive[mng_operasional],0,0,'C');
		$pdf->Cell(5,3,'',0,0,'C');
		$pdf->Cell(30,3,$row_archive[penanggung_jawab],0,0,'C');
		$pdf->Cell(5,3,'',0,0,'C');
		
		$pdf->Cell(30,3,$row_archive[hrd_manager],0,0,'C');
		$pdf->Cell(5,3,'',0,0,'C');		
		$pdf->Cell(30,3,$row_archive[staff],0,0,'C');
		$pdf->Ln();
		//----------------------------------------
		$pdf->SetFont('','','');
		$pdf->Cell(30,3,'Deputy Administrative Operation',0,0,'C');
		$pdf->Cell(5,3,'',0,0,'C');
		$pdf->Cell(30,3,'Manager Operasional',0,0,'C');
		$pdf->Cell(5,3,'',0,0,'C');
		$pdf->Cell(30,3,$row_archive[jabatan_penanggung],0,0,'C');
		$pdf->Cell(5,3,'',0,0,'C');
		
		$pdf->Cell(30,3,'Manager HRD',0,0,'C');
		$pdf->Cell(5,3,'',0,0,'C');		
		$pdf->Cell(30,3,'Payroll HR',0,0,'C');
		$pdf->Ln();
		$pdf->Ln();
		//----------------------------------------
		$pdf->SetFont('','','');
		$pdf->Cell(45,7,'',0,0,'C');
		$pdf->Cell(80,7,'Approved By,',0,0,'C');
		$pdf->Cell(45,7,'',0,0,'C');		
		$pdf->Ln(20);
		//----------------------------------------
		$pdf->SetFont('','U','');
		$pdf->Cell(45,3,'',0,0,'C');
		$pdf->Cell(80,3,$row_archive[director],0,0,'C');
		$pdf->Cell(45,3,'',0,0,'C');		
		$pdf->Ln();
		//----------------------------------------
		$pdf->SetFont('','','');
		$pdf->Cell(45,3,'',0,0,'C');
		$pdf->Cell(80,3,'Director',0,0,'C');
		$pdf->Cell(45,3,'',0,0,'C');		
		$pdf->Ln();
		//----------------------------------------------
		$pdf->Output("Summary_$row_archive[nama_periode].pdf",'D');
		?>
		
		
		
