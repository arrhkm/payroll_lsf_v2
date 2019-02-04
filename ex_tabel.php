<?php
require('./fpdf/fpdf.php');
# Koneksi 
require_once('connections/koneksi.php');
# select DB 
mysql_select_db($database_koneksi, $koneksi);


//Variabel awal 
$kd_project=1;
$kd_periode=5;

//select periode
$query_periode="SELECT * FROM periode WHERE kd_periode=$kd_periode";
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
SELECT c.*, d.nama_jabatan, a.nama_project, a.luar_pulau 
FROM project a, ikut_project b, employee c, jabatan d
WHERE b.kd_project= a.kd_project
AND d.kd_jabatan=c.kd_jabatan
AND c.emp_id=b.emp_id
AND a.kd_project=$kd_project
";
$rs_emp=mysql_query($sql_emp, $koneksi) or die(mysql_error());
		$GAJI_BERSIH=0;
		//:::::::::::::::::::::::    PERULANGAN ALL KARYAWAN  :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
		while ($row_emp=mysql_fetch_array($rs_emp)) { 
		?> <table border=1 cellpadding="0px" cellspacing="0px" > <?php 
		echo "$row_emp[emp_name] - $row_emp[jabtan] - $row_emp[emp_id] - $row_periode[nama_periode]";;
		$emp_id=$row_emp[emp_id];
		//$GAJI_BERSIH=0;
		
		//MENJUMLAH  PLUSMIN GAji jika ada
		//$qry_plusmin="select emp_id, jml_plus, jml_min from plusmin_gaji where emp_id='$row_emp[emp_id]' and tgl_plusmin='$tgl_ini'";
		$sql_plusmin="SELECT SUM(jml_plus) as jml_plus, sum(jml_min) as jml_min 
		FROM plusmin_gaji 
		where kd_periode =$kd_periode AND emp_id='$row_emp[emp_id]'";
		$rs_plusmin=mysql_query($sql_plusmin,$koneksi) or die (mysql_error());
		$row_plusmin=mysql_fetch_assoc($rs_plusmin);
		
		//MENJUMLAH INSENTIF GAJI
		$sql_ijam="SELECT SUM(jml_ijam) as jml_ijam 
		FROM insentif_overjam
		where kd_periode =$kd_periode AND emp_id='$row_emp[emp_id]'";
		$rs_ijam=mysql_query($sql_ijam,$koneksi) or die (mysql_error());
		$row_ijam=mysql_fetch_assoc($rs_ijam);
		
		//MENAMBHKAN CICILAN KASBON
		$sql_kasbon="SELECT a.kd_cicilan, a. kd_kasbon, a.kd_periode, sum(a.jml_cicilan) as jml_cicilan, c.emp_id from cicilan_kasbon a, kasbon b, employee c
		WHERE b.kd_kasbon=a.kd_kasbon
		AND b.emp_id=c.emp_id
		AND a.kd_periode ='$kd_periode'
		AND c.emp_id='$row_emp[emp_id]'";
		$rs_kasbon=mysql_query($sql_kasbon, $koneksi) or die(mysql_error());
		$row_kasbon=mysql_fetch_assoc($rs_kasbon);
		//-------------------------------------------------------
		//SALDO KASBON
		$sql_saldo="SELECT a.jml_kasbon, sum(b.jml_cicilan) as cicilan, (a.jml_kasbon-sum(b.jml_cicilan)) as saldo
		FROM kasbon a, cicilan_kasbon b, employee c
		WHERE b.kd_kasbon=a.kd_kasbon
		AND b.kd_periode='$kd_periode'
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
			$qry_libur="select tgl_libur from tanggal_libur where kd_periode=$kd_periode and tgl_libur='$tgl_ini'";
			$sql_libur=mysql_query($qry_libur,$koneksi);
			$libur=mysql_num_rows($sql_libur);

			//:::::::::::::::::::::::::::::::::: LOGIKA PENENTUAN TANGGAL :::::::::::::::::::::::::::::::::::::::::::::::
			//JIKA ABSEN
			if (strtotime($row_absensi[tgl])==null || $njam_in==0) {
				if ($row_emp['luar_pulau']==1) {
				$ket="ABSEN";
				$jam_ev=0;
				$UM=$row_emp['uang_makan'];
				$jam_lembur=0;
				$gaji_pokok=$row_emp[gaji_pokok]/7;
				$t_jab=0;
				$t_msker=0;
				$pot_safety=0;
				} else {
				$ket="ABSEN";
				$jam_ev=0;
				$UM=0;
				$jam_lembur=0;
				$gaji_pokok=$row_emp[gaji_pokok]/7;
				$t_jab=0;
				$t_msker=0;
				$pot_safety=0;
				}
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
			?>			
			<tr>
			<td><?php echo $hari=date("l",strtotime($tgl_ini));?></td>
			<td><?php echo $tgl_ini;?></td>
			<td><?php echo $jam_ev;?></td>
			<td><?php echo ceil($gaji_pokok);?></td>
			<td><?php echo $jam_lembur;?></td>
			<td><?php echo "$GP";?></td>
			<td><?php echo "$GL";?></td>
			<td><?php echo "$UM";?></td>
			<td><?php echo "$potongan_telat";?></td>	
			<td bgcolor="" align="right"><?php echo number_format($GT,2,',','.');?></td>			
			</tr>				
			<?php
			} 
				
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
			
			
			<tr >
			<td colspan="10"> <?php
		
		echo "Kasbon : ".number_format($row_saldo[jml_kasbon],2,',','.');echo "Pot. Jamsos : ".number_format($pot_jamsos,2,',','.')." <br>";
		echo "Cicilan : ".number_format($row_saldo[jml_cicilan],2,',','.');echo "T. jabatan : ".number_format($SUM_TJAB,2,',','.')." <br>";
		echo "Sisa Saldo :".number_format($row_saldo[saldo],2,',','.');echo "T. Masa Kerja : ".number_format($SUM_TMSKER,2,',','.')." <br>";
		echo "Pot. Savetytalk : ".number_format($SUM_POT_SAFETY,2,',','.')." <br>";
		echo "Kekurangan : ".number_format($row_plusmin[jml_plus],2,',','.')." <br>";
		echo "Kelebihan : ".number_format($row_plusmin[jml_min],2,',','.')." <br>";
		echo "Insentif : ".number_format($row_ijam[jml_ijam],2,',','.')." <br>";
		echo "Total gaji : ".number_format($GAJI_BERSIH,2,',','.')." <br>";
		
		?></td></tr>		
		</table> <?php
		}
			

?>
