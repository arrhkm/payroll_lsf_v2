<?php 
# Koneksi 
require_once('connections/conn_mysqli_procedural.php');
$qry_periode = "
SELECT * FROM periode ORDER BY kd_periode 
 ";
$rs_periode = mysqli_query($link, $qry_periode) or die(mysqli_error($link));

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
	<h2>Insentif Gaji</h2>     
	    		
		<table class="bordered">
		<thead>
		<tr> 
		<th> Kd. Periode </th><th> Periode </th><th>  </th>
		</tr>
		</thead>
		<?php while($row_periode = mysqli_fetch_assoc($rs_periode)) { ?>
		<tr>
		<td><?php echo $row_periode['kd_periode'];?></td>
		<td> <a href="cekinout.php?kd_periode=<?php echo $row_periode['kd_periode'];?>"><?php echo $row_periode['tgl_awal']." s/d ".$row_periode['tgl_akhir'];?></a> </td>
		<td> ::. </td>
		</tr>
		<?php } ?>		
		</table>  
		   	
	<div class="clear"></div>
	</div>
<!--Footer-->
</body>
</html>