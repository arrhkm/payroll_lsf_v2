<?php 
# Koneksi 
require_once('connections/conn_mysqli_procedural.php');
# select DB 
//mysql_select_db($database_koneksi, $koneksi);
$qry_project = "SELECT * FROM project ";
$rs_project = mysqli_query($link, $qry_project);


$SQLmax="SELECT MAX(kd_project) as NMAX FROM project";
$rsMax= mysqli_query($link, $SQLmax);
$row_rsMax= mysqli_fetch_assoc($rsMax);
$max=$row_rsMax[NMAX]+1;

if ($_REQUEST['edit']==1) {
$qry_editproject = "SELECT * FROM project WHERE kd_project = '$_REQUEST[kd_project]' ";
$rs_editproject = mysqli_query($link, $qry_editproject);
$row_editproject = mysqli_fetch_assoc($rs_editproject);

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
	            <h2>project</h2>
		<!-- Awal tabel -->
		<form name="form1" method="POST" action="saveinsert_m_project.php">
		  <table width="600" class="bordered" align="center">
			<tr>
			  <td width="111">Kd. project. (x)</td>
			  
			  <td width="325"><input name="kd_project"  id="" value="<?php if ($_REQUEST['edit']==1) echo $row_editproject['kd_project']; else echo $max;?>"></td>
			</tr>
			<tr>
			  <td>Nama project </td>			 
			  <td><input name="nama_project" type="text" id="nama_project" value="<?php if ($_REQUEST['edit']==1) echo $row_editproject['nama_project'];?>"></td>
			</tr>			
			<tr>
			<tr>
			  <td>Luar pulau ? </td>
			 
			  <td><input type="checkbox" name="luar_pulau"  value="1" id="luar_pulau" <?php if ($row_editproject['luar_pulau']) echo "checked";?> ></td>
			</tr>
			<tr>
			  <td>Penanggung Jawab </td>			 
			  <td><input name="penanggungjawab" type="text" id="jabatan" value="<?php if ($_REQUEST['edit']==1) echo $row_editproject['penanggungjawab'];?>"></td>
			</tr>
			<tr>
			  <td>Jabatan </td>			 
			  <td><input name="jabatan" type="text" id="jabatan" value="<?php if ($_REQUEST['edit']==1) echo $row_editproject['jabatan'];?>"></td>
			</tr>				
			<tr>			  
			  <td>&nbsp;</td>
			  <td><input name ="<?php if ($_REQUEST['edit']==1) echo "btn_edit"; else echo "btn_save";?>" type="submit" id="<?php if ($_REQUEST['edit']==1) echo "btn_edit"; else echo "btn_save";?>" value="<?php if ($_REQUEST['edit']==1) echo "btn_edit"; else echo "btn_save";?>">
			  <input name = "btn_back" type="button" value= "Back"  id="btn_back" Onclick="location='m_project.php'">			  
			  </td>
			</tr>
		  </table>
		  <table class="bordered" width=600 align = "center">
		  <tr align="center">
		  <td width=50 align=center>kd. </td>
		  <td align=center> Nama project</td>
		  <td align=center> Penanggung Jawab</td>
		  <td align=center> Jabatan</td>
		  
		  </tr>
		  <?php while ($row_rs_project = mysqli_fetch_assoc($rs_project)) { ?>
		  <tr>
		  <td align=center> <?php echo $row_rs_project['kd_project'];?></td>
		  <td align=left> <?php echo $row_rs_project['nama_project'];?></td>
		  <td align=left> <?php echo $row_rs_project['penanggungjawab'];?></td>
		  <td align=left> <?php echo $row_rs_project['jabatan'];?></td>
		  
		  </tr>
		 
		  <?php } ?> 
		  </table>
		</form>
		<?php mysqli_free_result($rs_project);	?>
		<!-- Tabel isi selesai -->            
    	
	<div class="clear"></div>
	</div>

<!--Footer-->


</body>
</html>