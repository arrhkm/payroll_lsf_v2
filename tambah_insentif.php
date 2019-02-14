<?php
require_once('connections/conn_mysqli_procedural.php');
$SQL_ijam="select MAX(kd_ijam) as n from insentif_overjam";
$rs_ijam=mysqli_query($link, $SQL_ijam) or die (mysqli_error($link));
$row_ijam=mysqli_fetch_assoc($rs_ijam);

$SQL_emp="select emp_id, t_insentif from employee WHERE emp_id='$_POST[emp_id]'";
$rs_emp=mysqli_query($link, $SQL_emp) or die (mysqli_error($link));
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
		$kd_ijam=$row_ijam[n]+1;		
		for($i=0;$i<count($_POST['cek']);$i++){
		$tgl_ijam=$_POST['cek'][$i];	
		
		$SQL_add="INSERT INTO insentif_overjam (kd_ijam, kd_periode, emp_id, tgl_ijam, jml_ijam) 
		VALUES ($kd_ijam, $_POST[kd_periode], '$_POST[emp_id]', '$tgl_ijam', $row_emp[t_insentif])";
		mysqli_query($link, $SQL_add); 
		$kd_ijam++;
		}
		?>
		<meta http-equiv='refresh' content='0; url=<?php echo "insert_insentifjam.php?emp_id=".$_POST[emp_id]."&kd_periode=".$_POST[kd_periode];?>'>
		<script type="text/javascript">
			alert("Data yang terpilih berhasil ditambah..!!!");
		</script>	
		<?php
	}?>