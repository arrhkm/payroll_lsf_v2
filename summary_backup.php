<?php 
# Koneksi 
require_once('connections/koneksi.php');
# select DB 
mysql_select_db($database_koneksi, $koneksi);

//select periode
$query_periode="SELECT * FROM periode WHERE kd_periode='$_REQUEST[kd_periode]'";
$SQL_periode=mysql_query($query_periode,$koneksi);
$row_periode=mysql_fetch_array($SQL_periode);
$period_awal=$row_periode[tgl_awal];
$period_akhir=$row_periode[tgl_akhir];

//--------end select periode

//-----JUMALAH SELISIH HARI PERIODE--------
$SQL_jedah=mysql_query("SELECT DATEDIFF('$period_akhir','$period_awal') as jedah",$koneksi);
$rs_jedah=mysql_fetch_array($SQL_jedah);
$jedah=$rs_jedah[jedah];


$sql_emp="
SELECT a.*, b.nama_jabatan FROM employee a, jabatan b
WHERE b.kd_jabatan= a.kd_jabatan
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
<style>


</style>

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
	    <h2>Summary</h2>        		
		<!-- Awal tabel -->
		<table class="bordered" cellpadding=0 cellspacing=0 >
		<thead>
		<tr align="center">		
		<th width=100>BAGED ID</th><!-- Gaji_pokok 7-->
		<th width=250>NAMA</th><!-- nama -->
		<th width=200>Jabatan</th><!-- jabatan 8-->		
		<th width=200>Gaji</th><!-- total_gaji 11-->
		<th width=50>WT</th><!-- WT -->
		<th width=50>PT</th><!-- PT -->
		<th width=150>No. Rekening</th><!-- PT -->
		
		</tr>
		</thead>
		<?php
		//:::::::::::::::::::::::    PERULANGAN ALL KARYAWAN  :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
		$SUM_GJ_BERSIH=0;
		$SUM_JE_BERSIH=0;
		$SUM_JL_BERSIH=0;
		$SUM_PT_BERSIH=0;
		$GAJI_BERSIH=0;
		while ($row_emp=mysql_fetch_array($rs_emp)) { 
		$emp_id=$row_emp[emp_id];
		
		//MENJUMLAH  PLUSMIN GAji jika ada
		//$qry_plusmin="select emp_id, jml_plus, jml_min from plusmin_gaji where emp_id='$row_emp[emp_id]' and tgl_plusmin='$tgl_ini'";
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
		
		//MENAMBHKAN CICILAN KASBON
		$sql_kasbon="SELECT a.kd_cicilan, a. kd_kasbon, a.kd_periode, sum(a.jml_cicilan) as jml_cicilan, c.emp_id from cicilan_kasbon a, kasbon b, employee c
		WHERE b.kd_kasbon=a.kd_kasbon
		AND b.emp_id=c.emp_id
		AND a.kd_periode ='$_REQUEST[kd_periode]'
		AND c.emp_id='$row_emp[emp_id]'";
		$rs_kasbon=mysql_query($sql_kasbon, $koneksi) or die(mysql_error());
		$row_kasbon=mysql_fetch_assoc($rs_kasbon);
		//-------------------------------------------------------
		//SALDO KASBON
		$sql_saldo="SELECT a.jml_kasbon, sum(b.jml_cicilan) as cicilan, (a.jml_kasbon-sum(b.jml_cicilan)) as saldo
		FROM kasbon a, cicilan_kasbon b, employee c
		WHERE b.kd_kasbon=a.kd_kasbon
		AND b.kd_periode='$_REQUEST[kd_periode]'
		AND a.emp_id=c.emp_id
		AND c.emp_id='$row_emp[emp_id]'
		GROUP BY a.kd_kasbon";
		$rs_saldo=mysql_query($sql_saldo, $koneksi) or die(mysql_error());
		$row_saldo=mysql_fetch_assoc($rs_saldo);		
		//---------------------------------------------------------
		if($row_periode[potongan_jamsos]==1){
			$pot_jamsos=$row_emp[pot_jamsos];
		}

		//----------------------------------------
		?>
		
		<?php 
		//definisi jam awal
		$jam_masuk="07:00";
		$jam_ev=0;
		$jam_lembur=0;
		$GP=0;
		$GL=0;
		$GT=0;
		$cicil=0;
		$t_jab=0;
		$pot_telat=0;
		
		$SUM_JE=0;
		$SUM_GT=0;
		$SUM_GP=0;
		$SUM_GL=0;
		$SUM_UM=0;
		$SUM_JE=0;
		$SUM_JL=0;
		$SUM_PT=0;
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
			

			$sql_absensi= "SELECT a.tgl, a.jam_in, a.jam_out, TIMEDIFF(a.jam_in,'07:00:00') as jt, SUBSTR(TIMEDIFF(a.jam_out, a.jam_in),1,2) as jam_kerja
			FROM absensi a, employee b, jabatan c
			WHERE 
			b.emp_id='$emp_id' 
			and a.emp_id=b.emp_id 
			and c.kd_jabatan=b.kd_jabatan
			and a.tgl ='$tgl_ini'";
			$rs_absensi= mysql_query($sql_absensi, $koneksi)or die(mysql_error());
			$row_absensi= mysql_fetch_array($rs_absensi);

			//Mengambil isi jam dan menit IN dan OUT
			$arr_out=explode(":",$row_absensi[jam_out]);
			$arr_in =explode(":",$row_absensi[jam_in]);
			$njam_out=$arr_out[0];//jam out
			$njam_in=$arr_in[0];//jam in
			$njam_in2=$arr_in[1];//menit in
			//--------------------end------------------
			
			//MENGHITUNG TELAT
			List($h,$m,$s)=explode(":",$row_absensi[jt]);
			if($njam_in>=7){
			$tl_jam=$h;
			$tl_menit=$m;
			}else {
			$tl_jam=0;
			$tl_menit=0;
			}
			//----end-------------
					
			
			//MENCARI TGL SAFETY TALK
			$qry_safety="select emp_id from safety_talk where emp_id='$row_emp[emp_id]' and tgl_safety='$tgl_ini'";
			$sql_safety=mysql_query($qry_safety,$koneksi);
			$safety_talk=mysql_num_rows($sql_safety);
			
			//MENCARI TGL MERAH----------
			$qry_libur="select tgl_libur from tanggal_libur where kd_periode=1 and tgl_libur='$tgl_ini'";
			$sql_libur=mysql_query($qry_libur,$koneksi);
			$libur=mysql_num_rows($sql_libur);

			//:::::::::::::::::::::::::::::::::: LOGIKA PENENTUAN TANGGAL :::::::::::::::::::::::::::::::::::::::::::::::
			//JIKA ABSEN
			if (strtotime($row_absensi[tgl])==null || $njam_in==0) {
			$ket="ABSEN";
			$jam_ev=0;
			$UM=0;
			$jam_lembur=0;
			$gaji_pokok=$row_emp[gaji_pokok]/7;
			$t_jab=0;
			$t_msker=0;
			$pot_safety=0;
			}//JIKA AKHIR PERIODE
			elseif(strtotime($row_absensi[tgl])==strtotime($period_akhir)){
				$ket="Akhir";
				if($libur>=1){
					$ket="TGL_MERAH $tgl_merah";
					include 'logika_libur_diakhir.php';
					$gaji_pokok=$row_emp[gaji_pokok]/7;
					$pot_safety=0;
				}
				else
				//potongan safety
				if ($safety_talk>0){ $pot_safety=7500; } else{ $pot_safety=0; }
				include 'logika_akhir.php';
				$gaji_pokok=$row_emp[gaji_pokok]/7;
				$t_jab=$row_emp[t_jabatan];
				$t_msker=$row_emp[t_masakerja];
			}//JIKA GANTUNGAN
			elseif(strtotime($row_absensi[tgl])==strtotime($period_awal)) {
				$ket="Gantungan";
			//potongan safety
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
				$pot_safety=0;
			}
			//JIKA SABTU
			elseif(date("l", strtotime($row_absensi[tgl]))=="Saturday") {
				$ket="Saturday";
				$pot_safety=0;
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
				$pot_safety=0;
			}
			//JIKA NORMAL
			else{
				//potongan safety
				if ($safety_talk>0){ $pot_safety=7500; } else{ $pot_safety=0; }
				$ket="Normal";
				include 'logika_normal.php';
				$gaji_pokok=$row_emp[gaji_pokok]/7;
				$t_jab=$row_emp[t_jabatan];
				$t_msker=$row_emp[t_masakerja];
			}
			//::::::::::::::::::::::::::::::::::::::::: END OF LOGIKA PENENTUAN TANGGAL :::::::::::::::::::::::::::::::::::::::::
			
						
			if (($tl_jam >=0) and ($tl_menit>5))
				$potongan_telat=$row_emp['pot_telat'];
			else 
				$potongan_telat=0;
							
			$GP=ceil($jam_ev*$gaji_pokok);//jumlah gaji pokok	
			$GL=ceil($jam_lembur*$row_emp[gaji_lembur]);//jumlah gaji lembur
			$GT=$GP+$GL+$UM-$potongan_telat;//jumlah gaji
			
			
			$SUM_GT=$SUM_GT+$GT;
			$SUM_GP=$GP+$SUM_GP;
			$SUM_GL=$GL+$SUM_GL;
			$SUM_UM=$SUM_UM+$UM;
			$SUM_JE=$SUM_JE+$jam_ev;
			$SUM_JL=$SUM_JL+$jam_lembur;
			$SUM_PT=$SUM_JL+$SUM_JE;
			$SUM_TJAB=$SUM_TJAB + $t_jab;
			$SUM_TMSKER=$SUM_TMSKER + $t_msker;
			$SUM_POT_SAFETY=$SUM_POT_SAFETY+$pot_safety;
							
			} 
		//:::::::::::::::::::::::::::::::::::::::::::::::::::: END OF PERIODE ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
		//::::::::::::::::::::::::::::::::::::::::::::::::TOTAL GAJI ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
		$GAJI_BERSIH=$SUM_GT-$pot_jamsos-$cicil+$SUM_TJAB+$SUM_TMSKER-$SUM_POT_SAFETY+$row_plusmin[jml_plus]-$row_plusmin[jml_min]-$row_kasbon[jml_cicilan]+$row_ijam[jml_ijam]; 
		
		//---------------------------------------------
		?>	
		
		<tr align="center">		
		<td width=100 align="left"><?php echo $row_emp[emp_id];?>
		<td width=250 align="left"><?php echo $row_emp[emp_name];?>
		<td width=200><?php echo $row_emp[nama_jabatan];?>		
		<td width="200" align="right"><?php echo "Rp ".number_format($GAJI_BERSIH,2,',','.');?></td>
		<td width="50" align="right"><?php echo $SUM_JE;?></td>
		<td width="50" align="right"><?php echo $SUM_PT;?></td>
		<td width=150><?php echo $row_emp[no_rekening];?></td>
		
		</tr 
		</table>
		<?php
			$SUM_GJ_BERSIH=$SUM_GJ_BERSIH+$GAJI_BERSIH;
			$SUM_JE_BERSIH=$SUM_JE_BERSIH+$SUM_JE;
			$SUM_JL_BERSIH=$SUM_JL_BERSIH+$SUM_JL;
			$SUM_PT_BERSIH=$SUM_PT_BERSIH+$SUM_PT;
		} 
		//::::::::::::::::::::::::::::::::::::::::::::: END OF PERULANGAN KARYAWAN :::::::::::::::::::::::::::::::::::::::::::::::::::::::
		?>
		<table class="bordered" cellpadding=0 cellspacing=0>
		<thead>
		<tr>
		<th width=100>JUMLAH</th>
		<th width=250></th>
		<th width=200></th>
		<th width=200 align="right"><?php echo "Rp ".number_format($SUM_GJ_BERSIH,2,',','.'); ?></th>
		<th width=50 align="right"><?php echo $SUM_JE_BERSIH;?></th>
		<th width=50 align="right"><?php echo $SUM_PT_BERSIH;?></th>
		<th width=150></th>		
		</tr>
		</thead>
		</table>
		
		<!-- Akhir tabel --> 	
	<div class="clear"></div>
	</div>
<!--Footer-->
</body>
</html>