<?php
//define('FPDF_FONTPATH','/fpdf/font');
require('./fpdf/fpdf.php');

require_once('connections/CConnect.php');
require_once('/include_class/employee/Employee.php');

$db=New Database();
$db->Connect();

// Kd Periode & kd_project 
$kd_periode= $_REQUEST[kd_periode];
$kd_project= $_REQUEST[kd_project];

//Data Employee $sql_emp="SELECT * FROM employee ";
$sql_emp="SELECT c.*, d.nama_jabatan, a.nama_project, a.luar_pulau 
FROM project a, ikut_project b, employee c, jabatan d
WHERE b.kd_project= a.kd_project
AND d.kd_jabatan=c.kd_jabatan
AND c.emp_id=b.emp_id
AND a.kd_project=$kd_project";
$rs_emp=$db->query($sql_emp);


$sql_periode="SELECT * FROM PERIODE WHERE kd_periode='$kd_periode'";
$rs_periode=$db->query($sql_periode);
$row_periode=$db->fetch_array($rs_periode);
//------------------- end --------------------

class PDF extends FPDF { }

$pdf=new PDF('P','mm','A4');
$pdf->SetMargins(5,5,5);
$pdf->SetFillColor(224,224,224);//Grey
//$pdf->SetTopMargin(10);
//$pdf->SetButtomMargin(10);
$t_baris=2.5;//tinggi baris
$pdf->SetFont('courier','',6);
$pdf->AddPage();
$header = array('Tanggal', 'Hari', 'GP/jam', 'EV', 'OT', 'Gj.Pokok', 'Gj.Lmbr', 'P.Telat', 'T.Msker', 'T.JAM12', 'P.Safety', 'Total');
// Column widths
$w = array(16, 15, 15, 6, 6, 20, 20, 20, 20, 20, 20, 20);
//---------------------

//select attribut payroll
$qry_attribut=mysql_query("select * from attribut_payroll");
$row_attribut=mysql_fetch_array($qry_attribut);

		//:::::::::::::::::::::::    PERULANGAN ALL KARYAWAN  :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
		$page==0;
		$Emp= New Employee();
		While ($row_emp=$db->fetch_array($rs_emp)) {
		
		//SET EMPLOYEE		
		$Emp->setEmp($row_emp[emp_id], $row_emp[emp_name], $row_emp[pot_jamsos], $row_emp[gaji_pokok], $row_emp[t_insentif], $row_emp[t_masakerja], $row_emp[nama_jabatan], $row_emp[no_rekening], $row_emp[emp_group]);
		
		$GAJI_BERSIH=0;
		$emp_id=$row_emp[emp_id];
		$pdf->SetFont('','B','');
		$pdf->Cell($w[0]+$w[1],$t_baris,"Nama    : $Emp->emp_name",1,0,'L',1);
		$pdf->SetFont('','B','');
		$pdf->Cell($w[2]+$w[3]+$w[4]+$w[5]+$w[6]+$w[7]+$w[8]+$w[9],$t_baris+$t_baris,"SLIP GAJI MANPOWER $row_emp[nama_project]",1,0,'C',1);
		$pdf->SetFont('','B','');
		$pdf->Cell($w[10]+$w[11],$t_baris,"$row_periode[nama_periode]",1,0,'R',1);
		$pdf->Ln();
		$pdf->Cell($w[0]+$w[1],$t_baris,"Jabatan : $Emp->jabatan",1,0,'L',1);		
		$pdf->Cell($w[2]+$w[3]+$w[4]+$w[5]+$w[6]+$w[7]+$w[8]+$w[9],0,'',0,0,'C');
		$pdf->Cell($w[10]+$w[11],$t_baris,"NIK : $Emp->emp_id",1,0,'R',1);
		$pdf->Ln();
		$pdf->SetFont('','','');
		for($hi=0;$hi<count($header);$hi++) {
		$pdf->Cell($w[$hi],$t_baris,$header[$hi],1,0,'C');
		
		}
		$pdf->Ln();
		
		$Emp->Periode->setId($kd_periode);
		$rs_periode=$db->query($Emp->Periode->sql_periode);
		$row_periode=$db->fetch_array($rs_periode);
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
		$SUM_PSAFETY=0;
		$SUM_PTELAT=0;
		$SUM_PT=0;
		$SUM_WT=0;			
		//---------------------------------
		
		//Perulangan payroll sesuai tanggal		
		//::::::::::::::::::::::::::::::::::::::::::::::  PERULANGAN WAKTU DALAM SATU PERODE :::::::::::::::::::::::::::::::::::::::::::::::::
		for ($i=0;$i<=$selisih;$i++) { 
			
			//setting tanggal ini 
			$tgl_ini=$Emp->Periode->tgl_ini[$i];
			//-----------Tgl Libur -----------------
			$sql_libur="SELECT * FROM tanggal_libur WHERE kd_periode=$kd_periode AND tgl_libur='$tgl_ini'";
			$rs_libur=$db->query($sql_libur);
			$numrow_libur=$db->num_rows($rs_libur);
			if ($numrow_libur>0) {
				$vlibur=1;
			}else {
				$vlibur=0;
			}
			//----------- end Libur ------------------
			//Menentukan nama Hari (SET TGL, AWAL, AKHIR)
			//$Emp->DayPeriode->setDay($tgl_ini, $Emp->Periode->tgl_awal, $Emp->Periode->tgl_akhir);
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
			$rs_office=$db->query($qry_office);
			$row_office=$db->fetch_array($rs_office);
			$office_in=$row_office[office_in];
			$office_out=$row_office[office_out];
			//-----------e end query offfice start-end ------------
			
			//SEELECT ABSENSI per tanggal ini 
			$sql_absensi="SELECT * FROM absensi WHERE emp_id='$row_emp[emp_id]' AND tgl='$tgl_ini'";
			$rs_absensi=$db->query($sql_absensi);
			$row_absensi=$db->fetch_array($rs_absensi);				
			
			//SET TJAM12
			$emp_ijam=$Emp->emp_id;
			$sql_tjam12="SELECT * FROM insentif_overjam WHERE 
			emp_id= '$emp_ijam'
			AND tgl_ijam='$tgl_ini'";
			$rs_tjam12=$db->query($sql_tjam12);
			$row_tjam12=$db->fetch_array($rs_tjam12);
			$tjam12=$db->num_rows($rs_tjam12);
			$Emp->Tjam->setTunjangan($tjam12, $Emp->tjam12);
			//---------------------------------
			
			//setting durasi
			$Emp->Durasi->setTime($office_in, $office_out, $row_absensi[jam_in], $row_absensi[jam_out], $Emp->DayPeriode->logika_periode);
			//$Emp->Durasi->setTime($office_in, $office_out, $row_absensi[jam_in], $row_absensi[jam_out], $Emp->DayPeriode->logika_periode);
			
			//Mencari jam evective
			$evektive_hour=$Emp->Durasi->getEvectiveHour();
			
			//SET VAR GAJI 
			$Emp->Gaji->setGaji($Emp->gaji_pokok, $Emp->Durasi->getEvectiveHour(), $Emp->Durasi->getOverTime(), $Emp->Durasi->getTolate(), $Emp->DayPeriode->logika_periode, $row_absensi[ket_absen]); 
			//$Emp->Gaji->setGaji($Emp->gaji_pokok, $Emp->Durasi->getEvectiveHour(), $Emp->Durasi->getOverTime(), $Emp->Durasi->getTolate(), $Emp->DayPeriode->logika_periode); 
			
			//SET TMSKER
			$Emp->Tunjangan->setTmasakerja($Emp->Durasi->getEvectiveHour(), $Emp->Durasi->getOverTime(), $Emp->tmasakerja, $Emp->DayPeriode->logika_periode);
			
			//Kasbon 
			$sql_kasbon="
			SELECT a.*, a.jml_kasbon - SUM(jml_cicilan) as sisa
			FROM kasbon a, cicilan_kasbon b
			WHERE b.kd_kasbon=a.kd_kasbon AND a.emp_id='$Emp->emp_id' AND a.status=1 
			";		
			$rs_kasbon=$db->query($sql_kasbon);
			$row_kasbon=$db->fetch_array($rs_kasbon);
			
			$sql_cicil="SELECT * FROM cicilan_kasbon WHERE kd_kasbon='$row_kasbon[kd_kasbon]' AND kd_periode=$kd_periode";
			$rs_cicil=$db->query($sql_cicil);
			$row_cicil=$db->fetch_array($rs_cicil);		
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
			
			$GPJAM_P=number_format($gp,2,',','.');// GP/Jam
			$GT_P= number_format($Emp->Grandtotal->getGrandtotal(), 2, '.', ',');
			$GP_P= number_format($Emp->Gaji->gajiPokok(), 2, ',', '.');
			$GL_P= number_format($Emp->Gaji->gajiLembur(), 2, ',', '.');
			$TMSKER_P= number_format($Emp->Tunjangan->getTmasakerja(), 2, ',', '.');
			$TJAM12_P= number_format($Emp->Tjam->getTunjangan(), 2, ',', '.');
			$PSAFETY_P= number_format($Emp->Safety->getPotongan(), 2, ',', '.');
			$PTELAT_P= number_format($Emp->Gaji->gajiTelat(), 2, ',', '.');
			
			$GT=$Emp->Grandtotal->getGrandtotal();
			$SUM_GT=$SUM_GT+$GT;
			$SUM_WT=$SUM_WT+$Emp->Durasi->evective_hour;
			$SUM_PT=$SUM_PT+$Emp->Durasi->evective_hour+$Emp->Durasi->getOverTime();
			$SUM_GP=$SUM_GP+$Emp->Gaji->gajiPokok();
			$SUM_GL=$SUM_GL+$Emp->Gaji->gajiLembur();
			$SUM_TMSKER= $SUM_TMSKER+ $Emp->Tunjangan->getTmasakerja();
			$SUM_TJAM12=$SUM_TJAM12+$Emp->Tjam->getTunjangan();
			$SUM_PSAFETY= $SUM_PSAFETY+ $Emp->Safety->getPotongan();
			$SUM_PTELAT= $SUM_PTELAT+ $Emp->Gaji->gajiTelat();
		
			//$tgl_ini, $jam_ev, round($gaji_pokok), $jam_lembur, $GP, $GL, $UM, $potongan_telat, $GT
			
				/*$GL2=number_format($GL,2,',','.');
			$UM2=number_format($UM,2,',','.');
			$potongan_telat2=number_format($potongan_telat,2,',','.');
			$GT2=number_format($GT,2,',','.');*/
			if ($row_absensi[ket_absen]) $GT2=$row_absensi[ket_absen];
			else {
				$GT2=number_format($GT, 2, ',', '.');
			}
			$pdf->SetFont('','','');
			$pdf->Cell($w[0],$t_baris,$Emp->Periode->tgl_ini[$i],1,0,'L');//tgl
			$pdf->Cell($w[1],$t_baris,$Emp->DayPeriode->getDay(),1,0,'C');//Hari $Emp->DayPeriode->getDay()
			$pdf->Cell($w[2],$t_baris,$GPJAM_P,1,0,'R');//Gaji /jam
			$pdf->Cell($w[3],$t_baris,$Emp->Durasi->getEvectiveHour(),1,0,'R');//JAM EV
			$pdf->Cell($w[4],$t_baris,$Emp->Durasi->getOverTime(),1,0,'C');//JAM OT
			$pdf->Cell($w[5],$t_baris, $GP_P,1,0,'R');//GP
			$pdf->Cell($w[6],$t_baris, $GL_P,1,0,'R');//GL
			$pdf->Cell($w[7],$t_baris,$PTELAT_P,1,0,'R');//P. TELAT
			$pdf->Cell($w[8],$t_baris,$TMSKER_P,1,0,'R');//T. MSKER
			$pdf->Cell($w[9],$t_baris,$TJAM12_P,1,0,'R');//T. JAM12
			$pdf->Cell($w[10],$t_baris,$PSAFETY_P,1,0,'R');//P. SAFETY
			$pdf->Cell($w[11],$t_baris,$GT_P,1,0,'R');//G. TOTAL
			$pdf->Ln();
		} 
		
		//---- Jamsostek -----
			$sql_jamsostek="SELECT * FROM jamsostek WHERE emp_id='$Emp->emp_id' AND kd_periode='$kd_periode'";
			$Emp->Jamsostek->setdb($db, $sql_jamsostek);
			//----- end jamsostek -----		
		//----- Plusmin -----
		$sql_plusmin="SELECT SUM(jml_plus) as jml_plus, sum(jml_min) as jml_min FROM plusmin_gaji WHERE emp_id='$Emp->emp_id' AND kd_periode='$kd_periode'";
		$Emp->Plusmin->setdbPlusmin($db, $sql_plusmin);
		//----- End Plusmin -----
		
		$GAJI_BERSIH=($SUM_GT + $Emp->Plusmin->getPlus())-($Emp->Kasbon->jml_cicil + $Emp->Jamsostek->getPotongan()+$Emp->Plusmin->getMin());
		
		
		
		$SUM_GP_P="Rp.".number_format($SUM_GP, 2, ',', '.');
		$SUM_GL_P="RP.".number_format($SUM_GL, 2, ',', '.');
		
		$SUM_GT_P="Rp.".number_format($SUM_GT, 2, ',', '.');
		
		$KASBON_P= "Rp.".number_format($Emp->Kasbon->jml_kasbon,2,',','.');
		$KASBONCICILAN_P = "Rp.".number_format($Emp->Kasbon->jml_cicil,2, ',', '.');
		$KASBONSALDO_P = "Rp.".number_format($Emp->Kasbon->sisa_cicil,2, ',', '.');
		
		$PJAMSOS_P = "Rp.".number_format($Emp->Jamsostek->getPotongan(),2, ',', '.');
		
		$SUM_TMSKER_P = "Rp.".number_format($SUM_TMSKER, 2, ',', '.');
		$SUM_TJAM12_P = "Rp.".number_format($SUM_TJAM12, 2, ',', '.');
		$SUM_PSAFETY_P = "Rp.".number_format($SUM_PSAFETY, 2, ',', '.');
		$SUM_PTELAT_P = "Rp.".number_format($SUM_PTELAT, 2, ',', '.');
		$KELEBIHAN_P = "Rp.".number_format($Emp->Plusmin->getMin(), 2, ',','.');
		$KEKURANGAN_P = "Rp.".number_format($Emp->Plusmin->getPlus(), 2, ',','.');
		
		
		$GAJI_BERSIH_P = "Rp.".number_format($GAJI_BERSIH, 2, ',', '.');
		
		$pdf->Cell($w[0]+$w[1],$t_baris,'Jumlah',1,0,'L',1);
		$pdf->Cell($w[2],$t_baris,'WT/PT',1,0,'L',1);
		$pdf->Cell($w[3],$t_baris,$SUM_WT,1,0,'C',1);		
		$pdf->Cell($w[4],$t_baris,$SUM_PT,1,0,'C',1);
		$pdf->Cell($w[5],$t_baris,$SUM_GP_P,1,0,'R',1);
		$pdf->Cell($w[6],$t_baris,$SUM_GL_P,1,0,'R',1);
		$pdf->Cell($w[7],$t_baris,$SUM_PTELAT_P,1,0,'R',1);
		$pdf->Cell($w[8],$t_baris,$SUM_TMSKER_P,1,0,'R',1);
		$pdf->Cell($w[9],$t_baris,$SUM_TJAM12_P,1,0,'R',1);
		$pdf->Cell($w[10],$t_baris,$SUM_PSAFETY_P,1,0,'R',1);
		$pdf->Cell($w[11],$t_baris, $SUM_GT_P,1,0,'R',1);
		$pdf->Ln();
		
		$pdf->Cell($w[0]+$w[1]+$w[2]+$w[3]+$w[4]+$w[5],$t_baris,'',0,0,'C');
		$pdf->Cell($w[6],$t_baris,'Kasbon',1,0,'L');
		$pdf->Cell($w[7]+$w[8],$t_baris,$KASBON_P,1,0,'R');
		$pdf->Cell($w[9]+$w[10],$t_baris,'Cicilan kasbon',1,0,'L');
		$pdf->Cell($w[11],$t_baris,$KASBONCICILAN_P,1,0,'R');
		$pdf->Ln();	
		
		$pdf->Cell($w[0]+$w[1]+$w[2]+$w[3]+$w[4]+$w[5],$t_baris,'',0,0,'C');
		$pdf->Cell($w[6],$t_baris,'Sisa Kasbon',1,0,'L');
		$pdf->Cell($w[7]+$w[8],$t_baris, $KASBONSALDO_P, 1,0,'R');
		$pdf->Cell($w[9]+$w[10],$t_baris,'Jamsostek',1,0,'L');
		$pdf->Cell($w[11],$t_baris,$PJAMSOS_P,1,0,'R');
		$pdf->Ln();				
		
		/*$pdf->Cell($w[0]+$w[1]+$w[2]+$w[3]+$w[4]+$w[5]+$w[6]+$w[7],$t_baris,'',0,0,'C');
		$pdf->Cell($w[8]+$w[9],$t_baris,'Pot. Safety Talk',1,0,'L');
		$pdf->Cell($w[10],$t_baris,$SUM_PSAFETY_P,1,0,'R');		
		$pdf->Ln();	*/		
		
		$pdf->Cell($w[0]+$w[1]+$w[2]+$w[3]+$w[4]+$w[5]+$w[6]+$w[7]+$w[8],$t_baris,'',0,0,'C');
		$pdf->Cell($w[9]+$w[10],$t_baris,'Kelebihan Gaji',1,0,'L');
		$pdf->Cell($w[11],$t_baris,$KELEBIHAN_P,1,0,'R');
		
		$pdf->Ln();
		$pdf->Cell($w[0]+$w[1]+$w[2]+$w[3]+$w[4]+$w[5]+$w[6]+$w[7]+$w[8],$t_baris,'',0,0,'C');
		$pdf->Cell($w[9]+$w[10],$t_baris,'Kekurangan Gaji',1,0,'L');
		$pdf->Cell($w[11],$t_baris,$KEKURANGAN_P,1,0,'R');		
		
		$pdf->Ln();	
		$pdf->Cell($w[0]+$w[1]+$w[2]+$w[3]+$w[4]+$w[5]+$w[6]+$w[7]+$w[8],$t_baris,'',0,0,'C');
		$pdf->Cell($w[9]+$w[10],$t_baris,'Total Gaji',1,0,'L',1);		
		$pdf->Cell($w[11],$t_baris,$GAJI_BERSIH_P,1,0,'R',1);
		$pdf->Ln();		
		$pdf->Ln();
		$pdf->Ln();
		//MultiCell(float w, float h, string txt [, mixed border [, string align [, boolean fill]]];
		//Line(float x1, float y1, float x2, float y2);
		//$pdf->MultiCell( 170, 1,'',1,'');
		$page++;
		if ($page%5==0)
		$pdf->AddPage();		
		}			
 //------------------
$pdf->Output("$row_periode[nama_periode].pdf",'D');
?>