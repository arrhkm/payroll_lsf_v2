<?php 
# Koneksi 
require_once('connections/koneksi.php');
require_once('includes/fungsi_hari.php');
# select DB 
mysql_select_db($database_koneksi, $koneksi);
//select attribut payroll
$qry_attribut=mysql_query("select * from attribut_payroll");
$row_attribut=mysql_fetch_array($qry_attribut);
//Variabel awal 
$kd_project=$_REQUEST['kd_project'];
$kd_periode=$_REQUEST['kd_periode'];

//select periode
$query_periode="SELECT * FROM periode WHERE kd_periode=$kd_periode";
$SQL_periode=mysql_query($query_periode,$koneksi);
$row_periode=mysql_fetch_array($SQL_periode);
$period_awal=$row_periode[tgl_awal];
$period_akhir=$row_periode[tgl_akhir];
//--------end select periode

// Delete tabel message jamsostek 
//----------------------------------
mysql_query("delete from jamsostek_msg WHERE kd_periode='$row_periode[kd_periode]'",$koneksi);

//-----JUMLAH SELISIH HARI PERIODE--------
$SQL_jedah=mysql_query("SELECT DATEDIFF('$period_akhir','$period_awal') as jedah",$koneksi);
$rs_jedah=mysql_fetch_array($SQL_jedah);
$jedah=$rs_jedah[jedah];
$sql_emp="
SELECT c.*, d.nama_jabatan, a.nama_project, a.luar_pulau 
FROM project a, ikut_project b, employee c, jabatan d
WHERE b.kd_project= a.kd_project
AND d.kd_jabatan=c.kd_jabatan
AND c.emp_id=b.emp_id
AND a.kd_project=$kd_project
";
$rs_emp=mysql_query($sql_emp, $koneksi) or die(mysql_error());

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>PT. Lintech</title>
<meta name="keywords" content="orando template, blog page, website template, CSS, HTML, drop down menu" />
<meta name="description" content="Orando Template, Blog Page, Free Template with Drop Down menu, designed by templatemo.com" />
<link href="templatemo_style.css" rel="stylesheet" type="text/css" />

<link rel="stylesheet" type="text/css" href="css/ddsmoothmenu.css" />

<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/ddsmoothmenu.js">

/***********************************************
* Smooth Navigational Menu- (c) Dynamic Drive DHTML code library (www.dynamicdrive.com)
* This notice MUST stay intact for legal use
* Visit Dynamic Drive at http://www.dynamicdrive.com/ for full source code
***********************************************/

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

<link rel="stylesheet" href="css/slimbox2.css" type="text/css" media="screen" /> 
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
		include("lib_class.php");
		$GJ=new gajiku($hostname_koneksi, $database_koneksi, $username_koneksi, $password_koneksi); 
		while ($row_emp=mysql_fetch_array($rs_emp)) { 
		$emp_id=$row_emp[emp_id];
		//$GAJI_BERSIH=0;
		
		//MENJUMLAH  PLUSMIN GAji jika ada		
		$sql_plusmin="SELECT SUM(jml_plus) as jml_plus, sum(jml_min) as jml_min 
		FROM plusmin_gaji 
		where kd_periode =$_REQUEST[kd_periode] AND emp_id='$row_emp[emp_id]'";
		$rs_plusmin=mysql_query($sql_plusmin,$koneksi) or die (mysql_error());
		$row_plusmin=mysql_fetch_assoc($rs_plusmin);
		
		//MENJUMLAH INSENTIF GAJI
		$sql_ijam="SELECT SUM(jml_ijam) as jml_ijam 
		FROM insentif_overjam
		where kd_periode =$_REQUEST[kd_periode] AND emp_id='$row_emp[emp_id]'";
		$rs_ijam=mysql_query($sql_ijam,$koneksi) or die (mysql_error());
		$row_ijam=mysql_fetch_assoc($rs_ijam);
		
		//MENJUMLAH INSENTIF UANG MAKAN
		/*$sql_ium="SELECT SUM(jml_ium) as jml_ium 
		FROM insentif_uang_makan
		where kd_periode =$_REQUEST[kd_periode] AND emp_id='$row_emp[emp_id]'";
		$rs_ium=mysql_query($sql_ium,$koneksi) or die (mysql_error());
		$row_ium=mysql_fetch_assoc($rs_ium);
		*/
		$ium=$GJ->get_ium($kd_periode, $emp_id, $koneksi, $database_koneksi);
	
		//MENAMBHKAN CICILAN KASBON
		$sql_kasbon="SELECT a.kd_cicilan, a. kd_kasbon, a.kd_periode, sum(a.jml_cicilan) as jml_cicilan, c.emp_id 
		from cicilan_kasbon a, kasbon b, employee c
		WHERE b.kd_kasbon=a.kd_kasbon
		AND b.emp_id=c.emp_id
		AND a.kd_periode ='$_REQUEST[kd_periode]'
		AND c.emp_id='$row_emp[emp_id]'";
		$rs_kasbon=mysql_query($sql_kasbon, $koneksi) or die(mysql_error());
		$row_kasbon=mysql_fetch_assoc($rs_kasbon);
		//-------------------------------------------------------
		//SALDO KASBON
		$sql_saldo="SELECT  a.status, a.jml_kasbon, b.emp_id, b. emp_name,sum(c.jml_cicilan) as cicilan, a.jml_kasbon-(sum(c.jml_cicilan)) as saldo
		FROM kasbon a, employee b, cicilan_kasbon c
		WHERE a.emp_id=b.emp_id
		AND b.emp_id='$row_emp[emp_id]'
		AND c.kd_kasbon=a.kd_kasbon
		AND a.status=1
		";
		$rs_saldo=mysql_query($sql_saldo, $koneksi) or die(mysql_error());
		$row_saldo=mysql_fetch_assoc($rs_saldo);		
		//---------------------------------------------------------
		
		//POTONGAN JAMSOSTEK 
		$sql_jmstk="SELECT *
		FROM jamsostek 
		WHERE kd_periode='$_REQUEST[kd_periode]' AND emp_id='$row_emp[emp_id]'";
		$rs_jmstk=mysql_query($sql_jmstk,$koneksi) or die(mysql_error());
		$row_jmstk=mysql_fetch_assoc($rs_jmstk);
		
		$sql_jmstk_p = "SELECT SUM(pot_jamsostek) as pot_jamsostek FROM jamsostek_pending
		WHERE kd_periode2= '$_REQUEST[kd_periode]' AND emp_id='$row_emp[emp_id]'";
		$rs_jmstk_p=mysql_query($sql_jmstk_p,$koneksi) or die(mysql_error());
		$row_jmstk_p=mysql_fetch_assoc($rs_jmstk_p);
		
		$pot_jamsos = $row_jmstk['pot_jamsostek']+$row_jmstk_p['pot_jamsostek'];
		
		//----------------------------------------
		?>
		<table class="bordered" border="1" cellpadding="0px" cellspacing="0px" align = "" width = "1200px">
		<br>
		<thead>
		<tr height="20px" align = "left">
		<td colspan=2>&nbsp;&nbsp;
			Nama : <?php echo $row_emp[emp_name];?><br>&nbsp;&nbsp;  
			Jabatan : <?php echo $row_emp[nama_jabatan];?>
		</td>
		<td colspan=6 align="center">
			<?php echo "SLIP GAJI MANPOWER ".$row_emp[nama_project];?>  
			
		</td>
		<td colspan=2>
		&nbsp;&nbsp;<?php echo "$row_periode[tgl_awal] s/d $row_periode[tgl_akhir]";?>
		&nbsp;&nbsp;NIP :<?php echo $row_emp[emp_id];?>
		</td>	
		</tr>
		<tr align= center height="20px">
			<th>Hari</th>
			<th>Tanggal</th>
			<th>jam<br>Efektif</th>
			<th>Gaji Pokok<br>/jam evektif</td>
			<th>Jam<br>Lbr</th>
			<th>Gaji Pokok</th>
			<th>Gaji Lembur</td>
			<th>Uang Makan</th>
			<th>Pot Telat</th>
			<th>Total Gaji</th>	
			
		</tr>
		</thead>
		<?php 
		//definisi jam awal
		
		$jam_ev=0;
		$jam_lembur=0;
		$GP=0;
		$GL=0;
		$GT=0;
		$cicil=0;
		$t_jab=0;		

		$SUM_GT=0;
		$SUM_GP=0;
		$SUM_GL=0;
		$SUM_UM=0;
		$SUM_JE=0;
		$SUM_JL=0;
		
		$SUM_TJAB=0;
		$SUM_TMSKER=0;
		$SUM_POT_TELAT=0;
		$SUM_POT_SAFETY=0;
		
		//---------------------------------
		//Perulangan payroll sesuai tanggal
		$total_gaji=0;
		$tgl_ini=$period_awal;
		//::::::::::::::::::::::::::::::::::::::::::::::  PERULANGAN WAKTU DALAM SATU PERODE :::::::::::::::::::::::::::::::::::::::::::::::::
		for ($i=0;$i<=$jedah;$i++) { 
			$tgl_ini = strtotime("+$i day" ,strtotime($period_awal));
			$tgl_ini = date('Y-m-d', $tgl_ini);
			
			$sql_absensi= "SELECT a.tgl, 
			a.jam_in, a.jam_out, 			 
			TIMEDIFF(a.jam_in,'08:00:00') as jt, TIMESTAMPDIFF(HOUR,a.jam_out, a.jam_in) as jam_kerja, 
			a.status, a.ket_absen
			FROM absensi a, employee b, jabatan c
			WHERE 
			b.emp_id='$emp_id' 
			and a.emp_id=b.emp_id 
			and c.kd_jabatan=b.kd_jabatan
			and a.tgl ='$tgl_ini'";
			$rs_absensi= mysql_query($sql_absensi, $koneksi)or die(mysql_error());
			$row_absensi= mysql_fetch_array($rs_absensi);

			//Mengambil isi jam dan menit IN dan OUT
			$time_in=$row_absensi[time_in];
			$time_out=$row_absensi[time_out];
			$arr_out=explode(":",$time_out);
			$arr_in =explode(":",$time_in);
			$njam_out=$arr_out[0];//jam out
			$njam_in=$arr_in[0];//jam in
			$njam_in2=$arr_in[1];//menit in
			
			//$jam_kerja_start= $tgl_ini." 07:00:00";
			//$jam_kerja_end= $tgl_ini." 15:00:00";
			
			//SQLTIME			
			$sql_time="
			SELECT a.`emp_id`, a.tgl, 
			a.jam_in, a.jam_out, a.status, a.`loc_code`, 
			a.jam_in as Tin, a.jam_out as Tout, HOUR(a.jam_in) as Hin, HOUR(a.jam_out) as Hout,
			HOUR(a.jam_out) - HOUR(a.jam_in) as sio
			FROM absensi a 
			WHERE 
			a.emp_id = '$emp_id'
			and a.tgl='$tgl_ini' 
			";
			$rs_time=mysql_query($sql_time, $koneksi);
			$row_time=mysql_fetch_assoc($rs_time);
			//--------------------end------------------
			
			
			//MENCARI TGL SAFETY TALK
			$qry_safety="select emp_id from safety_talk where emp_id='$row_emp[emp_id]' and tgl_safety='$tgl_ini'";
			$sql_safety=mysql_query($qry_safety,$koneksi);
			$safety_talk=mysql_num_rows($sql_safety);
			if ($safety_talk>0){ 
				$pot_safety=$row_attribut[safety_talk]; } 			
			else{ $pot_safety=0; }
			if (($tgl_ini)==($period_awal)) {
				$pot_safety=0; }
			//MENCARI TGL MERAH----------
			$qry_libur="select tgl_libur from tanggal_libur where kd_periode=$_REQUEST[kd_periode] and tgl_libur='$tgl_ini'";
			$sql_libur=mysql_query($qry_libur,$koneksi);
			$libur=mysql_num_rows($sql_libur);			

			//:::::::::::::::::::::::::::::::::: LOGIKA PENENTUAN TANGGAL :::::::::::::::::::::::::::::::::::::::::::::::
			//JIKA CUTI
			if ($row_absensi[ket_absen]=='SK'|| $row_absensi[ket_absen]=='CT' || $row_absensi[ket_absen]=='PD') {
				$ket="cuti / sakit";
				$jam_ev=0;
				$UM=$row_emp['uang_makan'];
				$jam_lembur=0;		
				$gaji_pokok=$row_emp[gaji_pokok];
				$t_jab=0;
				$t_msker=0;	
				$potongan_telat=0;
				$pot_safety=0;
			}
			//JIKA ABSEN
			elseif (strtotime($row_absensi[tgl])==0 || $row_time[jam_in]==Null || $row_time[jam_out]==Null || $row_time[Hin]>9 ){
				if ($row_emp['luar_pulau']==1) {
				$ket="ABSEN";
				$jam_ev=0;
				//$UM=$row_emp['uang_makan'];
				$UM=0;
				$jam_lembur=0;
				$gaji_pokok=$row_emp[gaji_pokok]/7;
				$t_jab=0;
				$t_msker=0;
				$potongan_telat=0;
				$pot_safety=0;
				
				} else {
				$ket="ABSEN";
				$jam_ev=0;
				$UM=0;
				$jam_lembur=0;
				$gaji_pokok=$row_emp[gaji_pokok]/7;
				$t_jab=0;
				$t_msker=0;
				$potongan_telat=0;
				$pot_safety=0;
				}
			}
			//JIKA AKHIR PERIODE
			elseif(strtotime($row_absensi[tgl])==strtotime($period_akhir)){
				$ket="Akhir";
				
				if($libur>=1){
					$ket="TGL_MERAH $tgl_merah";
					include 'logika_libur_diakhir.php';
					$gaji_pokok=$row_emp[gaji_pokok]/7;					
				}
				else				
				include 'logika_akhir.php';
				$gaji_pokok=$row_emp[gaji_pokok]/7;
				$t_jab=$row_emp[t_jabatan];
				$t_msker=$row_emp[t_masakerja];
			}//JIKA GANTUNGAN
			elseif(strtotime($row_absensi[tgl])==strtotime($period_awal)) {
				$ket="Gantungan";
				$potongan_telat=0;
				$pot_safety=0;
				include 'logika_awal.php';
				$gaji_pokok=$row_emp[gaji_pokok]/7;
				$t_jab=0;
				$t_msker=0;				
			}
			//JIKA TGL MERAH----------
			elseif($libur>=1){
				$ket="TGL_MERAH";				
				include 'logika_libur.php';
				$gaji_pokok=$row_emp[gaji_pokok]/7;
				$t_jab=$row_emp[t_jabatan];
				$t_msker=$row_emp[t_masakerja];
				
			}
			//JIKA SABTU
			elseif(date("l", strtotime($row_absensi[tgl]))=="Saturday") {
				$ket="Saturday";
				
				include 'logika_sabtu.php';
				if ($jam_ev>=5) {
				$gaji_pokok=$row_emp[gaji_pokok]/5;// Jam Evektif hari sabtu adalah 5 jam 
				$t_jab=$row_emp[t_jabatan];
				$t_msker=$row_emp[t_masakerja];
				}
				else {
				$gaji_pokok=$row_emp[gaji_pokok]/7;
				$t_jab=$row_emp[t_jabatan];
				$t_msker=$row_emp[t_masakerja];
				}
			}
			//JIKA MINGGU
			elseif(date("l", strtotime($row_absensi[tgl]))=="Sunday") {
				$ket="MINGGU";				
				include 'logika_libur.php';
				$gaji_pokok=$row_emp[gaji_pokok]/7;
				$t_jab=$row_emp[t_jabatan];
				$t_msker=$row_emp[t_masakerja];				
			}
			//JIKA NORMAL
			else{				
				$ket="Normal";				
				include ('logika_normal.php');
				$gaji_pokok=$row_emp[gaji_pokok]/7;
				$t_jab=$row_emp[t_jabatan];
				$t_msker=$row_emp[t_masakerja];	
				
			}
							
			//Gaji Pokok CUTI atau SAKIT atu Perjalanan Dinas	
			if(strtotime($row_absensi[tgl])==strtotime($period_awal)) {
				if ($row_absensi[ket_absen]=='SK'|| $row_absensi[ket_absen]=='CT' || $row_absensi[ket_absen]=='PD') {
					$GP=0;//jumlah gaji pokok
					$UM=0;
				}else{
					$GP=ceil($jam_ev*$gaji_pokok);//jumlah gaji pokok
				}
			} else {
				if ($row_absensi[ket_absen]=='SK'|| $row_absensi[ket_absen]=='CT' || $row_absensi[ket_absen]=='PD') {
					$GP=ceil($gaji_pokok);//jumlah gaji pokok
				}else{
					$GP=ceil($jam_ev*$gaji_pokok);//jumlah gaji pokok
				}			
			}
			
			$GL=ceil($jam_lembur*$row_emp[gaji_lembur]);//jumlah gaji lembur
			$GT=$GP+$GL+$UM-$potongan_telat;//jumlah gaji
			$PT=$Jam_ev+$jam_lembur;
			
			$SUM_GT=$SUM_GT+$GT;
			$SUM_GP=$GP+$SUM_GP;
			$SUM_GL=$GL+$SUM_GL;
			$SUM_UM=$SUM_UM+$UM;
			$SUM_JE=$SUM_JE+$jam_ev;
			$SUM_JL=$SUM_JL+$jam_lembur;
			$SUM_PT=$SUM_JE+$SUM_JL;
			$SUM_TJAB=$SUM_TJAB + $t_jab;
			$SUM_TMSKER=$SUM_TMSKER + $t_msker;
			$SUM_POT_SAFETY=$SUM_POT_SAFETY+$pot_safety;
			//-----------------------------------------------------
			//$hari=date("l",strtotime($tgl_ini));
			$hari=date("l", strtotime($tgl_ini));
			$hari_ini=fx_hari($hari);
			
			?>
			<tr align= center bgcolor=<?php if(date("l", strtotime($tgl_ini))=="Sunday"|| $libur>=1) echo"red";?>>
			<td align="left">&nbsp;&nbsp;<?php echo $hari_ini;?></td>
			<td><?php echo $tgl_ini;?></td>
			<td><?php echo $jam_ev;?></td>
			<td><?php echo ceil($gaji_pokok);?></td>
			<td><?php echo $jam_lembur;?></td>
			<td><?php echo "$GP";?></td>
			<td><?php echo "$GL";?></td>
			<td><?php echo "$UM";?></td>
			<td><?php 
			echo "$potongan_telat";
			echo "$ket|$row_time[Tin]|$row_time[Tout]| $telat";
			//echo "| $jam_start : $jam_end";
			?></td>	
			<td bgcolor="" align="right"><?php echo "$row_absensi[ket_absen]   ".number_format($GT,2,',','.');?></td>			
			</tr>
			
			<?php 
			
		} 
		//:::::::::::::::::::::::::::::::::::::::::::::::::::: END OF PERIODE ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
		//::::::::::::::::::::::::::::::::::::::::::::::::TOTAL GAJI ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
		
		$GAJI_BERSIH=$SUM_GT-$pot_jamsos-$cicil+$SUM_TJAB+$SUM_TMSKER-$SUM_POT_SAFETY+$row_plusmin[jml_plus]-$row_plusmin[jml_min]-$row_kasbon[jml_cicilan]+$row_ijam[jml_ijam]+$ium; 
		
		if ($GAJI_BERSIH < 0) {			
			$sql_msg_jamsos="REPLACE INTO jamsostek_msg (kd_periode, emp_id, emp_name) 
			VALUES ($_REQUEST[kd_periode], '$row_emp[emp_id]', '$row_emp[emp_name]')";
			mysql_query($sql_msg_jamsos,$koneksi);
		}
		
		//---------------------------------------------
		?>
		<tr align="center" bgcolor="Yellow">
		<td>Jumlah</td><!-- Hari_ini 1 -->
		<td>WT</td><!-- tgl_ini 2 -->

		<td><?php echo $SUM_JE;?></td><!-- jam_evektif 4-->
		<td>PT</td><!-- Gaji pokok/jam 5-->
		<td><?php echo $SUM_PT;?></td><!-- jam Lembur 6-->
		<td><?php echo $SUM_GP;?></td><!-- Gaji_pokok 7-->
		<td><?php echo $SUM_GL;?></td><!-- Gaji Lembur 8-->
		<td><?php echo $SUM_UM;?></td><!-- Uang_makan 9-->
		<td></td><!--potongan telat 10-->
		<td align="right"><?php echo "Rp ".number_format($SUM_GT,2,',','.');?></td><!-- total_gaji 11-->		
		</tr>
		<tr align="center">
		<td></td><!-- Hari_ini 1 -->
		<td></td><!-- tgl_ini 2 -->
		<td colspan=5 align="left">Kasbon :&nbsp;<?php echo number_format($GJ->kasbon($emp_id),2,',','.');?></td><!-- Jumlah Kasbon 4-->
		<td colspan=2 align="left">Cicil Kasbon</td><!--  9-->
		<td align="right"><?php echo number_format($GJ->cicilan($kd_periode, $emp_id),2,',','.');?></td><!-- cicilan Kasbon hari ini 11-->		
		</tr>
		<tr align="center">
		<td></td><!-- Hari_ini 1 -->
		<td></td><!-- tgl_ini 2 -->
		<td colspan=5 align="left">Sisa Kasbon :&nbsp;<?php echo number_format($GJ->sisa_kasbon($emp_id),2,',','.');?></td><!-- Sisa Kasbon 4-->
		<td colspan=2 align="left">Jamsostek</td><!-- -->
		<td align="right"><?php echo number_format($GJ->jamsostek($kd_periode, $emp_id),2,',','.');?></td><!-- Potongan Jamsos 11-->		
		</tr>
		
		<tr align="center">
		<td></td><!-- Hari_ini 1 -->
		<td></td><!-- tgl_ini 2 -->
		<td></td><!-- jam_evektif 4-->
		<td></td><!-- Gaji pokok/jam 5-->
		<td></td><!-- jam Lembur 6-->
		<td></td><!-- Gaji_pokok 7-->
		<td></td><!-- Gaji Lembur 8-->
		<td colspan=2 align="left">Potongan Safety Talk </td><!--  9-->
		<td align="right"><?php echo "Rp ".number_format($GJ->potsafety($emp_id, $period_awal, $period_akhir),2,',','.');?></td><!-- total_gaji 11-->		
		</tr>
		
		<tr align="center">
		<td></td><!-- Hari_ini 1 -->
		<td></td><!-- tgl_ini 2 -->
		<td></td><!-- jam_evektif 4-->
		<td></td><!-- Gaji pokok/jam 5-->
		<td></td><!-- jam Lembur 6-->
		<td></td><!-- Gaji_pokok 7-->
		<td></td><!-- Gaji Lembur 8-->
		<td colspan=2 align="left">Kelebihan Gaji </td><!--  9-->
		<td align="right"><?php echo "Rp ".number_format($GJ->get_min($kd_periode, $emp_id),2,',','.');?></td><!-- total_gaji 11-->		
		</tr>
		<tr align="center">
		<td></td><!-- Hari_ini 1 -->
		<td></td><!-- tgl_ini 2 -->
		<td></td><!-- jam_evektif 4-->
		<td></td><!-- Gaji pokok/jam 5-->
		<td></td><!-- jam Lembur 6-->
		<td></td><!-- Gaji_pokok 7-->
		<td></td><!-- Gaji Lembur 8-->
		<td colspan=2 align="left">Kekurangan Gaji </td><!--  9-->
		<td align="right"><?php echo "Rp ".number_format($GJ->get_plus($kd_periode, $emp_id),2,',','.');?></td><!-- total_gaji 11-->		
		</tr>
		<tr align="center">
		<td></td><!-- Hari_ini 1 -->
		<td></td><!-- tgl_ini 2 -->
		<td></td><!-- jam_evektif 4-->
		<td></td><!-- Gaji pokok/jam 5-->
		<td></td><!-- jam Lembur 6-->
		<td></td><!-- Gaji_pokok 7-->
		<td></td><!-- Gaji Lembur 8-->
		<td colspan=2 align="left">T Jabatan</td><!--  9-->
		<td align="right"><?php echo "Rp ".number_format($GJ->get_tjab($emp_id, $period_awal, $period_akhir),2,',','.');?></td><!-- total_gaji 11-->		
		</tr>
		<tr align="center">
		<td></td><!-- Hari_ini 1 -->
		<td></td><!-- tgl_ini 2 -->
		<td></td><!-- jam_evektif 4-->
		<td></td><!-- Gaji pokok/jam 5-->
		<td></td><!-- jam Lembur 6-->
		<td></td><!-- Gaji_pokok 7-->
		<td></td><!-- Gaji Lembur 8-->
		<td colspan=2 align="left">T masa kerja </td><!--  9-->
		<td align="right"><?php echo "Rp ".number_format($GJ->get_tmsker($emp_id, $period_awal, $period_akhir),2,',','.');?></td><!-- total_gaji 11-->		
		</tr>
		<tr align="center">
		<td></td><!-- Hari_ini 1 -->
		<td></td><!-- tgl_ini 2 -->
		<td></td><!-- jam_evektif 4-->
		<td></td><!-- Gaji pokok/jam 5-->
		<td></td><!-- jam Lembur 6-->
		<td></td><!-- Gaji_pokok 7-->
		<td></td><!-- Gaji Lembur 8-->
		<td colspan=2 align="left">Insentif Jam</td><!--  9-->
		<td align="right"><?php echo "Rp ".number_format($GJ->get_ijam($kd_periode, $emp_id),2,',','.');?></td><!-- total_gaji 11-->
		</tr>
		<tr align="center">
		<td></td><!-- Hari_ini 1 -->
		<td></td><!-- tgl_ini 2 -->
		<td></td><!-- jam_evektif 4-->
		<td></td><!-- Gaji pokok/jam 5-->
		<td></td><!-- jam Lembur 6-->
		<td></td><!-- Gaji_pokok 7-->
		<td></td><!-- Gaji Lembur 8-->
		<td colspan=2 align="left">Insentif Uang Makan </td><!--  9-->
		<td align="right"><?php 	
		
		echo "Rp ",number_format($GJ->get_ium($kd_periode, $emp_id),2,',','.');
		//echo "Rp ".$row_ium[jml_ium];?></td><!-- total_gaji 11-->
		</tr>
		<tr align="center">
		<td></td><!-- Hari_ini 1 -->
		<td></td><!-- tgl_ini 2 -->
		<td></td><!-- jam_evektif 4-->
		<td></td><!-- Gaji pokok/jam 5-->
		<td></td><!-- jam Lembur 6-->
		<td></td><!-- Gaji_pokok 7-->
		<td></td><!-- Gaji Lembur 8-->
		<td colspan=2 align="left">Total Gaji</td><!--  9-->
		<td align="right"><?php echo "Rp ".number_format($GAJI_BERSIH,2,',','.');?></td><!-- total_gaji 11-->
		</tr>
		</table>
		<?php $gaji_all=$gaji_all+$GAJI_BERSIH; 
			
		}			
		//::::::::::::::::::::::::::::::::::::::::::::: END OF PERULANGAN KARYAWAN :::::::::::::::::::::::::::::::::::::::::::::::::::::::
		echo "GAJI ALL = Rp." .number_format($gaji_all, 2, ',','.');
		$GJ->close_mysql();
		?>
		
		<!-- Akhir tabel --> 	
	<div class="clear"></div>
	</div>
<!--Footer-->
<?php require_once('footer.inc');  ?>
</body>
</html>