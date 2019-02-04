<?php
# Koneksi 
require_once('connections/conn_mysqli_procedural.php');
require_once('includes/fungsi_hari.php');
# select DB 
//mysql_select_db($database_koneksi);

$sql_cek="SELECT a.no_kartu, a.emp_number_kartu, b.id, date(b.timestamp) as tanggal_log, b.verifikasi, b.timestamp
FROM hs_hr_emp_kartu a, hs_hr_emp_absensi b
WHERE b.id= a.no_kartu
AND a.emp_number_kartu='$_REQUEST[emp_id]'
AND date(b.timestamp) between '$_REQUEST[tgl_start]' AND '$_REQUEST[tgl_end]'";
$rs_cek=mysqli_query($link, $sql_cek);

?>
<html>
<link href="css/hkm_table.css" rel="stylesheet" type="text/css" />
<body>
<table border ="0" class="hkm-table">
	<tr align="center">
		<th>no. </th> 
		<th>emp_id </th>
		<th>tanggal </th> 
		<th>verifikasi </th> 
		<th>timestamp </th> 
	</tr>
	<?php while ($row_cek=mysqli_fetch_assoc($rs_cek)) { ?>
	<tr align="center">
		<td><?php echo $row_cek['id']; ?></td> 
		<td><?php echo $row_cek['emp_number_kartu']; ?>  </td>
		<td><?php echo $row_cek['tanggal_log']; ?> </td> 
		<td><?php echo $row_cek['verifikasi']; ?></td> 
		<td><?php echo $row_cek['timestamp']; ?></td> 
	</tr>
	<?php } ?>
</body>
</html>