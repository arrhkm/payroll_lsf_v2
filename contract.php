<?php 
require_once ('cek_login.php');
# Koneksi 
require_once('connections/conn_mysqli_procedural.php');

$qry_emp_baruuuuuuuuuuuu="Select a.emp_id, a.emp_name, b.nama_jabatan, c.id_kontrak, c.no_kontrak, c. start_kontrak, c.end_kontrak, c.lama_kontrak
FROM employee a LEFT JOIN 
jabatan b ON (b.kd_jabatan= a.kd_jabatan) 
LEFT JOIN kontrak_kerja c ON (c.emp_id=a.emp_id)";

$qry_employee = "
Select a.*, b.nama_jabatan FROM employee a LEFT JOIN 
jabatan b ON (b.kd_jabatan= a.kd_jabatan)
 ";
$rs_employee = mysqli_query($link, $qry_employee) or die(mysqli_error($link));

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
		
	    <h2>Kontrak Kerja Employee</h2> 
		
		<!-- Awal tabel -->
		<table class="bordered" id='demotable1'>
		<thead>
		<tr align="center">
		<th filter='true'>EMP ID</th>
		<th filter='true'>Nama</th>
		<th filter='true'>Jabatan</th>		
		
		<th  filter='false' width="50px" colspan ="" align=center></th>		
		</tr>
		</thead>
		<?php while($row_rsemployee = mysqli_fetch_assoc($rs_employee)) { ?>
		<tr align="center">
		<td align="rigt"><?php echo $row_rsemployee['emp_id'];?></td>
		<td align="left"><?php echo $row_rsemployee['emp_name'];?></td>
		<td align="left"><?php echo $row_rsemployee['nama_jabatan'];?></td>
		
		
		<td width="50px">
		<a href="insert_contract.php?&emp_id=<?php echo $row_rsemployee['emp_id'];?>">Add </a> |  
		
		</td>		
		</tr>
		<?php } ?>
		</table>    	
</div>
<!--Footer-->
</body>
</html>