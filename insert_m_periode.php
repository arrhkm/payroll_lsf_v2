<?php 
# Koneksi 
require_once('connections/conn_mysqli_procedural.php');
# select DB 
//mysql_select_db($database_koneksi, $koneksi);
$query_rsPeriode = "SELECT * FROM periode ORDER BY kd_periode DESC";
//$rsPeriode = mysql_query($query_rsPeriode, $koneksi) or die(mysql_error());
$rsPeriode = mysqli_query($link, $query_rsPeriode) or die (mysqli_errno($link));

$SQLmax="SELECT MAX(kd_periode) as NMAX FROM periode";
$rsMax= mysqli_query($link, $SQLmax) or die (mysqli_errno($link));
$row_rsMax= mysqli_fetch_assoc($rsMax);
$max=$row_rsMax[NMAX]+1;

if ($_REQUEST['edit']==1) {
$query_rsEditPeriode = "SELECT * FROM periode WHERE kd_periode = '$_REQUEST[kd_periode]'  ORDER BY kd_periode ASC";
$rsEditPeriode = mysqli_query($link, $query_rsEditPeriode);
$row_rsEditPeriode = mysqli_fetch_assoc($rsEditPeriode);
$totalRows_rsEditPeriode = mysqli_num_rows($rsEditPeriode);
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
	            <h2>Periode</h2>
		<!-- Awal tabel -->
		<form name="form1" method="POST" action="saveinsert_m_periode.php">
		  <table width="600" border="0" align="center">
			<tr>
			  <td width="111">Kd. </td>
			  <td width="18">&nbsp;</td>
			  <td width="325"><input name="kd_periode" type="hidden" id="kd_periode" value="<?php if ($_REQUEST['edit']==1) echo $row_rsEditPeriode['kd_periode']; else echo $max;?>"><?php if ($_REQUEST['edit']==1) echo $row_rsEditPeriode['kd_periode']; else echo $max;?></td>
			</tr>
			<tr>
			  <td>Nama </td>
			  <td>&nbsp;</td>
			  <td><input name="nama_periode" type="text" id="nama_periode" value="<?php if ($_REQUEST['edit']==1) echo $row_rsEditPeriode['nama_periode'];?>"></td>
			</tr>
			<tr>
			  <td>tgl awal</td>
			  <td>&nbsp;</td>
			  <td>
			  <input type="text" id="awal" name="tgl_awal" size="10" maxlength="10" value="<?php if ($_REQUEST['edit']==1) echo $row_rsEditPeriode['tgl_awal'];?>"
			  onClick="if(self.gfPop)gfPop.fPopCalendar(document.form1.awal);return false;"/>
			  <a href="javascript:void(0)" onClick="if(self.gfPop)gfPop.fPopCalendar(document.form1.awal);return false;">
			  <img name="popcal" align="absmiddle" style="border:none" src="calender/calender.jpeg" width="34" height="29" border="0" alt="">
			  </a>				 
			  </td>
			</tr>
			<tr>
			  <td>tgl akhir</td>
			  <td>&nbsp;</td>			  
			  <td>
			  <input type="text" id="akhir" name="tgl_akhir"  size="10" maxlength="10" value="<?php if ($_REQUEST['edit']==1) echo $row_rsEditPeriode['tgl_akhir'];?>"
			  onClick="if(self.gfPop)gfPop.fPopCalendar(document.form1.akhir);return false;"/>
			  <a href="javascript:void(0)" onClick="if(self.gfPop)gfPop.fPopCalendar(document.form1.akhir);return false;" >
			  <img name="popcal" align="absmiddle" style="border:none" src="./calender/calender.jpeg" width="34" height="29" border="0" alt="">
			  </a>
			  <!--input name="tgl_akhir" type="text" id="tgl_akhir" value="<?php if ($_REQUEST['edit']==1) echo $row_rsEditPeriode['tgl_akhir'];?>"-->
			  </td>
			</tr>
			
			<tr>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
			  <td><input name ="<?php if ($_REQUEST['edit']==1) echo "btn_edit"; else echo "btn_save";?>" type="submit" id="<?php if ($_REQUEST['edit']==1) echo "btn_edit"; else echo "btn_save";?>" value="<?php if ($_REQUEST['edit']==1) echo "btn_edit"; else echo "btn_save";?>">
			  <input name = "btn_back" type="button" value= "Back"  id="btn_back" Onclick="location='m_periode.php'">
			  
			  </td>
			</tr>
		  </table>
		  <table border ="1" width=600 align = "center">
		  <tr align="center">
		  <td width=50 align=center>kd. </td>
		  <td align=center> Nama </td>
		  <td align=center> awal </td>
		  <td align=center> akhir </td>
		  
		  </tr>
		  <?php while ($row_rsPeriode = mysqli_fetch_assoc($rsPeriode)) { ?>
		  <tr>
		  <td align=center> <?php echo $row_rsPeriode['kd_periode'];?></td>
		  <td align=left> <?php echo $row_rsPeriode['nama_periode'];?></td>
		  <td align=left> <?php echo $row_rsPeriode['tgl_awal'];?></td>
		  <td align=left> <?php echo $row_rsPeriode['tgl_akhir'];?></td>
		 
		  </tr>		 
		  <?php } ?> 
		  </table>
		</form>
		<iframe width=174 height=189 name="gToday:normal:calender/agenda.js" id="gToday:normal:calender/agenda.js" src="calender/ipopeng.htm" scrolling="no" frameborder="0" style="visibility:visible; z-index:999; position:absolute; top:-500px; left:-500px;"></iframe>
				
		<?php 
                    mysqli_free_result($rsPeriode);	
                    mysqli_close($link);
                ?>
		<!-- Tabel isi selesai -->            
    	
	<div class="clear"></div>
	</div>

<!--Footer-->


</body>
</html>