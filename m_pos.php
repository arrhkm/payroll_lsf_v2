<?php 
include('cek_login.php');

# Koneksi 
require_once('connections/conn_mysqli_procedural.php');

if ($_REQUEST[delete]==1) {
$del_archive= "DELETE FROM pos_archive WHERE kd_project='$_REQUEST[kd_project]' AND kd_periode='$_REQUEST[kd_periode]'";
$sql_del1="DELETE FROM pos_payroll WHERE kd_project='$_REQUEST[kd_project]' AND kd_periode='$_REQUEST[kd_periode]'";
$sql_del2= "DELETE FROM pos_payroll_day WHERE kd_project='$_REQUEST[kd_project]' AND kd_periode='$_REQUEST[kd_periode]'";
mysqli_query($link, $del_archive) or die(mysqli_error($link));
mysqli_query($link, $sql_del1) or die(mysqli_error($link));
mysqli_query($link, $sql_del2) or die(mysqli_error($link));
}

$sql_pos="SELECT * FROM pos_archive ORDER BY tgl_akhir DESC";
$rs_pos=mysqli_query($link, $sql_pos) or die(mysqli_error($link));
//$row_pos=mysql_fetch_assoc($rs_pos, $koneksi);

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
	    <h2>POS Payroll</h2>        		
		<!-- Awal tabel -->
		<table class="bordered" width="100%">
		<tr text-align: right ="center">
		<th> Project.</th>
		<th> Periode</th>
		<th>tgl_awal</td>
		<th>tgl_akhir</th>
		<th colspan = "6" align=center></th>		
		</tr>
		<?php while($row_pos = mysqli_fetch_assoc($rs_pos)) { ?>
		<tr align="center">
		<td><?php echo $row_pos['nama_project'];?></td>
		<td><?php echo $row_pos['nama_periode'];?></td>
		<td><?php echo $row_pos['tgl_awal'];?></td>
		<td><?php echo $row_pos['tgl_akhir'];?></td>
		<td>
		<a href="#.php?edit=1&kd_periode=<?php echo $row_pos['kd_periode'];?>"> 
		<img src="./button/pencil_small.png" alt="" width=30 height=30>edit
		</a> 
		<a href="m_pos.php?delete=1&kd_project=<?php echo $row_pos['kd_project'];?>&kd_periode=<?php echo $row_pos['kd_periode'];?>"> 
		<img src="./button/delete.png" alt="" width=20 height=20>delete
		</a>
		</td>		
		<td><a href="detil_pos.php?kd_periode=<?php echo $row_pos['kd_periode'];?>&kd_project=<?php echo $row_pos['kd_project'];?>"> Lihat </a></td>
		</tr>
		<?php } ?>
		</table>    	
	<div class="clear"></div>
	</div>
<!--Footer-->

</body>
</html>