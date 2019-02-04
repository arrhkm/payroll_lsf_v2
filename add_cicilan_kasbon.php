<?php 
# Koneksi 
require_once('connections/conn_mysqli_procedural.php');


$qry_emp="select * from employee where emp_id='$_REQUEST[emp_id]'";
$rs_emp=mysqli_query($link, $qry_emp)or die(mysqli_error($link));
$row_emp=mysqli_fetch_array($rs_emp);

$qry_cicilan = " SELECT a.*, c.emp_id, d.nama_periode 
from cicilan_kasbon a, kasbon b, employee c, periode d
WHERE 
b.kd_kasbon=a.kd_kasbon
AND b.kd_kasbon='$_REQUEST[kd_kasbon]'
AND c.emp_id=b.emp_id
AND d.kd_periode=a.kd_periode
";
$rs_cicilan = mysqli_query($link, $qry_cicilan) or die(mysqli_error($link));

$sql_saldo="SELECT a.jml_kasbon, sum(b.jml_cicilan) as cicilan, (a.jml_kasbon-sum(b.jml_cicilan)) as saldo
FROM kasbon a, cicilan_kasbon b
WHERE b.kd_kasbon=a.kd_kasbon
AND a.kd_kasbon='$_REQUEST[kd_kasbon]'
GROUP BY a.kd_kasbon";
$rs_saldo=mysqli_query($link, $sql_saldo) or die (mysqli_error($link));
$row_saldo=mysqli_fetch_assoc($rs_saldo);

$SQLmax="SELECT MAX(kd_cicilan) as NMAX FROM cicilan_kasbon";
$rsMax= mysqli_query($link, $SQLmax) or die (mysqli_error($link));
$row_rsMax= mysqli_fetch_assoc($rsMax);
$max=$row_rsMax['NMAX']+1;

$sql_periode="SELECT * FROM periode ORDER BY kd_periode DESC LIMIT 0,25";
$rs_periode=mysqli_query($link, $sql_periode) or die (mysqli_error($link));


if (isset($_REQUEST['edit']) && $_REQUEST['edit']==1) {
$qry_editcicilan = "SELECT a.*, c.emp_id from cicilan_kasbon a, kasbon b, employee c
WHERE 
b.kd_kasbon=a.kd_kasbon
AND b.kd_kasbon='$_REQUEST[kd_kasbon]'
AND b.emp_id=c.emp_id
AND c.emp_id='$_REQUEST[emp_id]'
AND a.kd_cicilan='$_REQUEST[kd_cicilan]'";
$rs_editcicilan = mysqli_query($link, $qry_editcicilan) or die(mysqli_error($link));
$row_editcicilan = mysqli_fetch_assoc($rs_editcicilan);

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
	            <h2>Cicilan Kasbon <?php echo $row_emp['emp_name'];?></h2>
		<!-- Awal tabel -->
		<form name="form1" method="POST" action="save_add_cicilan_kasbon.php">
		  <table width="100%" border="0" align="left">
			<tr>
			  <td width="111">Kd.cicil  </td>
			  <td width="18">&nbsp;</td>
			  <td width="325"><input name="kd_cicilan"  id="" value="<?php if (isset($_REQUEST['edit']) && $_REQUEST['edit']==1) echo $row_editcicilan['kd_cicilan']; else echo $max;?>"></td>
			</tr>
			<tr>
			  <td>kd_kasbon</td>
			  <td>&nbsp;</td>
			  <td>
			  <input name="emp_id" type="hidden" id="" value="<?php if (isset($_REQUEST['edit']) && $_REQUEST['edit']==1) echo $row_editcicilan['kd_kasbon']; else echo $_REQUEST['emp_id'];?>">
			  <input name="kd_kasbon" type="text" id="" value="<?php if (isset($_REQUEST['edit']) && $_REQUEST['edit']==1) echo $row_editcicilan['kd_kasbon']; else echo $_REQUEST['kd_kasbon'];?>">
			  </td>
			</tr>
			
			<tr>
			<td colspan=3><hr></td>
			</tr>
			<tr>
			  <td>Periode</td>
			  <td>&nbsp;</td>
			  <td>
			  <select name="kd_periode">
				<?php while ($row_periode=mysqli_fetch_array($rs_periode)) { ?>
				<option value="<?php echo $row_periode['kd_periode'];?>" <?php if (isset($row_editcicilan['kd_periode']) && $row_editcicilan['kd_periode']==$row_periode['kd_periode']) echo "selected";?>><?php echo $row_periode['nama_periode'];?></option>
				<?php } ?>
			  </select>
			  </td>
			</tr>			
			<tr>
			  <td>jml cicilan</td>
			  <td>&nbsp;</td>
			  <input name="kd_trx" type="hidden" id="" value=0>
			  <td><input name="jml_cicilan" type="text" id="" value="<?php if (isset($_REQUEST['edit']) && $_REQUEST['edit']==1) echo $row_editcicilan['jml_cicilan'];?>"></td>			  
			</tr>			
			<tr>					
			<tr>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
			  <td><input name ="<?php if ($_REQUEST['edit']==1) echo "btn_edit"; else echo "btn_save";?>" type="submit" id="<?php if ($_REQUEST['edit']==1) echo "btn_edit"; else echo "btn_save";?>" value="<?php if (isset($_REQUEST['edit']) && $_REQUEST['edit']==1) echo "btn_edit"; else echo "btn_save";?>">
			  <input name = "btn_back" type="button" value= "Back"  id="btn_back" Onclick="location='cicilan_kasbon.php'">
			  
			  </td>
			</tr>
		  </table>
		</form>
		  <table class ="bordered" width=600 align = "center">
		  <tr align="center">
		  <th width=50 align=center>kd. cicilan </th>
		  <th align=center> kd .Kasbon </th>
		  <th align=center> kd. Periode</th>
		  <th align=center> nama Periode</th>		   
		  <th align=center> jml_cicil </th>
		 
		  <th></th>
		 
		  </tr>
		  <?php while ($row_cicilan = mysqli_fetch_assoc($rs_cicilan)) { ?>
		  <tr>
		  <td align=center> <?php echo $row_cicilan['kd_cicilan'];?></td>
		  <td align=left> <?php echo $row_cicilan['kd_kasbon'];?></td>
		  <td align=left> <?php echo $row_cicilan['kd_periode'];?></td>
		  <td align=left> <?php echo $row_cicilan['nama_periode'];?></td>
		  <td align=left> <?php echo $row_cicilan['jml_cicilan'];?></td>
		  
		 
		  <td>
			  <a href=add_cicilan_kasbon.php?edit=1&kd_cicilan=<?php echo $row_cicilan['kd_cicilan'];?>&kd_kasbon=<?php  echo $row_cicilan['kd_kasbon'];?>&emp_id=<?php  echo $row_cicilan['emp_id'];?>> edit </a> | 
			  <a href=save_add_cicilan_kasbon.php?delete=1&emp_id=<?php echo $row_cicilan['emp_id'];?>&kd_kasbon=<?php echo $row_cicilan['kd_kasbon'];?>&kd_cicilan=<?php echo $row_cicilan['kd_cicilan'];?>>delete</a>
		  </td>		  
		  </tr>
		 
		  <?php $sum_cicil=$sum_cicil+$row_cicilan['jml_cicilan']; }  		  		  
		  ?> 
		 </table>
	
		<?php mysqli_free_result($rs_cicilan);	?>
	<!-- Tabel isi selesai -->            
		<table align="">
		  <tr>		  
		  <td colspan=3>Kasbon</td>		  
		  <td colspan=2><?php  echo number_format($row_saldo['jml_kasbon'],2,',','.');?></td>
		  
		  </tr>
		  
		  <tr>
		  <td colspan=3>Cicilan</td>	
		  <td colspan=2><?php  echo number_format($row_saldo['cicilan'],2,',','.')."<br>";?></td>		  
		  <tr>
		  </tr>
		  
		  <tr>
		  <td colspan=3>Sisa Kasbon </td>	
		  <td colspan=2><?php  echo number_format($row_saldo['saldo'],2,',','.');?></td>		 
		  </tr>
		 </table>	
    	
	<div class="clear"></div>
	</div>

<!--Footer-->


</body>
</html>