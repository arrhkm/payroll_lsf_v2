<?php 
# Koneksi 
require_once('connections/conn_mysqli_procedural.php');


$qry_project = "Select * from project";
$rs_project = mysqli_query($link, $qry_project) or die(mysqli_error($link));

$SQL_periode = "SELECT * FROM periode ORDER BY tgl_awal DESC LIMIT 0,5";
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
		<table class="bordered">
		<tr>
		<td><a href="periode.php?kd_periode=<?php echo $_POST['kd_periode'];?>&kd_project=<?php echo $_POST['kd_project'];?>">Payroll</a></td>
                <td><a href="summary.php?kd_periode=<?php echo $_POST['kd_periode'];?>&kd_project=<?php echo $_POST['kd_project'];?>">summary</a></td>
                <td><a href="periode_pos.php?kd_periode=<?php echo $_POST['kd_periode'];?>&kd_project=<?php echo $_POST['kd_project'];?>">Payroll_pos</a></td>
		<!--td><a href="periode_class.php?kd_periode=<?php //echo $_POST['kd_periode'];?>&kd_project=<?php //echo $_POST['kd_project'];?>">Dulinan Class</a></td -->
		<!-- td><a href="periode2.php?kd_periode=<?php //echo $_POST[kd_periode];?>&kd_project=<?php //echo $_POST['kd_project'];?>">Payroll 2</td -->
		<!-- td><a href="report_pdf.php?kd_periode=<?php //echo $_POST['kd_periode'];?>&kd_project=<?php //echo $_POST['kd_project'];?>">Report PDF</td -->
		<!--td><a href="summary_pdf.php?kd_periode=<?php //echo $_POST['kd_periode'];?>&kd_project=<?php //echo $_POST['kd_project'];?>">summary_pdf</a></td -->
		<tr>
		</table>
		</div>
		
	<div class="clear"></div>
	
</div>
<!--Footer-->
</body>
</html>