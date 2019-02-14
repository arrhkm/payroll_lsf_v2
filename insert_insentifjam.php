<?php 
# Koneksi 
require_once('connections/conn_mysqli_procedural.php');

$sql_periode="SELECT * FROM periode WHERE kd_periode='$_REQUEST[kd_periode]'";
$rs_periode=mysqli_query($link, $sql_periode) or die (mysqli_error($link));
$row_periode=mysqli_fetch_assoc($rs_periode);


$qry_emp = "SELECT * FROM employee WHERE emp_id='$_REQUEST[emp_id]'";
$rs_emp = mysqli_query($link, $qry_emp) or die(mysqli_error($link));
$row_emp = mysqli_fetch_assoc($rs_emp);

$sql_ijam="SELECT * FROM insentif_overjam WHERE emp_id='$_REQUEST[emp_id]' AND kd_periode='$_REQUEST[kd_periode]'";
$rs_ijam=mysqli_query($link, $sql_ijam) or die(mysqli_error($link));


$sql_absen="
SELECT * FROM absensi
WHERE tgl BETWEEN '$row_periode[tgl_awal]' AND '$row_periode[tgl_akhir]'
AND emp_id='$_REQUEST[emp_id]'
";
$rs_absen=mysqli_query($link, $sql_absen) or die(mysqli_error($link));

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
	<h2>Insert insentif gaji employee <?php echo $row_emp[emp_id].", ".$row_emp[emp_name];?></h2>     
	    
		<table class="bordered">
		<tr>
		<td>
		<form name="form1" method="POST" action="tambah_insentif.php">		
		<?php
		
				//$q = mysqli_query($link, "select * employee");
				$num_row=mysqli_num_rows($rs_absen);
				$no=1;	
			   while($row=mysqli_fetch_assoc($rs_absen))
				{ ?>
				<table border=0>
				<tr>
				<td><?php echo $no;?>
				<input type=checkbox name=cek[] value="<?php echo $row[tgl];?>" id=<?php echo "id-".$no;?>> 
				</td>
				<td><?php echo $row[tgl].", ".$row[jam_in]."-".$row[jam_out]; if ($row[jam_out]>24) echo ".:";?></td>
				</tr></table> <?php
				$no++;
				}	
				?>
				<input type=radio name=pilih onClick='for (i=1;i<<?php echo $no; ?>;i++){document.getElementById("id-"+i).checked=true;}'>Centang Semua
				<input type=radio name=pilih onClick='for (i=1;i<<?php echo $no; ?>;i++){document.getElementById("id-"+i).checked=false;}'> Hapus Semua Centang
				<input type= hidden name= "emp_id" value="<?php echo $_REQUEST['emp_id'];?>">
				<input type= hidden name= "kd_periode" value="<?php echo $_REQUEST['kd_periode'];?>">
				<input type='submit' value='Tambah' name='btn_tambah' class='bordered' onClick='return confirm("Anda yakin ingin menambah data yang terpilih???")'>
				<input type='button' value='Back' name='btn_back' class='bordered' onClick="location='emp_insentif.php?kd_periode=<?php echo $_REQUEST[kd_periode];?>'">
		</form>
		</td>
		</tr>
		</table>
		<br>
		<table class="bordered">
		<tr>
		<td>No.kd</td><td>Periode</td><td>Tanggal</td><td>Jumlah Insentif</td><td></td>
		</tr>
		<?php while ($row_ijam=mysqli_fetch_assoc($rs_ijam)) { ?>
		<tr>
		<td><?php echo $row_ijam['kd_ijam'];?></td>
		<td><?php echo $row_ijam['kd_periode'];?></td>
		<td><?php echo $row_ijam['tgl_ijam'];?></td>
		<td><?php echo $row_ijam['jml_ijam'];?></td>
		<td><a href="saveinsert_insentifjam.php?delete=1&kd_ijam=<?php echo $row_ijam['kd_ijam'];?>&emp_id=<?php echo $_REQUEST['emp_id'];?>&kd_periode=<?php echo $_REQUEST['kd_periode'];?>">Delete</a></td>
		</tr>
		<?php } ?>
		</table>
	<div class="clear"></div>
	</div>
<!--Footer-->
</body>
</html>