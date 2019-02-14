<?php 
# Koneksi 
require_once('connections/conn_mysqli_procedural.php');

$qry_absensi_cuti = "SELECT * FROM absensi_cuti ";
$rs_absensi_cuti = mysqli_query($link, $qry_absensi_cuti) or die(mysqli_error($link));

$qry_emp=mysqli_query($link, "SELECT emp_id, emp_name FROM employee", $koneksi) or die (mysql_error());
$row_emp=mysqli_fetch_assoc($qry_emp);

//$SQLmax="SELECT MAX(kd_absensi_cuti) as NMAX FROM absensi_cuti";
//$rsMax= mysqli_query($link, $SQLmax, $koneksi) or die (mysql_error());
//$row_rsMax= mysqli_fetch_assoc($rsMax);
//$max=$row_rsMax[NMAX]+1;

if ($_REQUEST['edit']==1) {
$qry_editabsensi_cuti = "SELECT * FROM absensi_cuti WHERE tgl = '$_REQUEST[tgl]' and emp_id='$_REQUEST[emp_id]' ";
$rs_editabsensi_cuti = mysqli_query($link, $qry_editabsensi_cuti) or die(mysqli_error($link));
$row_editabsensi_cuti = mysqli_fetch_assoc($rs_editabsensi_cuti);

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
	            <h2>Ijin Cuti, sakit, Perjalanan Dinas</h2>
		<!-- Awal tabel -->
		<form name="form1" method="POST" action="saveinsert_cuti.php">
		  <table width="600" class="bordered" align="center">
			<tr>
			<td> Tanggal :</td>
			<td>
			<input type="text" id="form" name="tgl" size="10" maxlength="10"
			onClick="if(self.gfPop)gfPop.fPopCalendar(document.postform.form);return false;"/>
			<a href="javascript:void(0)" onClick="if(self.gfPop)gfPop.fPopCalendar(document.form1.form);return false;">
			<img name="popcal" align="absmiddle" style="border:none" src="calender/calender.jpeg" width="34" height="29" border="0" alt="">
			</a>
			</td>
			</tr>
			
			<tr>
			  <td>emp ID. </td>			 
			  <td><input name="emp_id" type="text" id="emp_id" value="<?php if ($_REQUEST['edit']==1) echo $row_editabsensi_cuti['emp_id'];?>"></td>
			</tr>
			
			<tr>
			  <td>Ket. Absen : </td>
			  <td>
			  <input type="radio" name="ket_absen" value="CT" checked > Cuti 
			  <input type="radio" name=ket_absen value="SK"> Sakit
			  <input type="radio" name=ket_absen value="PD"> Perjalanan Dinas	
			  <input type="radio" name=ket_absen value="MD"> Makan Dinas
			  </td>
			</tr>
			<tr>			  
			  <td>&nbsp;</td>
			  <td><input name ="<?php if ($_REQUEST['edit']==1) echo "btn_edit"; else echo "btn_save";?>" type="submit" id="<?php if ($_REQUEST['edit']==1) echo "btn_edit"; else echo "btn_save";?>" value="<?php if ($_REQUEST['edit']==1) echo "btn_edit"; else echo "btn_save";?>">
			  <input name = "btn_back" type="button" value= "Back"  id="btn_back" Onclick="location='insert_cuti.php'">
			  
			  </td>
			</tr>
		  </table>
		  <table class="bordered" width="600" align = "center">
		  <tr align="center">
		  <td width=50 align=center>tanggal </td>
		  <td align=center> emp id.</td>
		  <td align=center> ket. absen</td>
		  <td align=center> </td>
		  </tr>
		  <?php while ($row_rs_absensi_cuti = mysqli_fetch_assoc($rs_absensi_cuti)) { ?>
		  <tr>
		  <td align=center> <?php echo $row_rs_absensi_cuti['tgl'];?></td>
		  <td align=left> <?php echo $row_rs_absensi_cuti['emp_id'];?></td>
		  <td align=left> <?php echo $row_rs_absensi_cuti['ket_absen'];?></td>
		  <td align=left> <a href="saveinsert_cuti.php?delete=1&tgl=<?php echo $row_rs_absensi_cuti['tgl']; ?>&emp_id=<?php echo $row_rs_absensi_cuti['emp_id'];?>">Delete</a></td>
		  </tr>	
		  <?php } ?> 
		  <tr>
		  <td colspan="4">
		  <input name = "btn_post" type="button" value= "POST"  id="btn_post" Onclick="location='saveinsert_cuti.php?post=1'">
		  <input name = "btn_clear" type="button" value= "Clear"  id="btn_clear" Onclick="location='saveinsert_cuti.php?clear=1'">		  
		  </td>		  
		  </tr>
		 </table>
		</form>
		<iframe width=174 height=189 name="gToday:normal:calender/agenda.js" id="gToday:normal:calender/agenda.js" src="calender/ipopeng.htm" scrolling="no" frameborder="0" style="visibility:visible; z-index:999; position:absolute; top:-500px; left:-500px;">
		</iframe>
		<?php mysqli_free_result($rs_absensi_cuti);	?>
		<!-- Tabel isi selesai -->            
    	
	<div class="clear"></div>
	</div>

<!--Footer-->


</body>
</html>