<?php 
require_once ('cek_login.php');
# Koneksi 
require_once('connections/conn_mysqli_procedural.php');
# select DB 
//mysql_select_db($database_koneksi);

$SQL_group = "SELECT * FROM group_employee ";
$rs_group = mysqli_query($link, $SQL_group);

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
	    <h2>group</h2>        		
		<!-- Awal tabel -->
		<table class="bordered" width="100%">
		<tr text-align: right ="center">
		<th>id</th>
		<th>group name</th>		
		<th colspan = "3" align=center><a href="insert_m_group.php" >Insert</a></th>		
		</tr>
		<?php while($row_rsgroup = mysqli_fetch_assoc($rs_group)) { ?>
		<tr align="center">
		<td><?php echo $row_rsgroup[id];?></td>
		<td><?php echo $row_rsgroup[group_name];?></td>		
		<td>
		<a href="insert_m_group.php?edit=1&loc_code=<?php echo $row_rsgroup[id];?>">Edit</a> | 
		<a href="saveinsert_m_group.php?delete=1&loc_code=<?php echo $row_rsgroup[id];?>">Delete</a>
		</td>	
		</tr>
		<?php } ?>
		</table>    	
	<div class="clear"></div>
	</div>
<!--Footer-->

</body>
</html>