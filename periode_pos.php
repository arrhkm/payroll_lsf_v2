<?php 
# Koneksi 
require_once('connections/conn_mysqli_procedural.php');
require_once('include_class/employee/Employee.php');



// Kd Periode & kd_project 
$kd_periode= $_REQUEST[kd_periode];
$kd_project= $_REQUEST[kd_project];

//-----------sql cek archive -------------- 
$sql_cekarchive="SELECT  * from pos_archive 
WHERE kd_periode=$kd_periode AND kd_project=$kd_project";
$rs_archive=mysqli_query($link, $sql_cekarchive);
if (mysqli_num_rows($rs_archive) >0) // Jika data sudah ada maka ...
{
	echo "Data sudah ada ";
}
else 
{ //Jika data belum ada maka lakukan berikut ini 

//Data Employee $sql_emp="SELECT * FROM employee ";
$sql_emp="SELECT c.*, d.nama_jabatan, a.nama_project, a.luar_pulau 
FROM project a, ikut_project b, employee c, jabatan d
WHERE b.kd_project= a.kd_project
AND d.kd_jabatan=c.kd_jabatan
AND c.emp_id=b.emp_id
AND a.kd_project=$kd_project";
$rs_emp=mysqli_query($link, $sql_emp);

//select attribut payroll
$qry_attribut=mysqli_query($link, "select * from attribut_payroll");
$row_attribut=mysqli_fetch_assoc($qry_attribut);

//SELECT Project
$sql_project="SELECT * FROM project WHERE kd_project=$kd_project";
$rs_project=mysqli_query($link, $sql_project);
$row_project=mysqli_fetch_assoc($rs_project);
//-------------------------end project -------------
//select periode
$query_periode="SELECT * FROM periode WHERE kd_periode=$kd_periode";
$SQL_periode=mysqli_query($link, $query_periode);
$row_periode=mysqli_fetch_assoc($SQL_periode);

//INSERT RCHIVE
$sql_posArchive=" 
INSERT INTO `pos_archive`(`kd_project`, `kd_periode`, `nama_project`, `nama_periode`, `tgl_awal`, `tgl_akhir`, 
penanggung_jawab, jabatan_penanggung, staff, hrd_manager, deputi, director, mng_operasional) 
VALUES ('$kd_project', '$kd_periode', '$row_project[nama_project]', '$row_periode[nama_periode]', '$row_periode[tgl_awal]', '$row_periode[tgl_akhir]',
'$row_project[penanggungjawab]', '$row_project[jabatan]', '$row_attribut[nama_staff]', '$row_attribut[hrd_manager]',
'$row_attribut[deputi]', '$row_attribut[director]', '$row_attribut[mng_operasional]')
";
mysqli_query($link, $sql_posArchive);
//------------------------------------------------------------
?>

<html>
<head>

<title>PT. Lintech</title>
<link href="templatemo_style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="css/ddsmoothmenu.css" />
<link rel="stylesheet" href="css/slimbox2.css" type="text/css" media="screen" /> 
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/ddsmoothmenu.js"></script>
<script type="text/javascript">

ddsmoothmenu.init({
	mainmenuid: "templatemo_menu", //menu DIV id
	orientation: 'h', //Horizontal or vertical menu: Set to "h" or "v"
	classname: 'ddsmoothmenu', //class added to menu's outer DIV
	customtheme: ["#", "#"],
	contentsource: "markup" //"markup" or ["container_id", "path_to_menu_file"]
})
</script>
<script type="text/JavaScript" src="js/slimbox2.js"></script> 
</head>
<body>
<!-- Header Menu -->
<?php require_once('header.inc'); ?>

<div id="templatemo_main" class="wrapper">
<!-- Tempat Menaruh Tabel ISI -->
	<h2>Periode</h2>        		
	<!-- Awal tabel -->
	<?php
	$GAJI_BERSIH=0;
	$SUM_POT_SAFETY=0;
	//:::::::::::::::::::::::    PERULANGAN ALL KARYAWAN  :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
	$Emp= New Employee();
	$GAJI_BERSIH=0;
	While ($row_emp=mysqli_fetch_assoc($rs_emp)) {
	//set employee		
	$Emp->setEmp(
            $row_emp['emp_id'], 
            $row_emp['emp_name'], 
            $row_emp['pot_jamsos'], 
            $row_emp['gaji_pokok'], 
            $row_emp['t_insentif'], 
            $row_emp['t_masakerja'], 
            $row_emp['nama_jabatan'], 
            $row_emp['no_rekening'], 
            $row_emp['emp_group'],
            $row_emp['pot_telat']
        );
	
	$Emp->Periode->setId($kd_periode);
	$rs_periode=mysqli_query($link, $Emp->Periode->sql_periode);
	$row_periode=mysqli_fetch_assoc($rs_periode);
	$Emp->Periode->setPeriode($row_periode['tgl_awal'], $row_periode['tgl_akhir'], $row_periode['nama_periode'], 
	$row_periode['potongan_jamsos']);
	
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
	//$tgl_ini=$row_periode[tgl_awal];
	for ($i=0;$i<=$selisih;$i++) { 
	//setting tanggal ini 
		$tgl_ini=$Emp->Periode->tgl_ini[$i];
		//-------------------end----------------
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
		
		//SEELECT ABSENSI per tanggal ini 
		$sql_absensi="SELECT * FROM absensi WHERE emp_id='$row_emp[emp_id]' AND tgl='$tgl_ini'";
		$rs_absensi=mysqli_query($link, $sql_absensi);
		$row_absensi=mysqli_fetch_assoc($rs_absensi);				
		
		//setting durasi
		$Emp->Durasi->setTime($office_in, $office_out, $row_absensi[jam_in], $row_absensi[jam_out], $Emp->DayPeriode->logika_periode);
		
		
		//SET VAR GAJI 
		$Emp->Gaji->setGaji(
                        $Emp->gaji_pokok, 
                        $Emp->Durasi->getEvectiveHour(), 
                        $Emp->Durasi->getOverTime(), 
                        $Emp->Durasi->getTolate(), 
                        $Emp->DayPeriode->logika_periode, 
                        $row_absensi['ket_absen'],
                        $Emp->tmasakerja,
                        $Emp->pot_telat
                );
		//Mencari jam evective
		$evektive_hour=$Emp->Durasi->getEvectiveHour();
		//-------------------- SET TUNJANGAN -----------------------
		//SET TMSKER
		$Emp->Tunjangan->setTmasakerja(
                        $Emp->Durasi->getEvectiveHour(), 
                        $Emp->Durasi->getOverTime(), 
                        $Emp->tmasakerja, 
                        $Emp->DayPeriode->logika_periode
                );
		
		//SET TJAM12
		$emp_ijam=$Emp->emp_id;
		$sql_tjam12="SELECT * FROM insentif_overjam WHERE 
		emp_id= '$emp_ijam'
		AND tgl_ijam='$tgl_ini'";
		$rs_tjam12=mysqli_query($link, $sql_tjam12);
		$row_tjam12=mysqli_fetch_assoc($rs_tjam12);
		$tjam12=mysqli_num_rows($rs_tjam12);
		$Emp->Tjam->setTunjangan($tjam12, $Emp->tjam12);
		//------------------------END TUNJANGAN ---------------------
		//Kasbon 
                $sql_kasbon="
			SELECT a.*
			FROM kasbon a
			WHERE a.emp_id='$Emp->emp_id' AND a.status=1 
			";
                $rs_kasbon=mysqli_query($link, $sql_kasbon);
                $row_kasbon=mysqli_fetch_assoc($rs_kasbon);
                
		$sql_kasbon_sisa = "SELECT a.jml_kasbon - SUM(jml_cicilan) as sisa, sum(b.jml_cicilan) as jml_cicilan, a.keterangan
                        FROM kasbon as a, cicilan_kasbon b
                        WHERE  a.emp_id='$Emp->emp_id' AND a.status=1
                        AND b.kd_kasbon=a.kd_kasbon 
                        group by a.kd_kasbon";
                $rs_kasbon_sisa = mysqli_query($link, $sql_kasbon_sisa);
                $row_kasbon_sisa = mysqli_fetch_assoc($rs_kasbon_sisa);

		$Emp->Kasbon->setKasbon(
                    $row_kasbon['kd_kasbon'], 
                    $row_kasbon['emp_id'], 
                    $row_kasbon['tgl'], 
                    $row_kasbon['keterangan'],
                    $row_kasbon['jml_kasbon'], 
                    $row_kasbon['status'], 
                    $row_kasbon_sisa['sisa'], 
                    $row_kasbon_sisa['jml_cicilan']
                );
		
                
                //---- end Kasbon----------
		//---- Safety Talk -----
		$sql_safety="select * from safety_talk where emp_id='$Emp->emp_id' AND  tgl_safety='$tgl_ini'";
		$Emp->Safety->setdb($link, $sql_safety, $Emp->DayPeriode->logika_periode);
		//---- End afety -----

		if ( $Emp->DayPeriode->logika_periode=="sabtu") {
			$gp=$Emp->gaji_pokok/5;
			//$gp=$Emp->gaji_pokok;
		} else {
			$gp=$Emp->gaji_pokok/7;
			//$gp=$Emp->gaji_pokok;
		}
		
		//SET GRAND TOTAL 
		$Emp->Grandtotal->setGrandtotal(
                    $Emp->Gaji->gajiPokok(),
                    $Emp->Gaji->gajiLembur(), 
                    $Emp->Tjam->getTunjangan(), 
                    $Emp->Tunjangan->getTmasakerja(), 
                    $Emp->Gaji->gajiTelat(), 
                    $Emp->Safety->getPotongan(),
                    $row_absensi['ket_absen'], 
                    $Emp->gaji_pokok, 
                    $Emp->DayPeriode->logika_periode
                );
		
		$GT=$Emp->Grandtotal->getGrandtotal();
		$SUM_GT=$SUM_GT+$GT;
		$SUM_WT=$SUM_WT+$Emp->Durasi->evective_hour;
		$SUM_PT=$SUM_PT+$Emp->Durasi->evective_hour+$Emp->Durasi->getOverTime();
		$SUM_GP=$SUM_GP+$Emp->Gaji->gajiPokok();
		$SUM_GL=$SUM_GL+$Emp->Gaji->gajiLembur();
		$SUM_TMSKER=$SUM_TMSKER+$Emp->Tunjangan->getTmasakerja();
		$SUM_TJAM12=$SUM_TJAM12+$Emp->Tjam->getTunjangan();
		$SUM_SAFETY=$SUM_SAFETY+$Emp->Safety->getPotongan();                                       		
		
		//-----------------------------------------------------			
			
		//$hari=date("l", strtotime($tgl_ini));
		//$hari_ini=fx_hari($hari);			
		
		//----------------------------------------
		//if (($libur>=1) OR ($hari_ini == 'Minggu')) { $hr_libur=1; } else { $hr_libur=0; }
		$GJ_JAM=round($gp,2);
		$EMP_ID=$Emp->emp_id;
		$HARI=$Emp->DayPeriode->getDay();
		$OT=$Emp->Durasi->getOverTime();
		$GL=$Emp->Gaji->gajiLembur();
		$P_TELAT=$Emp->Gaji->gajiTelat();
		$P_SAFETY=$Emp->Safety->getPotongan();
		$JAM_EV=$Emp->Durasi->getEvectiveHour();
		/*if ($logika_office=="awal") {
			$GP=0;
		} else {
			$GP=$Emp->Gaji->gajiPokok();
		}	
                 * 
                 */	
                $GP=$Emp->Gaji->gajiPokok();
		$T_MSKER=$Emp->Tunjangan->getTmasakerja();
		$T_JAM12=$Emp->Tjam->getTunjangan();
		$GRAND_TOT=$Emp->Grandtotal->getGrandtotal();
		//$LOGIKA=$Emp->DayPeriode->logika_periode;
		$LOGIKA= $logika_office;
		$sql_payroll_day="
		INSERT IGNORE pos_payroll_day(
			kd_periode, emp_id, tgl,kd_project, hari,
                        jam_ev, g_perjam, ot, gp, gl, 
			pot_tel, p_safety, t_jam12, t_msker, tg, 
			logika, jam_in, jam_out, ket_absen ) 
		VALUES (
			$kd_periode, '$EMP_ID',	'$tgl_ini', $kd_project, '$HARI', 
			'$JAM_EV', '$GJ_JAM', '$OT', '$GP', '$GL', 
			'$P_TELAT', '$P_SAFETY', '$T_JAM12', '$T_MSKER', '$GRAND_TOT', 
			'$LOGIKA', '$row_absensi[jam_in]', '$row_absensi[jam_out]', '$row_absensi[ket_absen]' )";
		mysqli_query($link, $sql_payroll_day) or die (mysqli_error($link));
		
				
	}
	//---- Jamsostek -----
	$sql_jamsostek="SELECT * FROM jamsostek WHERE emp_id='$Emp->emp_id' AND kd_periode='$kd_periode'";
	$Emp->Jamsostek->setdb($link, $sql_jamsostek);
	//----- end jamsostek -----
	
	//----- Plusmin -----
	$sql_plusmin="SELECT SUM(jml_plus) as jml_plus, sum(jml_min) as jml_min FROM plusmin_gaji WHERE emp_id='$Emp->emp_id' AND kd_periode='$kd_periode'";
	$Emp->Plusmin->setdbPlusmin($link, $sql_plusmin);
	//----- End Plusmin -----
	$GAJI_BERSIH=($SUM_GT + $Emp->Plusmin->getPlus())-($Emp->Kasbon->jml_cicil + $Emp->Jamsostek->getPotongan()+$Emp->Plusmin->getMin());		
	$GAJI_ALL=$GAJI_ALL + $GAJI_BERSIH;
	
	$EMP_ID=$Emp->emp_id;
	$EMP_NAME=$Emp->emp_name;
	$EMP_JABATAN=$Emp->jabatan;
	$KASBON=$Emp->Kasbon->jml_kasbon;
	$SISA_KASBON=$Emp->Kasbon->sisa_cicil;
	$CICIL_KASBON=$Emp->Kasbon->jml_cicil;
	$JAMSOS=$Emp->Jamsostek->getPotongan();
	$GPLUS=$Emp->Plusmin->getPlus();
	$GMIN=$Emp->Plusmin->getMin();
	$GROUP= $Emp->emp_group;
	
	$sql_pos_payroll="
		INSERT IGNORE `pos_payroll`
		(emp_id, kd_periode, kd_project, emp_name, jabatan, project,
		`kasbon`, `sisa_kasbon`, `cicil_kasbon`, `jamsos`, `over_gaji`, `def_gaji`,
		`tg_all`, no_rekening, emp_group)
		VALUES ('$EMP_ID', $kd_periode, $kd_project, '$EMP_NAME', '$EMP_JABATAN', '$row_emp[nama_project]',
		'$KASBON', '$SISA_KASBON', '$CICIL_KASBON', '$JAMSOS', 
		'$GMIN', '$GPLUS', '$GAJI_BERSIH', '$Emp->norekening', '$GROUP')
		";
	mysqli_query($link, $sql_pos_payroll) or die (mysqli_error($link));			
	echo "$row_emp[emp_name] - $row_emp[emp_id] - period : $row_periode[kd_periode] - proj: $row_project[kd_project]  - $GAJI_BERSIH <br>";		
}//--------------end of karyaean looping --------------------

echo "Gaji alll : $GAJI_ALL";		
	?>		
<!-- Akhir tabel --> 	
<div class="clear"></div>
</div>
<!--Footer-->
<?php require_once('footer.inc');  ?>
</body>
</html>

<?php } ?>
