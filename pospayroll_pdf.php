<?php
//define('FPDF_FONTPATH','/fpdf/font');
require('./fpdf/fpdf.php');
require_once('connections/conn_mysqli_procedural.php');



//SEELCT ARCHIVE
$sql_periode="SELECT * FROM pos_archive WHERE kd_periode='$_REQUEST[kd_periode]' AND kd_project='$_REQUEST[kd_project]'";
$rs_periode=mysqli_query($link, $sql_periode) or die(mysqli_error($link));
$row_periode=mysqli_fetch_assoc($rs_periode);

//SELECT employee & payroll
$sql_emp = "SELECT * FROM pos_payroll WHERE kd_periode='$_REQUEST[kd_periode]' AND kd_project='$_REQUEST[kd_project]'";
$rs_emp = mysqli_query($link, $sql_emp) or die(mysqli_error($link));


class PDF extends FPDF { }

$pdf=new PDF('P','mm','A4');
$pdf->SetMargins(5,5,5);
$pdf->SetFillColor(224,224,224);//Grey
//$pdf->SetTopMargin(10);
//$pdf->SetButtomMargin(10);
$t_baris=2.5;//tinggi baris
$pdf->SetFont('courier','',6);
$pdf->AddPage();
$header = array('Tanggal', 'Hari', 'GP/jam', 'EV', 'OT', 'Gj.Pokok', 'Gj.Lmbr', 'T. Jam12', 'T. Msker', 'P.Telat', 'P.Safety', 'Total');
// Column widths
$w = array(16, 15, 15, 6, 6, 20, 20, 20, 20, 20, 20, 20);
//select attribut payroll
$qry_attribut=mysqli_query($link, "select * from attribut_payroll");
$row_attribut=mysqli_fetch_assoc($qry_attribut);

		
		//:::::::::::::::::::::::    PERULANGAN ALL KARYAWAN  :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
		$page==0;
		while ($row_emp=mysqli_fetch_assoc($rs_emp)) { 		
		$emp_id=$row_emp[emp_id];
		$pdf->SetFont('','B','');
		$pdf->Cell($w[0]+$w[1],$t_baris,"Nama    : $row_emp[emp_name]",1,0,'L',1);
		$pdf->SetFont('','B','');
		$pdf->Cell($w[2]+$w[3]+$w[4]+$w[5]+$w[6]+$w[7]+$w[8]+$w[9],$t_baris+$t_baris,"SLIP GAJI MANPOWER $row_periode[nama_project]",1,0,'C',1);
		$pdf->SetFont('','B','');
		$pdf->Cell($w[10]+$w[11],$t_baris,"$row_periode[nama_periode]",1,0,'R',1);
		$pdf->Ln();
		$pdf->Cell($w[0]+$w[1],$t_baris,"Jabatan : $row_emp[jabatan]",1,0,'L',1);		
		$pdf->Cell($w[2]+$w[3]+$w[4]+$w[5]+$w[6]+$w[7]+$w[8]+$w[9],0,'',0,0,'C');
		$pdf->Cell($w[10]+$w[11],$t_baris,"NIK : $row_emp[emp_id]",1,0,'R',1);
		$pdf->Ln();
		$pdf->SetFont('','','');
		for($hi=0;$hi<count($header);$hi++) {
		$pdf->Cell($w[$hi],$t_baris,$header[$hi],1,0,'C');		
		}
		$pdf->Ln();
		
		//::::::::::::::::::::::::::::::::::::::::::::::  PERULANGAN WAKTU DALAM SATU PERODE :::::::::::::::::::::::::::::::::::::::::::::::::
		
		//Definisi awal 
			$WT=0;
			$PT=0;
			$SUM_WT=0;
			$SUM_PT=0;
			$SUM_GP=0;
			$SUM_GL=0;
			$SUM_UM= 0;			
			$SUM_TG=0;
			$SUM_TMSKER=0;
			$SUM_TJAM12=0;
			$SUM_P_TELAT= 0;	
			$SUM_P_SAFETY= 0;				
			$SUM_TG=0;
			
		//-------------------------------------------
		
		$sql_posDetil= "SELECT * FROM pos_payroll_day WHERE kd_periode='$_REQUEST[kd_periode]' AND kd_project= '$_REQUEST[kd_project]'
							AND emp_id='$row_emp[emp_id]'";
		
		$rs_posDetil= mysqli_query($link, $sql_posDetil) or die(mysqli_error($link));
		while ($row_posDetil=mysqli_fetch_assoc($rs_posDetil)) 
		{ 	
			
			$GP2=number_format($row_posDetil[gp],2,',','.');
			$GL2=number_format($row_posDetil[gl],2,',','.');
			$UM2=number_format($row_posDetil[um],2,',','.');
			$potongan_telat2=number_format($row_posDetil[pot_tel],2,',','.');
			$p_safety2=number_format($row_posDetil[p_safety],2,',','.');
			$t_msker2=number_format($row_posDetil[t_msker],2,',','.');
			$GT2=number_format($row_posDetil[tg],2,',','.');
			$pdf->SetFont('','','');
			$pdf->Cell($w[0],$t_baris,$row_posDetil[hari],1,0,'L');
			$pdf->Cell($w[1],$t_baris,$row_posDetil[tgl],1,0,'C');
			$pdf->Cell($w[2],$t_baris,ceil($row_posDetil[g_perjam]),1,0,'R');
			$pdf->Cell($w[3],$t_baris,$row_posDetil[jam_ev],1,0,'C');			
			$pdf->Cell($w[4],$t_baris,$row_posDetil[ot],1,0,'C');
			$pdf->Cell($w[5],$t_baris,$GP2,1,0,'R');
			$pdf->Cell($w[6],$t_baris,$GL2,1,0,'R');
			$pdf->Cell($w[7],$t_baris,$t_jam12,1,0,'R');
			$pdf->Cell($w[8],$t_baris,$t_msker2,1,0,'R');
			$pdf->Cell($w[9],$t_baris,$potongan_telat2,1,0,'R');
			$pdf->Cell($w[10],$t_baris,$p_safety2,1,0,'R');
			$pdf->Cell($w[11],$t_baris,$GT2,1,0,'R');
			$pdf->Ln();
			
			$WT=$row_posDetil[jam_ev]+$wt;
			$PT=$pt+$row_posDetil[jam_ev]+$row_posDetil[ot];
			$SUM_WT=$SUM_WT+$WT;
			$SUM_PT=$SUM_PT+$PT;
			$SUM_GP=$SUM_GP+$row_posDetil[gp];
			$SUM_GL=$SUM_GL+$row_posDetil[gl];
			$SUM_TJAM12=$SUM_JAM12+$row_posDetil[t_jam12];
			$SUM_TMSKER=$SUM_TMSKER+$row_posDetil[t_msker];
			$SUM_P_TELAT= $SUM_P_TELAT+$row_posDetil[pot_tel];	
			$SUM_P_SAFETY= $SUM_P_SAFETY+$row_posDetil[p_safety];				
			$SUM_TG=$SUM_TG+$row_posDetil[tg];	
			
		} 
		$sql_posPay= "SELECT * FROM pos_payroll WHERE kd_periode='$_REQUEST[kd_periode]' AND kd_project= '$_REQUEST[kd_project]'
							AND emp_id='$row_emp[emp_id]'";
		$rs_posPay= mysqli_query($link, $sql_posPay) or die(mysqli_error($link));
		$row_posPay=mysqli_fetch_assoc($rs_posPay);
		//:::::::::::::::::::::::::::::::::::::::::::::::::::: END OF PERIODE ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
		
				
		$SUM_GP2="Rp.".number_format($SUM_GP, 2, ',', '.');
		$SUM_GL2="RP.".number_format($SUM_GL, 2, ',', '.');
		$SUM_UM2="Rp.".number_format($SUM_UM, 2, ',', '.');
		$SUM_GT2="Rp.".number_format($SUM_TG, 2, ',', '.');
		
		$jml_kasbon2= "Rp.".number_format($row_emp[kasbon], 2, ',', '.');
		$jml_cicilan2 = "Rp.".number_format($row_emp[cicil_kasbon], 2, ',', '.');
		$saldo2 = "Rp.".number_format($row_emp[sisa_kasbon], 2, ',', '.');
		$pot_jamsos2 = "Rp.".number_format($row_emp[jamsos], 2, ',', '.');
		$SUM_TJAB2 = "Rp.".number_format($row_emp[t_jab], 2, ',', '.');
		$SUM_TJAM122 = "Rp.".number_format($SUM_TJAM12, 2, ',', '.');
		$SUM_TMSKER2 = "Rp.".number_format($SUM_TMSKER, 2, ',', '.');
		$SUM_P_SAFETY2 = "Rp.".number_format($SUM_P_SAFETY, 2, ',', '.');
		$SUM_P_TELAT2 = "Rp.".number_format($SUM_P_TELAT, 2, ',', '.');
		$jml_plus2 = "Rp.".number_format($row_posPay[over_gaji], 2, ',', '.');
		$jml_min2 = "Rp.".number_format($row_posPay[def_gaji], 2, ',', '.');
		$jml_ijam2 = "Rp.".number_format($row_emp[i_jam], 2, ',', '.');
		$jml_ium= "Rp.".number_format($row_emp[i_um], 2, ',', '.');
		$GAJI_BERSIH2 = "Rp.".number_format($row_emp[tg_all], 2, ',', '.');
		
		
		
		$pdf->Cell($w[0]+$w[1],$t_baris,'Jumlah',1,0,'L',1);//jumlah
		$pdf->Cell($w[2],$t_baris,'WT/PT',1,0,'L',1);
		$pdf->Cell($w[3],$t_baris,$SUM_WT,1,0,'C',1);
		
		$pdf->Cell($w[4],$t_baris,$SUM_PT,1,0,'C',1);
		$pdf->Cell($w[5],$t_baris,$SUM_GP2,1,0,'R',1);
		$pdf->Cell($w[6],$t_baris,$SUM_GL2,1,0,'R',1);
		$pdf->Cell($w[7],$t_baris,$SUM_TJAM122,1,0,'R',1);
		$pdf->Cell($w[8],$t_baris,$SUM_TMSKER2,1,0,'R',1);
		$pdf->Cell($w[9],$t_baris,$SUM_P_TELAT2,1,0,'R',1);
		$pdf->Cell($w[10],$t_baris,$SUM_P_SAFETY2,1,0,'R',1);		
		$pdf->Cell($w[11],$t_baris,$SUM_GT2,1,0,'R',1);
		$pdf->Ln();		
		$pdf->Cell($w[0]+$w[1]+$w[2]+$w[3]+$w[4]+$w[5]+$w[6],$t_baris,'',0,0,'C');
		$pdf->Cell($w[7],$t_baris,'Kasbon',1,0,'L');
		$pdf->Cell($w[8],$t_baris,$jml_kasbon2,1,0,'R');
		$pdf->Cell($w[9]+$w[10],$t_baris,'Cicilan kasbon',1,0,'L');
		$pdf->Cell($w[11],$t_baris,$jml_cicilan2,1,0,'R');
		$pdf->Ln();		
		$pdf->Cell($w[0]+$w[1]+$w[2]+$w[3]+$w[4]+$w[5]+$w[6],$t_baris,'',0,0,'C');
		$pdf->Cell($w[7],$t_baris,'Sisa Kasbon',1,0,'L');
		$pdf->Cell($w[8],$t_baris,$saldo2,1,0,'R');
		$pdf->Cell($w[9]+$w[10],$t_baris,'Jamsostek',1,0,'L');
		$pdf->Cell($w[11],$t_baris,$pot_jamsos2,1,0,'R');
		$pdf->Ln();				
		
		$pdf->Cell($w[0]+$w[1]+$w[2]+$w[3]+$w[4]+$w[5]+$w[6]+$w[7]+$w[8],$t_baris,'',0,0,'C');
		$pdf->Cell($w[9]+$w[10],$t_baris,'Kelebihan Gaji',1,0,'L');
		$pdf->Cell($w[11],$t_baris,$jml_plus2,1,0,'R');
		$pdf->Ln();
		$pdf->Cell($w[0]+$w[1]+$w[2]+$w[3]+$w[4]+$w[5]+$w[6]+$w[7]+$w[8],$t_baris,'',0,0,'C');
		$pdf->Cell($w[9]+$w[10],$t_baris,'Kekurangan Gaji',1,0,'L');
		$pdf->Cell($w[11],$t_baris,$jml_min2,1,0,'R');
		$pdf->Ln();	
		
						
	
		
		$pdf->Cell($w[0]+$w[1]+$w[2]+$w[3]+$w[4]+$w[5]+$w[6]+$w[7]+$w[8],$t_baris,'',0,0,'C');
		$pdf->Cell($w[9]+$w[10],$t_baris,'Total Gaji',1,0,'L',1);
		$pdf->Cell($w[11],$t_baris,$GAJI_BERSIH2,1,0,'R',1);
		$pdf->Ln();		
		$pdf->Ln();
		$pdf->Ln();
		//MultiCell(float w, float h, string txt [, mixed border [, string align [, boolean fill]]];
		//Line(float x1, float y1, float x2, float y2);
		//$pdf->MultiCell( 170, 1,'',1,'');
		$page++;
		if ($page%4==0)
		$pdf->AddPage();		
		}			
 //------------------
$pdf->Output("$row_periode[nama_periode].pdf",'D');

?>