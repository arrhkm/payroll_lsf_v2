<?php 
require_once('../connections/conn_mysqli_procedural.php');
require_once 'HkmLib.php';
date_default_timezone_set('UTC');

$machine_qry = "SELECT * FROM machine_att ";
$rs_machine = mysqli_query($link, $machine_qry);
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
<div class="mainHeading"><h2>DOWNLOAD CHEKINOUT (Linux Machine Zsoft) </h2></div>


<form action="from_linux_machine.php" method="POST">
    IP Address: <input type="Text" name="ip" value="" size=15><BR>
    Comm Key: <input type="Text" name="key" size="5" value="80"><BR><BR>
    Machine : 
    <select name="machine">
    <?php 
    while ($dt_machine = mysqli_fetch_assoc($rs_machine)) {
    
    ?>
    <option value="<?=$dt_machine['id'];?>" selected="selected"><?php echo $dt_machine['ip'];?></option>
    <?php } ?>
    </select>
    <input name="download" type="Submit" value="Download">
</form>
<BR>

</body>
</html>
<?php 
/*
function Parse_Data($data,$p1,$p2) 
{
    $data=" ".$data;
    $hasil="";
    $awal=strpos($data,$p1);
    if($awal!=""){
        $akhir=strpos(strstr($data,$p1),$p2);
        if($akhir!=""){
                $hasil=substr($data,$awal+strlen($p1),$akhir-strlen($p1));
        }
    }
    return $hasil;	
}*/

if (isset($_POST['download'])&& isset($_POST['machine']))
{
    $rs_machine_set = mysqli_query($link, "SELECT * FROM machine_att WHERE id = '$_POST[machine]'");
    $machine_set = mysqli_fetch_assoc($rs_machine_set);
//$ip = "192.168.1.209";
    
    var_dump($machine_set);
    $ip = $machine_set['ip'];//'192.168.4.138';
    $port = $machine_set['port'];//"80";
    $com = $machine_set['com'];//"0";
    $id_machine=$machine_set['id'];
    
    //$db = New DbAutoIncrement();
    //$db->setDb($link, 'hs_hr_emp_absensi', $id_machine);
    //$last_id = $db->getlastId('id');
    //$max_time  = $db->maxValue('timestamp');
    $max_time_sql = "SELECT MAX(timestamp)as maxtime FROM hs_hr_emp_absensi WHERE id_machine = '$id_machine'";
    $rs_max_time = mysqli_query($link, $max_time_sql);
    $dt_max_time = mysqli_fetch_assoc($rs_max_time);
    $max_time = $dt_max_time['maxtime'];
    
    echo "Max time = ".$max_time."<br>";
    
    $log = New HkmLib();
    $dt_log = $log->download($ip, $port, $com);
    
    $id = 0;
    //$id = $las_id;
    foreach ($dt_log as $value){      
        foreach ($value as $data){            
            if (strtotime($data['DateTime']) > strtotime($max_time)){
                echo $data['PIN']." - ".$id_machine." - ".$data['DateTime']." Lebih besar dari ".$max_time."<br>";
                //echo $data['PIN']." # ".$data['DateTime']." # ".$data['Status']." # ".$data['Verified']."<br>";
                
                $sql_insert = "INSERT INTO hs_hr_emp_absensi(id, timestamp, verifikasi, status, id_machine) VALUE (?,?,?,?,?)";
                $stmt = mysqli_prepare($link, $sql_insert);
                mysqli_stmt_bind_param($stmt,"isiii" ,$data['PIN'], $data['DateTime'], $data['Verified'], $data['Status'], $id_machine);
                mysqli_stmt_execute($stmt);
                
           
                //$id++;
            }            
        }
    }
    //var_dump($dt_log);
    mysqli_close($link);
    
    
  
}
?>


