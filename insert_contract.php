<?php 
# Koneksi 
require_once('connections/conn_mysqli_procedural.php');
//$db= New Database();
//$db->Connect();

$SQL_emp = "SELECT a.*, b.nama_jabatan FROM employee a  JOIN 
jabatan b ON (b.kd_jabatan= a.kd_jabatan AND a.emp_id='$_REQUEST[emp_id]')";
$RS_emp = mysqli_query($link, $SQL_emp);
$ROW_emp=mysqli_fetch_assoc($RS_emp);

$SQL_kontrak="SELECT * FROM kontrak_kerja WHERE emp_id='$_REQUEST[emp_id]'";
$RS_kontrak=mysqli_query($link, $SQL_kontrak);
$NO_kontrak= mysqli_num_rows($RS_kontrak);

$QRYmax=mysqli_query($link, "select Max(id_kontrak) as NMAX from kontrak_kerja");
$ROWmax=mysqli_fetch_assoc($QRYmax);

if ($_REQUEST['edit']==1) {
$SQLedit = "SELECT * FROM kontrak_kerja WHERE emp_id = '$_REQUEST[emp_id]' AND id_kontrak='$_REQUEST[id_kontrak]'";
$RSedit = mysqli_query($link, $SQLedit) or die(mysql_error());
$ROWedit = mysqli_fetch_assoc($RSedit);
$totalROWedit = mysqli_num_rows($RSedit);
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
	    <h2>Kontrak Kerja Employee</h2>
		<!-- Awal tabel -->
		<form name="form1" method="POST" action="saveinsert_contract.php">
		  <table class="" width="500" border="0" align="center">
			<tr>
			  <td width="" colspan=3>
				<?php echo "$ROW_emp[emp_id] $ROW_emp[emp_name] - $ROW_emp[nama_jabatan]";?>
				<input type=hidden name=emp_id value=<?php echo $ROW_emp[emp_id];?>>	
			  </td>
			 
			</tr>
			<tr>
			  <td>id. Contarct</td>
			  <td>&nbsp;</td>
			  <td><?php if ($_REQUEST['edit']==1) echo $row_rsEditemp['start_kontrak']; else echo $ROWmax[NMAX]+1;?>
				<input type=hidden name=id_kontrak value=<?php if ($_REQUEST['edit']==1) echo $ROWedit['id_kontrak']; else echo $ROWmax[NMAX]+1;?>>			  
			  </td>						  
			</tr>
			<tr>
			<tr>
			  <td>No. Contarct</td>
			  <td>&nbsp;</td>
			  <td>
			  <?php if ($_REQUEST['edit']==1) echo $ROWedit['no_kontrak']; else echo $NO_kontrak+1;?>	
			  <input type=hidden name=no_kontrak value=<?php if ($_REQUEST['edit']==1) echo $ROWedit['no_kontrak']; else echo $NO_kontrak+1;?>>		
			  </td>						  
			</tr>
			<tr>			
			<tr>
			  <td>Mulai Kontrak</td>
			  <td>&nbsp;</td>
			  <td><input name="start_kontrak" type="text" size="10" maxlength="10" id="start_kontrak" value="<?php if ($_REQUEST['edit']==1) echo $ROWedit['start_kontrak'];?>"
			  onClick="if(self.gfPop)gfPop.fPopCalendar(document.form1.start_kontrak);return false;"/>
			  <a href="javascript:void(0)" onClick="if(self.gfPop)gfPop.fPopCalendar(document.form1.start_kontrak);return false;">
			  <img name="popcal" align="absmiddle" style="border:none" src="calender/calender.jpeg" width="34" height="29" border="0"alt="">
			  </a>				  
			  </td>						  
			</tr>
			<tr>
			  <td>Akhir Kontrak</td>
			  <td>&nbsp;</td>
			  <td><input name="end_kontrak" type="text" size="10" maxlength="10" id="end_kontrak" value="<?php if ($_REQUEST['edit']==1) echo $ROWedit['end_kontrak'];?>"
			  onClick="if(self.gfPop)gfPop.fPopCalendar(document.form1.end_kontrak);return false;"/>
			  <a href="javascript:void(0)" onClick="if(self.gfPop)gfPop.fPopCalendar(document.form1.end_kontrak);return false;">
			  <img name="popcal" align="absmiddle" style="border:none" src="calender/calender.jpeg" width="34" height="29" border="0"alt="">
			  </a>				  
			  </td>						  
			</tr>
			<tr>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
			  <td><input name ="<?php if ($_REQUEST['edit']==1) echo "btn_edit"; else echo "btn_save";?>" type="submit" id="<?php if ($_REQUEST['edit']==1) echo "btn_edit"; else echo "btn_save";?>" value="<?php if ($_REQUEST['edit']==1) echo "btn_edit"; else echo "btn_save";?>">
			  <input name = "btn_back" type="button" value= "Back"  id="btn_back" Onclick="location='contract.php'">
			  
			  </td>
			</tr>
		  </table>
		  </form>
		  <iframe width=174 height=189 name="gToday:normal:calender/agenda.js" id="gToday:normal:calender/agenda.js" src="calender/ipopeng.htm" scrolling="no" frameborder="0" style="visibility:visible; z-index:999; position:absolute; top:-500px; left:-500px;"></iframe>
		  <table class="bordered" width="900" align = "center">
		  <tr align="center">
			<td width=50 align=center>id conract. </td>
			<td align=center> no. contract </td>			 
			<td align=center> Start Contract </td>
			<td align=center> End Contract </td>	
			<td align=center> Lama Contract</td>
			<td align=center> </td>				
		  </tr>
		  <?php while ($ROW_kontrak =mysqli_fetch_assoc($RS_kontrak)) { ?>
		  <tr>
		  <td align=center> <?php echo $ROW_kontrak['id_kontrak'];?></td>
		  <td align=left> <?php echo $ROW_kontrak['no_kontrak'];?></td>
		  <td align=left> <?php echo $ROW_kontrak['start_kontrak'];?></td>	
		  <td align=left> <?php echo $ROW_kontrak['end_kontrak'];?></td>
		  <td align=left> <?php echo $ROW_kontrak['lama_kontrak'];?></td>		
		  <td align=left> <a href="saveinsert_contract.php?delete=1&id_kontrak=<?=$ROW_kontrak['id_kontrak']."&emp_id=".$ROW_emp['emp_id']?>"> Delete</a></td>		  
		  </tr>		 
		  <?php } ?> 
		  </table>		
		<!-- Tabel isi selesai -->            
    	
	<div class="clear"></div>
	</div>

<!--Footer-->


</body>
</html>