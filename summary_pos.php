<?php 
# Koneksi 
require_once('connections/conn_mysqli_procedural.php');

//SEELCT ARCHIVE
$sql_periode="SELECT * FROM pos_archive WHERE kd_periode='$_REQUEST[kd_periode]' AND kd_project='$_REQUEST[kd_project]'";
$rs_periode=mysqli_query($link, $sql_periode);
$row_periode=mysqli_fetch_assoc($rs_periode);

//SELECT employee & payroll
$sql_emp = "SELECT * FROM pos_payroll WHERE kd_periode='$_REQUEST[kd_periode]' AND kd_project='$_REQUEST[kd_project]'";
$rs_emp = mysqli_query($link, $sql_emp) or die(mysqli_error($link));

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
<style>


</style>

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
	    <h2>SUMARY POS periode : <?php echo "$row_periode[tgl_awal] s/d $row_periode[tgl_akhir]"; ?></h2>        		
		<!-- Awal tabel -->
		<table class="bordered" cellpadding=0 cellspacing=0 >
		<thead>
		<tr align="center" height="30px">		
		<th width=100>BAGED ID</th><!-- Gaji_pokok 7-->
		<th width=250>NAMA</th><!-- nama -->
		<th width=200>Jabatan</th><!-- jabatan 8-->		
		<th width=200>Gaji</th><!-- total_gaji 11-->
		<th width=50>WT</th><!-- WT -->
		<th width=50>PT</th><!-- PT -->
		<th width=150>No. Rekening</th><!-- PT -->
		<th width=150>Emp Group</th><!-- PT -->
		
		</tr>
		</thead>
		<?php
		//:::::::::::::::::::::::    PERULANGAN ALL KARYAWAN  :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
		$GAJI_ALL=0; $WT_ALL=0; $PT_ALL=0;
		while ($row_emp=mysqli_fetch_assoc($rs_emp)) { 				
		//::::::::::::::::::::::::::::::::::::::::::::::  PERULANGAN WAKTU DALAM SATU PERODE :::::::::::::::::::::::::::::::::::::::::::::::::
		$sql_wtpt="SELECT SUM(jam_ev) as WT, SUM(ot) as OT FROM pos_payroll_day
		WHERE emp_id='$row_emp[emp_id]' AND kd_periode='$row_periode[kd_periode]' AND kd_project='$row_periode[kd_project]'";
		$rs_wt_pt=mysqli_query($link, $sql_wtpt);
		$row_wtpt=mysqli_fetch_assoc($rs_wt_pt);
		$PT=$row_wtpt[WT] + $row_wtpt[OT];
		?>			
		<tr align="center">		
		<td width=100 align="left"><?php echo $row_emp[emp_id];?>
		<td width=250 align="left"><?php echo $row_emp[emp_name];?>
		<td width=200 align="left"><?php echo $row_emp[jabatan];?>		
		<td width="200" align="right"><?php echo "Rp ".number_format($row_emp[tg_all],2,',','.');?></td>
		<td width="50" align="right"><?php echo $row_wtpt[WT];?></td>
		<td width="50" align="right"><?php echo $PT;?></td>
		<td width=150><?php echo $row_emp[no_rekening];?></td>
		<td width=50><?php echo $row_emp[emp_group];?></td>
		</tr >
		
		<?php
		$GAJI_ALL=$GAJI_ALL + $row_emp[tg_all]; 
		$WT_ALL=$WT_ALL + $row_wtpt[WT]; 
		$PT_ALL= $PT_ALL + $PT;
		} 		
		//::::::::::::::::::::::::::::::::::::::::::::: END OF PERULANGAN KARYAWAN :::::::::::::::::::::::::::::::::::::::::::::::::::::::
		?>
		</table>
		<table class="bordered" cellpadding=0 cellspacing=0>
		<thead>
		<tr>
		<th width=100>JUMLAH</th>
		<th width=250></th>
		<th width=200></th>
		<th width=200 align="right"><?php echo "Rp ".number_format($GAJI_ALL,2,',','.'); ?></th>
		<th width=50 align="right"><?php echo $WT_ALL;?></th>
		<th width=50 align="right"><?php echo $PT_ALL;?></th>
		<th width=150></th>		
		</tr>
		</thead>
		</table>
		
		<!-- Akhir tabel --> 	
	<div class="clear"></div>
	</div>
<!--Footer-->
</body>
</html>