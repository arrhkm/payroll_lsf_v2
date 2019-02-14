<?php 
# Koneksi 
require_once('connections/conn_mysqli_procedural.php');
/*
KETERANGAN : 
file contract message ini berfungsi untuk menambahkan row pada contract_warmning dengan ketentuan 
1. jika kontrak akan berakhior kurang dari samadengan 15 hari. 
2. jika lebih dari batas waktu hingga warmning message dimatikan (off) di sistem.

file ini akan di eksekusi dalam bentuk file *.bat pada schedule di sistem windows xp
konfigurasi dari pengiriman email ada di sendmail.ini, yang di panggil dari php.ini
- php.ini : 
	sendmail_path = "C:\sendmail\sendmail.exe -t"
- sendmail.ini : 
	smtp_server=smtp.lintech.co.id
	smtp_port=465
	auth_username=hakam@lintech.co.id
	auth_password=hakamlin7890 (selama pasword tidak dirubah)
	force_sender=Payroll
*/
//------------------------------------------------
if (isset($_REQUEST['OFF']) && $_REQUEST['OFF']==1) {
	$sql_off="UPDATE kontrak_message SET status=1 WHERE id_kontrak=$_REQUEST[id_kontrak]";
	mysqli_query($link, $sql_off);
}
else if (isset($_REQUEST['ON']) && $_REQUEST['ON']==1) {
	$sql_on="UPDATE kontrak_message SET status=0 WHERE id_kontrak=$_REQUEST[id_kontrak]";
	mysqli_query($link, $sql_on);
}
else if (isset($_REQUEST['DELL']) && $_REQUEST['DELL']==1) {
	$sql_del="DELETE FROM kontrak_message WHERE id_kontrak=$_REQUEST[id_kontrak]";
	mysqli_query($link, $sql_del);
}
//---------------------------------------------
$SQLwarm="SELECT a.emp_id, a.emp_name, b.nama_jabatan, c.id_kontrak, c.no_kontrak, 
c. start_kontrak, c.end_kontrak, c.lama_kontrak, datediff(curdate(), end_kontrak) as lamax
FROM employee a, jabatan b, kontrak_kerja c
WHERE 
c.emp_id=a.emp_id AND 
b.kd_jabatan= a.kd_jabatan
 AND datediff(curdate(), end_kontrak) >= -45
 AND datediff(curdate(), end_kontrak) <=0
";
//Ket : >= -45 --> remainder 45 hari sebelum do date
//ket : <=0 --> yang lewat dari 1 hari ke atas tidak ikut di ulang  
$RSwarm=mysqli_query($link, $SQLwarm);
while ($ROWwarm=mysqli_fetch_assoc($RSwarm)) 
{
	$SQLmsg="INSERT IGNORE  kontrak_message 
	(`id_kontrak`, `emp_id`, `emp_name`, `nama_jabatan`, `no_kontrak`, `start_kontrak`, `end_kontrak`, `lama_kontrak`, `umur_kontrak`, `status`) 
	VALUES ( $ROWwarm[id_kontrak], '$ROWwarm[emp_id]', '$ROWwarm[emp_name]', '$ROWwarm[nama_jabatan]', $ROWwarm[no_kontrak],
	'$ROWwarm[start_kontrak]', '$ROWwarm[end_kontrak]', $ROWwarm[lama_kontrak], $ROWwarm[lamax], 0)";
	$RSmsg=mysqli_query($link, $SQLmsg);
}
//----------------------------------------------
$SQLmsg2="SELECT * FROM kontrak_message ORDER BY end_kontrak DESC LIMIT 0,20 ";
$RSmsg2=mysqli_query($link, $SQLmsg2);

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
<script src="includes/jquery-1.3.2.min.js" type="text/javascript"></script>    	
<script type="text/javascript" src="includes/scripts-pack.js"></script>  
<script type="text/javascript">

ddsmoothmenu.init({
	mainmenuid: "templatemo_menu", //menu DIV id
	orientation: 'h', //Horizontal or vertical menu: Set to "h" or "v"
	classname: 'ddsmoothmenu', //class added to menu's outer DIV
	customtheme: ["#", "#"],
	contentsource: "markup" //"markup" or ["container_id", "path_to_menu_file"]
})

</script>
<script language="JavaScript">
	
	$(document).ready(function() {
            //  Randomly Create Data Rows
          /*  for (var i = 0; i < 50; i++) {
                var tr = $("<tr>" +
					"<td>Value" + Math.floor(Math.random() * 500) + "</td>" + 
					"<td>" + Math.floor(Math.random() * 500) + " </td>" + 
					"<td>" + (Math.random() > 0.5 ? "yes" : "no") + "</td>" + 
					"<td>" + (Math.random() <= 0.333 ? "Item 1" : Math.random() > 0.5 ? "Item 2" : "Item 3") + "</td>" + 
					"<td></td>" +
					"<td>" + parseInt(10 + Math.random() * 18) + "/" + parseInt(10 + Math.random() * 2) + "/2009</td>" + 					
					
					"</tr>");
                $('#demotable1 tbody').append(tr);
            }*/
			
			/*for (var i = 0; i < 50; i++) {
                var tr = $("<tr><td>Value(2) " + Math.floor(Math.random() * 500) + "</td></tr>");
                $('#demotable2 tbody').append(tr);
            }*/

            // Initialise Plugin
            var options1 = {
                //additionalFilterTriggers: [$('#onlyyes'), $('#onlyno'), $('#quickfind')],
                clearFiltersControls: [$('#cleanfilters')],
                /*matchingRow: function(state, tr, textTokens) {
                    if (!state || !state.id) { return true; }					
					var val =  tr.children('td:eq(2)').text();
					switch (state.id) {
						case 'onlyyes': return state.value !== 'true' || val === 'yes';
						case 'onlyno': return state.value !== 'true' || val === 'no';
						default: return true;
					}
                }*/
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

<link rel="stylesheet" href="css/slimbox2.css" type="text/css" media="screen" /> 
<script type="text/JavaScript" src="js/slimbox2.js"></script> 
</head>
<body>
<!-- Header Menu -->
<?php require_once('header.inc'); ?>

<div id="templatemo_main" class="wrapper" >
<!-- div class="searchbox" -->
	<!-- Tempat Menaruh Tabel ISI -->
		
	    <h2>Warmning Message Kontrak Kerja Employee</h2> 
		
		<!-- Awal tabel -->
		<table class="bordered" id='demotable1'>
		<thead>
		<tr align="center">
		<th filter='false'>EMP ID</th>
		<th filter='false'>Nama</th>
		<th filter='false'>Jabatan</th>		
		<th filter='false'>Kontrak ke-</th>
		<th filter='false'>Start</th>
		<th filter='false'>End</th>	
		<th filter='false'>Kurang (x) hari</th>
		<th filter='false'>Status</th>
		<th  filter='false' width="150px" colspan ="" align=center></th>		
		</tr>
		</thead>
		<?php
		
		while($ROWmsg2 = mysqli_fetch_assoc($RSmsg2)) { 
			if ($ROWmsg2['umur_kontrak']>0) {
				$status= "LEWAT";
			}else $status="KURANG";
		?>
		<tr align="center">
		<td align="rigt"><?php echo $ROWmsg2['emp_id'];?></td>
		<td align="left"><?php echo $ROWmsg2['emp_name'];?></td>
		<td align="left"><?php echo $ROWmsg2['nama_jabatan'];?></td>
		<td align="left"><?php echo $ROWmsg2['no_kontrak'];?></td>
		<td align="left"><?php echo $ROWmsg2['start_kontrak'];?></td>
		<td align="left"><?php echo $ROWmsg2['end_kontrak'];?></td>
		<td align="left"><?php echo $status." * ".$ROWmsg2['umur_kontrak']." hari ";?></td>
		<td align="left"><?php if ($ROWmsg2['status']==0) echo "ON"; else echo "OFF";?></td>
		<td width="">
		<?php if ($ROWmsg2['status']==0) { ?>
		<a href="contract_message.php?OFF=1&id_kontrak=<?php echo $ROWmsg2['id_kontrak'];?>">OF kan </a>
		<?php } else if ($ROWmsg2['status']==1) { ?>
		<a href="contract_message.php?ON=1&id_kontrak=<?php echo $ROWmsg2['id_kontrak'];?>">ON kan </a><?php } ?>
		| <a href="contract_message.php?DELL=1&id_kontrak=<?php echo $ROWmsg2['id_kontrak'];?>">DELLETE</a
		</td>		
		</tr>
		<?php }			
		?>
		</table> 
		
</div>
<!--Footer-->
</body>
</html>