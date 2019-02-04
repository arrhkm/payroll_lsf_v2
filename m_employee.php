<?php 
require_once ('cek_login.php');
# Koneksi 
require_once('connections/conn_mysqli_procedural.php');
# select DB 
//mysql_select_db($database_koneksi, $koneksi);

if(!empty($_POST['inputString'])) {
$qry_employee = "
Select a.*, timestampdiff(MONTH, a.start_work, CURDATE()) as ms_kerja, b.nama_jabatan, group_name FROM employee a LEFT JOIN 
jabatan b ON (b.kd_jabatan= a.kd_jabatan)
LEFT JOIN group_employee c
ON (c.id= a.emp_group)
WHERE a.emp_name LIKE '%$_POST[inputString]%'
 ";
$rs_employee = mysqli_query($link, $qry_employee);
}
else {
$qry_employee = "
Select a.*, timestampdiff(MONTH, a.start_work, CURDATE()) as ms_kerja, b.nama_jabatan, group_name 
FROM employee a LEFT JOIN 
jabatan b ON (b.kd_jabatan= a.kd_jabatan) 
LEFT JOIN group_employee c
ON (c.id= a.emp_group)
 ";
$rs_employee = mysqli_query($link, $qry_employee);
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
		
	    <h2>employee</h2> 
		<div class="">
			<form action="m_employee.php" method="post">
				<div>
					Type your employee name:
					<?php if (isset($_POST['inputString'])){ echo $_POST['inputString'];}?>
					<br />
					<input type="text" name= "inputString" size="30" value="" id="inputString">
					<input type=submit name="src" value="Search">
					<input type=button name="upload" value="Upload from CSV" onclick="location='upload_file_employee.php'">
				</div>					
			</form>
		</div>
		<!-- Awal tabel -->
		<table class="bordered" width="100%">
		<tr align="center">
		<th>EMP ID</th>
		<th>Nama</th>
		<th>Jabatan</th>
		<th>Gaji Pokok</th>
		<th>Gaji Lembur</th>
		<th>Pot jamsos</th>
		<th>T-Jab</th>
		<th>T-Msker</th>
		<th>T-Insen</th>
		<th>Pot-Telat</th>
		<th>No.Rekening</th>
		<th>Uang Makan</th>
		<th>Start Work</th>
		<th>Msker<br>(Bulan)</th>
		<th>emp_group</th>
		<th width="50px" colspan ="" align=center><a href="insert_m_employee.php" >Insert Emp</a></th>		
		</tr>
		<?php while($row_rsemployee = mysqli_fetch_assoc($rs_employee)) { ?>
		<tr align="center">
		<td align="rigt"><?php echo $row_rsemployee['emp_id'];?></td>
		<td align="left"><?php echo $row_rsemployee['emp_name'];?></td>
		<td align="left"><?php echo $row_rsemployee['nama_jabatan'];?></td>
		<td align="right"><?php echo number_format($row_rsemployee['gaji_pokok'],2,',','.');?></td>
		<td align="right"><?php echo number_format($row_rsemployee['gaji_lembur'],2,',','.');?></td>
		<td align="right"><?php echo number_format($row_rsemployee['pot_jamsos'],2,',','.');?></td>
		<td align="right"><?php echo number_format($row_rsemployee['t_jabatan'],2,',','.');?></td>
		<td align="right"><?php echo number_format($row_rsemployee['t_masakerja'],2,',','.');?></td>
		<td align="right"><?php echo number_format($row_rsemployee['t_insentif'],2,',','.');?></td>
		<td align="right"><?php echo number_format($row_rsemployee['pot_telat'],2,',','.');?></td>
		<td align="right"><?php echo $row_rsemployee['no_rekening'];?></td>
		<td align="right"><?php echo number_format($row_rsemployee['uang_makan'],2,',','.');?></td>
		<td align="right"><?php echo $row_rsemployee['start_work'];?></td>
		<td align="right"><?php echo $row_rsemployee['ms_kerja'];?></td>
		<td align="right"><?php echo $row_rsemployee['group_name'];?></td>
		<td width="50px">
		<a href="insert_m_employee.php?edit=1&emp_id=<?php echo $row_rsemployee['emp_id'];?>">Edit</a> |  
		<a href="saveinsert_m_employee.php?delete=1&emp_id=<?php echo $row_rsemployee['emp_id'];?>">X</a>
		</td>		
		</tr>
		<?php } ?>
		</table>    	
	<div class="clear"></div>
	</div>
<!--Footer-->
</body>
</html>