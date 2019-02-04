<?php require_once('../connections/koneksi.php'); ?>
<?php require_once('calendar/tc_calendar.php');


mysql_select_db($database_koneksi, $koneksi);

//$rs_emp= mysql_query($sql_emp, $koneksi) or die (mysql_error());




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
<form name="form1" id="form1" method="post" action="setup_pulang.php">   
	<table width="400" border="0" align="left" cellpadding="1" cellspacing="1">
	<tr>	
		<td width=""> Tanggal :</td>
		<td>
			<input type="text" id="awal" name="awal"  size="10" maxlength="10" value="" onClick ="if(self.gfPop)gfPop.fPopCalendar(document.form1.awal);return false;"/>
				  <a href="javascript:void(0)" onClick="if(self.gfPop)gfPop.fPopCalendar(document.form1.awal);return false;" >
				  <img name="popcal" align="absmiddle" style="border:none" src="./calender/calender.jpeg" width="34" height="29" border="0" alt="">
				  </a>
		</td>
	</tr>
	<tr>
		<td>Setup jam Pulang : 
		</td>
		<td>
			<input type="text" name="jam_out">
		</td>
	<tr>
		<td></td>
		<td><input name="submit" type="submit" value="submit"></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	</table>
</form>
<iframe width=174 height=189 name="gToday:normal:calender/agenda.js" id="gToday:normal:calender/agenda.js" src="calender/ipopeng.htm" scrolling="no" frameborder="0" style="visibility:visible; z-index:999; position:absolute; top:-500px; left:-500px;"></iframe>
<?php 
if ($_POST[submit]) 
{
	$out= $_POST[awal]." ".$_POST[jam_out];
	$sql_setup_pulang="UPDATE absensi SET jam_out='$out' WHERE tgl='$_POST[awal]'";
	if (mysql_query($sql_setup_pulang, $koneksi))
	{
		echo "Data jam Pulang sudah ter update ".$_POST[awal]." tangal : ".$_POST[jam_pulang];
	}
	else 
	echo "gagal ";
}
?>	

</body>
</html>
<?php
//mysql_free_result($rs_view_harian);
?>
