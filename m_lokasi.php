<?php 
require_once ('cek_login.php');
# Koneksi 
require_once('connections/conn_mysqli_procedural.php');
# select DB 
//mysql_select_db($database_koneksi, $koneksi);

$SQL_lokasi = "SELECT * FROM hs_hr_location ";
$rs_lokasi = mysqli_query($link, $SQL_lokasi);

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
	    <h2>lokasi</h2>        		
		<!-- Awal tabel -->
		<table class="bordered" width="100%">
		<tr text-align: right ="center">
		<th>loc_code</th>
		<th>loc_name</th>
		<th>loc_state</td>
		<th>loc_city</th>
		<th>loc_add</th>
		<th>loc_zip</th>
		<th>loc_phone</th>
		<th>loc_fax</th>
		<th>loc_comments</th>
		<th colspan = "3" align=center><a href="insert_m_lokasi.php" >Insert</a></th>		
		</tr>
		<?php while($row_rslokasi = mysqli_fetch_assoc($rs_lokasi)) { ?>
		<tr align="center">
		<td><?php echo $row_rslokasi[loc_code];?></td>
		<td><?php echo $row_rslokasi[loc_name];?></td>
		<td><?php echo $row_rslokasi[loc_state];?></td>
		<td><?php echo $row_rslokasi[loc_city];?></td>
		<td><?php echo $row_rslokasi[loc_add];?></td>
		<td><?php echo $row_rslokasi[loc_zip];?></td>
		<td><?php echo $row_rslokasi[loc_phone];?></td>
		<td><?php echo $row_rslokasi[loc_fax];?></td>
		<td><?php echo $row_rslokasi[loc_comments];?></td>
		<td>
		<a href="insert_m_lokasi.php?edit=1&loc_code=<?php echo $row_rslokasi[loc_code];?>">Edit</a> | 
		<a href="saveinsert_m_lokasi.php?delete=1&loc_code=<?php echo $row_rslokasi[loc_code];?>">Delete</a>
		</td>	
		</tr>
		<?php } ?>
		</table>    	
	<div class="clear"></div>
	</div>
<!--Footer-->

</body>
</html>