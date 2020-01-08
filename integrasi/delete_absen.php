<?php 
# Koneksi 

require_once('../connections/conn_mysqli_procedural.php');

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>PT. Lintech</title>

<link href="../themes/orange/css/style.css" rel="stylesheet" type="text/css" />
<script src="../includes/jquery-1.3.2.min.js" type="text/javascript"></script>    	
<script type="text/javascript" src="../includes/scripts-pack.js"></script>   
</head>
<body>
<div class="outerbox">
<?php include ("menu.txt"); ?>

<!-- Header Menu -->
<?php //require_once('header.inc'); ?>
<?php 
    $sql_emp1 = "SELECT distinct(b.emp_id)as id FROM  absensi as b JOIN employee as c ON (b.emp_id = c.emp_id)";
    $record_emp = mysqli_query($link, $sql_emp1);
    $employee = array();
    while ($x = mysqli_fetch_assoc($record_emp)){
        array_push($employee, $x['id']);
    }
    //var_dump($employee);
    
    if (!empty($_POST) && $_POST['btn_del']==TRUE)
    {
        if (!empty($_POST['emp_id'])){
            if (!empty($_POST['tgl']))
            {
                //echo "Data ada isi nya : <br>";
                $dt_emp = array();
                $dt_emp=explode(",", $_POST['emp_id']); 
                         
                for($i = 0; $i<count($dt_emp);$i++){
                   
                    $SQLdel="DELETE from absensi WHERE emp_id='$dt_emp[$i]' AND tgl BETWEEN '$_POST[tgl]' AND '$_POST[tgl2]'";
                    mysqli_query($link, $sql_del);
                }
                $message = "Ada ".count($dt_emp)." data dihapus.";
            }else {
                $message = "Tanggal 1 dan Tanggal 2 belum di isi";
            }    
        } else {
            $message = "emp id Belum di isi";
        }
    }else {
        echo $message = "kosong";
    }
    if (isset($_POST['tgl'])){
        echo "tgl1 : ".$_POST['tgl']."<br>";
    }
    if (isset($_POST['tgl2'])){
        echo "Tgl2 :".$_POST['tgl2'];
    }
?>

<div class="mainHeading"><h2>Delete absen Employee</h2></div>

<form name="form1" method="POST" action="delete_absen.php">
    <table class="" width="700" border="0" align="center">			
        <tr>
          <td>emp_id</td>
          <td>&nbsp;</td>
          <td>
                <textarea  name="emp_id" cols=65 rows=1></textarea> <br>masukkan emp_id examp: P001, P002, P003, etc...			  
          </td>						  
        </tr>
        <tr>

        <tr>			
        <tr>
          <td>Tanggal</td>
          <td>&nbsp;</td>
          <td>
          <input name="tgl" type="text" size="10" maxlength="10" id="tgl" value="<?php if (isset($_REQUEST['edit']) && $_REQUEST['edit']==1){ echo $ROWedit['start_kontrak'];}?>"
          onClick="if(self.gfPop)gfPop.fPopCalendar(document.form1.tgl);return false;"/>
          <a href="javascript:void(0)" onClick="if(self.gfPop)gfPop.fPopCalendar(document.form1.tgl);return false;">
          <img name="popcal" align="absmiddle" style="border:none" src="calender/calender.jpeg" width="34" height="29" border="0"alt="">
          </a>	

                <input name="tgl2" type="text" size="10" maxlength="10" id="tgl2" value=""
          onClick="if(self.gfPop)gfPop.fPopCalendar(document.form1.tgl2);return false;"/>
          <a href="javascript:void(0)" onClick="if(self.gfPop)gfPop.fPopCalendar(document.form1.tgl2);return false;">
          <img name="popcal" align="absmiddle" style="border:none" src="calender/calender.jpeg" width="34" height="29" border="0"alt="">
          </a>		
          </td>						  
        </tr>

        <tr>			  
          <td colspan=2 align="center">
              <input type="submit" name="btn_del" >
          <input name = "btn_back" type="button" value= "Back"  id="btn_back" Onclick="location='delete_absen.php'">
          </td>
          <td>
               
              <?php 
                echo "Message : ".$message;  
               
               
              
               
              
              ?>
          </td>

        </tr>
        <tr>
                <td colspan="3"><font color="red">
                </font>
                </td>
        </tr>
        </table>
</form>
<iframe width=174 height=189 name="gToday:normal:calender/agenda.js" id="gToday:normal:calender/agenda.js" src="calender/ipopeng.htm" scrolling="no" frameborder="0" style="visibility:visible; z-index:999; position:absolute; top:-500px; left:-500px;"></iframe>
			
<!-- Tabel isi selesai -->      	

</div>
<!--Footer-->
</body>
</html>
