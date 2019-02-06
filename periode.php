<?php 
require_once('connections/conn_mysqli_procedural.php');
require_once('include_class/employee/Employee.php');


// Kd Periode & kd_project 
$kd_periode= $_REQUEST['kd_periode'];
$kd_project= $_REQUEST['kd_project'];

//Data Employee $sql_emp="SELECT * FROM employee ";
$sql_emp="SELECT c.*, d.nama_jabatan, a.nama_project, a.luar_pulau 
FROM project a, ikut_project b, employee c, jabatan d
WHERE b.kd_project= a.kd_project
AND d.kd_jabatan=c.kd_jabatan
AND c.emp_id=b.emp_id
AND a.kd_project=$kd_project";
$rs_emp=mysqli_query($link, $sql_emp);


$sql_periode="SELECT * FROM periode WHERE kd_periode='$kd_periode'";
$rs_periode=mysqli_query($link, $sql_periode);
$row_periode=mysqli_fetch_assoc($rs_periode);
?>
<html >
<head>
<title>PT. Lintech</title>
<link href="templatemo_style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="css/ddsmoothmenu.css" />
<!-- link rel="stylesheet" href="css/slimbox2.css" type="text/css" media="screen" /--> 
<link rel="stylesheet" href="css/hkm_table.css" type="text/css" media="screen" /> 
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/ddsmoothmenu.js">
</script>
<script type="text/javascript">
ddsmoothmenu.init({
	mainmenuid: "templatemo_menu", //menu DIV id
	orientation: 'h', //Horizontal or vertical menu: Set to "h" or "v"
	classname: 'ddsmoothmenu', //class added to menu's outer DIV
	customtheme: ["#", "#"],
	contentsource: "markup" //"markup" or ["container_id", "path_to_menu_file"]
})
</script>
</head>
<body>

<!-- Header Menu -->
<?php require_once('header.inc'); ?>

<div id="templatemo_main" class="wrapper">
	<!-- Tempat Menaruh Tabel ISI -->
	    <h2>Periode <?php echo $row_periode['nama_periode']." kd periode :".$kd_periode;?></h2>        		
		<!-- Awal tabel -->
		<table border=0 class="hkm-table" >
		<?php

		$Emp= New Employee();
		$GAJI_BERSIH=0;
		$GAJI_ALL=0;
		While ($row_emp=mysqli_fetch_assoc($rs_emp)) {		
		//SET EMPLOYEE		
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
		?>	
		<tr bgcolor="">	
			<th colspan=18>
			<table border="0" width="100%" bgcolor="" color="Green" class="" align="center"  >
				<tr >
				<td align="left" width=20%><?php echo $Emp->emp_name."<br>".$Emp->jabatan;?></td>
				<td align="center" width=60%><?php echo $row_emp['nama_project'];?></td>
				<td align="left" width="20%"><?php echo $Emp->emp_id."<br>".$Emp->Periode->nama_periode;?>
				
				<a href="#"
				onclick="javascript:void window.open('cek_absen.php?<?php echo "emp_id=".$Emp->emp_id."&tgl_start=".$Emp->Periode->tgl_awal."&tgl_end=".$Emp->Periode->tgl_akhir;?>','1395882331015','width=500,height=500,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=500,top=300');return false;">
				CEK </a>
				</td>
				</tr>
			</table>
			
			</th>
		</tr>
		<tr>
			<th>Tanggal</th>
			<th>Hari</th>
			<th>Logika</th>
			<th>GP</th>
			<th>Jam In</th>
			<th>Jam_out</th>
			<th>Office In</th>
			<th>Office Out</th>
			<th>Jam EV</th>
			<th>Jam OT</th>
			<th>Gaji Pokok</th>
			<th>Gaji OT</th>
			<th>Telat</th>
			<th>Premi Hadir</th>
			<th>T. Mskerja</th>
			<th>T. Jam 12</th>
			<th>Pot.Safety</th>		
			<th>Total</th>
			
		</tr>
		<?php
				
		
		
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
			$office_in=$row_office['office_in'];
			$office_out=$row_office['office_out'];
			//-----------e end query offfice start-end ------------
			
			//SEELECT ABSENSI per tanggal ini 
			$sql_absensi="SELECT * FROM absensi WHERE emp_id='$row_emp[emp_id]' AND tgl='$tgl_ini'";
			$rs_absensi=mysqli_query($link, $sql_absensi);
			$row_absensi=mysqli_fetch_assoc($rs_absensi);				
			//var_dump($row_absensi);
			
			
			//setting durasi
			$Emp->Durasi->setTime($office_in, $office_out, $row_absensi['jam_in'], $row_absensi['jam_out'], $Emp->DayPeriode->logika_periode);
			//Mencari jam evective
			
			$evektive_hour=$Emp->Durasi->getEvectiveHour();
			
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
			$jam_kerja_ev = $Emp->Durasi->getEvectiveHour();
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
                        
                        $sql_kasbon_sisa = "SELECT a.jml_kasbon - SUM(jml_cicilan) as sisa, sum(b.jml_cicilan) as jml_cicilan
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
			?>		
			<tr class="<?php if ($Emp->DayPeriode->logika_periode=="libur" OR $Emp->DayPeriode->logika_periode=="minggu") echo "hkm_td_libur";?>">
                            <td><?php echo $Emp->Periode->tgl_ini[$i];?></td> 
                            <td><?php echo $Emp->DayPeriode->getDay();?></td>
                            <td><?php echo $Emp->DayPeriode->logika_periode;?></td> 
                            <td><?php echo "Rp.".number_format($gp, 2, '.', ',');?></td> 
                            <td><?php echo $row_absensi['jam_in'];?></td> 
                            <td><?php echo $row_absensi['jam_out'];?></td>
                            <td><?php echo $office_in;//$Emp->Durasi->must_in;?></td> 
                            <td><?php echo $office_out;//$Emp->Durasi->must_out;?></td> 
                            <td><?php echo $Emp->Durasi->getEvectiveHour();?></td>
                            <td><?php echo $Emp->Durasi->getOverTime();?></td>
                            <td><?php echo number_format($Emp->Gaji->gajiPokok(), 2, ',','.');?></td>
                            <td><?php echo number_format($Emp->Gaji->gajiLembur(), 2, ',','.');?></td>
                            <td><?php echo $Emp->Durasi->getTolate();?></td>
                            <td><?php echo number_format($Emp->Gaji->gajiTelat(), 2, ',', '.');?></td>
                            <td><?php echo number_format($Emp->Tunjangan->getTmasakerja(), 2, ',', '.');?></td>
                            <td><?php echo number_format($Emp->Tjam->getTunjangan(), 2, ',', '.'); //Tunajangan Jam 12?></td> 
                            <td><?php echo number_format($Emp->Safety->getPotongan(), 2, ',', '.');?></td>

                            <td><?php if ($row_absensi['ket_absen']) echo $row_absensi['ket_absen']." - "; echo number_format($GT, 2, ',', '.');?></td>	
			</tr>		
			<?php
			
		}
		//---- Jamsostek -----
			$sql_jamsostek="SELECT * FROM jamsostek WHERE emp_id='$Emp->emp_id' AND kd_periode='$kd_periode'";
			$Emp->Jamsostek->setdb($link, $sql_jamsostek);
			//----- end jamsostek -----
						
		//----- Plusmin -----
		$sql_plusmin="SELECT SUM(jml_plus) as jml_plus, sum(jml_min) as jml_min FROM plusmin_gaji WHERE emp_id='$Emp->emp_id' AND kd_periode='$kd_periode'";
		$Emp->Plusmin->setdbPlusmin($link, $sql_plusmin);
		//----- End Plusmin -----
		
		$GAJI_BERSIH=($SUM_GT + $Emp->Plusmin->getPlus())-($Emp->Kasbon->jml_cicil + $Emp->Jamsostek->getPotongan() + $Emp->Plusmin->getMin());
		?>
		<tr class="hkm_td">
			<td colspan=7>Grand Total</td>
			<td colspan=0>WT/PT</td>
			<td colspan=0><?php echo $SUM_WT;?></td>
			<td colspan=0><?php echo $SUM_PT;?> </td>
			<td colspan=0><?php echo number_format($SUM_GP, 2, ',','.');?> </td>
			<td colspan=0><?php echo number_format($SUM_GL,2, ',','.');?> </td>
			<td colspan=0><?php ?> </td>
			<td colspan=0><?php ?> </td>
			<td colspan=0><?php echo number_format($SUM_TMSKER,2, ',','.');?> </td>
			<td colspan=0><?php echo number_format($SUM_TJAM12,2, ',','.');?> </td>
			<td colspan=0><?php echo number_format($SUM_SAFETY,2, ',','.');?> </td>
			<td><?php echo number_format($SUM_GT, 2, ',', '.');?> </td>
		</tr>
		<tr>
			<td colspan=14><?php echo " Kasbon : ". number_format($Emp->Kasbon->jml_kasbon,2,',','.').
									  " Sisa kasbon : ".number_format($Emp->Kasbon->sisa_cicil,2, ',', '.');?>
			</td>
			<td colspan=3>Cicil Kasbon</td>
			<td><?php echo number_format($Emp->Kasbon->jml_cicil,2, ',', '.');?></td>
		</tr>
		<tr>
			<td colspan=14></td>
			<td colspan=3>Potongan Jamsostek </td>
			<td colspan=0>
				<?php echo "Rp. ".number_format($Emp->Jamsostek->getPotongan(), 2, '.', '.');// echo $Emp->Jamsostek->getPotongan();?>
			</td>
		</tr>
		<tr>
			<td colspan=14></td>
			<td colspan=3>Gaji dikurangi </td>
			<td colspan=0>
				<?php echo "Rp. ".number_format($Emp->Plusmin->getMin(), 2, ',','.');?>
			</td>
		</tr>
		<tr>
			<td colspan=14></td>
			<td colspan=3>Gaji ditambahi </td>
			<td colspan=0>
				<?php echo "Rp. ".number_format($Emp->Plusmin->getPlus(), 2, ',','.');?>
			</td>
		</tr>
		<tr>
			<td colspan=14></td>
			<td colspan=3>TOTAL </td>
			<td colspan=0>
				<?php echo "Rp. ".number_format($GAJI_BERSIH,2, ',', '.');?>
			</td>
		</tr>
		<?php
		
		$GAJI_ALL=$GAJI_ALL + $GAJI_BERSIH;

		}
	?> 	</table>
		<!-- Akhir tabel --> 	
	<?php echo "Rp. ".number_format($GAJI_ALL, 2, ',', '.');?>
	<div class="clear"></div>
	</div>
<!--Footer-->
<?php require_once('footer.inc');  ?>
</body>
</html>