<?php 
//include('cek_login.php');
# Koneksi 
require_once('connections/conn_mysqli_procedural.php');
//$db = New Database();
//$db->SetConnect("localhost", 'root', '','ldp');
//$db->Connect();

$SQL_periode = "SELECT * FROM periode  Order BY tgl_awal DESC";
//$rs_periode = mysql_query($SQL_periode, $koneksi) or die(mysql_error());
$rs_periode= mysqli_query($link, $SQL_periode);

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
	    <h2>>> Setup Gaji Periode</h2>        		
		<!-- Awal tabel -->
		<table class="bordered" width="600px">
		<tr text-align: right ="Left">
		<th>kd.</th>
		<th>Periode</th>
		<th>tgl_awal</td>
		<th>tgl_akhir</th>
		</th>
		<th></th>
		</tr>
		<?php 	
		if (mysqli_num_rows($rs_periode) > 0) {
		while ($row_rsperiode = mysqli_fetch_assoc($rs_periode)) {
		?>
		<tr align="Left">
		<td><?php echo "{$row_rsperiode['kd_periode']}";?></td>
		<td><?php echo "{$row_rsperiode['nama_periode']}";?></td>
		<td><?php echo "{$row_rsperiode['tgl_awal']}";?></td>
		<td><?php echo "{$row_rsperiode['tgl_akhir']}";?></td>			
		<td>
		<?php 
		$sql_cek="SELECT * FROM gaji_periode WHERE kd_periode='$row_rsperiode[kd_periode]'";
		$rs_cek=mysqli_query($link, $sql_cek);
		echo mysqli_num_rows($rs_cek);
		if (mysqli_num_rows($rs_cek)<=0) { 
		?>
		<a href="set_gaji_periode.php?kd_periode=<?php echo $row_rsperiode['kd_periode'];?>"> SET Gaji</a>
		<?php } ?>
		</td>
		
		</tr>
		<?php } }?>
		</table>    	
	<div class="clear"></div>
	</div>
<!--Footer-->

</body>
</html>