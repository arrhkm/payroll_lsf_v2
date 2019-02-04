<?php
require_once('connections/koneksi.php');
mysql_select_db($database_koneksi, $koneksi);

if ($_REQUEST[cancel]==1) {
	$qry_set="UPDATE jamsostek_pending SET kd_periode2 = null WHERE kd_periode1='$_REQUEST[kd_periode1]' 
	AND emp_id='$_REQUEST[emp_id]'";
	if (mysql_query($qry_set)) {
		header("location:jamsostek_pending_setup.php?kd_periode=$_REQUEST[kd_periode]");
		}
}
if ($_REQUEST[set_inperiode]==1) {
	$qry_set="UPDATE jamsostek_pending SET kd_periode2 = '$_REQUEST[kd_periode]' WHERE kd_periode1='$_REQUEST[kd_periode1]' 
	AND emp_id='$_REQUEST[emp_id]'";
	if (mysql_query($qry_set)) {
		header("location:jamsostek_pending_setup.php?kd_periode=$_REQUEST[kd_periode]");
		}
}
if ($_REQUEST[delete]==1) {
		$qry_del="DELETE FROM jamsostek_pending WHERE kd_periode1=$_REQUEST[kd_periode] AND emp_id='$_REQUEST[emp_id]'";
		if (mysql_query($qry_del)){
		header("location:jamsostek_pending.php?kd_periode=$_REQUEST[kd_periode]");
		}
	
}
else if ($_REQUEST[del_all]==1) {
	$qry_del="DELETE FROM jamsostek_pending WHERE kd_periode1=$_REQUEST[kd_periode]";
		if (mysql_query($qry_del)){
		header("location:jamsostek_pending.php?kd_periode=$_REQUEST[kd_periode]");
		}
}
else


	if(count($_POST['cek']) < 1)
	{
		?>
			<meta http-equiv='refresh' content='0; url=<?php echo "insert_jamsostek_pending.php?kd_periode=".$_POST[kd_periode]."&emp_id=".$_POST[emp_id];?>'>
			<script type="text/javascript">
				alert("Tidak ada data yang terpilih...!!!");
			</script>
		<?php
	}
	else
	{
		
		//memeasukkan data kedalam tabel software secara berulang-ulang selama kurang dari count ($_POST['cek'])
		//$kd_ijam=$row_ijam[n]+1;		
		for($i=0;$i<count($_POST['cek']);$i++){
		$emp_id=$_POST['cek'][$i];	
		$qry_emp="SELECT pot_jamsos FROM employee WHERE emp_id='$emp_id'";
		$rs_emp=mysql_query($qry_emp,$koneksi);
		$row_emp=mysql_fetch_array($rs_emp);
		$SQL_add="REPLACE INTO jamsostek_pending (kd_periode1, emp_id, pot_jamsostek) 
		VALUES ($_POST[kd_periode], '$emp_id', $row_emp[pot_jamsos])";
		mysql_query($SQL_add); 
		//$kd_ijam++;
		}
		?>
		<meta http-equiv='refresh' content='0; url=<?php echo "insert_jamsostek_pending.php?emp_id=".$emp_id."&kd_periode=".$_POST[kd_periode];?>'>
		<script type="text/javascript">
			alert("Data yang terpilih berhasil ditambah..!!!");
		</script>	
		<?php
	}

?>