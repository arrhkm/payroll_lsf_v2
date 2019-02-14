<?php 
# Koneksi 
require_once('connections/conn_mysqli_procedural.php');

$qry_jabatan = "SELECT * FROM jabatan ";
$rs_jabatan = mysqli_query($link, $qry_jabatan) or die(mysqli_error($link));


$SQLmax="SELECT MAX(kd_jabatan) as NMAX FROM jabatan";
$rsMax= mysqli_query($link, $SQLmax) or die (mysqli_error($link));
$row_rsMax= mysqli_fetch_assoc($rsMax);
$max=$row_rsMax[NMAX]+1;

if ($_REQUEST['edit']==1) {
$qry_editjabatan = "SELECT * FROM jabatan WHERE kd_jabatan = '$_REQUEST[kd_jabatan]' ";
$rs_editjabatan = mysqli_query($link, $qry_editjabatan) or die(mysqli_error($link));
$row_editjabatan = mysqli_fetch_assoc($rs_editjabatan);

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
	            <h2>jabatan</h2>
		<!-- Awal tabel -->
		<form name="form1" method="POST" action="saveinsert_m_jabatan.php">
		  <table width="600" class="bordered" align="center">
			<tr>
			  <td width="111">Kd. Jabatan. </td>
			  
			  <td width="325"><input name="kd_jabatan"  id="" value="<?php if ($_REQUEST['edit']==1) echo $row_editjabatan['kd_jabatan']; else echo $max;?>"></td>
			</tr>
			<tr>
			  <td>Nama Jabatan </td>
			 
			  <td><input name="nama_jabatan" type="text" id="nama_jabatan" value="<?php if ($_REQUEST['edit']==1) echo $row_editjabatan['nama_jabatan'];?>"></td>
			</tr>
			
			<tr>
			  
			  <td>&nbsp;</td>
			  <td><input name ="<?php if ($_REQUEST['edit']==1) echo "btn_edit"; else echo "btn_save";?>" type="submit" id="<?php if ($_REQUEST['edit']==1) echo "btn_edit"; else echo "btn_save";?>" value="<?php if ($_REQUEST['edit']==1) echo "btn_edit"; else echo "btn_save";?>">
			  <input name = "btn_back" type="button" value= "Back"  id="btn_back" Onclick="location='m_jabatan.php'">
			  
			  </td>
			</tr>
		  </table>
		  <table class="bordered" width=600 align = "center">
		  <tr align="center">
		  <td width=50 align=center>kd. </td>
		  <td align=center> Nama Jabatan</td>
		  
		  </tr>
		  <?php while ($row_rs_jabatan = mysqli_fetch_assoc($rs_jabatan)) { ?>
		  <tr>
		  <td align=center> <?php echo $row_rs_jabatan['kd_jabatan'];?></td>
		  <td align=left> <?php echo $row_rs_jabatan['nama_jabatan'];?></td>
		  
		  </tr>
		 
		  <?php } ?> 
		  </table>
		</form>
		<?php mysqli_free_result($rs_jabatan);	?>
		<!-- Tabel isi selesai -->            
    	
	<div class="clear"></div>
	</div>

<!--Footer-->


</body>
</html>