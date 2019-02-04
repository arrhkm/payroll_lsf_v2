<?php 
require_once('../connections/conn_mysqli_procedural.php');
require_once('calendar/tc_calendar.php');


/*$query_rs_view_harian = "SELECT a.`emp_id`, b.emp_id, 
b.emp_name , date(a.jam_in) as tanggal, 
a.jam_in, a.jam_out, a.status, a.`loc_code` 
FROM absensi a Join employee b On (a.emp_id = b.emp_id 
and DATE(a.`jam_in`) = DATE('$theDate1')) 
order by b.`emp_id`";
*/
$query_rs_view_harian ="SELECT a.`emp_id`, c.no_kartu,
b.emp_name , a.tgl as tanggal, 
a.jam_in, a.jam_out, a.status, a.`loc_code`, a.jam_in as Hin, a.jam_out as Hout, 
TIMEDIFF(a.jam_out, a.jam_in) as durasi
FROM absensi a Join employee b On (a.emp_id = b.emp_id 
and a.tgl = '$_POST[awal]') 
Join hs_hr_emp_kartu c on (c.emp_number_kartu=a.emp_id)
order by c.no_kartu";

$rs_view_harian = mysqli_query($link, $query_rs_view_harian) or die(mysqli_error($link));
$row_rs_view_harian = mysqli_fetch_assoc($rs_view_harian);
$totalRows_rs_view_harian = mysqli_num_rows($rs_view_harian);
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Report per Day</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../themes/orange/css/style.css" rel="stylesheet" type="text/css" />
<script src="../includes/jquery-1.3.2.min.js" type="text/javascript"></script>    	
<script type="text/javascript" src="../includes/scripts-pack.js"></script>   

</head>

<body>
<?php include ("menu.txt"); ?>
<div class="mainHeading"><h2>Lihat Download Absensi </h2></div>
<table width="562" border="0" align="center" cellpadding="1" cellspacing="1">
  <tr>
    <td width="558" align="center">
	<form name="form1" id="form1" method="post" action="list_rpt_day.php">
      Tanggal : <input type="text" id="awal" name="awal"  size="10" maxlength="10" value="" onClick ="if(self.gfPop)gfPop.fPopCalendar(document.form1.awal);return false;"/>
			  <a href="javascript:void(0)" onClick="if(self.gfPop)gfPop.fPopCalendar(document.form1.awal);return false;" >
			  <img name="popcal" align="absmiddle" style="border:none" src="./calender/calender.jpeg" width="34" height="29" border="0" alt="">
			  </a>
	  
      <input name="submit" type="submit" value="submit" />
      </form>
	  <iframe width=174 height=189 name="gToday:normal:calender/agenda.js" id="gToday:normal:calender/agenda.js" src="calender/ipopeng.htm" scrolling="no" frameborder="0" style="visibility:visible; z-index:999; position:absolute; top:-500px; left:-500px;"></iframe>

	  </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<table width="90%" border="1" align="center" cellpadding="1" cellspacing="1">

  <tr>
    <td colspan="8"><? echo "Tanggal : ".$theDate1; ?></td>
  </tr>
  <tr>
    <td width="81"><div align="center">EMP ID </div></td>
	<td width="81"><div align="center">No. KARTU </div></td>
    <td width="238"><div align="center">Nama</div></td>
    <td width="142"><div align="center">TANGGAL</div></td>
    <td width="102"><div align="center">IN</div>      <div align="center"></div></td>
    <td width="113"><div align="center">OUT</div></td>	
    <td width="58"><div align="center">STATUS</div></td>
	<td width="58"><div align="center">durasi</div></td>
  </tr>
  <?php do { ?>
  <tr align="center">
    <td><div align="center"><?php echo $row_rs_view_harian['emp_id']; ?></div></td>
	<td><div align="right"><?php echo $row_rs_view_harian['no_kartu']; ?></div>	</td>
    <td><div align="left">&nbsp;<?php echo $row_rs_view_harian['emp_name']; ?></div></td>
    <td><div align="center"><?php echo $row_rs_view_harian['tanggal']; ?></div></td>
    <td><div align="center"><?php echo $row_rs_view_harian['Hin']; ?></div></td>
    <td><div align="center"><?php echo $row_rs_view_harian['Hout']; ?></div></td>
    <td><div align="center">  <?php echo $row_rs_view_harian['status']; ?></div></td>
	<td><div align="center">  <?php echo $row_rs_view_harian['durasi']; ?></div></td>
  </tr>
  <?php } while ($row_rs_view_harian = mysqli_fetch_assoc($rs_view_harian)); ?>
</table>
</body>
</html>
<?php
mysqli_free_result($rs_view_harian);
?>
