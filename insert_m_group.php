<?php 
# Koneksi 
require_once('connections/conn_mysqli_procedural.php');
# select DB 
//mysql_select_db($database_koneksi);
$query_rsgroup = "SELECT * FROM group_employee ORDER BY group_name ASC";
$rsgroup = mysqli_query($link, $query_rsgroup) or die(mysqli_error($link));


$SQLmax="SELECT MAX(id) as NMAX FROM group_employee";
$rsMax= mysqli_query($link, $SQLmax) or die (mysqli_error($link));
$row_rsMax= mysqli_fetch_assoc($rsMax);
$max=$row_rsMax[NMAX]+1;

if ($_REQUEST['edit']==1) {
$query_rsEditgroup = "SELECT * FROM group_employee WHERE id = '$_REQUEST[id]'  ORDER BY id ASC";
$rsEditgroup = mysqli_query($link, $query_rsEditgroup) or die(mysqli_error($link));
$row_rsEditgroup = mysqli_fetch_assoc($rsEditgroup);
$totalRows_rsEditgroup = mysqli_num_rows($rsEditgroup);
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
	            <h2>group</h2>
		<!-- Awal tabel -->
		<form name="form1" method="POST" action="saveinsert_m_group.php">
		  <table width="600" border="0" align="center">
			<tr>
			  <td width="111">id. </td>
			  <td width="18">&nbsp;</td>
			  <td width="325"><input name="id" type="text" id="id" value="<?php if ($_REQUEST['edit']==1) echo $row_rsEditgroup['id']; else echo $max;?>"><?php if ($_REQUEST['edit']==1) echo $row_rsEditgroup['id']; else echo $max;?></td>
			</tr>
			<tr>
			  <td>group_name </td>
			  <td>&nbsp;</td>
			  <td><input name="group_name" type="text" id="group_name" value="<?php if ($_REQUEST['edit']==1) echo $row_rsEditgroup['group_name'];?>"></td>
			</tr>			
			<tr>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
			  <td><input name ="<?php if ($_REQUEST['edit']==1) echo "btn_edit"; else echo "btn_save";?>" type="submit" id="<?php if ($_REQUEST['edit']==1) echo "btn_edit"; else echo "btn_save";?>" value="<?php if ($_REQUEST['edit']==1) echo "btn_edit"; else echo "btn_save";?>">
			  <input name = "btn_back" type="button" value= "Back"  id="btn_back" Onclick="location='m_group.php'">
			  
			  </td>
			</tr>
		  </table>
		  <table border ="1" width=900 align = "center">
		  <tr align="center">
			<th>id</th>
			<th>group_name</th>			
		  </tr>
		  <?php while ($row_rsgroup = mysqli_fetch_assoc($rsgroup)) { ?>
		  <tr>
			<td><?php echo $row_rsgroup[id];?></td>
			<td><?php echo $row_rsgroup[group_name];?></td>			
			<td><a href="insert_m_group.php?edit=1&id=<?php echo $row_rsgroup[id];?>">Edit</a></td>
		  </tr>		 
		  <?php } ?> 
		  </table>
		</form>
		<iframe width=174 height=189 name="gToday:normal:calender/agenda.js" id="gToday:normal:calender/agenda.js" src="calender/ipopeng.htm" scrolling="no" frameborder="0" style="visibility:visible; z-index:999; position:absolute; top:-500px; left:-500px;"></iframe>
				
		<?php mysqli_free_result($rsgroup);	?>
		<!-- Tabel isi selesai -->            
    	
	<div class="clear"></div>
	</div>

<!--Footer-->


</body>
</html>