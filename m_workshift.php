<?php 
# Koneksi 
require_once('connections/conn_mysqli_procedural.php');
# select DB 

$qry_workshift = "SELECT * FROM workshift ";
$rs_workshift = mysqli_query($link, $qry_workshift);


$SQLmax="SELECT MAX(id_workshift) as NMAX FROM workshift";
$rsMax= mysqli_query($link, $SQLmax);
$row_rsMax= mysqli_fetch_assoc($rsMax);
$max=$row_rsMax['NMAX']+1;

if (isset($_REQUEST['edit']) && $_REQUEST['edit']==1) {
$qry_editworkshift = "SELECT * FROM workshift WHERE id_workshift = '$_REQUEST[id_workshift]' ";
$rs_editworkshift = mysqli_query($link, $qry_editworkshift);
$row_editworkshift = mysqli_fetch_assoc($rs_editworkshift);

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
	            <h2>workshift</h2>
		<!-- Awal tabel -->
		<form name="form1" method="POST" action="save_workshift.php">
		  <table width="600" class="bordered" align="center">
			<tr>
			  <td width="111">Id. workshift. </td>
			  
                          <td width="325"><input name="id_workshift"  id="" value="<?php if(isset($_REQUEST['edit']) && $_REQUEST['edit']==1) {echo $row_editworkshift['id_workshift'];} else echo $max;?>"></td>
			</tr>
			<tr>
			  <td>Nama workshift </td>
			 
                          <td><input name="name_shift" type="text" id="name_shift" value="<?php if(isset($_REQUEST['edit']) && $_REQUEST['edit']==1){ echo $row_editworkshift['name_shift'];}?>"></td>
			</tr>
			
			<tr>
			  
			  <td>&nbsp;</td>
                          <td>
                                <input name ="<?php if(isset($_REQUEST['edit']) && $_REQUEST['edit']==1) { echo "btn_edit";} else echo "btn_save";?>" type="submit"  value="<?php if(isset($_REQUEST['edit']) && $_REQUEST['edit']==1) { echo "btn_edit";} else echo "btn_save";?>">
                                <input name = "btn_back" type="button" value= "Back"  id="btn_back" Onclick="location='m_workshift.php'">
			  
			  </td>
			</tr>
		  </table>
		  <table class="bordered" width=600 align = "center">
		  <tr align="center">
		  <td width=50 align=center>kd. </td>
		  <td align=center> Nama workshift</td>
		  <td colspan=""></td>
		  
		  </tr>
		  <?php while ($row_rs_workshift = mysqli_fetch_assoc($rs_workshift)) { ?>
		  <tr>
		  <td align=center> <?php echo $row_rs_workshift['id_workshift'];?></td>
		  <td align=left> <?php echo $row_rs_workshift['name_shift'];?></td>
		  <td align=center> 
				<a href="m_workshift.php?edit=1&id_workshift=<?php echo $row_rs_workshift['id_workshift'];?>">Edit</a> | 
				<a href="save_workshift.php?delete=1&id_workshift=<?php echo $row_rs_workshift['id_workshift'];?>">Delete</a> |
				<a href="workshift_detil.php?id_workshift=<?php echo $row_rs_workshift['id_workshift'];?>">Detil</a> |
				<a href="set_workshift.php?id_workshift=<?php echo $row_rs_workshift['id_workshift'];?>">Set Workshift</a> |
				<a href="set_workshift_insert.php?id_workshift=<?php echo $row_rs_workshift['id_workshift'];?>">Anggota workshift</a>
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