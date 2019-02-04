<?php 
# Koneksi 
require_once('connections/koneksi.php');
# select DB 
mysql_select_db($database_koneksi, $koneksi);

//Variabel awal 
$kd_project=$_REQUEST['kd_project'];
$kd_periode=$_REQUEST['kd_periode'];
//Select Employee
/*$sql_emp="
SELECT a.*, b.nama_jabatan FROM employee a, jabatan b
WHERE b.kd_jabatan= a.kd_jabatan
";*/
$sql_emp="
SELECT c.*, d.nama_jabatan, a.nama_project, a.luar_pulau 
FROM project a, ikut_project b, employee c, jabatan d
WHERE b.kd_project= a.kd_project
AND d.kd_jabatan=c.kd_jabatan
AND c.emp_id=b.emp_id
AND a.kd_project=$kd_project
";
$rs_emp=mysql_query($sql_emp, $koneksi) or die(mysql_error());

//select periode
$query_periode="SELECT * FROM periode WHERE kd_periode=$_REQUEST[kd_periode]";
$SQL_periode=mysql_query($query_periode,$koneksi);
$row_periode=mysql_fetch_array($SQL_periode);
$period_awal=$row_periode[tgl_awal];
$period_akhir=$row_periode[tgl_akhir];
//--------end select periode

//-----JUMALAH SELISIH HARI PERIODE--------
$SQL_jedah=mysql_query("SELECT DATEDIFF('$period_akhir','$period_awal') as jedah",$koneksi);
$rs_jedah=mysql_fetch_array($SQL_jedah);
$jedah=$rs_jedah[jedah];


?>
<html>
<body>
<style>
table

{

border-collapse:collapse;

}

table,th, td

{

border: 1px solid black;

}
  .my-table {
    page-break-before: always;
    page-break-after: always;
  }
  .my-table tr {
    page-break-inside: avoid;
  }
</style>
<?php
$rs_emp=mysql_query($sql_emp, $koneksi) or die(mysql_error());

		$GAJI_BERSIH=0;
		//:::::::::::::::::::::::    PERULANGAN ALL KARYAWAN  :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
		$baris=1;
		while ($row_emp=mysql_fetch_array($rs_emp)) { 
		$emp_id=$row_emp[emp_id];	
		
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
		//echo $baris%4;
		?>
		<br>
		<table <?php if ($baris%4==0){ ?> style="page-break-before: always;"<?php } ?> class="bordered" border="1" cellpadding="0px" cellspacing="0px" align = "" width = "1200px">		
		<tr 20px" align = "left">
		<td colspan=7>&nbsp;&nbsp;
			Nama : <?php echo $row_emp[emp_name];?>			
		</td>
		<td colspan=3>
		&nbsp;&nbsp;<?php echo "$row_periode[tgl_awal] s/d $row_periode[tgl_akhir]";?>
		</td>	
		</tr>
		<tr height="20px" align = "left">
		<td colspan=7>			
			&nbsp;&nbsp; Jabatan : <?php echo $row_emp[nama_jabatan];?>
		</td>
		<td colspan=3>		
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
		//$pot_telat=0;

		$SUM_GT=0;
		$SUM_GP=0;
		$SUM_GL=0;
		$SUM_UM=0;
		$SUM_JE=0;
		$SUM_JL=0;
		//$SUM_PT=0;
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
			//List($h,$m,$s)=explode(":",$row_absensi[jt]);
			List($h,$m,$s)=explode(":",$row_absensi[jam_in]);
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
			$qry_libur="select tgl_libur from tanggal_libur where kd_periode=$_REQUEST[kd_periode] and tgl_libur='$tgl_ini'";
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
				if ($safety_talk>0){ $pot_safety=5000; } else{ $pot_safety=0; }
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
				if ($safety_talk>0){ $pot_safety=500; } else{ $pot_safety=0; }
				$ket="Normal";
				include 'logika_normal.php';
				$gaji_pokok=$row_emp[gaji_pokok]/7;
				$t_jab=$row_emp[t_jabatan];
				$t_msker=$row_emp[t_masakerja];
			}
						
			if (($tl_jam >=0) and ($tl_menit>5)) {
				$potongan_telat=$row_emp['pot_telat'];}
			else {
				$potongan_telat=0;}
							
			$GP=ceil($jam_ev*$gaji_pokok);//jumlah gaji pokok	
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
			//
			?>
			<tr>
			<td align="left"><?php echo $hari=date("l",strtotime($tgl_ini));?></td>
			<td align="center"><?php echo $tgl_ini;?></td>
			<td align="center"><?php echo $jam_ev;?></td>
			<td align="right"><?php echo ceil($gaji_pokok);?></td>
			<td align="center"><?php echo $jam_lembur;?></td>
			<td align="right"><?php echo "$GP";?></td>
			<td align="right"><?php echo "$GL";?></td>
			<td align="right"><?php echo "$UM";?></td>
			<td align="right"><?php echo "$potongan_telat";?></td>	
			<td align="right"><?php echo number_format($GT,2,',','.');?></td>			
			</tr>
			<?php
			$sql_slip="INSERT INTO slip_gaji (`kd_periode`, `kd_emp`, `tgl`, `hari`, `jam_ev`, `jam_lembur`, `GP_J`, `GP_L`, `GP`, `GL`, `UM`, `POT_TEL`, `JAMSOSTEK`, `KASBON`, `TG`) 

			VALUES ('$_REQUEST[kd_periode]', '$row_emp[emp_id]', '$tgl_ini', '$hari', $jam_ev, $jam_lembur,'','','','','','','','','')";
			//$rs_slip=mysql_query($sql_slip, $koneksi) or die (mysql_error());
			?>
			<?php } 
		//:::::::::::::::::::::::::::::::::::::::::::::::::::: END OF PERIODE ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
		//::::::::::::::::::::::::::::::::::::::::::::::::TOTAL GAJI ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
		$GAJI_BERSIH=$SUM_GT-$pot_jamsos-$cicil+$SUM_TJAB+$SUM_TMSKER-$SUM_POT_SAFETY+$row_plusmin[jml_plus]-$row_plusmin[jml_min]-$row_kasbon[jml_cicilan]+$row_ijam[jml_ijam]; 

		//---------------------------------------------
		?>
		<tr align="center" bgcolor="Yellow">
		<td>Jumalah</td><!-- Hari_ini 1 -->
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
		<td colspan=5 align="left">Kasbon :&nbsp;<?php echo number_format($row_saldo[jml_kasbon],2,',','.');?></td><!-- Jumlah Kasbon 4-->
		<td colspan=2 align="left">Cicil Kasbon</td><!--  9-->
		<td align="right"><?php echo number_format($row_kasbon['jml_cicilan'],2,',','.');?></td><!-- cicilan Kasbon hari ini 11-->		
		</tr>
		<tr align="center">
		<td></td><!-- Hari_ini 1 -->
		<td></td><!-- tgl_ini 2 -->
		<td colspan=5 align="left">Sisa Kasbon :&nbsp;<?php echo number_format($row_saldo[saldo],2,',','.');?></td><!-- SIsa Kasbon 4-->
		<td colspan=2 align="left">Jamsostek</td><!-- -->
		<td align="right"><?php echo $pot_jamsos;?></td><!-- Potongan Jamsos 11-->		
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
		<td align="right"><?php echo "Rp ".number_format($SUM_TJAB,2,',','.');?></td><!-- total_gaji 11-->		
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
		<td align="right"><?php echo "Rp ".number_format($SUM_TMSKER,2,',','.');?></td><!-- total_gaji 11-->		
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
		<td align="right"><?php echo "Rp ".number_format($SUM_POT_SAFETY,2,',','.');?></td><!-- total_gaji 11-->		
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
		<td align="right"><?php echo "Rp ".number_format($row_plusmin[jml_plus],2,',','.');?></td><!-- total_gaji 11-->		
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
		<td align="right"><?php echo "Rp ".number_format($row_plusmin[jml_min],2,',','.');?></td><!-- total_gaji 11-->		
		</tr>		
		<tr align="center">
		<td></td><!-- Hari_ini 1 -->
		<td></td><!-- tgl_ini 2 -->
		<td></td><!-- jam_evektif 4-->
		<td></td><!-- Gaji pokok/jam 5-->
		<td></td><!-- jam Lembur 6-->
		<td></td><!-- Gaji_pokok 7-->
		<td></td><!-- Gaji Lembur 8-->
		<td colspan=2 align="left">Insentif </td><!--  9-->
		<td align="right"><?php echo "Rp ".number_format($row_ijam[jml_ijam],2,',','.');?></td><!-- total_gaji 11-->
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
		
		<?php $baris++;}
		//::::::::::::::::::::::::::::::::::::::::::::: END OF PERULANGAN KARYAWAN :::::::::::::::::::::::::::::::::::::::::::::::::::::::
		?>
</body>
</html>