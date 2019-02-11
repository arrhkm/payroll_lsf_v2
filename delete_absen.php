<?php 
# Koneksi 

require_once('connections/conn_mysqli_procedural.php');
?>
<html>
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

<script type="text/javascript">

ddsmoothmenu.init({
	mainmenuid: "templatemo_menu", //menu DIV id
	orientation: 'h', //Horizontal or vertical menu: Set to "h" or "v"
	classname: 'ddsmoothmenu', //class added to menu's outer DIV
	customtheme: ["#", "#"],
	contentsource: "markup" //"markup" or ["container_id", "path_to_menu_file"]
})

</script>

<link rel="stylesheet" href="css/slimbox2.css" type="text/css" media="screen" /> 
<script type="text/JavaScript" src="js/slimbox2.js"></script> 
</head>
<body>
<!-- Header Menu -->
<?php require_once('header.inc'); ?>

<div id="templatemo_main" class="wrapper">	
<!-- Tempat Menaruh Tabel ISI -->
<h2>Delete absen Employee</h2>
<!-- Awal tabel -->
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
          <td></td>

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
<div class="clear"></div>
</div>
<!--Footer-->
</body>
</html>
<?php 
    if (isset($_POST['btn_del'])) 
    {
        echo "Data : <br>";
        $dt_emp=explode(",", $_POST[emp_id]);
        
        var_dump($_POST);
        /*
        foreach ($dt_emp as $emp) 
        {
            
             $SQLdel="DELETE from absensi WHERE emp_id='$emp' "
             
                    . "AND tgl BETWEEN '$_POST[tgl]' AND '$_POST[tgl2]'";
            $SQL_emp="
            SELECT a.emp_id, a.emp_name, b. tgl, b.jam_in, b.jam_out from employee a, absensi b 
            WHERE b.emp_id=a.emp_id 
            AND b.tgl='$_POST[tgl]'
            AND a.emp_id='$emp'										
            ";
            $RS_emp=mysqli_query($link, $SQL_emp);
            
            $ROW_emp= mysqli_fetch_assoc($RS_emp);
            if (mysqli_num_rows($RS_emp)>0)
            {
                    mysqli_query($SQLdel);					
                    echo "<br> Employee :  ".$ROW_emp['emp_id']."  -  ".$ROW_emp['emp_name']." - tanggal : ".$_POST['tgl']."  berhasil dihapus";
            }
            else  
            {
                    echo "record absensi emp_id : ".$emp[] tidak ditemukan";
            }
              
             
        }*/
    }else {
        echo "GATEL";
    }
?>