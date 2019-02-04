<?php 
require('./fpdf/fpdf.php');
# Koneksi 
require_once('connections/conn_mysqli_procedural.php');
require_once('include_class/employee/Employee.php');



//Variabel awal 
$kd_project=$_REQUEST['kd_project'];
$kd_periode=$_REQUEST['kd_periode'];

//select attribut payroll
$qry_attribut=mysqli_query($link, "select * from attribut_payroll");
$row_attribut=mysqli_fetch_assoc($qry_attribut);

//Data Employee
//$sql_emp="SELECT * FROM employee ";
$sql_emp="SELECT c.*, d.nama_jabatan, a.nama_project, a.luar_pulau 
FROM project a, ikut_project b, employee c, jabatan d
WHERE b.kd_project= a.kd_project
AND d.kd_jabatan=c.kd_jabatan
AND c.emp_id=b.emp_id
AND a.kd_project=$kd_project";
$rs_emp=mysqli_query($link, $sql_emp);
//---- end employeee-----------

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
$w = array(20, 40, 35, 25, 10, 10, 30);

$pdf->SetFont('','B',10);
$pdf->SetFillColor(224,224,224);//Grey
$pdf->Cell($w[0]+$w[1]+$w[2]+$w[3]+$w[4]+$w[5]+$w[6],6,"Summary Gaji DW Project $row_project[nama_project]",0,0,'C');
$pdf->Ln();
$pdf->SetFont('','',7);		
for($hi=0;$hi<count($header);$hi++) {
$pdf->Cell($w[$hi],6,$header[$hi],1,0,'C',1);		
}
$pdf->Ln();	  
$SUM_GJ_BERSIH=0;
$SUM_JE_BERSIH=0;
$SUM_JL_BERSIH=0;
$SUM_PT_BERSIH=0;
$GAJI_BERSIH=0;
//:::::::::::::::::::::::    PERULANGAN ALL KARYAWAN
$Emp= New Employee();
$GAJI_BERSIH=0;
$GAJI_ALL=0;
While ($row_emp=mysqli_fetch_assoc ($rs_emp)) {
	//SET EMPLOYEE		
	$Emp->setEmp($row_emp[emp_id], $row_emp[emp_name], $row_emp[pot_jamsos], $row_emp[gaji_pokok], $row_emp[t_insentif], $row_emp[t_masakerja], $row_emp[nama_jabatan], $row_emp[no_rekening], $row_emp[emp_group]);

	
	$Emp->Periode->setId($kd_periode);
	$rs_periode=mysqli_query($link, $Emp->Periode->sql_periode);
	$row_periode=mysqli_fetch_assoc ($rs_periode);
	$Emp->Periode->setPeriode($row_periode[tgl_awal], $row_periode[tgl_akhir], $row_periode[nama_periode], 
	$row_periode[potongan_jamsos]);
			
	//Menghitung Selisih hari periode 	
	$selisih=$Emp->Periode->SetSelisih();
	$Emp->Periode->tglIni($selisih);
	$SUM_GT=0;
	$SUM_GP=0;
	$SUM_GL=0;
	$SUM_TMSKER=0;
	$SUM_TJAM12=0;
	$SUM_SAFETY=0;
	$SUM_PT=0;
	$SUM_WT=0;
	//$tgl_ini=$row_periode[tgl_awal];		//::::::::::::::::::::::::::::::::::::::::::::::  PERULANGAN WAKTU DALAM SATU PERODE :::::::::::::::::::::::::::::::::::::::::::::::::
	for ($i=0;$i<=$selisih;$i++) { 
		//setting tanggal ini 
		$tgl_ini=$Emp->Periode->tgl_ini[$i];
		//-----------Tgl Libur -----------------
		$sql_libur="SELECT * FROM tanggal_libur WHERE kd_periode=$kd_periode AND tgl_libur='$tgl_ini'";
		$rs_libur=mysqli_query($link, $sql_libur);
		$numrow_libur=mysqli_num_rows($rs_libur);
		if ($numrow_libur>0) {
			$vlibur=1;
		}else {
			$vlibur=0;
		}
		//----------- end Libur ------------------
		//Menentukan nama Hari (SET TGL, AWAL, AKHIR)		
		$Emp->DayPeriode->setDay($tgl_ini, $Emp->Periode->tgl_awal, $Emp->Periode->tgl_akhir, $vlibur);
		//menentukan LOGIKA PERIODE
		$Emp->DayPeriode->logikaPeriode();
			
		//------------query office start - end work ---------------
		$logika_office=$Emp->DayPeriode->logika_periode;
		$emp_office=$Emp->emp_id;
		$qry_office="SELECT b. *
			FROM workshift a, workshift_detil b, set_workshift c
			WHERE c.emp_id='$emp_office' 
			AND a.id_workshift=c.id_workshift
			AND b.id_workshift=a.id_workshift
			AND b.logika='$logika_office'";
		$rs_office=mysqli_query($link, $qry_office);
		$row_office=mysqli_fetch_assoc($rs_office);
		$office_in=$row_office[office_in];
		$office_out=$row_office[office_out];
		//-----------e end query offfice start-end ------------
			
		//Data absensi per tanggal ini 
		$sql_absensi="SELECT * FROM absensi WHERE emp_id='$row_emp[emp_id]' AND tgl='$tgl_ini'";
		$rs_absensi=mysqli_query($link, $sql_absensi);
		$row_absensi=mysqli_fetch_assoc($rs_absensi);				
				
		//setting durasi
		$Emp->Durasi->setTime($office_in, $office_out, $row_absensi[jam_in], $row_absensi[jam_out], $Emp->DayPeriode->logika_periode);
		
		//Mencari jam evective
		$evektive_hour=$Emp->Durasi->getEvectiveHour();
		
		//SET VAR GAJI 
		$Emp->Gaji->setGaji($Emp->gaji_pokok, $Emp->Durasi->getEvectiveHour(), $Emp->Durasi->getOverTime(), $Emp->Durasi->getTolate(), $Emp->DayPeriode->logika_periode, $row_absensi[ket_absen]); 
	
		//SET TMSKER
		$Emp->Tunjangan->setTmasakerja($Emp->Durasi->getEvectiveHour(), $Emp->Durasi->getOverTime(), $Emp->tmasakerja, $Emp->DayPeriode->logika_periode);
		
		//SET TJAM12
		$emp_ijam=$Emp->emp_id;
		$sql_tjam12="SELECT * FROM insentif_overjam WHERE 
		emp_id= '$emp_ijam'
		AND tgl_ijam='$tgl_ini'";
		$rs_tjam12=mysqli_query($link, $sql_tjam12);
		$row_tjam12=mysqli_fetch_assoc ($rs_tjam12);
		$tjam12=mysqli_num_rows($rs_tjam12);
		$Emp->Tjam->setTunjangan($tjam12, $Emp->tjam12);
		//---------------------------------
					
		//Kasbon 
		$sql_kasbon="
		SELECT a.*, a.jml_kasbon - SUM(jml_cicilan) as sisa
		FROM kasbon a, cicilan_kasbon b
		WHERE b.kd_kasbon=a.kd_kasbon AND a.emp_id='$Emp->emp_id' AND a.status=1 
		";		
		$rs_kasbon=mysqli_query($link, $sql_kasbon);
		$row_kasbon=mysqli_fetch_assoc ($rs_kasbon);
			
		$sql_cicil="SELECT * FROM cicilan_kasbon WHERE kd_kasbon='$row_kasbon[kd_kasbon]' AND kd_periode='$kd_periode'";
		$rs_cicil=mysqli_query($link, $sql_cicil);
		$row_cicil=mysqli_fetch_assoc ($rs_cicil);		
		$Emp->Kasbon->setKasbon($row_kasbon[kd_kasbon], $row_kasbon[emp_id], $row_kasbon[tgl], $row_kasbon[ket], $row_kasbon[jml_kasbon], $row_kasbon[status], $row_kasbon[sisa], $row_cicil[jml_cicilan]);
		//---- end Kasbon----------
		//---- Safety Talk -----
		$sql_safety="select * from safety_talk where emp_id='$Emp->emp_id' AND  tgl_safety='$tgl_ini'";
		$Emp->Safety->setdb($db, $sql_safety, $Emp->DayPeriode->logika_periode);
		//---- End afety -----				
				
		if ( $Emp->DayPeriode->logika_periode=="sabtu") {
			$gp=$Emp->gaji_pokok/5;
			//$gp=$Emp->gaji_pokok;
		} else {
			$gp=$Emp->gaji_pokok/7;
			//$gp=$Emp->gaji_pokok;
		}
				
		//SET GRAND TOTAL 
		$Emp->Grandtotal->setGrandtotal($Emp->Gaji->gajiPokok(),$Emp->Gaji->gajiLembur(), $Emp->Tjam->getTunjangan(), $Emp->Tunjangan->getTmasakerja(), $Emp->Gaji->gajiTelat(), $Emp->Safety->getPotongan(),$row_absensi[ket_absen], $Emp->gaji_pokok, $Emp->DayPeriode->logika_periode);
	
		$GT=$Emp->Grandtotal->getGrandtotal();
		$SUM_GT=$SUM_GT+$GT;
		$SUM_WT=$SUM_WT+$Emp->Durasi->evective_hour;
		$SUM_PT=$SUM_PT+$Emp->Durasi->getEvectiveHour()+$Emp->Durasi->getOverTime();
		$SUM_GP=$SUM_GP+$Emp->Gaji->gajiPokok();
		$SUM_GL=$SUM_GL+$Emp->Gaji->gajiLembur();
		$SUM_TMSKER=$SUM_TMSKER+$Emp->Tunjangan->getTmasakerja();
		$SUM_TJAM12=$SUM_TJAM12+$Emp->Tjam->getTunjangan();
		$SUM_SAFETY=$SUM_SAFETY+$Emp->Safety->getPotongan();
	}
	//::::::::::::END OF PERIODE ::::::::::::::::
	//::::::::::::::TOTAL GAJI ::::::::::::::::::
	//---- Jamsostek -----
	$sql_jamsostek="SELECT * FROM jamsostek WHERE emp_id='$Emp->emp_id' AND kd_periode='$kd_periode'";
	$Emp->Jamsostek->setdb($db, $sql_jamsostek);
	//----- end jamsostek -----
	
	//----- Plusmin -----
	$sql_plusmin="SELECT SUM(jml_plus) as jml_plus, sum(jml_min) as jml_min FROM plusmin_gaji WHERE emp_id='$Emp->emp_id' AND kd_periode='$kd_periode'";
	$Emp->Plusmin->setdbPlusmin($db, $sql_plusmin);
	//----- End Plusmin -----
		
	$GAJI_BERSIH=($SUM_GT + $Emp->Plusmin->getPlus())-($Emp->Kasbon->jml_cicil + $Emp->Jamsostek->getPotongan()+$Emp->Plusmin->getMin());
	$GAJI_BERSIH_P="Rp. ".number_format($GAJI_BERSIH, 2, ',', '.');	
			
	$pdf->Cell($w[0],$t_baris,$Emp->emp_id,1,0,'C');
	$pdf->Cell($w[1],$t_baris,$Emp->emp_name,1,0,'L');
	$pdf->Cell($w[2],$t_baris,$Emp->jabatan,1,0,'L');
	$pdf->Cell($w[3],$t_baris,$GAJI_BERSIH_P,1,0,'R');
	$pdf->Cell($w[4],$t_baris,$SUM_WT,1,0,'C');
	$pdf->Cell($w[5],$t_baris,$SUM_PT,1,0,'C');
	$pdf->Cell($w[6],$t_baris,$Emp->norekening,1,0,'C');			
	$pdf->Ln();
	
	$GAJI_ALL=$GAJI_ALL + $GAJI_BERSIH;	$GAJI_ALL_P="Rp. ".number_format($GAJI_ALL, 2, ',', '.');
	$SUM_WT_ALL=$SUM_WT_ALL+$SUM_WT;
	$SUM_PT_ALL=$SUM_PT_ALL+$SUM_PT;	
} 
//:::::::::::::::::::::::::END OF PERULANGAN KARYAWAN :::::::::::::::::::::::::::::::::::::::::
	
$SUM_GJ_BERSIH2=number_format($SUM_GJ_BERSIH,2,',','.');
//$SUM_JE_BERSIH2=number_format($SUM_JE_BERSIH,2,',','.');
//$SUM_PT_BERSIH2=number_format($SUM_PT_BERSIH,2,',','.');
$pdf->Cell($w[0],$t_baris,'',0,0,'C');
$pdf->Cell($w[1],$t_baris,'',0,0,'C');
$pdf->SetFont('','B',7);
$pdf->Cell($w[2],$t_baris,'Total',1,0,'C');		
$pdf->Cell($w[3],$t_baris,$GAJI_ALL_P,1,0,'R');
$pdf->Cell($w[4],$t_baris,$SUM_WT_ALL,1,0,'C');
$pdf->Cell($w[5],$t_baris,$SUM_PT_ALL,1,0,'C');
$pdf->SetFont('','',7);
$pdf->Cell($w[6],$t_baris,'',0,0,'C');
$pdf->Ln();
$pdf->Ln();

//----------------------------------------
$pdf->Cell(35,7,'',0,0,'C');//ADI
$pdf->Cell(10,7,'',0,0,'C');
$pdf->Cell(35,7,'',0,0,'C');//EMIL
$pdf->Cell(10,7,'',0,0,'C');
$pdf->Cell(35,7,'',0,0,'C');//JOICE
$pdf->Cell(10,7,'',0,0,'C');$hari_ini=date("d M Y");
$pdf->Cell(35,7,"Surabaya, $hari_ini",0,0,'C');//ANDRE
$pdf->Ln();
//--------------------------------------------
$pdf->Cell(35,7,'',0,0,'C');//ADI
$pdf->Cell(10,7,'',0,0,'C');
$pdf->Cell(35,7,'Acknowledge By,',0,0,'C');//EMIL
$pdf->Cell(10,7,'',0,0,'C');
$pdf->Cell(35,7,'',0,0,'C');//JOICE
$pdf->Cell(10,7,'',0,0,'C');
$pdf->Cell(35,7,'Prepared By,',0,0,'C');//ANDRE
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
//----------------------------------------
$pdf->SetFont('','U','');
$pdf->Cell(35,3,'ADI IRMANTYO',0,0,'C');
$pdf->Cell(10,3,'',0,0,'C');
$pdf->Cell(35,3,$row_project[penanggungjawab],0,0,'C');
$pdf->Cell(10,3,'',0,0,'C');
$pdf->Cell(35,3, $row_attribut[hrd_manager],0,0,'C');
$pdf->Cell(10,3,'',0,0,'C');
$pdf->Cell(35,3,$row_attribut[nama_staff],0,0,'C');
$pdf->Ln();
//----------------------------------------
$pdf->SetFont('','','');
$pdf->Cell(35,3,'Deputi Administrative Operation',0,0,'C');
$pdf->Cell(10,3,'',0,0,'C');
$pdf->Cell(35,3,$row_project[jabatan],0,0,'C');
$pdf->Cell(10,3,'',0,0,'C');
$pdf->Cell(35,3,'Manager HRD',0,0,'C');
$pdf->Cell(10,3,'',0,0,'C');
$pdf->Cell(35,3,'Payroll HR',0,0,'C');
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
$pdf->Cell(80,3,'LION MOEDJIONO / NURUL KAHIR,',0,0,'C');
$pdf->Cell(45,3,'',0,0,'C');		
$pdf->Ln();
//----------------------------------------
$pdf->SetFont('','','');
$pdf->Cell(45,3,'',0,0,'C');
$pdf->Cell(80,3,'Director',0,0,'C');
$pdf->Cell(45,3,'',0,0,'C');		
$pdf->Ln();
//----------------------------------------------
$pdf->Output("Summary_$row_periode[nama_periode].pdf",'D');
?>
		
		
		
