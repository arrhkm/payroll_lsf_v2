<?php

require_once('../connections/conn_mysqli_procedural.php');

require_once ('../include_class/integrasi/IntegrasiClass.php');
date_default_timezone_set('UTC');


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
    if (xmlhttp.readyState == 4) 
        if (xmlhttp.status == 200) 
            document.getElementById(ajaxdestination).innerHTML =xmlhttp.responseText;
}	
</script>

</head>
<body>
<div class="outerbox">
<?php include ("menu.txt"); ?>
		<div id="isinya">
		<div class="mainHeading"><h2>Langkah 1 : Integrasi data log </h2></div>

<?php

?>
<div class="searchbox">
    <form name="form_load" method="post" action="integrasi_linux_log.php">
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
		<select name="machine">
                        <?php
                        $rs_machine= mysqli_query($link, "SELECT * FROM hs_hr_location");
                        
                        while ($dt_machine = mysqli_fetch_assoc($rs_machine)){
                        ?>
			<option value="<?=$dt_machine['loc_code'];?>" selected="selected"><?=$dt_machine['loc_name'];?></option>
                        
                        <?php } ?>
		</select>
	</td>
	</tr>			
	<tr>
	<td>
	<td colspan="3" valign="top" >
            <input name="download" type="Submit" value="Download">
        </td>
	</tr>
	</table>
</form>
<iframe width=174 height=189 name="gToday:normal:calender/agenda.js" id="gToday:normal:calender/agenda.js" src="calender/ipopeng.htm" scrolling="no" frameborder="0" style="visibility:visible; z-index:999; position:absolute; top:-500px; left:-500px;"></iframe>
</div>
<?php
if(isset($_POST["download"])) 
{			
    $query_inout="SELECT a.id, a.timestamp, a.verifikasi, a.status
    FROM hs_hr_emp_absensi as a
    WHERE DATE(timestamp) BETWEEN '$_POST[awal]' AND '$_POST[akhir]'";
    $rs_inout= mysqli_query($link, $query_inout);
    $my_log = array();
    while ($dt_zsoft=mysqli_fetch_assoc($rs_inout)) 
    {
        $userid=$dt_zsoft['id'];			 
        $checktime=$dt_zsoft['timestamp'];
        $verifycode=$dt_zsoft['verifikasi'];
        $status=$dt_zsoft['status'];
        $mesin_id='LSF';
        
        array_push($my_log, ['id'=>$userid, 'timestamp'=>$checktime, 'verifikasi'=>$verifycode, 'status'=>$status]);

    }
		
    $nama_mesin = "LSF";   
    
    echo "data Log :".$_POST['awal']. " - ". $_POST['akhir']."<br>";
    echo "--------------------------------------------------<br>";
    $SQL_jedah="SELECT DATEDIFF('$_POST[akhir]','$_POST[awal]') as jedah";
    $rs_jedah=mysqli_query($link, $SQL_jedah);
    $row_jedah=mysqli_fetch_assoc($rs_jedah);
    $jedah=$row_jedah['jedah'];
    
    // looping on the hs_hr_emp_absensi (group by on date)
    $range_date=array();
    for ($i = 0; $i<= $jedah; $i++) {
        $tgl_ini = strtotime("+$i day" ,strtotime($_POST['awal']));
        $tgl_ini = date('Y-m-d', $tgl_ini);
        array_push($range_date, ['date_now'=>$tgl_ini]);

    }
    //var_dump($range_date);
        
    /*$sqlString = "
        SELECT a.*,b.* 
        FROM employee a, hs_hr_emp_kartu b 
        WHERE b.emp_number_kartu=a.emp_id
        AND a.emp_id ='LSF187'
        ";*/
    $sqlString = "
        SELECT a.*,b.* 
        FROM employee a, hs_hr_emp_kartu b 
        WHERE b.emp_number_kartu=a.emp_id        
        ";
     $resultEmployee = mysqli_query($link, $sqlString);
     //var_dump($my_log);
         
        
        
           	 
   ?> 
            <table width="800"> 
                
    <?php			
    //looping employee have card 
    while ($dt_emp = mysqli_fetch_assoc($resultEmployee))
    { // star loop emp 
    ?>								
        <tr>
    <?php                     
        $emp_no_kartu = $dt_emp['no_kartu'];

        $emp_emp_id = $dt_emp['emp_id'];

        $emp_emp_name = $dt_emp['emp_name']; 

        // select first data on punch-in
        //----------------------------------------------------------------

        //echo "Date : ".$punchDate;
        echo "<br>emp_id : ".$emp_emp_id. "  Nama : ".$emp_emp_name. " No. Card : ".$emp_no_kartu." <br>";
        echo "----------------------------------------------------------------------------------<br>";
        //echo "IN : ".substr($punchStart, -9,18);
        //echo "Out: ".substr($punchEnd,-9,18);				

        //var_dump($range_date);
        
        foreach ($range_date as $dt_date)
        {
                    
            //echo "-----------------------------------------------------------------------------------------<br>";
            $it = New IntegrasiClass($my_log, $emp_no_kartu, $dt_date['date_now']);
            //println($it->date_integration);
            //println($it->card_id);
            $it->getLog();
            if ($it->in!=NULL && $it->out!=NULL){
                if ($it->in===$it->out){
                    $in = date("Y-m-d H:i:s", $it->in);                    
                    $out=NULL;
                    $jam_in = date("H:i:s", $it->in);
                    $jam_out=NULL;
                    //echo "Tanggal : ".$dt_date['date_now']." -  IN : ".$in. " Out : ".$out."<br>";
                    //echo "----------------------------------------------------------------------------------------<br>";
                } else {
                    $in = date("Y-m-d H:i:s", $it->in);
                    $out = date("Y-m-d H:i:s", $it->out);
                    $jam_in = date("H:i:s", $it->in);
                    $jam_out = date("H:i:s", $it->out);
                    //echo "Tanggal : ".$dt_date['date_now']." -  IN : ".$in. " Out : ".$out."<br>";
                }
                echo "Tanggal : ".$dt_date['date_now']." emp id : ".$emp_emp_id." jam in : ".$jam_in." jam out : ".$jam_out."<br><br>";
                //$qry_ins = "INSERT IGNORE absensi (tgl, emp_id, jam_in, jam_out) VALUES ('$dt_date[date_now]', '$emp_emp_id', '$jam_in', '$jam_out')";
                $qry_ins = "REPLACE INTO absensi (tgl, emp_id, jam_in, jam_out) VALUES ('$dt_date[date_now]', '$emp_emp_id', '$jam_in', '$jam_out')";
                mysqli_query($link, $qry_ins);
                //if (mysqli_query($link, $qry_ins)){
                    //echo "masuk pak eko";
                //} else 
                //    echo "gagal";
                        
                
            }
            
        } //end of loop date range
    } // end loop emp ?> 
    </table> <?php

} //end of looping date range
echo "import to hs_hr_emp_absensi done!<br/>";	
echo "import to table absensi done!<br/>";
        
        	
	?>
	<?php
	
?> 
<br/>
</div> <!-- end of wrapper -->
</div> <!-- end of body wrapper -->
</body>
</html>




