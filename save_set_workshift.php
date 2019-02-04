<?php
require_once('connections/conn_mysqli_procedural.php');


if ($_REQUEST[delete]==1) {
		$qry_del="DELETE FROM set_workshift WHERE id_workshift=$_REQUEST[id_workshift] AND emp_id='$_REQUEST[emp_id]'";
		if (mysqli_query($link, $qry_del)){
		header("location:set_workshift_insert.php?id_workshift=$_REQUEST[id_workshift]");
		}
	
}
else

	if(count($_POST['cek']) < 1)
	{
		?>
			<meta http-equiv='refresh' content='0; url=<?php echo "set_workshift_insert.php?id_workshift=".$_POST[id_workshift];?>'>
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
		
		$SQL_add="INSERT INTO set_workshift (id_workshift, emp_id) 
		VALUES ($_POST[id_workshift], '$emp_id')";
		mysqli_query($link, $SQL_add); 
		//$kd_ijam++;
		}
		?>
		<meta http-equiv='refresh' content='0; url=<?php echo "set_workshift_insert.php?emp_id=".$emp_id."&id_workshift=".$_POST[id_workshift];?>'>
		<script type="text/javascript">
			alert("Data yang terpilih berhasil ditambah..!!!");
		</script>	
		<?php
	}

?>