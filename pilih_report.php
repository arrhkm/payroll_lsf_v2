<?php 
# Koneksi 
require_once('connections/conn_mysqli_procedural.php');

$qry_project = "Select * from project";
$rs_project = mysqli_query($link, $qry_project) or die(mysqli_error($link));
$SQL_periode = "SELECT * FROM periode ORDER BY tgl_awal DESC LIMIT 0,20";
$rs_periode = mysqli_query($link, $SQL_periode) or die(mysqli_error($link));

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>PT. Lintech</title>
<meta name="keywords" content="orando template, blog page, website template, CSS, HTML, drop down menu" />
<meta name="description" content="Orando Template, Blog Page, Free Template with Drop Down menu, designed by templatemo.com" />
<link href="templatemo_style.css" rel="stylesheet" type="text/css" />
<link href="css/hkm_table.css" rel="stylesheet" type="text/css" />
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
	
		<div class="half left">
		<form name="form1" method="POST" action="all_report.php">
		<table class="hkm-table" width="">
		<th colspan = "2" align=Left>SELECT PROJECT & PERIODE PAYROLL</th>		
		<tr>
		<td>
		Project : 
		</td>
		<td align="left">
		<select name="kd_project">
		<?php while ($row_project=mysqli_fetch_assoc($rs_project)) { ?>
			<option value=<?php echo $row_project['kd_project'];?>><?php echo $row_project['nama_project'];?></option>
		<?php } ?>
		</select>
		</td>		
		</tr>
		<tr>
		<td>Periode : </td>
		<td><select name="kd_periode">
		<?php while ($row_periode=mysqli_fetch_assoc($rs_periode)) { ?>
			<option value=<?php echo $row_periode['kd_periode'];?>><?php echo $row_periode['nama_periode'];?></option>
		<?php } ?>
		</select>
		</td>
		</tr>
		<tr>
		<td colspan=2>
		<input name=btn_cetak type="submit" value="Cetak">
		<input name = "b" type="button" value= "Back"  id="btn_back" Onclick="location='m_employee.php'">
		</td>
		<tr>
		</table>
		</form>
		</div>
		<div class="half right">
		<p>Untuk mencetak Payroll anda harus memilih project dan periode yang akan dicetak terlebih dahulu, setelah itu dilanjutkan dengan perintah cetak</p>
		</div>
	<div class="clear"></div>
	
</div>
<!--Footer-->
</body>
</html>