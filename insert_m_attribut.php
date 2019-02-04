<?php 
# Koneksi 
require_once('connections/conn_mysqli_procedural.php');
# select DB 
//mysql_select_db($database_koneksi, $koneksi);
$qry_attribut = "SELECT * FROM attribut_payroll ";
$rs_attribut = mysqli_query($link, $qry_attribut);


$SQLmax="SELECT MAX(kd_attribut) as NMAX FROM attribut_payroll";
$rsMax= mysqli_query($link, $SQLmax);
$row_rsMax= mysqli_fetch_assoc($rsMax);
$max=$row_rsMax[NMAX]+1;

if ($_REQUEST['edit']==1) {
$qry_editattribut = "SELECT * FROM attribut_payroll WHERE kd_attribut = '$_REQUEST[kd_attribut]' ";
$rs_editattribut = mysqli_query($link, $qry_editattribut);
$row_editattribut = mysqli_fetch_assoc($rs_editattribut);

}
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
	//customtheme: ["#1c5a80", "#18374a"],
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
	            <h2>Attribut Payroll</h2>
		<!-- Awal tabel -->
		<form name="form1" method="POST" action="saveinsert_m_attribut.php">
		  <table width="600" class="bordered" align="left">
			<tr>
			  <td width="111">Kd. attribut. </td>			  
			  <td width="325"><input name="kd_attribut"  id="" value="<?php if ($_REQUEST['edit']==1) echo $row_editattribut['kd_attribut']; else echo $max;?>"></td>
			</tr>
			<tr>
			  <td>Nama proejct </td>			 
			  <td><input name="nama_project" type="text" id="nama_project" value="<?php if ($_REQUEST['edit']==1) echo $row_editattribut['nama_project'];?>"></td>
			</tr>
			<tr>
			  <td>Nama satff </td>			 
			  <td><input name="nama_staff" type="text" id="nama_staff" value="<?php if ($_REQUEST['edit']==1) echo $row_editattribut['nama_staff'];?>"></td>
			</tr>
			<tr>
			  <td>Pot_safety_talk </td>			 
			  <td><input name="safety_talk" type="text" id="safety_talk" value="<?php if ($_REQUEST['edit']==1) echo $row_editattribut['safety_talk'];?>"></td>
			</tr>
			<tr>
			  <td>HRD_manager </td>			 
			  <td><input name="hrd_manager" type="text" id="hrd_manager" value="<?php if ($_REQUEST['edit']==1) echo $row_editattribut['hrd_manager'];?>"></td>
			</tr>
			<tr>
			  <td>Deputi </td>			 
			  <td><input name="deputi" type="text" id="deputi" value="<?php if ($_REQUEST['edit']==1) echo $row_editattribut['deputi'];?>"></td>
			</tr>
			<tr>
			  <td>Director</td>			 
			  <td><input name="director" type="text" id="director" value="<?php if ($_REQUEST['edit']==1) echo $row_editattribut['director'];?>"></td>
			</tr>
			<tr>
			  <td>mng Operasional</td>			 
			  <td><input name="mng_operasional" type="text" id="mng_operasional" value="<?php if ($_REQUEST['edit']==1) echo $row_editattribut['mng_operasional'];?>"></td>
			</tr>
			<tr>			  
			  <td>&nbsp;</td>
			  <td><input name ="<?php if ($_REQUEST['edit']==1) echo "btn_edit"; else echo "btn_save";?>" type="submit" id="<?php if ($_REQUEST['edit']==1) echo "btn_edit"; else echo "btn_save";?>" value="<?php if ($_REQUEST['edit']==1) echo "btn_edit"; else echo "btn_save";?>">
			  <input name = "btn_back" type="button" value= "Back"  id="btn_back" Onclick="location='m_attribut.php'">			  
			  </td>
			</tr>
		  </table>
		  
		  <table class="bordered" width="" align = "left">
		  <tr align="center">
		  <td width=50 align=center>kd. </td>
		  <td align=center> Nama Project</td>
		  <td align=center> Nama staff</td>
		  <td align=center> Safety Talk</td>
		  <td align=center> HRD Manager</td>
		  <td align=center> Deputi</td>
		  <td align=center> Director</td>
		  <td align=center> mng operasional</td>
		  </tr>
		  <?php while ($row_rs_attribut = mysqli_fetch_assoc($rs_attribut)) { ?>
		  <tr>
		  <td align=center> <?php echo $row_rs_attribut['kd_attribut'];?></td>
		  <td align=left> <?php echo $row_rs_attribut['nama_project'];?></td>
		  <td align=left> <?php echo $row_rs_attribut['nama_staff'];?></td>
		  <td align=left> <?php echo "Rp. ".number_format($row_rs_attribut['safety_talk'], 2, ',', '.');?></td>
		  <td align=left> <?php echo $row_rs_attribut['hrd_manager'];?></td>
		  <td align=left> <?php echo $row_rs_attribut['deputi'];?></td>
		  <td align=left> <?php echo $row_rs_attribut['director'];?></td>
		  <td align=left> <?php echo $row_rs_attribut['mng_operasional'];?></td>
		  
		  </tr>
		 
		  <?php } ?> 
		  </table>
		</form>
		<?php mysqli_free_result($rs_attribut);	?>
		<!-- Tabel isi selesai -->            
    	
	<div class="clear"></div>
	</div>

<!--Footer-->


</body>
</html>