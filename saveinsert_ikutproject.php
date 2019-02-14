<?php
require_once('connections/conn_mysqli_procedural.php');
//mysql_select_db($database_koneksi, $koneksi);

if ($_REQUEST[delete]==1) {
		$qry_del="DELETE FROM ikut_project WHERE kd_project=$_REQUEST[kd_project] AND emp_id='$_REQUEST[emp_id]'";
		if (mysqli_query($link, $qry_del)){
		header("location:ikut_project.php?kd_project=$_REQUEST[kd_project]");
		}
	
}
else

	if(count($_POST['cek']) < 1)
	{
		?>
			<meta http-equiv='refresh' content='0; url=<?php echo "insert_ikutproject.php?kd_project=".$_POST[kd_project];?>'>
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
		
		$SQL_add="INSERT INTO ikut_project (kd_project, emp_id) 
		VALUES ($_POST[kd_project], '$emp_id')";
		mysqli_query($link, $SQL_add); 
		//$kd_ijam++;
		}
		?>
		<meta http-equiv='refresh' content='0; url=<?php echo "insert_ikutproject.php?emp_id=".$emp_id."&kd_project=".$_POST[kd_project];?>'>
		<script type="text/javascript">
			alert("Data yang terpilih berhasil ditambah..!!!");
		</script>	
		<?php
	}

?>