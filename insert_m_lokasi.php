<?php 
# Koneksi 
require_once('connections/conn_mysqli_procedural.php');
# select DB 
//mysql_select_db($database_koneksi, $koneksi);
$query_rslokasi = "SELECT * FROM hs_hr_location ORDER BY loc_code ASC";
$rslokasi = mysqli_query($link, $query_rslokasi);


$SQLmax="SELECT MAX(loc_code) as NMAX FROM hs_hr_location";
$rsMax= mysqli_query($link, $SQLmax);
$row_rsMax= mysqli_fetch_assoc($rsMax);
$max=$row_rsMax[NMAX]+1;

if ($_REQUEST['edit']==1) {
$query_rsEditlokasi = "SELECT * FROM hs_hr_location WHERE loc_code = '$_REQUEST[loc_code]'  ORDER BY loc_code ASC";
$rsEditlokasi = mysqli_query($link, $query_rsEditlokasi);
$totalRows_rsEditlokasi = mysqli_num_rows($rsEditlokasi);
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
	            <h2>lokasi</h2>
		<!-- Awal tabel -->
		<form name="form1" method="POST" action="saveinsert_m_lokasi.php">
		  <table width="600" border="0" align="center">
			<tr>
			  <td width="111">loc_code. </td>
			  <td width="18">&nbsp;</td>
			  <td width="325"><input name="loc_code" type="text" id="loc_code" value="<?php if ($_REQUEST['edit']==1) echo $row_rsEditlokasi['loc_code']; else echo $max;?>"><?php if ($_REQUEST['edit']==1) echo $row_rsEditlokasi['loc_code']; else echo $max;?></td>
			</tr>
			<tr>
			  <td>loc_name </td>
			  <td>&nbsp;</td>
			  <td><input name="loc_name" type="text" id="loc_name" value="<?php if ($_REQUEST['edit']==1) echo $row_rsEditlokasi['loc_name'];?>"></td>
			</tr>
			
			<tr>
			  <td>loc_state</td>
			  <td>&nbsp;</td>
			  <td><input name="loc_state" type="text"  id="" value="<?php if ($_REQUEST['edit']==1) echo $row_rsEditlokasi['loc_state'];?>"> </td>
			</tr>
			<tr>
			  <td>loc_city</td>
			  <td>&nbsp;</td>
			  <td><input name="loc_city" type="text" id="" value="<?php if ($_REQUEST['edit']==1) echo $row_rsEditlokasi['loc_city'];?>"></td>
			</tr>
			<tr>
			  <td>loc_add</td>
			  <td>&nbsp;</td>
			  <td><input name="loc_add" type="text"  id="" value="<?php if ($_REQUEST['edit']==1) echo $row_rsEditlokasi['loc_add'];?>"></td>
			</tr>
			<tr>
			  <td>loc_zip</td>
			  <td>&nbsp;</td>
			  <td><input name="loc_zip" type="text"  id="" value="<?php if ($_REQUEST['edit']==1) echo $row_rsEditlokasi['loc_zip'];?>"></td>
			</tr>
			<tr>
			  <td>loc_phone</td>
			  <td>&nbsp;</td>
			  <td><input name="loc_phone" type="text"  id="" value="<?php if ($_REQUEST['edit']==1) echo $row_rsEditlokasi['loc_phone'];?>"></td>
			</tr>
			<tr>
			  <td>loc_fax</td>
			  <td>&nbsp;</td>
			  <td><input name="loc_fax" type="text"  id="" value="<?php if ($_REQUEST['edit']==1) echo $row_rsEditlokasi['loc_fax'];?>"></td>
			</tr>
			<tr>
			  <td>loc_comments</td>
			  <td>&nbsp;</td>
			  <td><input name="loc_comments" type="text"  id="" value="<?php if ($_REQUEST['edit']==1) echo $row_rsEditlokasi['loc_comments'];?>"></td>
			</tr>
			<tr>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
			  <td><input name ="<?php if ($_REQUEST['edit']==1) echo "btn_edit"; else echo "btn_save";?>" type="submit" id="<?php if ($_REQUEST['edit']==1) echo "btn_edit"; else echo "btn_save";?>" value="<?php if ($_REQUEST['edit']==1) echo "btn_edit"; else echo "btn_save";?>">
			  <input name = "btn_back" type="button" value= "Back"  id="btn_back" Onclick="location='m_lokasi.php'">
			  
			  </td>
			</tr>
		  </table>
		  <table border ="1" width=900 align = "center">
		  <tr align="center">
			<th>loc_code</th>
			<th>loc_name</th>
			<th>loc_state</td>
			<th>loc_city</th>
			<th>loc_add</th>
			<th>loc_zip</th>
			<th>loc_phone</th>
			<th>loc_fax</th>
			<th>loc_comments</th>
			<th>Insert</th>
		  </tr>
		  <?php while ($row_rslokasi = mysqli_fetch_assoc($rslokasi)) { ?>
		  <tr>
			<td><?php echo $row_rslokasi[loc_code];?></td>
			<td><?php echo $row_rslokasi[loc_name];?></td>
			<td><?php echo $row_rslokasi[loc_state];?></td>
			<td><?php echo $row_rslokasi[loc_city];?></td>
			<td><?php echo $row_rslokasi[loc_add];?></td>
			<td><?php echo $row_rslokasi[loc_zip];?></td>
			<td><?php echo $row_rslokasi[loc_phone];?></td>
			<td><?php echo $row_rslokasi[loc_fax];?></td>
			<td><?php echo $row_rslokasi[loc_comments];?></td>
			<td><a href="insert_m_lokasi.php?edit=1&loc_code=<?php echo $row_rslokasi[loc_code];?>">Edit</a></td>
		  </tr>		 
		  <?php } ?> 
		  </table>
		</form>
		<iframe width=174 height=189 name="gToday:normal:calender/agenda.js" id="gToday:normal:calender/agenda.js" src="calender/ipopeng.htm" scrolling="no" frameborder="0" style="visibility:visible; z-index:999; position:absolute; top:-500px; left:-500px;"></iframe>
				
		<?php mysqli_free_result($rslokasi);	?>
		<!-- Tabel isi selesai -->            
    	
	<div class="clear"></div>
	</div>

<!--Footer-->


</body>
</html>