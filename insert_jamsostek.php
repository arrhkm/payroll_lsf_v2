<?php 
# Koneksi 
require_once('connections/conn_mysqli_procedural.php');

$kd_periode=$_REQUEST[kd_periode];
/*
$qry_emp="SELECT b.emp_id, b.emp_name, b.pot_jamsos
FROM jamsostek a RIGHT JOIN employee b 
ON (b.emp_id = a.emp_id) WHERE a.emp_id IS NULL";
*/
$qry_emp="
SELECT a.emp_id, a.emp_name, a.pot_jamsos
FROM employee a 
WHERE emp_id like 'LSF%'
";


$rs_emp=mysqli_query($link, $qry_emp);
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
	            <h2>Periode  No. <?php echo $_REQUEST['kd_periode'];?> </h2>
		<!-- Awal tabel -->
		<form name="form1" method="POST" action="saveinsert_jamsostek.php">
		  <table width="600" class="bordered" align="">
			<tr>
			  <td width="111">Employee </td>
			  
			</tr>
			<tr>
			<td>
			<input type='submit' value='Tambah' name='btn_tambah' class='bordered' onClick='return confirm("Anda yakin ingin menambah data yang terpilih???")'>
			<input type='button' value='Back' name='btn_back' class='bordered' onClick="location='jamsostek.php?kd_periode=<?php echo $_REQUEST['kd_periode'];?>'">
			</td>
			</tr>
			<tr>
			  <td width="325">
				<?php								
				$num_row= mysqli_num_rows($rs_emp);
				$no=1;	
				while($row=mysqli_fetch_array($rs_emp))
				{ ?>
				<table border=0>
				<tr>
				<td><?php echo $no;?>
				<input type=checkbox name=cek[] value="<?php echo $row['emp_id'];?>" id=<?php echo "id-".$no;?>> 
				</td>
				<td><?php echo $row['emp_id']."-".$row['emp_name'];?></td>
				</tr></table> <?php
				$no++;
				}	
				?>
				</td>
			</tr>
			<tr>
			<td>
				<input type=radio name=pilih onClick='for (i=1;i<<?php echo $no; ?>;i++){document.getElementById("id-"+i).checked=true;}'>Centang Semua
				<input type=radio name=pilih onClick='for (i=1;i<<?php echo $no; ?>;i++){document.getElementById("id-"+i).checked=false;}'> Hapus Semua Centang
				<input type= hidden name= "emp_id" value="<?php echo $row['emp_id'];?>">
				<input type= hidden name= "kd_periode" value="<?php echo $_REQUEST['kd_periode'];?>">
				
			</td>
			</tr>
			<tr>
			<td>
				<!-- input type='submit' value='Tambah' name='btn_tambah' class='bordered' onClick='return confirm("Anda yakin ingin menambah data yang terpilih???")' -->
                                <input type="submit" value="Tambah" name="btn_tambah">
                                <input type='button' value='Back' name='btn_back' class='bordered' onClick="location='jamsostek.php?kd_periode=<?php echo $_REQUEST[kd_periode];?>'">
			</td>
			</tr>
				  
		</form>
		<?php ?>
		<!-- Tabel isi selesai -->            
    	
	<div class="clear"></div>
	</div>

<!--Footer-->


</body>
</html>