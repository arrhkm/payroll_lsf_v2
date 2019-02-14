<?php

include("class_Mysql_connect.php");
require_once('../connections/koneksi.php');
$Konek=new Konek_Mysql($hostname_koneksi, $database_koneksi, $username_koneksi, $password_koneksi);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Manajemen Kartu</title>

<link href="../themes/orange/css/style.css" rel="stylesheet" type="text/css" />
<!--script src="./includes/jquery-1.3.2.min.js" type="text/javascript"></script -->    	
<!-- script type="text/javascript" src="./includes/scripts-pack.js"></script -->   
<script type="text/javascript">
	$(document).ready(function() {
            
            var options1 = {                
                clearFiltersControls: [$('#cleanfilters')],                
            };
            $('#demotable1').tableFilter(options1);
			
			var grid2 = $('#demotable2');
			var options2 = {                
                filteringRows: function(filterStates) {										
					grid2.addClass('filtering');
                },
				filteredRows: function(filterStates) {      															
					grid2.removeClass('filtering');					
					setRowCountOnGrid2();
                }
            };			
			function setRowCountOnGrid2() {
				var rowcount = grid2.find('tbody tr:not(:hidden)').length;
				$('#rowcount').text('(Rows ' + rowcount + ')');										
			}
			
			grid2.tableFilter(options2); // No additional filters			
			setRowCountOnGrid2();
        });
		
		// here we define global variable
		var ajaxdestination="";

		function getdata(what,where) { // get data from source (what)
		 try {
		   xmlhttp = window.XMLHttpRequest?new XMLHttpRequest():
				new ActiveXObject("Microsoft.XMLHTTP");
		 }
		 catch (e) { /* do nothing */ }
		 document.getElementById(where).innerHTML ="<center><img src='../images/loading.gif'></center>";
		// we are defining the destination DIV id, must be stored in global variable (ajaxdestination)
		 ajaxdestination=where;
		 xmlhttp.onreadystatechange = triggered; // when request finished, call the function to put result to destination DIV
		 xmlhttp.open("GET", what);
		 xmlhttp.send(null);
		  return false;
		}

		function triggered() { // put data returned by requested URL to selected DIV
		  if (xmlhttp.readyState == 4) if (xmlhttp.status == 200) 
			document.getElementById(ajaxdestination).innerHTML =xmlhttp.responseText;
		}		
	
</script>

</head>
<body>
<div class="outerbox">
<?php include ("menu.txt"); ?>
		<div id="isinya">
		<div class="mainHeading"><h2>DOWNLOAD zsofttadb ( MySQL) </h2></div>


<div class="searchbox">
<form name="form_load" method="post" action="download_zsoft.php">
	<table width="600" border="0" cellpadding="0" cellspacing="0" style="padding-bottom:10px; padding-left:8px; padding-right:8px;">
	<tr>
	<td>Tanggal Start </td>
	<td>
	<input type="text" id="awal" name="awal"  size="10" maxlength="10" value="" onClick ="if(self.gfPop)gfPop.fPopCalendar(document.form_load.awal);return false;"/>
			  <a href="javascript:void(0)" onClick="if(self.gfPop)gfPop.fPopCalendar(document.form_load.awal);return false;" >
			  <img name="popcal" align="absmiddle" style="border:none" src="./calender/calender.jpeg" width="34" height="29" border="0" alt="">
			  </a>
	</td>
	</tr>
	<tr>
	<td>Tanggal akhir </td>
	<td>
	<input type="text" id="akhir" name="akhir"  size="10" maxlength="10" value="" onClick ="if(self.gfPop)gfPop.fPopCalendar(document.form_load.akhir);return false;"/>
			  <a href="javascript:void(0)" onClick="if(self.gfPop)gfPop.fPopCalendar(document.form_load.akhir);return false;" >
			  <img name="popcal" align="absmiddle" style="border:none" src="./calender/calender.jpeg" width="34" height="29" border="0" alt="">
			  </a>
	</td>
	</tr>
			
	<tr>
	<td>
	<td colspan="3" valign="top" ><input name="download" type="Submit" value="Download"></td>
	</tr>
	</table>
</form>
<iframe width=174 height=189 name="gToday:normal:calender/agenda.js" id="gToday:normal:calender/agenda.js" src="calender/ipopeng.htm" scrolling="no" frameborder="0" style="visibility:visible; z-index:999; position:absolute; top:-500px; left:-500px;"></iframe>
</div>
<?php
if(isset($_POST["download"])) 
{
		
		?>
			
		<strong>Langkah download dari tabel ta_log:</strong>
			
		<table cellspacing="2" cellpadding="2" border="1">
		<tr align="center">
	    <td><B>UserID</B></td>
	    <td width="200"><B>Tanggal & Jam</B></td>
	    <td><B>Verifikasi</B></td>
	    <td><B>status</B></td>
		</tr>
	<?php
			
		//$koneksi=mysql_connect("localhost", "root", "");
		mysql_select_db($zsoft_database, $koneksi);
		
		
		$query_inout="SELECT Fid, In_out, Tanggal_Log, Jam_Log, time(DateTime) as H_Log, DateTime, Verifikasi FROM ta_log 
		WHERE Tanggal_Log BETWEEN '$_POST[awal]' AND '$_POST[akhir]' ORDER BY Fid";
		$rs_inout= mysql_query($query_inout,$koneksi);
		while ($dt_zsoft=mysql_fetch_array($rs_inout)) 
		{
			 $userid=$dt_zsoft['Fid'];			 
			 $checktime=$dt_zsoft['DateTime'];
			 $verifycode=$dt_zsoft['In_out'];
			 $status=$dt_zsoft['Verifikasi'];
			 $tanggal_log= $dt_zsoft['Tanggal_Log'];
			 $jam_log= $dt_zsoft['H_Log'];
			 	
			$query="INSERT IGNORE `zsoft_log`(`id`,`timestamp`,`verifikasi`,`status`, tanggal_log, jam_log) 
			VALUES ( '$userid','$checktime', '$verifycode','$status', '$tanggal_log', '$jam_log');";
			mysql_select_db(database_koneksi, $koneksi);
			$Konek->Exec_Query_Mysql($query);			
			?>
			<tr align="center">
					<td><?php echo $userid; ?></td>
					<td><?php echo $checktime; ?></td>
					<td><?php echo $verifycode; ?></td>
					<td><?php echo $status; ?></td>
					<td><?php echo $tanggal_log; ?></td>
					<td><?php echo $jam_log; ?></td>
				</tr>
			<?php
	
		}
		?>
		</table>
		<?php
		mysql_select_db($database_koneksi, $koneksi);
		$sql_updateOut1= "UPDATE zsoft_log SET verifikasi= 1 WHERE time(timestamp) > '12:00:00'	
		AND DATE(timestamp) BETWEEN '$_POST[awal]' AND '$_POST[akhir]'";
		$sql_updateOut2= "UPDATE zsoft_log SET verifikasi= 1 WHERE time(timestamp) >= '00:00:00' AND time(timestamp) <= '03:00:00'		
		AND DATE(timestamp) BETWEEN '$_POST[awal]' AND '$_POST[akhir]'";
		$sql_updateIn= "UPDATE zsoft_log SET verifikasi = 0 WHERE  time(timestamp) BETWEEN '05:00:00' AND '09:00:00'
		AND DATE(timestamp) BETWEEN '$_POST[awal]' AND '$_POST[akhir]'";
		mysql_query($sql_updateOut1, $koneksi);
		//mysql_query($sql_updateOut2, $koneksi);
		mysql_query($sql_updateIn, $koneksi);
		echo "Download Table Zsoft completed";
	
}

?>

	<br/>
	</div> <!-- end of wrapper -->
</div> <!-- end of body wrapper -->
</body>
</html>




