<?php 
# Koneksi 
require_once('connections/koneksi.php');
# select DB 
mysql_select_db($database_koneksi, $koneksi);
$query_rsCabang = "SELECT * FROM cabang ORDER BY kd_cabang ASC";
$rsCabang = mysql_query($query_rsCabang, $koneksi) or die(mysql_error());
//$row_rsCabang = mysql_fetch_assoc($rsCabang);
//$totalRows_rsCabang = mysql_num_rows($rsCabang);

$SQLmax="SELECT MAX(kd_cabang) as NMAX FROM cabang";
$rsMax= mysql_query($SQLmax, $koneksi) or die (mysql_error());
$row_rsMax= mysql_fetch_assoc($rsMax);
$max=$row_rsMax[NMAX]+1;

if ($_REQUEST['edit']==1) {
$query_rsEditCabang = "SELECT * FROM cabang WHERE kd_cabang = '$_REQUEST[kd_cabang]'  ORDER BY kd_cabang ASC";
$rsEditCabang = mysql_query($query_rsEditCabang, $koneksi) or die(mysql_error());
$row_rsEditCabang = mysql_fetch_assoc($rsEditCabang);
$totalRows_rsEditCabang = mysql_num_rows($rsEditCabang);
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
            <h2>Maseter Location</h2>
            <div class="post_meta">
			
			<div class="clear">
			</div>
			</div>
			<!-- END Of Meta--> 
		
		<!-- Awal tabel -->
		<form name="form1" method="POST" action="saveinsert_mcabang.php">
		  <table width="405" border="0">
			<tr>
			  <td width="111">Kd. </td>
			  <td width="18">&nbsp;</td>
			  <td width="325"><input name="kd_cabang" type="hidden" id="kd_cabang" value="<?php if ($_REQUEST['edit']==1) echo $row_rsEditCabang['kd_cabang']; else echo $max;?>"><?php if ($_REQUEST['edit']==1) echo $row_rsEditCabang['kd_cabang']; else echo $max;?></td>
			</tr>

			<tr>
			  <td>Nama </td>
			  <td>&nbsp;</td>
			  <td><input name="nama_cabang" type="text" id="nama_cabang" value="<?php if ($_REQUEST['edit']==1) echo $row_rsEditCabang['nama_cabang'];?>"></td>
			</tr>
			
			<tr>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
			  <td><input name ="<?php if ($_REQUEST['edit']==1) echo "btn_edit"; else echo "btn_save";?>" type="submit" id="<?php if ($_REQUEST['edit']==1) echo "btn_edit"; else echo "btn_save";?>" value="<?php if ($_REQUEST['edit']==1) echo "btn_edit"; else echo "btn_save";?>">
			  <input name = "btn_back" type="button" value= "Back"  id="btn_back" Onclick="location='mCabang.php'">
			  
			  </td>
			</tr>
		  </table>
		  <table border ="1" width=400 >
		  <tr>
		  <td width=50 align=center>kd. </td><td align=center> Nama </td>
		  </tr>
		  <?php while ($row_rsCabang = mysql_fetch_assoc($rsCabang)) { ?>
		  <tr>
		  <td align=center> <?php echo $row_rsCabang['kd_cabang'];?></td><td align=left><?php echo $row_rsCabang['nama_cabang'];?></td>
		  </tr>
		  </table>
		  <?php } ?>
		</form>
		<?php mysql_free_result($rsCabang);	?>
		<!-- Tabel isi selesai -->           
        </div> <!-- END Of post--> 
		
		
		<!-- Begin Tombol Paging --> 	
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
		<!-- END Of tombol Paging -->
        
    
    </div> 
	<!-- END of content -->
    	
	<div class="clear"></div>
	</div>

<!--Footer-->
<?php require_once('footer.inc');  ?>

</body>
</html>