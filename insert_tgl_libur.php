<?php 
# Koneksi 
require_once('connections/koneksi.php');
# select DB 

$SQLmax="select MAX(kd_libur) as NMAX FROM tanggal_libur ";
$rsMax= mysql_query($SQLmax, $koneksi) or die (mysql_error());
$row_rsMax= mysql_fetch_assoc($rsMax);
$max=$row_rsMax[NMAX]+1;

if ($_REQUEST['edit']==1) {
$qry_editLibur = "SELECT * FROM tanggal_libur WHERE kd_libur = $_REQUEST[kd_libur]";
$rs_editLibur = mysql_query($qry_editLibur, $koneksi) or die(mysql_error());
$row_editLibur = mysql_fetch_assoc($rs_editLibur);
$totalRows_editLibur = mysql_num_rows($rs_editLibur);
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
	<div id="content" class="wrapper">
        <div class="post">
            <h2>Periode</h2>
            <div class="post_meta">
			
			<div class="clear">
			</div>
			</div>
			<!-- END Of Meta--> 
		
		<!-- Awal tabel -->
		<form name="form1" method="POST" action="save_inserttgl_libur.php">
		  <table width="600" border="0">
			<tr>
			  <td width="111">kd_libur </td>
			  <td width="18">&nbsp;</td>
			  <td width="325"><input name="kd_libur" type="hidden" id="kd_periode" value="<?php if ($_REQUEST['edit']==1) echo $row_editLibur['kd_libur']; else echo $max;?>"><?php if ($_REQUEST['edit']==1) echo $row_editLibur['kd_libur']; else echo $max;?></td>
			</tr>
			<tr>
			  <td>kd_periode </td>
			  <td>&nbsp;</td>
			  <td><input name="kd_periode" type="text" id="" value="<?php if ($_REQUEST['edit']==1) echo $row_editLibur['kd_periode'];?>"></td>
			</tr>
			<tr>
			  <td>tgl Libur</td>
			  <td>&nbsp;</td>
			  <td><input name="tgl_libur" type="text" id="" value="<?php if ($_REQUEST['edit']==1) echo $row_editLibur['tgl_libur'];?>"></td>
			</tr>
			<tr>
			  <td>Ket</td>
			  <td>&nbsp;</td>
			  <td><input name="ket" type="text" id="" value="<?php if ($_REQUEST['edit']==1) echo $row_editLibur['ket'];?>"></td>
			</tr>			
			<tr>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
			  <td><input name ="<?php if ($_REQUEST['edit']==1) echo "btn_edit"; else echo "btn_save";?>" type="submit" id="<?php if ($_REQUEST['edit']==1) echo "btn_edit"; else echo "btn_save";?>" value="<?php if ($_REQUEST['edit']==1) echo "btn_edit"; else echo "btn_save";?>">
			  <input name = "btn_back" type="button" value= "Back"  id="btn_back" Onclick="location='m_periode.php'">
			  
			  </td>
			</tr>
		  </table>
		  
		</form>
		<?php 	?>
		<!-- Tabel isi selesai -->           
        </div> <!-- END Of post--> 
		
		
		<!-- Begin Tombol Paging  	
        <div class="pagging">
            <ul>
                <li><a href="#" target="_parent">Previous</a></li>
                <li><a href="#" target="_parent">1</a></li>
                <li><a href="#" target="_parent">2</a></li>
                <li><a href="#" target="_parent">3</a></li>
                <li><a href="#4" target="_parent">4</a></li>
                <li><a href="#5" target="_parent">5</a></li>
                <li><a href="#6" target="_parent">6</a></li>
                <li><a href="#7" target="_parent">Next</a></li>
            </ul>
        </div>
		 END Of tombol Paging -->
        
    
    </div> 
	<!-- END of content -->
    	
	<div class="clear"></div>
	</div>

<!--Footer-->


</body>
</html>