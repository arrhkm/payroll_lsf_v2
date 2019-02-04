<?php 
# Koneksi 
require_once('connections/conn_mysqli_procedural.php');

$qry_project = "Select * from project";
$rs_project = mysqli_query($link, $qry_project) or die(mysqli_error($link));
$SQL_periode = "SELECT * FROM periode ORDER BY tgl_awal DESC LIMIT 0,20";
$rs_periode = mysqli_query($link, $SQL_periode) or die(mysqli_error($link));

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
	
		<div class="half left">
		<form name="form1" method="POST" action="report_potongan.php">
		<table class="bordered" width="">
		<th colspan = "2" align=Left>SELECT PROJECT & PERIODE PAYROLL</th>		
		<tr>
		<td>
		Project : 
		</td>
		<td align="left">
		<select name="kd_project">
		<?php while ($row_project=mysqli_fetch_assoc($rs_project)) { ?>
			<option value=<?php echo $row_project['kd_project'];?>><?php echo $row_project['nama_project'];?></option>
		<?php } ?>
		</select>
		</td>		
		</tr>
		<tr>
		<td>Periode : </td>
		<td><select name="kd_periode">
		<?php while ($row_periode=mysqli_fetch_assoc($rs_periode)) { ?>
			<option value=<?php echo $row_periode['kd_periode'];?>><?php echo $row_periode['nama_periode'];?></option>
		<?php } ?>
		</select>
		</td>
		</tr>
		<tr>
		<td colspan=2>
		<input name=btn_cetak type="submit" value="Cetak">
		<input name = "b" type="button" value= "Back"  id="btn_back" Onclick="location='m_employee.php'">
		</td>
		<tr>
		</table>
		</form>
		</div>
		
	<div class="clear"></div>
	<table border=1>
	<tr>
		<td>Nama</td>
		<td>Kabon</td>
		<td>jamsos</td>
		<td>safety</td>
		<td>telat</td>
	</tr>
	<?php
	$sql_emp="SELECT * FROM employee a, ikut_project b 
	WHERE a.emp_id=b.emp_id AND b.kd_project=$_POST[kd_project]";
	$rs_emp=mysqli_query($link, $sql_emp);
	
	While ($row_emp=mysqli_fetch_assoc($rs_emp)) 
	{	
		$sql_potel="SELECT 
		SUM(pot_tel) as pot_tel 
		FROM pos_payroll_day WHERE emp_id='$row_emp[emp_id]' AND kd_periode=$_POST[kd_periode] AND kd_project=$_POST[kd_project]";
		$rs_potel=mysqli_query($link, $sql_potel); 
		$row_potel=mysqli_fetch_assoc($rs_potel);
		
		$sql_pos="
		SELECT * FROM pos_payroll WHERE kd_periode='$_POST[kd_periode]' AND kd_project='$_POST[kd_project]' AND emp_id='$row_emp[emp_id]'
		";
		$rs_pos=mysqli_query($link, $sql_pos); $row_pos=mysqli_fetch_assoc($rs_pos);
	?>	
	<tr>
		<td><?php echo $row_emp['emp_name'];?></td>
		<td><?php echo $row_pos['cicil_kasbon'];?></td>
		<td><?php echo $row_pos['jamsos'];?></td>
		<td><?php echo $row_pos['pot_safety'];?></td>
		<td><?php echo $row_potel['pot_tel'];?></td>
	</tr>
	<?php } ?>
	</table>
	
</div>
<!--Footer-->
</body>
</html>