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
		<div class="mainHeading"><h2>DOWNLOAD CHEKINOUT ( MS. ACCESS) </h2></div>

<?php

include("class_Mysql_connect.php");//use
require_once('../connections/koneksi.php'); //use
$Konek=new Konek_Mysql($hostname_koneksi, $database_koneksi, $username_koneksi, $password_koneksi); //use

if (!file_exists($dbName)) {
		die("Could not find database file.");
}
$db = new PDO($string_conn);//Connection PDO ODBC	
?>
<div class="searchbox">
<form name="form_load" method="post" action="from_ms_access.php">
	<table width="600" border="0" cellpadding="0" cellspacing="0" style="padding-bottom:10px; padding-left:8px; padding-right:8px;">
	<tr>
	<td>Mesin : </td>
	<td>
	<select name="mesin">
		<option value="3" selected>LDP</option>
		<option value="2">LSF</option> 
	</select>
	</td>
	</tr>
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
		if ($_POST["mesin"]=="3") {// $_POST["mesin"]==3 tidak bisa dipakai lagi karena sensor pada mesin berubah secara acak pada setiap user sehingga pada query row nama mesin diabaikan
			$mesin_id= "LDP";
		}
		else { $mesin_id= "LSF"; }
		//$kode_lokasi=$nama_mesin;//LOKASI DI LDP Karang Pilang 

		?>
			
		<strong>Langkah download dari tabel CHEKINOUT (ACCESS)  ke Tabel access_log ( MySQL):</strong>
			
		<table cellspacing="2" cellpadding="2" border="1">
		<tr align="center">
		<td><B>Sensor Id</B></td>
	    <td><B>UserID</B></td>
	    <td width="200"><B>Tanggal & Jam</B></td>
	    <td><B>Verifikasi</B></td>
	    <td><B>status</B></td>
		 <td><B>Tgl Log</B></td>
		  <td><B>Jam Log</B></td>
		</tr>
	<?php
	
		//$conn_odbc=odbc_connect($name_odbc, "", "");	//use
		
		//$= odbc_connect("Driver={Microsoft Access Driver (*.mdb)};
		//Dbq=N:\att2000.mdb", "", "");
		//$conn_odbc=odbc_connect("system_access","", "");
		
		/*YANG LAMA
		$query_inout="
		SELECT CHECKINOUT.USERID, CHECKINOUT.SENSORID, USERINFO.Badgenumber, USERINFO.Name, Format(CHECKINOUT.CHECKTIME,'yyyy-mm-dd') AS Tanggal_Log, 
		Format(CHECKINOUT.CHECKTIME,'hh:nn:ss') AS H_Log, CHECKINOUT.CHECKTIME, CHECKINOUT.VERIFYCODE, CHECKINOUT.CHECKTYPE
		FROM USERINFO , CHECKINOUT 
		WHERE 
		CHECKINOUT.USERID=[USERINFO].[USERID] AND 
		FORMAT(CHECKINOUT.CHECKTIME, 'yyyy-mm-dd') BETWEEN '$_POST[awal]' AND '$_POST[akhir]' AND 
		-- CHECKINOUT.SENSORID=3
		ORDER BY USERINFO.Badgenumber
		";
		*/
		
		// Query Tgl 02 December 2016 ditemukan kesalahan pada number sensor ID, Sensor ID pada mesin terkadang berubah pada user tertentu misal pada M Sofi dgn ID 93 tgl 2 December 2016
		/*$query_inout="
		SELECT b.USERID, b.SENSORID, a.Badgenumber, a.Name, Format(b.CHECKTIME,'yyyy-mm-dd') AS Tanggal_Log, 
		Format(b.CHECKTIME,'hh:nn:ss') AS H_Log, b.CHECKTIME, b.VERIFYCODE, b.CHECKTYPE
		FROM USERINFO a , CHECKINOUT b 
		WHERE 
		b.USERID=[a].[USERID]  
		AND FORMAT(b.CHECKTIME, 'yyyy-mm-dd') BETWEEN '$_POST[awal]' AND '$_POST[akhir]' 
		AND b.SENSORID='$_POST[mesin]'
		ORDER BY a.USERID;
		";*/
		$query_inout="
		SELECT b.USERID, b.SENSORID, a.Badgenumber, a.Name, Format(b.CHECKTIME,'yyyy-mm-dd') AS Tanggal_Log, 
		Format(b.CHECKTIME,'hh:nn:ss') AS H_Log, b.CHECKTIME, b.VERIFYCODE, b.CHECKTYPE
		FROM USERINFO a , CHECKINOUT b 
		WHERE 
		b.USERID=[a].[USERID]  
		AND FORMAT(b.CHECKTIME, 'yyyy-mm-dd') BETWEEN '$_POST[awal]' AND '$_POST[akhir]' 
		ORDER BY a.USERID;
		";
				
		//$dt_access= odbc_exec($conn_odbc,$query_inout);//use
		$result = $db->query($query_inout);//pdo_odbc//1		
		
		//$dt_access= odbc_exec("Driver={Microsoft Access Driver (*.mdb)};Dbq=C:\Program Files\Att2008\att2000.mdb",'', '');
		 //$dbh = new PDO("odbc:Driver={Microsoft Access Driver (*.mdb)};Dbq=C:/xampp/htdocs/inventory/ORSDATA.mdb;Uid=; Pwd=;");
		//while (odbc_fetch_row($dt_access)) //use
		//while ($row = $result->fetch()) //pdo_odbc//1
		while($row = $result->fetch(PDO::FETCH_ASSOC)) //0
		//while ($row = mysql_fetch_array($result))
		{
			//$userid=$dt_access['Fid'];
			$sensorid = $row[SENSORID];
			$userid = $row[Badgenumber];//$userid=odbc_result($dt_access,"Badgenumber");			 
			//$checktime=$dt_access['DateTime'];
			$checktime= $row[CHECKTIME];//$checktime=odbc_result($dt_access,"CHECKTIME");
			//$verifycode=$dt_zsoft['In_out'];
			$verifycode = $row[CHECKTYPE];//$verifycode=odbc_result($dt_access,"CHECKTYPE");
			//$status=$dt_zsoft['Verifikasi'];
			$status = $row[VERIFYCODE]; //$status=odbc_result($dt_access,"VERIFYCODE");
			//$tanggal_log= $dt_zsoft['Tanggal_Log'];
			$tanggal_log = $row[Tanggal_Log];//$tanggal_log=odbc_result($dt_access,"Tanggal_Log");
			//$jam_log= $dt_zsoft['H_Log'];
			$jam_log = $row[H_Log];//$jam_log=odbc_result($dt_access,"H_Log");
			 	
			$query="REPLACE INTO `access_log`(`id`,`timestamp`,`verifikasi`,`status`, tanggal_log, jam_log, mesin_id) 
			VALUES ( '$userid','$checktime', '$verifycode','$status', '$tanggal_log', '$jam_log', '$mesin_id');";
			$db->query($query);
			mysql_select_db($database_koneksi,$koneksi);//use//1
			$Konek->Exec_Query_Mysql($query);//1
			//mysql_query($query, $koneksi); //use
			?>
			<tr align="center">
					<td><?php echo $sensorid; ?></td>
					<td><?php echo $userid; ?></td>
					<td><?php echo $checktime; ?></td>
					<td><?php echo $verifycode; ?></td>
					<td><?php echo $status; ?></td>
					<td><?php echo $tanggal_log; ?></td>
					<td><?php echo $jam_log; ?></td>
				</tr>						
<?php	}		
		?>
		</table>
<?php
		//INI digunakan ASLINYA USE
		mysql_select_db($database_koneksi, $koneksi);
		$sql_updateOut= "UPDATE access_log SET verifikasi= 'O' WHERE time(timestamp) > '12:00:00'	
		AND DATE(timestamp) BETWEEN '$_POST[awal]' AND '$_POST[akhir]'";
		
		$sql_updateIn= "UPDATE access_log SET verifikasi = 'I' WHERE  time(timestamp) <'10:00:00'
		AND DATE(timestamp) BETWEEN '$_POST[awal]' AND '$_POST[akhir]'";
		
		mysql_query($sql_updateOut, $koneksi);
		if (mysql_query($sql_updateIn, $koneksi)){
		echo "Download Table access_log completed";
		} else echo "gagal";		
}
?>
	<br/>
	</div> <!-- end of wrapper -->
</div> <!-- end of body wrapper -->
</body>
</html>




