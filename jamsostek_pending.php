<?php 
# Koneksi 
require_once('connections/koneksi.php');
# select DB 
mysql_select_db($database_koneksi, $koneksi);

$qry_periode="SELECT * FROM periode WHERE kd_periode='$_REQUEST[kd_periode]'";
$rs_periode = mysql_query($qry_periode, $koneksi) or die(mysql_error());
$row_periode=mysql_fetch_assoc($rs_periode);

/*$qry_emp = "SELECT b.emp_id, b.emp_name, a.kd_periode1
FROM jamsostek_pending a, employee b
WHERE b.emp_id = a.emp_id
AND a.kd_periode1='$_REQUEST[kd_periode]'";
$rs_emp = mysql_query($qry_emp, $koneksi) or die(mysql_error());
*/
$qry_emp = "SELECT b.emp_id, b.emp_name, a.kd_periode1
FROM jamsostek_pending a, employee b
WHERE b.emp_id = a.emp_id and a.kd_periode1=$_REQUEST[kd_periode]";
$rs_emp = mysql_query($qry_emp, $koneksi) or die(mysql_error());
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
	    <h2>Jamsostek Pending Periode <?php echo "No ($row_periode[kd_periode]) $row_periode[nama_periode]";?></h2>        		
		<!-- Awal tabel -->
		<table class="bordered" width="700px">
		<tr align="center">
		<th>EMP ID</th>
		<th>Nama Emp</th>		
		<th colspan = "3" align=center>
		<a href="insert_jamsostek_pending.php?kd_periode=<?php echo $_REQUEST[kd_periode];?>" >Insert</a> | 
		<a href="saveinsert_jamsostek_pending.php?del_all=1&kd_periode=<?php echo $_REQUEST[kd_periode];?>" >Delete all</a> |
		<a href="m_periode.php"> <-Back </a>| 
		</th>		
		</tr>
		<?php while($row_emp = mysql_fetch_assoc($rs_emp)) { ?>
		<tr align="center">
		<td><?php echo $row_emp[emp_id];?></td>
		<td align="left"><?php echo $row_emp[emp_name];?></td>	
		
		<td>		
		<a href="saveinsert_jamsostek_pending.php?delete=1&kd_periode=<?php echo $_REQUEST[kd_periode];?>&emp_id=<?php echo $row_emp[emp_id];?>">Delete</a>
		</td>		
		</tr>
		<?php } ?>
		</table>    	
	<div class="clear"></div>
	</div>
<!--Footer-->
</body>
</html>