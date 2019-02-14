<?php 
# Koneksi 
require_once('connections/conn_mysqli_procedural.php');


/*$qry_kasbon = "SELECT a.*, b.* 
FROM ldp.kasbon as a LEFT JOIN ldp.employee as b ON (b.emp_id = a.emp_id)
WHERE b.emp_id= a.emp_id AND a.status=1 
ORDER BY a.emp_id";*/

$qry_kasbon = "
    SELECT c.emp_name, b.*, sum(a.jml_cicilan) as sum_cicil, (b.jml_kasbon - sum(a.jml_cicilan)) as saldo_cicil
    FROM lsf_payroll.cicilan_kasbon as a 
    JOIN lsf_payroll.kasbon as b ON (a.kd_kasbon = b.kd_kasbon) 
    JOIN lsf_payroll.employee as c ON (c.emp_id = b.emp_id)
    WHERE b.status = 1
    GROUP BY b.kd_kasbon
";
$rs_kasbon = mysqli_query($link, $qry_kasbon) or die(mysqli_error($link));

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
	    <h2>Pembayaran Cicilan Kasbon</h2>        		
		<!-- Awal tabel -->
		<table class="bordered" width="100%">
		<tr align="center">
		<th>kd_kasbon</th>
		<th>emp_name</th>
		<th>keterangan</th>
		<th>jml Kasbon</th>
                <th>jml cicilan</th>
                <th>sisa cicilan</th>
		<th colspan = "3" align=center> </th>		
		</tr>
		<?php while($row_kasbon = mysqli_fetch_assoc($rs_kasbon)) { ?>
		<tr align="center">
		<td><?php echo $row_kasbon['kd_kasbon'];?></td>
		<td><?php echo $row_kasbon['emp_name'];?></td>
		<td><?php echo $row_kasbon['keterangan'];?></td>
		<td align="right"><?php echo "Rp. ".number_format($row_kasbon['jml_kasbon'],2,',','.');?></td>
                <td align="right"><?php echo "Rp. ".number_format($row_kasbon['sum_cicil'],2,',','.');?></td>
                <td align="right"><?php echo "Rp. ".number_format($row_kasbon['saldo_cicil'],2,',','.');?></td>
		<td>
		<a href="add_cicilan_kasbon.php?add=1&emp_id=<?php echo$row_kasbon['emp_id'];?>&kd_kasbon=<?php echo $row_kasbon['kd_kasbon'];?>">[+] Cicilan</a> |
		<a href="save_insert_create_kasbon.php?lunas2=1&emp_id=<?php echo$row_kasbon['emp_id'];?>&kd_kasbon=<?php echo $row_kasbon['kd_kasbon'];?>">Lunas</a>
		</td>		
		</tr>
		<?php } ?>
		</table>    	
	<div class="clear"></div>
	</div>
<!--Footer-->
</body>
</html>