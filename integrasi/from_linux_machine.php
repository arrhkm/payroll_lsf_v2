<?php 
require_once('../connections/conn_mysqli_procedural.php');
require_once 'HkmLib.php';
date_default_timezone_set('UTC');

$machine_qry = "SELECT * FROM machine_att order by ip ";
$rs_machine = mysqli_query($link, $machine_qry);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Manajemen Kartu</title>

<link href="../themes/orange/css/style.css" rel="stylesheet" type="text/css" />  

</head>
<body>
<div class="outerbox">
<?php include ("menu.txt"); ?>
<div id="isinya">
<div class="mainHeading"><h2>DOWNLOAD CHEKINOUT (Linux Machine Hkm Lib) </h2></div>


<form action="from_linux_machine.php" method="POST">
    <!-- input type="Text" name="ip" value="" size=15><BR -->
    <!-- input type="Text" name="key" size="5" value="80"><BR><BR -->
    <br></br>
    <?php 
    $machine = array();
    while ($dt= mysqli_fetch_array($rs_machine)){
        array_push($machine, [
            'id'=>$dt['id'], 
            'ip'=>$dt['ip'], 
            'port'=>$dt['port'],
            'com'=>$dt['com']
        ]);
    }
    $num_row_machine = mysqli_num_rows($rs_machine);
    //var_dump($machine);
    ?>
    <table border='1' class='tabLeftSpace' cellpadding="2" cellspacing="0"width="500px">
        
        <?php
    echo "<tr align ='center'>"
        . "<td colspan='5'>id</td>"
        . "<td colspan='10'>ip</td>"
        . "<td>port</td>"
        . "<td>com</td>"
        . "<td><a href='_form_machine.php?add=1'>Add</a></td></tr>";
    for ($i=0;$i<$num_row_machine;$i++){
        echo "<tr align = 'center'>"
        . "<td colspan='5'>".$machine[$i]['id']."</td>"
        . "<td colspan='10'>".$machine[$i]['ip']."</td>"
        . "<td>".$machine[$i]['port']."</td>"
        . "<td>".$machine[$i]['com']."</td>";
        ?>
        <td>
            <a href="_form_machine.php?id=<?=$machine[$i][id]?>">Edit</a> | 
            <a href="_form_machine.php?delete=TRUE&id=<?=$machine[$i][id]?>">Delete</a>
        </td>
        
        <?php
        echo "</tr>";
    }?>
    <div class='header'>
    <?php echo "<div class=''>JUMLAH MACHINE : ".$num_row_machine."</div><br><br>";
    
    echo "</table>";
    echo "<br><br>";
    
    ?>
    </div>
    <div class='headerRight'>
    Select Machine : 
    <select name="machine">
    <?php 
    for ($i=0;$i<$num_row_machine;$i++){    
    ?>
    <option value="<?=$machine[$i]['id'];?>" selected="selected"><?php echo $machine[$i]['ip'];?></option>
    <?php } ?>
    </select>
    
        <input name="download" type="Submit" value="Download">
    </div>
</form>
<BR>

</body>
</html>
<?php 

if (isset($_POST['download'])&& isset($_POST['machine']))
{
    $rs_machine_set = mysqli_query($link, "SELECT * FROM machine_att WHERE id = '$_POST[machine]'");
    $machine_set = mysqli_fetch_assoc($rs_machine_set);
    //$ip = "192.168.1.209";
    
    //var_dump($machine_set);
    $ip = $machine_set['ip'];//'192.168.4.138';
    $port = $machine_set['port'];//"80";
    $com = $machine_set['com'];//"0";
    $id_machine=$machine_set['id'];    
    
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


