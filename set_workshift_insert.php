<?php 
# Koneksi 
require_once('connections/conn_mysqli_procedural.php');
# select DB 

$qry_workshift="SELECT * FROM workshift WHERE id_workshift='$_REQUEST[id_workshift]'";
$rs_workshift = mysqli_query($link, $qry_workshift);
$row_workshift=mysqli_fetch_assoc($rs_workshift);

$qry_emp = "SELECT b.emp_id, c.emp_name, a.id_workshift
FROM workshift a, set_workshift b, employee c
WHERE b.id_workshift= a.id_workshift
AND c.emp_id=b.emp_id
AND a.id_workshift='$_REQUEST[id_workshift]'";
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
	customtheme: ["#f2244cc", "#cc1133"],
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
	    <h2>Group workshift <?php echo "No ($row_workshift[id_workshift]) $row_workshift[nama_workshift]";?></h2>        		
		<!-- Awal tabel -->
		<table class="bordered" width="700px">
		<tr align="center">
		<th>EMP ID</th>
		<th>Nama Emp</th>		
		<th colspan = "3" align=center><a href="set_workshift.php?id_workshift=<?php echo $_REQUEST[id_workshift];?>" >Insert</a> | 
		<a href="m_workshift.php"> <-Back </a> 
		</th>		
		</tr>
		<?php while($row_emp = mysqli_fetch_assoc($rs_emp)) { ?>
		<tr align="center">
		<td><?php echo $row_emp[emp_id];?></td>
		<td align="left"><?php echo $row_emp[emp_name];?></td>	
		
		<td>
		<!--<a href="saveset_workshift.php?edit=1&id_workshift=<?php echo $row_emp[id_workshift];?>&emp_id=<?php echo $row_emp[emp_id];?>">Edit</a> |--> 
		<a href="save_set_workshift.php?delete=1&id_workshift=<?php echo $row_emp[id_workshift];?>&emp_id=<?php echo $row_emp[emp_id];?>">Delete</a>
		</td>		
		</tr>
		<?php } ?>
		</table>    	
	<div class="clear"></div>
	</div>
<!--Footer-->
</body>
</html>