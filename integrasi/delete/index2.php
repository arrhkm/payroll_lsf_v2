<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Manajemen Kartu</title>

<link href="../../../themes/orange/css/style.css" rel="stylesheet" type="text/css" />
<script src="./includes/jquery-1.3.2.min.js" type="text/javascript"></script>    	
<script type="text/javascript" src="./includes/scripts-pack.js"></script>   
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
<div class="mainHeading"><h2>Langkah 1 : Download Log Data</h2></div>
<?php
$IP="";
$Key="";
if(isset($_POST["ip"])) 
	{	
			$IP=$_POST["ip"];
			$Key=$_POST["key"]; 
	}
if($IP=="") $IP="192.168.100.136";
if($Key=="") $Key="80";
include("class_Mysql_connect.php");
require_once('../connections/koneksi.php');
$Konek=new Konek_Mysql($hostname_koneksi, $database_koneksi, $username_koneksi, $password_koneksi);
?>
<div class="searchbox">
<form name="form_mesin" method="post" action="index.php">
	<table width="500" border="0" cellpadding="0" cellspacing="0" style="padding-bottom:10px; padding-left:8px; padding-right:8px;">
	<tr>
		<td colspan="" valign="middle">IP Address:</td>
		<td><input type="Text" name="ip" value="<?php echo $IP; ?>" size="17" maxlength="15"></td>
	</tr>
	<tr>
		<td> Lokasi Mesin : </td>
		<td>
		<select name="lokasi"><!--option value="LOC004" selected="selected">LSF</option -->
		<?php 		
		$query_lok="select loc_name, loc_code from hs_hr_location ";
		$hasil_lok = $Konek->Exec_Query_Mysql($query_lok);
		while($row_lok = mysql_fetch_array($hasil_lok))
		{						
		?>
			<option value="<?php echo $row_lok['loc_code'];?>"><?php echo $row_lok['loc_name'];?></option>			
		<?php }?>
		</select>
		</td>
	</tr>
	<tr>
		<td colspan="" valign="middle" >Comm Key: </td>
		<td><input type="Text" name="key" size="5" value="<?php echo $Key;?>"></td>
	</tr>
	<tr>			
				<td>				
					From<input type="text" id="awal" name="awal"  size="10" maxlength="10" value="" onClick ="if(self.gfPop)gfPop.fPopCalendar(document.form_mesin.awal);return false;"/>
						<a href="javascript:void(0)" onClick="if(self.gfPop)gfPop.fPopCalendar(document.form_mesin.awal);return false;" >
						  <img name="popcal" align="absmiddle" style="border:none" src="./calender/calender.jpeg" width="34" height="29" border="0" alt="">
						</a>				
				</td>
				<td>				
					To <input type="text" id="akhir" name="akhir"  size="10" maxlength="10" value="" onClick ="if(self.gfPop)gfPop.fPopCalendar(document.form_mesin.akhir);return false;"/>
						<a href="javascript:void(0)" onClick="if(self.gfPop)gfPop.fPopCalendar(document.form_mesin.akhir);return false;" >
						  <img name="popcal" align="absmiddle" style="border:none" src="./calender/calender.jpeg" width="34" height="29" border="0" alt="">
						</a>				
				</td>
				
	</tr>
	<tr>
		<td colspan="2" ><input type="Submit" value="Download"></td>
	</tr>
	</table>
</form>

<iframe width=174 height=189 name="gToday:normal:calender/agenda.js" id="gToday:normal:calender/agenda.js" src="calender/ipopeng.htm" scrolling="no" frameborder="0" style="visibility:visible; z-index:999; position:absolute; top:-500px; left:-500px;"></iframe>
</div>
<?php
if(isset($_POST["ip"])) 
{
	if($_POST["ip"]!="") { 
		$lokasi=$_POST["lokasi"];
		$awal=$_POST[awal];
		$akhir=$_POST[akhir];
		?>			
		<strong>Langkah 2:</strong>
		<form name="integra" method="post" action="">
			<td><input type="submit" name="integrasi" value="Integrasi"></td>
			<input type="hidden" name="lokasi" value="<?php echo $lokasi; ?>">
		</form>			
	<table cellspacing="2" cellpadding="2" border="1">
	<tr align="center">
	    <td><B>UserID</B></td>
	    <td><B>Tanggal & Jam</B></td>
	    <td><B>Verifikasi</B></td>
	    <td><B>Status</B></td>
		
	</tr>
	<?php
	echo "awal =".$awal." - akhir : ".$akhir."<br>";
	$Connect = fsockopen($IP, "80", $errno, $errstr, 1);
	if($Connect){
		$soap_request="<GetAttLog><ArgComKey xsi:type=\"xsd:integer\">".$Key."</ArgComKey><Arg><PIN xsi:type=\"xsd:integer\">All</PIN></Arg></GetAttLog>";
		$newLine="\r\n";
		fputs($Connect, "POST /iWsService HTTP/1.0".$newLine);
	    fputs($Connect, "Content-Type: text/xml".$newLine);
	    fputs($Connect, "Content-Length: ".strlen($soap_request).$newLine.$newLine);
	    fputs($Connect, $soap_request.$newLine);
		$buffer="";
		while($Response=fgets($Connect, 1024))
		{
			$buffer=$buffer.$Response;
		}
	}else echo "Koneksi Gagal";	
	
	include("parse.php");
	$buffer=Parse_Data($buffer,"<GetAttLogResponse>","</GetAttLogResponse>");
	$buffer=explode("\r\n",$buffer);
	for($a=0;$a<count($buffer);$a++){
		$data=Parse_Data($buffer[$a],"<Row>","</Row>");
		$PIN=Parse_Data($data,"<PIN>","</PIN>");
		$DateTime=Parse_Data($data,"<DateTime>","</DateTime>");
		$Verified=Parse_Data($data,"<Verified>","</Verified>");
		$Status=Parse_Data($data,"<Status>","</Status>");
		
		if (SUBSTR($DateTime,0,10)>=$awal AND SUBSTR($DateTime,0,10) <=$akhir) 
		{
			$query="INSERT IGNORE `hs_hr_emp_absensi`(`id`,`timestamp`,`verifikasi`,`status`) 
			VALUES ( '$PIN','$DateTime','$Verified','$Status')
			;";
			$Konek->Exec_Query_Mysql($query);	
			?>	
			<tr align="center">
					<td><?php echo $PIN; ?></td>
					<td><?php echo $DateTime; ?></td>
					<td><?php echo $Verified; ?></td>
					<td><?php echo $Status; ?></td>
					
				</tr>
			<?php
		}
	}?>
	</table>
	<?php

$query="delete from `hs_hr_emp_absensi` where `id`=0";
$Konek->Exec_Query_Mysql($query);
}
}

?>
<?php 
if(isset($_POST["integrasi"])) 
{
	echo "integrasi sukses <br>";
	//if($_POST["lokasi"]!="") 
	 
	
	// script name: p_upload_time_attendance.php
 
	// connect to database  
	//include ('../connection/koneksi.php');
	  $dbConn = mysql_connect($hostname_koneksi, $username_koneksi, '') or DIE("Connection to database failed, perhaps the service is down !!");
	  mysql_select_db($database_koneksi) or DIE("Database name not available !!"); 
	//function processLogFileData() {
	  global $dbConn;    
	
	
    // looping on the hs_hr_emp_absensi (group by on date)
    $sqlString = "SELECT SUBSTR(timestamp FROM 1 FOR 10) AS timestamp_date 
	FROM hs_hr_emp_absensi 
	GROUP BY substr(timestamp FROM 1 FOR 10)
	";
    $resultTimeLogDate = mysql_query($sqlString, $dbConn);
 
		for ($i=0;$i<mysql_num_rows($resultTimeLogDate);$i++) 
		{
		  $punchDate = mysql_result($resultTimeLogDate, $i, "timestamp_date");
		  echo "processing date " . $punchDate . " Lokasi : ".$_POST[lokasi]."<br>";	 		
		
		  $lokasi=$_POST[lokasi];

		  // select all employee 		  
		  $sqlString = "SELECT a.*,b.* 
		  FROM employee a, hs_hr_emp_kartu b 
		  WHERE b.emp_number_kartu=a.emp_id and b.lokasi='$lokasi'
		  
		  ";
		  $resultEmployee = mysql_query($sqlString, $dbConn);
	 
		  for ($j=0;$j<mysql_num_rows($resultEmployee);$j++) 
		  {
				$hardwareIdOnEmployee = mysql_result($resultEmployee, $j, "no_kartu");
				$employeeIdOrange = mysql_result($resultEmployee, $j, "emp_id");
				$employeeFullName = mysql_result($resultEmployee, $j, "emp_name");
		 
				//echo "processing user id: " . $employeeIdOrange . "<br/>";
		 
				// select first data on punch-in
				$sqlString = "SELECT * FROM hs_hr_emp_absensi WHERE SUBSTR(timestamp FROM 1 FOR 10) = '" . $punchDate . "' AND id = '" . $hardwareIdOnEmployee . "' ORDER BY timestamp ASC LIMIT 1";
				$resultPunchStart = mysql_query($sqlString, $dbConn);
				if (mysql_num_rows($resultPunchStart) > 0) 
				{
					$punchStart = mysql_result($resultPunchStart, 0, "timestamp");
				} else 
				{
				  $punchStart = "";
				}
		 
				// select last data on punch-in
				$sqlString = "SELECT * FROM hs_hr_emp_absensi WHERE SUBSTR(timestamp FROM 1 FOR 10) = '$punchDate' AND id = '$hardwareIdOnEmployee' ORDER BY timestamp DESC LIMIT 1";
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
					// start save it to hs_hr_attendance
					if ($punchEnd != "") 
					{
					  $sqlString = "REPLACE INTO absensi " .
								 "(tgl, emp_id, jam_in, jam_out,  timestamp_diff, status, loc_code) VALUES " .
								 "('" . substr($punchStart,0,-9) . "', '" . $employeeIdOrange . "', '" . $punchStart . "', '" . $punchEnd . "', TIMESTAMPDIFF(HOUR,'$punchStart','$punchEnd'), '1','$lokasi')";
						
					} else 
					{
					  $sqlString = "REPLACE INTO absensi " .
								 "(tgl, emp_id, jam_in, jam_out, timestamp_diff, status, loc_code) VALUES " .
								 "('" . substr($punchStart,0,-9) . "', '" .$employeeIdOrange. "', '" . $punchStart . "', NULL, 0, '1','$lokasi')";
					}
					mysql_query($sqlString, $dbConn);
				  }
				}//end validation
		  }
		}
	// clean the data table first
	echo "cleaning the temporary table hs_hr_timeattendance_log...<br/>";
    mysql_query("DELETE FROM hs_hr_emp_absensi", $dbConn);
	//processLogFileData();
	echo "import to table absensi done!<br/>";		
}
?>
</body>
</html>



