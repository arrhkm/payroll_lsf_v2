<?php 
# Koneksi 
   require_once('connections/conn_mysqli_procedural.php');


$qry_safety = "
Select a.*, b.emp_name FROM safety_talk a LEFT JOIN 
employee b ON (b.emp_id= a.emp_id) ORDER BY (a.tgl_safety  ) DESC
 ";
$rs_safety = mysqli_query($link, $qry_safety) or die(mysqli_error($link));

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
	<h2>Safety Talk</h2>     
	    <table class ="bordered" width="100%">
		<tr align="center">
		<th>emp_id</th>
		<th>emp_name</th>
		<th>Tgl Potongan</th>
		<th>Value</th>		
		<th colspan = "3" align=center><a href="insert_safetytalk.php" >Insert</a></th>		
		</tr>
		<?php while($row_rssafety = mysqli_fetch_assoc($rs_safety)) { ?>
		<tr align="center">
		<td align="rigt"><?php echo $row_rssafety[emp_id];?></td>
		<td align="left"><?php echo $row_rssafety[emp_name];?></td>
		<td align="left"><?php echo $row_rssafety[tgl_safety];?></td>
		<td align="right"><?php echo "Rp ".number_format($row_rssafety[jml_safety],2,',','.');?></td>		
		<td>
		<a href="insert_safetytalk.php?edit=1&kd_safety=<?php echo $row_rssafety[kd_safety];?>">Edit</a> | 
		<a href="saveinsert_safetytalk.php?delete=1&kd_safety=<?php echo $row_rssafety[kd_safety];?>">Delete</a>
		</td>		
		</tr>
		<?php } ?>
		</table>   
		   	
	<div class="clear"></div>
	</div>
<!--Footer-->
</body>
</html>