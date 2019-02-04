<?php 
# Koneksi 
require_once('connections/conn_mysqli_procedural.php');


$qry_employee = "
Select a.emp_id, a.emp_name, b.nama_jabatan, c.keterangan, c.kd_kasbon, c.status 
FROM employee a LEFT JOIN kasbon c ON (c.emp_id=a.emp_id AND c.status=1) LEFT JOIN 
jabatan b ON (b.kd_jabatan= a.kd_jabatan)  Order BY emp_id
 ";
$rs_employee = mysqli_query($link, $qry_employee) or die(mysqli_error($link));

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
	    <h2>Create Kasbon, please choose employee ID!</h2>        		
		<!-- Awal tabel -->
		<table class="bordered" width="900">
		<tr align="center">
		<th>NIK</th>
		<th>NAMA EMP</th>
		<th>JABATAN</th>
		<th>Keterangan</th>
		<th colspan = "3" align=center> </th>		
		</tr>
		<?php while($row_rsemployee = mysqli_fetch_assoc($rs_employee)) { ?>
		<tr align="center">
		<td><?php echo $row_rsemployee['emp_id'];?></td>
		<td><?php echo $row_rsemployee['emp_name'];?></td>
		<td><?php echo $row_rsemployee['nama_jabatan'];?></td>
		<td><?php echo $row_rsemployee['keterangan'];?></td>
		<td>
		<?php if (!isset($row_rsemployee['kd_kasbon'])) { ?>
		<a href="insert_create_kasbon.php?add=1&emp_id=<?php echo $row_rsemployee['emp_id'];?>">[+ADD] </a>
		
		<?php } else {?>
		<a href="insert_create_kasbon.php?edit=1&emp_id=<?php echo $row_rsemployee['emp_id'];?>&kd_kasbon=<?php echo $row_rsemployee['kd_kasbon'];?>"> [Edit] </a> |
		<a href="save_insert_create_kasbon.php?delete=1&kd_kasbon=<?php echo $row_rsemployee['kd_kasbon'];?>">[ Delete]</a>
		<a href="save_insert_create_kasbon.php?lunas=1&emp_id=<?php echo $row_rsemployee['emp_id'];?>&kd_kasbon=<?php echo $row_rsemployee['kd_kasbon'];?>">[ Lunas]</a>
                <a href="add_cicilan_kasbon.php?emp_id=1&emp_id=<?php echo $row_rsemployee['emp_id'];?>&kd_kasbon=<?php echo $row_rsemployee['kd_kasbon'];?>">[ add cicil]</a>
                <?php } ?>
		
		</td>		
		</tr>
		<?php } ?>
		</table>    	
	<div class="clear"></div>
	</div>
<!--Footer-->
</body>
</html>