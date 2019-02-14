<?php 
include('cek_login.php');
require_once 'connections/conn_mysqli_procedural.php';


$SQL_periode = "SELECT * FROM periode  Order BY tgl_awal DESC";
//$rs_periode = mysql_query($SQL_periode, $koneksi) or die(mysql_error());
$rs_periode = mysqli_query($link, $SQL_periode);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>PT. Lintech</title>


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
<!-- link rel="stylesheet" href="css/slimbox2.css" type="text/css" media="screen" /--> 
<script type="text/JavaScript" src="js/slimbox2.js"></script> 
</head>
<body>
<!-- Header Menu -->
<?php require_once('header.inc'); ?>
	

<div id="templatemo_main" class="wrapper">
	<!-- Tempat Menaruh Tabel ISI -->
	    <h2>Periode</h2>        		
		<!-- Awal tabel -->
		<table class="bordered" width="100%">
		<tr text-align: right ="center">
		<th>kd.</th>
		<th>Nama<br>Periode</th>
		<th>tgl_awal</td>
		<th>tgl_akhir</th>
		<th colspan = "6" align=center><a href="insert_m_periode.php" >
		<img src="./button/create.png" alt="" width=30 height=30>Insert</a></th>		
		</tr>
		<?php while($row_rsperiode = mysqli_fetch_assoc($rs_periode)) { ?>
		<tr align="center">
		<td><?=$row_rsperiode['kd_periode']?></td>
		<td><?=$row_rsperiode['nama_periode']?></td>
		<td><?=$row_rsperiode['tgl_awal']?></td>
		<td><?=$row_rsperiode['tgl_akhir']?></td>
		<td>
		<a href="insert_m_periode.php?edit=1&kd_periode=<?=$row_rsperiode['kd_periode']?>"> 
		<img src="./button/pencil_small.png" alt="" width=30 height=30>edit
		</a> 
		<a href="saveinsert_m_periode.php?delete=1&kd_periode=<?=$row_rsperiode['kd_periode']?>"> 
		<img src="./button/delete.png" alt="" width=20 height=20>delete
		</a>
		</td>
		<td>
		<a href="jamsostek.php?kd_periode=<?=$row_rsperiode['kd_periode']?>"> Setting Jamsos <br>Periode ini</a>	
		</td>		
		<td><a href="tgl_libur.php?kd_periode=<?=$row_rsperiode['kd_periode']?>"> Tgl _libur</a></td>
		</tr>
		<?php } ?>
		</table>    	
	<div class="clear"></div>
	</div>
<!--Footer-->

</body>
</html>