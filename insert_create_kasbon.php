<?php 
# Koneksi 
require_once('connections/conn_mysqli_procedural.php');

$qry_emp="select * from employee where emp_id='$_REQUEST[emp_id]'";
$rs_emp=mysqli_query($link, $qry_emp)or die(mysqli_error($link));
$row_emp= mysqli_fetch_array($rs_emp);

$qry_kasbon = "select * from kasbon where emp_id='$_REQUEST[emp_id]'";
$rs_kasbon = mysqli_query($link, $qry_kasbon) or die(mysqli_error($link));


$SQLmax="SELECT MAX(kd_kasbon) as NMAX FROM kasbon";
$rsMax= mysqli_query($link, $SQLmax) or die (mysqli_error($link));
$row_rsMax= mysqli_fetch_assoc($rsMax);
$max=$row_rsMax['NMAX']+1;

if (isset($_REQUEST['edit']) &&$_REQUEST['edit']==1) {
$qry_editkasbon = "SELECT * FROM kasbon WHERE kd_kasbon = '$_REQUEST[kd_kasbon]' ";
$rs_editkasbon = mysqli_query($link, $qry_editkasbon) or die(mysqli_error($link));
$row_editkasbon = mysqli_fetch_assoc($rs_editkasbon);

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
	            <h2>KASBON <?php echo $row_emp['emp_name'];?></h2>
		<!-- Awal tabel -->
		<form name="form1" method="POST" action="save_insert_create_kasbon.php">
		  <table width="600" border="0" align="center">
			<tr>
			  <td width="111">Kd. kasbon. </td>
			  <td width="18">&nbsp;</td>
			  <td width="325">			 
			  <input name="kd_kasbon" type="hidden" id="" value="<?php if ($_REQUEST['edit']==1) echo $row_editkasbon['kd_kasbon']; else echo $max;?>">
			  <?php if (isset($_REQUEST['edit']) &&$_REQUEST['edit']==1) echo $row_editkasbon['kd_kasbon']; else echo $max;?>			  
			  </td>
			</tr>
			<tr>
			  <td>emp_id </td>
			  <td>&nbsp;</td>
			  <td><input name="emp_id" type="hidden" id="nama_kasbon" value="<?php if ($_REQUEST['edit']==1) echo $row_editkasbon['emp_id']; else echo $_REQUEST['emp_id'];?>">
			  <?php if (isset($_REQUEST['edit']) && $_REQUEST['edit']==1) echo $row_editkasbon['emp_id']; else echo $_REQUEST['emp_id'];?>
			  </td>
			</tr>
			
			<tr>
			<td colspan=3><hr></td>
			</tr>
			
			<tr>
			  <td>tgl</td>
			  <td>&nbsp;</td>
			  <td>
			  <input type="text" id="tgl" name="tgl" size="10" maxlength="10" value="<?php if (isset($_REQUEST['edit']) && $_REQUEST['edit']==1) echo $row_editkasbon['tgl'];?>"
			  onClick="if(self.gfPop)gfPop.fPopCalendar(document.form1.tgl);return false;"/>
			  <a href="javascript:void(0)" onClick="if(self.gfPop)gfPop.fPopCalendar(document.form1.tgl);return false;">
			  <img name="popcal" align="absmiddle" style="border:none" src="calender/calender.jpeg" width="34" height="29" border="0" alt="">
			  </a>
			  
			  <!--input name="tgl" type="text" id="" value="<?php if ($_REQUEST['edit']==1) echo $row_editkasbon['tgl'];?>"--> "Y-m-d"
			  <input name="kd_trx" type="hidden" id="" value="1">
			  </td>
			</tr>
			<tr>
			  <td>Keterangan</td>
			  <td>&nbsp;</td>
			  <td><input name="keterangan" type="text" id="" value="<?php if (isset($_REQUEST['edit']) && $_REQUEST['edit']==1) echo $row_editkasbon['keterangan'];?>">
			  <input name="kasbon_aktif" type="hidden" id="" value="1">
			  </td>
			</tr>
			<tr>
			  <td>jml kasbon</td>
			  <td>&nbsp;</td>
			  <td><input name="jml_kasbon" type="text" id="" value="<?php if (isset($_REQUEST['edit']) && $_REQUEST['edit']==1) echo $row_editkasbon['jml_kasbon'];?>">
			  <input name="kd_trx" type="hidden" id="" value="1">
			  </td>
			</tr>	
			<tr>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
			  <td><input name ="<?php if (isset($_REQUEST['edit']) && $_REQUEST['edit']==1) echo "btn_edit"; else echo "btn_save";?>" type="submit" id="<?php if (isset($_REQUEST['edit']) && $_REQUEST['edit']==1) echo "btn_edit"; else echo "btn_save";?>" value="<?php if (isset($_REQUEST['edit']) && $_REQUEST['edit']==1) echo "btn_edit"; else echo "btn_save";?>">
			  <input name = "btn_back" type="button" value= "Back"  id="btn_back" Onclick="location='create_kasbon.php'">
			  
			  </td>
			</tr>
		  </table>
		  <table border ="1" width=600 align = "center">
		  <tr align="center">
		  <td width=50 align=center>kd. </td>
		  <td align=center> emp_id </td>
		  <td align=center> tgl </td>		  
		  <td align=center> jml_kasbon </td>
		  		 
		  </tr>
		  <?php while ($row_rs_kasbon = mysqli_fetch_assoc($rs_kasbon)) { ?>
		  <tr>
		  <td align=center> <?php echo $row_rs_kasbon['kd_kasbon'];?></td>
		  <td align=left> <?php echo $row_rs_kasbon['emp_id'];?></td>
		  <td align=left> <?php echo $row_rs_kasbon['tgl'];?></td>
		  <td align=left> <?php echo $row_rs_kasbon['jml_kasbon'];?></td>		    	  
		  </tr>		 
		  <?php } ?> 
		  </table>
		</form>
		<iframe width=174 height=189 name="gToday:normal:calender/agenda.js" id="gToday:normal:calender/agenda.js" src="calender/ipopeng.htm" scrolling="no" frameborder="0" style="visibility:visible; z-index:999; position:absolute; top:-500px; left:-500px;">
			  </iframe>
		<?php mysqli_free_result($rs_kasbon);	?>
		<!-- Tabel isi selesai -->            
    	
	<div class="clear"></div>
	</div>

<!--Footer-->


</body>
</html>