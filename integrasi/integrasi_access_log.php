<?php

require_once('../connections/conn_mysqli_procedural.php');

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
		<div class="mainHeading"><h2>Langkah 1 : Download Log Data From tabel access_log ( MySQL) </h2></div>

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

?>
<div class="searchbox">
<form name="form_load" method="post" action="integrasi_access_log.php">
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
			<option value="<?php echo $nama_mesin;?>" selected="selected"><?php echo $nama_lokasi;?></option>
		</select>
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
		<strong>Langkah 2 Integrasi data from tabel access_log:</strong>
		<form method="post" action="integrasi_access_log.php">
		<input type="Submit" name="integrasi" value="Integrasi">
		<input type="hidden" name="kode_lokasi" value="LDP_LOC001">
		</form>			
		<table cellspacing="2" cellpadding="2" border="1">
		<tr align="center">
	    <td><B>UserID</B></td>
	    <td><B>Tanggal & Jam</B></td>
	    <td><B>in_out</B></td>
	    <td><B>Verifikasi</B></td>
		<td><B>Mesin Id</B></td>
		</tr>
	<?php
			
		
		
		$query_inout="SELECT id, timestamp, verifikasi, status, mesin_id 
		FROM access_log 
		WHERE DATE(timestamp) BETWEEN '$_POST[awal]' AND '$_POST[akhir]' ";
		$rs_inout= mysqli_query($link, $query_inout,$koneksi);
		while ($dt_zsoft=mysqli_fetch_assoc($rs_inout)) 
		{
			 $userid=$dt_zsoft['id'];			 
			 $checktime=$dt_zsoft['timestamp'];
			 $verifycode=$dt_zsoft['verifikasi'];
			 $status=$dt_zsoft['status'];
			 $mesin_id=$dt_zsoft['mesin_id'];
			 //Dimasukkan hs_hr_emp_absensi dulu sebagai tampungan download dari tgl x s/d y (customize)	
			$query="INSERT IGNORE `hs_hr_emp_absensi_access`(`id`,`timestamp`,`verifikasi`,`status`, mesin_id) 
			VALUES ( '$userid','$checktime', '$verifycode','$status', '$mesin_id');";
			
			mysqli_query($link, $query);			
			?>
			<tr align="center">
					<td width=""><?php echo $userid; ?></td>
					<td width=""><?php echo $checktime; ?></td>
					<td width=""><?php echo $verifycode; ?></td>
					<td width=""><?php echo $status; ?></td>
					<td width=""><?php echo $mesin_id; ?></td>
				</tr>
			<?php
	
		}
		//odbc_close($conn_odbc);
		?>
		</table>
		<?php
	
}

?>
<?php 
if(isset($_POST["integrasi"])) 
{
	if($_POST["kode_lokasi"]!="") 
	{ 	
		// looping on the hs_hr_emp_absensi_access (group by on date)
		$sqlString = "SELECT SUBSTR(timestamp FROM 1 FOR 10) AS timestamp_date 
		FROM hs_hr_emp_absensi_access GROUP BY substr(timestamp FROM 1 FOR 10)";
		$resultTimeLogDate = mysqli_query($link, $sqlString);
 
		for ($i=0;$i<mysqli_num_rows($resultTimeLogDate);$i++) 
		{
			$punchDate = mysqli_result($resultTimeLogDate, $i, "timestamp_date");
			echo "processing date " . $punchDate . "lokasi : ".$nama_mesin."<br/>";				
			
			$sqlString = "
			SELECT a.*,b.* 
			FROM employee a, hs_hr_emp_kartu b 
			WHERE b.emp_number_kartu=a.emp_id and b.lokasi='$nama_mesin'		  
			";
			$resultEmployee = mysqli_query($link, $sqlString);	 
			?> <table width="800"> <?php			
			for ($j=0;$j<mysqli_num_rows($resultEmployee);$j++) 
			{
				?>								
				<tr>
				<?php 
				$hardwareIdOnEmployee = mysqli_result($resultEmployee, $j, "no_kartu");
				$employeeIdOrange = mysqli_result($resultEmployee, $j, "emp_id");
				$employeeFullName = mysqli_result($resultEmployee, $j, "emp_name");
		 
					
		 
				// select first data on punch-in
				//----------------------------------------------------------------
				$DayStart=$punchDate." 05:00:00";
				$DayNext=$punchDate." 04:59:59";
				
				$sqlString = "SELECT * FROM hs_hr_emp_absensi_access 
				WHERE timestamp BETWEEN '".$DayStart."' AND DATE_ADD('$DayNext', interval 1 day) 
				AND id = '" . $hardwareIdOnEmployee . "' 
				AND verifikasi='I'
				ORDER BY timestamp ASC LIMIT 1";
				$resultPunchStart = mysqli_query($link, $sqlString);
				if (mysqli_num_rows($resultPunchStart) > 0) 
				{
					$punchStart = mysqli_result($resultPunchStart, 0, "timestamp");
				} else 
				{
				  $punchStart = "";
				}
		 
				// select last data on punch-Out
				//-----------------------------------------------------						
				$sqlString = "SELECT * FROM hs_hr_emp_absensi_access
				WHERE timestamp
				BETWEEN '".$DayStart."' AND DATE_ADD('$DayNext', interval 1 day)
				AND id=$hardwareIdOnEmployee
				AND verifikasi ='O'
				ORDER BY timestamp DESC LIMIT 1";				
				
				$resultPunchEnd = mysqli_query($link, $sqlString);
				if (mysqli_num_rows($resultPunchEnd) > 0) 
				{
				  $punchEnd = mysqli_result($resultPunchEnd, 0, "timestamp");
				} else 
				{
				  $punchEnd = "";
				}
								
				
				// validation
				
				if ($punchStart != "" && $punchEnd != "") // Jika cek IN dan Cek OUT
				{
					if ($punchStart == $punchEnd) // JIka cek IN = cek OUT
					{	$punchEnd = "";	}		 
					if ($punchStart != $punchEnd) 
					{	// start save it to absensi
						if ($punchEnd != "") 
						{						
							$sqlString = "REPLACE INTO absensi ".
							"(tgl, emp_id, jam_in, jam_out,  timestamp_diff, status, loc_code) VALUES " .
							"('" . substr($punchStart,0,-9) . "', '" . $employeeIdOrange . "', '" . substr($punchStart,-9,18) . "', '" . $punchEnd . "', TIMESTAMPDIFF(HOUR,'$punchStart','$punchEnd'), '1','$nama_mesin')";
						
						} else 
						{
							$sqlString = "REPLACE INTO absensi " .
								 "(tgl, emp_id, jam_in, jam_out, timestamp_diff, status, loc_code) VALUES " .
								 "('" . substr($punchStart,0,-9) . "', '" .$employeeIdOrange. "', '" . SUBSTR($punchStart ,-9,18) . "', NULL, 0, '1','$nama_mesin')";
						}						
						mysqli_query($link, $sqlString);
					}					
				}
				elseif ($punchStart != "" && $punchEnd == "") {
					$sqlString = "REPLACE INTO absensi " .
					"(tgl, emp_id, jam_in, status, loc_code) VALUES " .
					"('" . substr($punchStart,0,-9) . "', '" .$employeeIdOrange. "', '" . SUBSTR($punchStart ,-9,18) . "','1','$nama_mesin')";
					mysqli_query($link, $sqlString);
				}
				elseif ($punchStart == "" && $punchEnd !="") 
				{
					$sqlString = "REPLACE INTO absensi " .
					"(tgl, emp_id, jam_in, jam_out, status, loc_code) VALUES " .
					"('" . substr($punchStart,0,-9) . "', '" .$employeeIdOrange. "', NULL, '" . SUBSTR($punchEnd ,-9,18) . "', '1', '$nama_mesin')";
					mysqli_query($link, $sqlString);
				}
				//end validation 
				?>
				
					<td width="40"><?php echo "emp_id : ".$employeeIdOrange;?></td>
					<td width="50"><?php echo "Nama : ".$employeeFullName;?></td>
					<td width="10"><?php echo "IN : ".substr($punchStart, -9,18);?></td>
					<td width="10"><?php echo "Out: ".substr($punchEnd,-9,18);?></td>				
						
				
				<?php
				//echo "emp_id : ".$employeeIdOrange." nama : ".$employeeFullName." IN : ".substr($punchStart, -9,18)." Out: ".substr($punchEnd,-9,18)."<br/>";
			}
			?> </tr>
			<?php
		}
		?> </table> <?php
	
	// clean the data table first
	echo "cleaning the temporary table hs_hr_timeattendance_log...<br/>";
    mysqli_query($link, "DELETE FROM hs_hr_emp_absensi_access");
	mysqli_query($link, "DELETE FROM absensi WHERE tgl='0000-00-00'");
	
	//processLogFileData();
	echo "import to hs_hr_emp_absensi_access done!<br/>";	
	echo "import to table absensi done!<br/>";	
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




