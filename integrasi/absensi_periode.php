<?php 

require_once('../connections/CConnect.php'); 
require_once('calendar/tc_calendar.php');
$db= New Database();

$SQL_jedah="SELECT DATEDIFF('$_POST[akhir]','$_POST[awal]') as jedah";
$rs_jedah=$db->query($SQL_jedah);
$row_jedah=$db->fetch_array($rs_jedah);
$jedah=$row_jedah[jedah];
//SELECT Employee
$sql_emp= "SELECT b.`emp_id`, c.no_kartu, b.emp_name  
FROM employee b Join hs_hr_emp_kartu c on (c.emp_number_kartu=b.emp_id)
order by c.no_kartu";
$rs_emp= $db->query($sql_emp) or die (mysql_error());

$sql_periode="SELECT * FROM periode ";
$rs_periode=$db->query($sql_periode);
function dino($dino) {
	if ($dino=="Saturday") 
		$dinoku="Sabtu";
	elseif ($dino=="Sunday")
		$dinoku="Minggu";
	elseif ($dino=="Monday")
		$dinoku="Senin";
	elseif ($dino=="Tuesday")
		$dinoku="Selasa";
	elseif ($dino=="Wednesday")
		$dinoku="Rabu";
	elseif ($dino=="Thursday")
		$dinoku="Kamis";
	elseif ($dino=="Friday")
		$dinoku="Jumat";
	return $dinoku;
}

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
<table width="562" border="1" align="center" cellpadding="1" cellspacing="1">
<tr>
    <td width="558" align="center">
	<form name="form1" id="form1" method="post" action="absensi_periode.php">      
	  Awal : 
	  <input type="text" id="awal" name="awal"  size="10" maxlength="10" value="" onClick ="if(self.gfPop)gfPop.fPopCalendar(document.form1.awal);return false;"/>
			  <a href="javascript:void(0)" onClick="if(self.gfPop)gfPop.fPopCalendar(document.form1.awal);return false;" >
			  <img name="popcal" align="absmiddle" style="border:none" src="./calender/calender.jpeg" width="34" height="29" border="0" alt="">
			  </a>
	  Akhir : 
	  <input type="text" id="akhir" name="akhir"  size="10" maxlength="10" value="" onClick ="if(self.gfPop)gfPop.fPopCalendar(document.form1.akhir);return false;"/>
			  <a href="javascript:void(0)" onClick="if(self.gfPop)gfPop.fPopCalendar(document.form1.akhir);return false;" >
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

<div class="subHeading"> <strong>DAFTAR HADIR KARYAWAN <br>From</strong> :<?php echo "$_POST[awal] <strong>to</strong> $_POST[akhir] | lama  = $jedah hari";?></div>
<br>
<br>

<table width="90%" border="1" align="center">
  <tr align="center">
    <td width="81">EMP ID </td>
	<td width="81">No. KARTU</td>
    <td width="238">Nama</td>    
	<?php 
	for ($i=0;$i<=$jedah;$i++) 
	{ 
		$tgl_ini = strtotime("+$i day" ,strtotime($_POST[awal]));
		$tgl_ini = date('Y-m-d', $tgl_ini);
		$hari_ini = date("l", strtotime($tgl_ini));
	
	echo "<td colspan=2>".$tgl_ini."<br>".dino($hari_ini)."</td>";
	} 
	?>
  </tr>
  <?php while ($row_emp = $db->fetch_array($rs_emp)) { 
  ?>
  <tr align="center" bgcolor="">
    <td><div align="center"><?php echo $row_emp[emp_id]; ?></div></td>
	<td><div align="right"><?php echo $row_emp[no_kartu]; ?></div>	</td>
    <td><div align="left"><?php echo $row_emp[emp_name]; ?></div></td>   
  <?php $alfa=0; $liburan=0;
	for ($i=0;$i<=$jedah;$i++) 
	{ 
		$tgl_ini = strtotime("+$i day" ,strtotime($_POST[awal]));
		$tgl_ini = date('Y-m-d', $tgl_ini); 
	
		$query_rs_view_harian ="
		SELECT * FROM absensi 
		WHERE emp_id = '$row_emp[emp_id]' AND tgl='$tgl_ini'
		";
		$rs_view_harian = $db->query($query_rs_view_harian) or die(mysql_error()); 
		$row_view_harian=$db->fetch_array($rs_view_harian);
		if(date("l", strtotime($tgl_ini))=="Sunday"|| $libur>=1){
			$liburan=1;
		}
		else {
			$liburan=0;
		}
		if ($liburan ==0)
		{
			if (empty($row_view_harian['jam_in']) OR empty($row_view_harian['jam_out'])) 
			{
				 $alfa++;
			}
		}    
    	echo "<td>".$row_view_harian['jam_in']."</td>";
		echo "<td>".$row_view_harian['jam_out']."</td>";    	
		} 
		?>    
  </tr>	
<?php }  ?>
</table>
</body>
</html>

