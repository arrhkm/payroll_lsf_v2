<?php 
# Koneksi 
require_once('connections/conn_mysqli_procedural.php');

$SQLmax="SELECT MAX(kd_plusmin) as NMAX FROM plusmin_gaji";
$rsMax= mysqli_query($link, $SQLmax) or die (mysqli_error($link));
$row_rsMax= mysqli_fetch_assoc($rsMax);
$max=$row_rsMax[NMAX]+1;

$sql_periode="SELECT * FROM periode ORDER BY kd_periode DESC limit 0,10";
$rs_periode=mysqli_query($link, $sql_periode) or die (mysqli_error($link));


$qry_emp = "SELECT * FROM employee ORDER BY emp_id, emp_name ";
$rs_emp = mysqli_query($link, $qry_emp) or die(mysqli_error($link));

if ($_REQUEST['edit']==1) {
$qry_editplusmin = "SELECT * FROM plusmin_gaji WHERE kd_plusmin = '$_REQUEST[kd_plusmin]' ";
$rs_editplusmin = mysqli_query($link, $qry_editplusmin) or die(mysqli_error($link));
$row_editplusmin = mysqli_fetch_assoc($rs_editplusmin);
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
	<h2>Insert Plus Minus Gaji Employee</h2>     
	    <form name="form1" method="POST" action="saveinsert_plusmin.php">
		  <table width="600" border="0" align="center">
			
			<tr>
			<td></td>
			<td></td>
			<td></td>
			<tr>
			  <td>Employee </td>
			  <td>&nbsp;</td>
			  <td>
					<input name="kd_plusmin" type="hidden" value="<?php if ($_REQUEST['edit']==1) echo $row_editplusmin['kd_plusmin']; else echo $max;?>">
					<select name="emp_id">
					<?php while($row_emp=mysqli_fetch_assoc($rs_emp)) {?>
					<option value="<?php echo $row_emp[emp_id];?>" <?php if ($row_emp[emp_id]==$row_editplusmin[emp_id]) echo 'selected="selected"';?>><?php echo $row_emp[emp_id]." .::. ".$row_emp[emp_name]; ?></options>
					<?php } ?>
					</select>					
			</tr>
			<tr>
			  <td>Periode</td>
			  <td>&nbsp;</td>
			  <td>			  
			  <select name="kd_periode">
			  <?php while ($row_periode=mysqli_fetch_assoc($rs_periode)) {?>
					<option value="<?php echo $row_periode[kd_periode];?>"<?php if ($row_periode[kd_periode]==$row_editplusmin[kd_periode]) echo 'selected="selected"';?>><?php echo $row_periode['nama_periode'];?></option>
			  <?php } ?>
			  </select>
			  Jumlah record yang ditampilkan hanya 10 row DESC
			  </td>
			</tr>
			<tr>
			  <td>tgl Plusmin</td>
			  <td>&nbsp;</td>
			  <td>
			  <input type="text" id="tgl_plusmin" name="tgl_plusmin" size="10" maxlength="10" value="<?php if ($_REQUEST['edit']==1) echo $row_editplusmin['tgl_plusmin'];?>"
			  onClick="if(self.gfPop)gfPop.fPopCalendar(document.form1.tgl_plusmin);return false;"/>
			  <a href="javascript:void(0)" onClick="if(self.gfPop)gfPop.fPopCalendar(document.form1.tgl_plusmin);return false;">
			  <img name="popcal" align="absmiddle" style="border:none" src="calender/calender.jpeg" width="34" height="29" border="0" alt="">
			  </a>
			  <!--input name="tgl_plusmin" size="10" maxlength="10"  type="text" id="" value="<?php if ($_REQUEST['edit']==1) echo $row_editplusmin['tgl_plusmin']; else echo date("Y-m-d");?>"--> yyyy-mm-dd			  
			  </td>
			</tr>
			<tr>
			  <td>jml Plus</td>
			  <td>&nbsp;</td>
			  <td>
			  <input name="jml_plus" size="" maxlength=""  type="text" id="" value="<?php if ($_REQUEST['edit']==1) echo $row_editplusmin['jml_plus'];?>"> Isi 0, jika kosong.		  
			  </td>
			</tr>
			<tr>
			  <td>jml Min</td>
			  <td>&nbsp;</td>
			  <td>
			  <input name="jml_min" size="" maxlength=""  type="text" id="" value="<?php if ($_REQUEST['edit']==1) echo $row_editplusmin['jml_min'];?>"> Isi 0, jika kosong. 		  
			  </td>
			</tr>
			<tr>
			  <td>Keterangan</td>
			  <td>&nbsp;</td>
			  <td>
			  <input name="ket" size="" maxlength=""  type="text" id="" value="<?php if ($_REQUEST['edit']==1) echo $row_editplusmin['ket'];?>">	  
			  </td>
			</tr>	
			<tr>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
			  <td><input name ="<?php if ($_REQUEST['edit']==1) echo "btn_edit"; else echo "btn_save";?>" type="submit" id="<?php if ($_REQUEST['edit']==1) echo "btn_edit"; else echo "btn_save";?>" value="<?php if ($_REQUEST['edit']==1) echo "btn_edit"; else echo "btn_save";?>">
			  <input name = "btn_back" type="button" value= "Back"  id="btn_back" Onclick="location='create_plusmin.php'">			  
			  </td>
			</tr>
		  </table>
		  </form>
		  <iframe width=174 height=189 name="gToday:normal:calender/agenda.js" id="gToday:normal:calender/agenda.js" src="calender/ipopeng.htm" scrolling="no" frameborder="0" style="visibility:visible; z-index:999; position:absolute; top:-500px; left:-500px;">
		  </iframe>
		   	
	<div class="clear"></div>
	</div>
<!--Footer-->
</body>
</html>