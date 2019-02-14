<?php 
# Koneksi 
require_once('connections/conn_mysqli_procedural.php');
# select DB 
//mysql_select_db($database_koneksi, $koneksi);
$qry_rs_emp = "SELECT * FROM employee ORDER BY emp_id ASC";
//$rs_emp = mysqli_query($qry_rs_emp, $koneksi) or die(mysql_error());
$rs_emp = mysqli_query($link, $qry_rs_emp);

$qyr_jabatan="select kd_jabatan, nama_jabatan from jabatan";
//$rs_jabatan= mysql_query($qyr_jabatan,$koneksi)or die(mysql_error());
$rs_jabatan = mysqli_query($link, $qyr_jabatan);
if (isset($_REQUEST['edit']) && $_REQUEST['edit']==1) {
    $qry_rsEditemp = "SELECT * FROM employee WHERE emp_id = '$_REQUEST[emp_id]'  ORDER BY emp_id ASC";
    //$rsEditemp = mysql_query($qry_rsEditemp, $koneksi) or die(mysql_error());
    $rsEditemp = mysqli_query($link, $qry_rsEditemp);
    $row_rsEditemp = mysqli_fetch_assoc($rsEditemp);
    $totalRows_rsEditemp = mysqli_num_rows($rsEditemp);
}
$sqlGroup= "select * from group_employee";
$rsGroup= mysqli_query($link, $sqlGroup);
$db_emp_group= array('MECHANICAL', 'SUBCONT', 'FITTER');
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

<script type="text/javascript" src="js/jqry.min.js"></script>
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

</script>

<link rel="stylesheet" href="css/slimbox2.css" type="text/css" media="screen" /> 
<script type="text/JavaScript" src="js/slimbox2.js"></script> 

</head>
<body>
<!-- Header Menu -->
<?php require_once('header.inc'); ?>

<div id="templatemo_main" class="wrapper">	
	<!-- Tempat Menaruh Tabel ISI -->
	    <h2>Employee</h2>
		<!-- Awal tabel -->
		<form name="form1" method="POST" action="saveinsert_m_employee.php">
		  <table class="" width="800" border="0" align="center">
			<tr>
			  <td width="111">ID </td>
			  <td width="18">&nbsp;</td>
			  <td width="325"><input name="emp_id" value="<?php if ($_REQUEST['edit']==1) echo $row_rsEditemp['emp_id'];?>"></td>
			</tr>
			<tr>
			  <td>Nama </td>
			  <td>&nbsp;</td>
			  <td><input name="emp_name" type="text" id="emp_name" value="<?php if ($_REQUEST['edit']==1)echo $row_rsEditemp['emp_name'];?>"></td>
			</tr>
			<tr>
			  <td>Jabatan</td>
			  <td>&nbsp;</td>
			  <td>
					<select name="kd_jabatan">
					<?php while($row_jabatan= mysqli_fetch_assoc($rs_jabatan)) {?>
					<option value="<?php echo $row_jabatan['kd_jabatan'];?>" <?php if ($row_jabatan['kd_jabatan']==$row_rsEditemp['kd_jabatan']) echo 'selected="selected"';?>><?php echo $row_jabatan['nama_jabatan']; ?></options>
					<?php } ?>
					</select>
					<!--<option value ="<?php echo $row_jabatan[kd_jabatan];?>"<?php if (($_REQUEST['edit']==1) && ($row_jabatan==$row_rsEditemp[kd_jabatan])) echo "selected";?>><?php echo $row_jabatan[nama_jabatan];?></option -->	
			</tr>
			<tr>
			  <td>Gaji</td>
			  <td>&nbsp;</td>
			  <td><input name="gaji_pokok" type="text" id="" value="<?php if ($_REQUEST['edit']==1) echo $row_rsEditemp['gaji_pokok'];?>"></td>
			</tr>
			<tr>
			  <td>Gaji Lembur</td>
			  <td>&nbsp;</td>
			  <td><input name="gaji_lembur" type="text" id="" value="<?php if ($_REQUEST['edit']==1) echo $row_rsEditemp['gaji_lembur'];?>"></td>
			</tr>
			<tr>
			  <td>Potongan jamsos</td>
			  <td>&nbsp;</td>
			  <td><input name="pot_jamsos" type="text" id="" value="<?php if ($_REQUEST['edit']==1) echo $row_rsEditemp['pot_jamsos'];?>"></td>
			</tr>		
			<tr>
			  <td>Tunjangan jabatan</td>
			  <td>&nbsp;</td>
			  <td><input name="t_jabatan" type="text" id="" value="<?php if ($_REQUEST['edit']==1) echo $row_rsEditemp['t_jabatan'];?>"></td>
			</tr>
			<tr>
			  <td>Tunjangan masakerja</td>
			  <td>&nbsp;</td>
			  <td><input name="t_masakerja" type="text" id="" value="<?php if ($_REQUEST['edit']==1) echo $row_rsEditemp['t_masakerja'];?>"></td>
			</tr>
			<tr>
			  <td>Tunjangan Insentif</td>
			  <td>&nbsp;</td>
			  <td><input name="t_insentif" type="text" id="" value="<?php if ($_REQUEST['edit']==1) echo $row_rsEditemp['t_insentif'];?>"></td>
			</tr>
			<tr>
			<tr>
			  <td>Pot Telat</td>
			  <td>&nbsp;</td>
			  <td><input name="pot_telat" type="text" id="" value="<?php if ($_REQUEST['edit']==1) echo $row_rsEditemp['pot_telat'];?>"></td>
			</tr>
			<tr>
			  <td>No. Rekening</td>
			  <td>&nbsp;</td>
			  <td><input name="no_rekening" type="text" id="" value="<?php if ($_REQUEST['edit']==1) echo $row_rsEditemp['no_rekening'];?>"></td>
			</tr>
			<tr>
			  <td>Uang Makan</td>
			  <td>&nbsp;</td>
			  <td><input name="uang_makan" type="text" id="" value="<?php if ($_REQUEST['edit']==1) echo $row_rsEditemp['uang_makan'];?>"></td>
			</tr>
			<tr>
			  <td>Start Work</td>
			  <td>&nbsp;</td>
			  <td><input name="start_work" type="text" size="10" maxlength="10" id="start_work" value="<?php if ($_REQUEST['edit']==1) echo $row_rsEditemp['start_work'];?>"
			  onClick="if(self.gfPop)gfPop.fPopCalendar(document.form1.start_work);return false;"/>
			  <a href="javascript:void(0)" onClick="if(self.gfPop)gfPop.fPopCalendar(document.form1.start_work);return false;">
			  <img name="popcal" align="absmiddle" style="border:none" src="calender/calender.jpeg" width="34" height="29" border="0"alt="">
			  </a>	
			  
			  </td>						  
			</tr>
			<tr>
			  <td> emp_group </td>
			  <td>&nbsp;</td>
			  <td>
				<select name="emp_group">
					<?php 
						while ($rowGroup = mysqli_fetch_assoc($rsGroup)) { 
					?>
					<option  value="<?php echo $rowGroup['id'];?>" <?php if ($rowGroup['id']==$row_rsEditemp['emp_group']) echo 'selected="selected"';?>><?php echo $rowGroup['group_name'];?> </option>
					<?php } ?>
				</select>
			  </td>
			</tr>
			<tr>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
			  <td><input name ="<?php if ($_REQUEST['edit']==1) echo "btn_edit"; else echo "btn_save";?>" type="submit" id="<?php if ($_REQUEST['edit']==1) echo "btn_edit"; else echo "btn_save";?>" value="<?php if ($_REQUEST['edit']==1) echo "btn_edit"; else echo "btn_save";?>">
			  <input name = "btn_back" type="button" value= "Back"  id="btn_back" Onclick="location='m_employee.php'">
			  
			  </td>
			</tr>
		  </table>
		  </form>
		  <iframe width=174 height=189 name="gToday:normal:calender/agenda.js" id="gToday:normal:calender/agenda.js" src="calender/ipopeng.htm" scrolling="no" frameborder="0" style="visibility:visible; z-index:999; position:absolute; top:-500px; left:-500px;"></iframe>
		  <table class="bordered" width=100% align = "center">
		  <tr align="center">
		  <td width=50 align=center>ID. </td>
		  <td align=center> Nama </td>
		  <td align=center> No. Rek </td>
		  <td align=center> KD. Jabatan </td>
		  <td align=center> Gaji Pokok</td>
		  <td align=center> Gaji Lembur </td>
		  <td align=center> Pot. Jamsostek </td>
		  <td align=center> Uang makan </td>
		  <td align=center> Start Work </td>
		  <td align=center> emp_group </td>
		  </tr>
		  <?php while ($row_rs_emp = mysqli_fetch_assoc($rs_emp)) { ?>
		  <tr>
		  <td align=center> <?php echo $row_rs_emp['emp_id'];?></td>
		  <td align=left> <?php echo $row_rs_emp['emp_name'];?></td>
		  <td align=left> <?php echo $row_rs_emp['no_rekening'];?></td>	
		  <td align=left> <?php echo $row_rs_emp['kd_jabatan'];?></td>
		  <td align=left> <?php echo $row_rs_emp['gaji_pokok'];?></td>
		  <td align=left> <?php echo $row_rs_emp['gaji_lembur'];?></td>
		  <td align=left> <?php echo $row_rs_emp['pot_jamsos'];?></td>
		  <td align=left> <?php echo $row_rs_emp['uang_makan'];?></td>
		  <td align=left> <?php echo $row_rs_emp['start_work'];?></td>
		  <td align=left> <?php echo $row_rs_emp['emp_group'];?></td>
		  </tr>		 
		  <?php } ?> 
		  </table>
		
		<?php mysqli_free_result($rs_emp);	?>
		<!-- Tabel isi selesai -->            
    	
	<div class="clear"></div>
	</div>

<!--Footer-->


</body>
</html>