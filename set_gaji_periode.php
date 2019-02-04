<?php 
require_once('connections/conn_mysqli_procedural.php');
//$db = New Database();
//$db->Connect();

if (isset($_REQUEST['kd_periode'])) {

	echo "kode periode = ".$_REQUEST['kd_periode'];
	$SQL_periode="SELECT * FROM periode WHERE kd_periode='$_REQUEST[kd_periode]'";
	$rs_periode=mysqli_query($link, $SQL_periode);
	$row_periode=mysqli_fetch_assoc($rs_periode);
	echo "<br> Tanggal awal : ".$row_periode['tgl_awal'];
	echo "<br> Tanggal akhir : ".$row_periode['tgl_akhir'];
	$SQL_jedah="SELECT DATEDIFF('$row_periode[tgl_akhir]','$row_periode[tgl_awal]') as jedah";
	$RS_jedah=mysqli_query($link, $SQL_jedah);
	$ROW_jedah=mysqli_fetch_assoc($RS_jedah);
	//$JML_row=$db->num_rows($RS_jedah);
	echo "<br> jedah  : ".$ROW_jedah[jedah];
	$SQL_emp="SELECT * FROM employee";
	$RS_emp=mysqli_query($link, $SQL_emp);
	while ($ROW_emp=mysqli_fetch_assoc($RS_emp)) 
	{
		echo "<br> ".$ROW_emp['emp_id'];
		for ($i=0; $i<=$ROW_jedah[jedah];$i++) 
		{
			$tgl_ini = strtotime("+$i day" ,strtotime($row_periode['tgl_awal']));
			$tgl_ini = date('Y-m-d', $tgl_ini);
			echo "<br> ".$tgl_ini;	
			$SQL_gj="INSERT IGNORE gaji_periode
			(emp_id, 
			kd_periode, 
			tgl_gaji, 
			gaji_pokok,
			gaji_lembur, 
			pot_jamsos, 
			t_jabatan, 
			t_masakerja, 
			t_jam, 
			pot_telat, 
			uang_makan
			) 
			VALUES('$ROW_emp[emp_id]', $_REQUEST[kd_periode], '$tgl_ini',	{$ROW_emp[gaji_pokok]},
			$ROW_emp[gaji_lembur],
			$ROW_emp[pot_jamsos],
			$ROW_emp[t_jabatan],
			$ROW_emp[t_masakerja],
			$ROW_emp[t_insentif],
			$ROW_emp[pot_telat],
			$ROW_emp[uang_makan])
			";
			if (mysqli_query($link, $SQL_gj))
			echo "sudah disimpan";
			else echo "gagal disimpan";
		}
		$x="
		
		$ROW_emp[gaji_lembur],
			$ROW_emp[pot_jamsos],
			$ROW_emp[t_jabatan],
			$ROW_emp[t_masakerja],
			$ROW_emp[t_insentif],
			$ROW_emp[pot_telat],
			$ROW_emp[uang_makan])";
	}
}

?>