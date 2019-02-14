<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Manajemen Kartu</title>

<link href="../../../themes/orange/css/style.css" rel="stylesheet" type="text/css" />
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
		<div class="mainHeading"><h2>Langkah 1 : Download Log Data From zsofttadb ( MySQL) </h2></div>

<?php
$IP="";
$Key="";
if(isset($_POST["ip"])) 
	{
		//echo("xxWA");
		$IP=$_POST["ip"];
		$Key=$_POST["key"]; 
	}
if($IP=="") $IP="192.168.1.201";
if($Key=="") $Key="80";
include("class_Mysql_connect.php");
require_once('../connections/koneksi.php');
$Konek=new Konek_Mysql($hostname_koneksi, $database_koneksi, $username_koneksi, $password_koneksi);
?>
<div class="searchbox">
<form name="form_load" method="post" action="from_zsoft.php">
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
	<td>Lokasi: </td>
	<td align= "left">
		<input type="hidden" name="ip" value="<?php echo $IP; ?>">
		<select name="lokasi">
			<option value="LDP_LOC001" selected="selected">LDP</option>
		</select>
	</td>
	</tr>			
	<tr>
	<td>
	<td colspan="3" valign="top" ><input type="Submit" value="Download"></td>
	</tr>
	</table>
</form>
<iframe width=174 height=189 name="gToday:normal:calender/agenda.js" id="gToday:normal:calender/agenda.js" src="calender/ipopeng.htm" scrolling="no" frameborder="0" style="visibility:visible; z-index:999; position:absolute; top:-500px; left:-500px;"></iframe>
</div>
<?php
if(isset($_POST["ip"])) 
{
	if($_POST["ip"]!="") 
	{ 
		$kode_lokasi="LDP_LOC001";//LSF

		?>
			
		<strong>Langkah 2:</strong>
		<form method="post" action="from_zsoft.php">
		<input type="Submit" name="integrasi" value="Integrasi">
		<input type="hidden" name="kode_lokasi" value="LDP_LOC001">
		</form>			
		<table cellspacing="2" cellpadding="2" border="1">
		<tr align="center">
	    <td><B>UserID</B></td>
	    <td width="200"><B>Tanggal & Jam</B></td>
	    <td><B>in_out</B></td>
	    <td><B>Verifikasi</B></td>
		</tr>
	<?php
			
		$conn_zsoft=mysql_connect("localhost", "root", "");
		mysql_select_db("zsofttadb",$conn_zsoft);
		//if($koneksi) echo "database terkoneksi";
		//else 
		//echo" Gagal"; 
		$query_inout="SELECT Fid, In_out, Tanggal_Log, DateTime, Verifikasi FROM ta_log 
		WHERE Tanggal_Log BETWEEN '$_POST[awal]' AND '$_POST[akhir]' ";
		$rs_inout= mysql_query($query_inout,$conn_zsoft);
		while ($dt_zsoft=mysql_fetch_array($rs_inout)) 
		{
			 $userid=$dt_zsoft['Fid'];			 
			 $checktime=$dt_zsoft['DateTime'];
			 $verifycode=$dt_zsoft['In_out'];
			 $status=$dt_zsoft['Verifikasi'];
			 	
			$query="INSERT IGNORE `hs_hr_emp_absensi`(`id`,`timestamp`,`verifikasi`,`status`) 
			VALUES ( '$userid','$checktime', '$verifycode','$status');";
			mysql_select_db("ldp",$conn_zsoft);
			$Konek->Exec_Query_Mysql($query);			
			?>
			<tr align="center">
					<td><?php echo $userid; ?></td>
					<td><?php echo $checktime; ?></td>
					<td><?php echo $verifycode; ?></td>
					<td><?php echo $status; ?></td>
				</tr>
			<?php
	
		}
		//odbc_close($conn_odbc);
		?>
		</table>
		<?php
	}
}

?>
<?php 
if(isset($_POST["integrasi"])) 
{
	if($_POST["kode_lokasi"]!="") 
	{ 
		
		// script name: p_upload_time_attendance.php
 
		// connect to database  
		//include ('../connection/koneksi.php');
		$dbConn = mysql_connect($hostname_koneksi, $username_koneksi, '') or DIE("Connection to database failed, perhaps the service is down !!");
		mysql_select_db($database_koneksi) or DIE("Database name not available !!");
		//function processLogFileData() {
		global $dbConn;  	
		// looping on the hs_hr_emp_absensi (group by on date)
		$sqlString = "SELECT SUBSTR(timestamp FROM 1 FOR 10) AS timestamp_date 
		FROM hs_hr_emp_absensi GROUP BY substr(timestamp FROM 1 FOR 10)";
		$resultTimeLogDate = mysql_query($sqlString, $dbConn);
 
		for ($i=0;$i<mysql_num_rows($resultTimeLogDate);$i++) 
		{
			$punchDate = mysql_result($resultTimeLogDate, $i, "timestamp_date");
			echo "processing date " . $punchDate . "lokasi : ".$_POST[kode_lokasi]."<br/>";				
			$lokasi=$_POST["kode_lokasi"];
			// select all employee 	yang terdaftar dalam Mesin LOC004	  
			$sqlString = "SELECT a.*,b.* 
			FROM employee a, hs_hr_emp_kartu b 
			WHERE b.emp_number_kartu=a.emp_id and b.lokasi='LDP_LOC001'		  
			";
			$resultEmployee = mysql_query($sqlString, $dbConn);	 
			for ($j=0;$j<mysql_num_rows($resultEmployee);$j++) 
			{
				
				$hardwareIdOnEmployee = mysql_result($resultEmployee, $j, "no_kartu");
				$employeeIdOrange = mysql_result($resultEmployee, $j, "emp_id");
				$employeeFullName = mysql_result($resultEmployee, $j, "emp_name");
		 
					
		 
				// select first data on punch-in
				//----------------------------------------------------------------
				$DayStart=$punchDate." 05:00:00";
				$DayNext=$punchDate." 04:59:59";
				
				$sqlString = "SELECT * FROM hs_hr_emp_absensi 
				WHERE timestamp BETWEEN '".$DayStart."' AND DATE_ADD('$DayNext', interval 1 day) 
				AND id = '" . $hardwareIdOnEmployee . "' 
				AND verifikasi=0
				ORDER BY timestamp ASC LIMIT 1";
				$resultPunchStart = mysql_query($sqlString, $dbConn);
				if (mysql_num_rows($resultPunchStart) > 0) 
				{
					$punchStart = mysql_result($resultPunchStart, 0, "timestamp");
				} else 
				{
				  $punchStart = "";
				}
		 
				// select last data on punch-Out
				//-----------------------------------------------------						
				$sqlString = "SELECT * FROM hs_hr_emp_absensi
				WHERE timestamp	BETWEEN '".$DayStart."' AND DATE_ADD('$DayNext', interval 1 day)
				AND id=$hardwareIdOnEmployee
				AND verifikasi!=0
				ORDER BY timestamp DESC LIMIT 1";				
				
				$resultPunchEnd = mysql_query($sqlString, $dbConn);
				if (mysql_num_rows($resultPunchEnd) > 0) 
				{
				  $punchEnd = mysql_result($resultPunchEnd, 0, "timestamp");
				} else 
				{
				  $punchEnd = "";
				}
								
				
				// validation
				
				if ($punchStart != "" && $punchEnd != "") 
				{
					if ($punchStart == $punchEnd) 
					{
						$punchEnd = "";
					}
		 
					if ($punchStart != $punchEnd) 
					{
						
						// start save it to absensi
						if ($punchEnd != "") 
						{
						
							$sqlString = "REPLACE INTO absensi ".
							"(tgl, emp_id, jam_in, jam_out,  timestamp_diff, status, loc_code) VALUES " .
							"('" . substr($punchStart,0,-9) . "', '" . $employeeIdOrange . "', '" . $punchStart . "', '" . $punchEnd . "', TIMESTAMPDIFF(HOUR,'$punchStart','$punchEnd'), '1','$_POST[kode_lokasi]')";
						
						} else 
						{
							$sqlString = "REPLACE INTO absensi " .
								 "(tgl, emp_id, jam_in, jam_out, timestamp_diff, status, loc_code) VALUES " .
								 "('" . substr($punchStart,0,-9) . "', '" .$employeeIdOrange. "', '" . $punchStart . "', NULL, 0, '1','$_POST[kode_lokasi]')";
						}
						
						mysql_query($sqlString, $dbConn);
					}
					
				}
				elseif ($punchStart != "" && $punchEnd == "") {
					$sqlString = "REPLACE INTO absensi " .
					"(tgl, emp_id, jam_in, status, loc_code) VALUES " .
					"('" . substr($punchStart,0,-9) . "', '" .$employeeIdOrange. "', '" . $punchStart . "','1','$_POST[kode_lokasi]')";
					mysql_query($sqlString, $dbConn);
				}				
				//end validation 
				echo "emp_id : ".$employeeIdOrange." nama : ".$employeeFullName." IN : ".$punchStart." Out: ".$punchEnd."<br/>";
				
			}
		}
	//}
	// clean the data table first
	echo "cleaning the temporary table hs_hr_timeattendance_log...<br/>";
    mysql_query("DELETE FROM hs_hr_emp_absensi", $dbConn);
	//processLogFileData();
	echo "import to hs_hr_emp_absensi done!<br/>";	
	?>
	<?php
	}
}
?> 
	<br/>
	</div> <!-- end of wrapper -->
</div> <!-- end of body wrapper -->
</body>
</html>




