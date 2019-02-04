<?php 
# Koneksi 
require_once('connections/conn_mysqli_procedural.php');

$SQLmax="SELECT MAX(kd_safety) as NMAX FROM safety_talk";
$rsMax= mysqli_query($link, $SQLmax) or die (mysqli_error($link));
$row_rsMax= mysqli_fetch_assoc($rsMax);
$max=$row_rsMax[NMAX]+1;

//Mengambil jumlah safty talk
$sql_jlmsafetytalk="
SELECT safety_talk FROM attribut_payroll
";
$rs_jmlsafety_talk=mysqli_query($link, $sql_jlmsafetytalk) or die(mysqli_error($link));
$row_jmlsafety_talk=mysqli_fetch_assoc($rs_jmlsafety_talk);
//-------------------------------------------------------------

$qry_emp = "SELECT * FROM employee ";
$rs_emp = mysqli_query($link, $qry_emp) or die(mysqli_error($link));

if ($_REQUEST['edit']==1) {
$qry_editsafety = "SELECT * FROM safety_talk WHERE kd_safety = '$_REQUEST[kd_safety]' ";
$rs_editsafety = mysqli_query($link, $qry_editsafety) or die(mysqli_error($link));
$row_editsafety = mysqli_fetch_assoc($rs_editsafety);
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
	<h2>Safety Talk</h2>     
	    <form name="form1" method="POST" action="saveinsert_safetytalk.php">
		  <table width="600" border="0" align="center">
			
			<tr>
			<td></td>
			<td></td>
			<td></td>
			<tr>
			  <td>Emp_id <?php //echo $max;?></td>
			  <td>&nbsp;</td>
			  <td>
					<input name="kd_safety" type="hidden" value="<?php if ($_REQUEST['edit']==1) echo $row_editsafety['kd_safety']; else echo $max;?>">
					<select name="emp_id">
					<?php while($row_emp=mysqli_fetch_array($rs_emp)) {?>
					<option value="<?php echo $row_emp[emp_id];?>" <?php if ($row_emp[emp_id]==$row_editsafety[emp_id]) echo 'selected="selected"';?>><?php echo $row_emp[emp_id].", ".$row_emp[emp_name]; ?></options>
					<?php } ?>
					</select>					
			</tr>
			<tr>
			  <td>tgl_safety</td>
			  <td>&nbsp;</td>
			  <td>
			  <input type="text" id="tgl_safety" name="tgl_safety" size="10" maxlength="10" value="<?php if ($_REQUEST['edit']==1) echo $row_editsafety['tgl_safety'];?>"
			  onClick="if(self.gfPop)gfPop.fPopCalendar(document.form1.tgl_safety);return false;"/>
			  <a href="javascript:void(0)" onClick="if(self.gfPop)gfPop.fPopCalendar(document.form1.tgl_safety);return false;">
			  <img name="popcal" align="absmiddle" style="border:none" src="calender/calender.jpeg" width="34" height="29" border="0" alt="">
			  </a>
			  
			  <!--input name="tgl_safety" size="10" maxlength="10"  type="text" id="" value="<?php if ($_REQUEST['edit']==1) echo $row_editsafety['tgl_safety'];?>"--> yyyy-mm-dd
			  <input name="jml_safety" type="hidden"  value="<?php echo $row_jmlsafety_talk[safety_talk];?>">
			  </td>
			</tr>			
			<tr>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
			  <td><input name ="<?php if ($_REQUEST['edit']==1) echo "btn_edit"; else echo "btn_save";?>" type="submit" id="<?php if ($_REQUEST['edit']==1) echo "btn_edit"; else echo "btn_save";?>" value="<?php if ($_REQUEST['edit']==1) echo "btn_edit"; else echo "btn_save";?>">
			  <input name = "btn_back" type="button" value= "Back"  id="btn_back" Onclick="location='create_safetytalk.php'">			  
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