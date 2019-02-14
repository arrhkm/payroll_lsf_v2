<?php 
# Koneksi 
require_once('connections/conn_mysqli_procedural.php');


$sql_periode="SELECT * FROM periode WHERE kd_periode='$_REQUEST[kd_periode]'";
$rs_periode=mysqli_query($link, $sql_periode) or die (mysqli_error($link));
$row_periode=mysqli_fetch_assoc($rs_periode);

$qry_emp = "SELECT * FROM employee ";
$rs_emp = mysqli_query($link, $qry_emp) or die(mysqli_error($link));

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
	<h2>Insert Insentif Gaji Employee</h2>     
	    <table class="bordered">
		<tr>
		<td>EMP ID</td><td>EMP name</td><td><a href="periode_insentifjam.php">Back</a></td>
		</tr>
		<?php while ($row_emp=mysqli_fetch_assoc($rs_emp)) { ?>
		<tr>
		<td><?php echo $row_emp[emp_id];?></td><td><?php echo $row_emp[emp_name];?></td>
		<td><a href="insert_insentifjam.php?emp_id=<?php echo $row_emp[emp_id];?>&kd_periode=<?php echo $row_periode[kd_periode];?>">Next</a></td>
		</tr>
		<?php } ?>
		</table>		 
		   	
	<div class="clear"></div>
	</div>
<!--Footer-->
</body>
</html>