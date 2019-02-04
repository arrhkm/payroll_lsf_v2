<?php
require_once('connections/conn_mysqli_procedural.php');

$SQL_ium="select MAX(kd_ium) as n from insentif_uang_makan";
$rs_ium=mysqli_query($link, $SQL_ium) or die (mysqli_error($link));
$row_ium=mysqli_fetch_assoc($rs_ium);

$SQL_emp="select emp_id, uang_makan from employee WHERE emp_id='$_POST[emp_id]'";
$rs_emp=mysqli_query($link, $SQL_emp,$koneksi) or die (mysqli_error($link));
$row_emp=mysqli_fetch_assoc($rs_emp);


//echo $rs_rowsoft[n];


	if(count($_POST['cek']) < 1)
	{
		?>
			<meta http-equiv='refresh' content='0; url=<?php echo "addSoftware.php?komp_id=".$_POST[komp_id];?>'>
			<script type="text/javascript">
				alert("Tidak ada data yang terpilih...!!!");
			</script>
		<?php
	}
	else
	{
		
		//memeasukkan data kedalam tabel software secara berulang-ulang selama kurang dari count ($_POST['cek'])
		$kd_ium=$row_ium[n]+1;		
		for($i=0;$i<count($_POST['cek']);$i++){
		$tgl_ium=$_POST['cek'][$i];	
		
		$SQL_add="INSERT INTO insentif_uang_makan (kd_ium, kd_periode, emp_id, tgl_ium, jml_ium) 
		VALUES ($kd_ium, $_POST[kd_periode], '$_POST[emp_id]', '$tgl_ium', $row_emp[uang_makan])";
		mysqli_query($link, $SQL_add); 
		$kd_ium++;
		}
		?>
		<meta http-equiv='refresh' content='0; url=<?php echo "insert_insentif_ium.php?emp_id=".$_POST[emp_id]."&kd_periode=".$_POST[kd_periode];?>'>
		<script type="text/javascript">
			alert("Data yang terpilih berhasil ditambah..!!!");
		</script>	
		<?php
	}?>