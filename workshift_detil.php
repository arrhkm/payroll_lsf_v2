<?php 
# Koneksi 
require_once('connections/conn_mysqli_procedural.php');
# select DB 

$qry_workshift_detil = "SELECT * FROM workshift_detil WHERE id_workshift='$_REQUEST[id_workshift]'";
$rs_workshift_detil = mysqli_query($link, $qry_workshift_detil);

$sql_workshift="SELECT * FROM workshift WHERE id_workshift='$_REQUEST[id_workshift]'";
$rs_workshift=mysqli_query($link, $sql_workshift);
$row_workshift=mysqli_fetch_assoc($rs_workshift);

$SQLmax="SELECT MAX(num_day) as NMAX FROM workshift_detil WHERE id_workshift='$_REQUEST[id_workshift]'";
$rsMax= mysqli_query($link, $SQLmax);
$row_rsMax= mysqli_fetch_assoc($rsMax);
$max=$row_rsMax['NMAX']+1;

if (isset($_REQUEST['edit']) && $_REQUEST['edit']==1) {
$qry_editworkshift_detil = "SELECT * FROM workshift_detil WHERE id_workshift = '$_REQUEST[id_workshift]' AND num_day='$_REQUEST[num_day]' ";
$rs_editworkshift_detil = mysqli_query($link, $qry_editworkshift_detil);
$row_editworkshift_detil = mysqli_fetch_assoc($rs_editworkshift_detil);

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
	            <h2>workshift_detil</h2>
		<!-- Awal tabel -->
		<form name="form1" method="POST" action="save_workshift_detil.php">
		  <table width="600" class="bordered" align="center">
			<tr>
			  <th colspan="2"><?php echo $row_workshift['name_shift'];?></th>
			</tr>
			<tr>
			<tr>
			  <td width="111">num_day</td>			  
			  <td width="325"><input name="num_day"  id="num_day" value="<?php if (isset($_REQUEST['edit']) && $_REQUEST['edit']==1) echo $row_editworkshift_detil['num_day']; else echo $max;?>"></td>
			</tr>
			<tr>
			  <td>id_workshift</td>			 
			  <td><input name="id_workshift" type="text" id="id_workshift" value="<?php if (isset($_REQUEST['edit']) && $_REQUEST['edit']==1) echo $row_editworkshift_detil['id_workshift']; else echo $_REQUEST['id_workshift'];?>"></td>
			</tr>
			<tr>
			  <td>logika</td>			 
			  <td><input name="logika" type="text" id="logika" value="<?php if (isset($_REQUEST['edit']) && $_REQUEST['edit']==1) echo $row_editworkshift_detil['logika'];?>"></td>
			</tr>
			<tr>
			  <td>office in</td>			 
			  <td><input name="office_in" type="text" id="office_in" value="<?php if (isset($_REQUEST['edit']) && $_REQUEST['edit']==1) echo $row_editworkshift_detil['office_in'];?>"></td>
			</tr>
			<tr>
			  <td>office_out</td>			 
			  <td><input name="office_out" type="text" id="office_out" value="<?php if (isset($_REQUEST['edit']) && $_REQUEST['edit']==1) echo $row_editworkshift_detil['office_out'];?>"></td>
			</tr>
			<tr>			  
			  <td>&nbsp;</td>
			  <td><input name ="<?php if (isset($_REQUEST['edit']) && $_REQUEST['edit']==1) echo "btn_edit"; else echo "btn_save";?>" type="submit" id="<?php if (isset($_REQUEST['edit']) && $_REQUEST['edit']==1) echo "btn_edit"; else echo "btn_save";?>" value="<?php if (isset($_REQUEST['edit']) && $_REQUEST['edit']==1) echo "btn_edit"; else echo "btn_save";?>">
			  <input name = "btn_back" type="button" value= "Back"  id="btn_back" Onclick="location='m_workshift.php'">
			  
			  </td>
			</tr>
		  </table>
		  <table class="bordered" width=600 align = "center">
		  <tr align="center">
			<td width=50 align=center>numday. </td>
			<td align=center> id_workshift</td>
			<td width=50 align=center>logika</td>
			<td align=center> office In</td>			
			<td align=center> Office Out</td>
			<td colspan=""></td>
		  
		  </tr>
		  <?php while ($row_rs_workshift_detil = mysqli_fetch_assoc($rs_workshift_detil)) { ?>
		  <tr>
			<td align=center> <?php echo $row_rs_workshift_detil['num_day'];?></td>
			<td align=left> <?php echo $row_rs_workshift_detil['id_workshift'];?></td>
			<td align=center> <?php echo $row_rs_workshift_detil['logika'];?></td>
			<td align=center> <?php echo $row_rs_workshift_detil['office_in'];?></td>
			<td align=left> <?php echo $row_rs_workshift_detil['office_out'];?></td>			
			<td align=center> 
				<a href="workshift_detil.php?edit=1&id_workshift=<?php echo $row_rs_workshift_detil['id_workshift'];?>&num_day=<?php echo $row_rs_workshift_detil['num_day'];?>">Edit</a> | 
				<a href="save_workshift_detil.php?delete=1&id_workshift=<?php echo $row_rs_workshift_detil['id_workshift'];?>&num_day=<?php echo $row_rs_workshift_detil['num_day'];?>">Delete</a> 						  
		  </td>
		 
		  </tr>		 
		  <?php } ?> 
		  </table>
		</form>
		<?php ?>
		<!-- Tabel isi selesai -->            
    	
	<div class="clear"></div>
	</div>

<!--Footer-->


</body>
</html>