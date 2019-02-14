<?php 
require_once('connections/conn_mysqli_procedural.php');

$sql_archive="SELECT * FROM pos_archive WHERE kd_periode='$_REQUEST[kd_periode]' AND kd_project='$_REQUEST[kd_project]'";
$rs_archive=mysqli_query($link, $sql_archive) or die(mysqli_error($link));
$row_archive=mysqli_fetch_assoc($rs_archive);

$sql_pos_payroll = "SELECT * FROM pos_payroll WHERE kd_periode='$_REQUEST[kd_periode]' AND kd_project='$_REQUEST[kd_project]'";
$rs_pos_payroll = mysqli_query($link, $sql_pos_payroll) or die(mysqli_error($link));

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
<script type="text/javascript" src="js/ddsmoothmenu.js"></script>

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
<link rel="stylesheet" href="css/hkm_table.css" type="text/css" media="screen" /> 
<script type="text/JavaScript" src="js/slimbox2.js"></script> 

</head>
<body>
<?php 

?>
<!-- Header Menu -->
<?php require_once('header.inc'); ?>

<div id="templatemo_main" class="wrapper">
    <h2>Periode Pos </h2> 
    <table>
    <tr>
        <td>
                <a href="pospayroll_pdf.php?kd_periode=<?php echo $row_archive['kd_periode'];?>&kd_project=<?php echo $row_archive['kd_project'];?>"> Payroll PDF Click Here >> </a>
        </td>
        <td>
                <a href="summary_pos.php?kd_periode=<?php echo $row_archive['kd_periode'];?>&kd_project=<?php echo $row_archive['kd_project'];?>">| Sumary Pos >> </a>
        </td>
        <td>
                <a href="possummary_pdf.php?kd_periode=<?php echo $row_archive['kd_periode'];?>&kd_project=<?php echo $row_archive['kd_project'];?>"> | POS Summary PDF >> </a>
        </td>
        <td>
            <a href="export_excel_index.php?kd_periode=<?=$row_archive['kd_periode']?>&kd_project=<?=$row_archive['kd_project']?>"> 
                Export to Excel </a>
        </td>
    </tr>
    </table>
		
		<!-- Awal tabel -->
		<?php 
		$gaji_all=0;
while ($row_posPayroll=mysqli_fetch_assoc($rs_pos_payroll)) {
?>		
<table class="bordered" width="100%">		
<tr>
    <td colspan="2">
        <?php echo "Nama : ".$row_posPayroll[emp_name]."<br> Jabatan :".$row_posPayroll[jabatan];?>
    </td>
    <td colspan="9" align="center">
        <?php echo "SLIP GAJI MANPOWER ".$row_posPayroll[project];?>
    </td>
    <td colspan="2">
        &nbsp;&nbsp;<?php echo "$row_archive[tgl_awal] s/d $row_archive[tgl_akhir] <br>";?>
        &nbsp;&nbsp;NIP :<?php echo $row_posPayroll[emp_id];?>
    </td>
</tr>
<tr>
    <th>Hari</th>
    <th>Tanggal</th>
    <th>Jam</th>
    <th>GP/Jam</th>
    <th>Jam EV</th>
    <th>Jam Lbr</th>
    <th>Gaji Pokok</th>
    <th>Gaji Lembur</th>
    <th>P.Telat</th>
    <th>P. Safety</th>
    <th>P. jam12</th>
    <th>T. Msker </th>
    <th>Subtotal</th>
</tr>	
    <?php 
    //Definisi awal 
    $wt=0;
    $pt=0;
    $sum_gp=0;
    $sum_gl=0;
    $sum_psafety=0;
    $sum_tjam12=0;
    $sum_tmsker=0;
    $sum_potTel=0;
    $sum_tg=0;
    //-------------------------------------------
    $sql_pos_detil= "SELECT * FROM pos_payroll_day WHERE kd_periode='$_REQUEST[kd_periode]' AND kd_project= '$_REQUEST[kd_project]'
                                    AND emp_id='$row_posPayroll[emp_id]'";
    $rs_pos_detil= mysqli_query($link, $sql_pos_detil) or die(mysqli_error($link));
    while ($row_posDetil=mysqli_fetch_assoc($rs_pos_detil)) { 		
?>
<tr bgcolor=<?php if ($row_posDetil[tgl_merah]=="libur") echo "red"; ?>>
    <td><?php echo $row_posDetil[hari];?></td><!-- hari -->
    <td><?php echo $row_posDetil[tgl];?></td><!-- tanggal -->
    <td><?php echo $row_posDetil[jam_in]."/".$row_posDetil[jam_out];?></td><!-- Jam -->
    <td> <?php echo $row_posDetil[g_perjam];?> </td><!-- jam ev -->
    <td> <?php echo ceil($row_posDetil[jam_ev]);?> </td><!-- GP/ jam -->
    <td> <?php echo $row_posDetil[ot];?> </td><!-- jam ot -->
    <td> <?php echo "Rp ".number_format($row_posDetil[gp],2,',','.');?></td><!-- gp -->
    <td> <?php echo "Rp ".number_format($row_posDetil[gl],2,',','.');?> </td><!-- gl -->
    <td> <?php echo "Rp ".number_format($row_posDetil[pot_tel],2,',','.');?> </td><!-- Ptelat -->
    <td> <?php echo "Rp ".number_format($row_posDetil[p_safety],2,',','.');?> </td><!-- p safety -->
    <td> <?php echo "Rp ".number_format($row_posDetil[t_jam12],2,',','.');?> </td><!-- t. msker  -->
    <td> <?php echo "Rp ".number_format($row_posDetil[t_msker],2,',','.');?> </td><!-- t. msker  -->
    <td> <?php echo "Rp ".number_format($row_posDetil[tg],2,',','.');?> </td><!-- Sub Gaji  -->			
</tr>	
		<?php 
    $wt=$row_posDetil[jam_ev]+$wt;
    $pt=$pt+$row_posDetil[jam_ev]+$row_posDetil[ot];
    $sum_gp=$sum_gp+$row_posDetil[gp];
    $sum_gl=$sum_gl+$row_posDetil[gl];

    $sum_potTel=$sumPotTel+$row_posDetil[pot_tel];
    $sum_psafety=$sum_psafety+$row_posDetil[p_safety];
    $sum_tjam12=$sum_tjam12+$row_posDetil[t_jam12];
    $sum_tmsker=$sum_tmsker+$row_posDetil[t_msker];
    $sum_tg=$sum_tg+$row_posDetil[tg];
		} ?>
<tr bgcolor="Yellow">
    <td> </td><!-- hari -->
    <td> </td><!-- tanggal -->
    <td> </td><!-- Jam -->
    <td> WT/PT </td><!-- jam ev -->
    <td> <?php echo $wt;?> </td><!-- GP/ jam -->
    <td> <?php echo $pt;?> </td><!-- jam ot -->
    <td> <?php echo "Rp ".number_format($sum_gp,2,',','.');?></td><!-- gp -->
    <td> <?php echo "Rp ".number_format($sum_gl,2,',','.');?> </td><!-- gl -->			
    <td> <?php echo "Rp ".number_format($sum_potTel,2,',','.');?> </td><!-- pot_tel -->
    <td> <?php echo "Rp ".number_format($sum_psafety,2,',','.');?> </td><!-- p safety -->
    <td> <?php echo "Rp ".number_format($sum_tjam12,2,',','.');?> </td><!-- t msker -->
    <td> <?php echo "Rp ".number_format($sum_tmsker,2,',','.');?> </td><!-- t msker -->
    <td> <?php echo "Rp ".number_format($sum_tg,2,',','.');?> </td><!-- Sub Gaji  -->				
</tr>
<tr bgcolor="">			
            <td colspan="3">  </td>
            <td colspan="7"> Kasbon : <?php echo "Rp ".number_format($row_posPayroll[kasbon],2,',','.');?> </td>
            <td colspan="2"> Cicil kasbon</td><!-- Sub Gaji  -->
            <td><?php echo "Rp ".number_format($row_posPayroll[cicil_kasbon],2,',','.');?> </td>
</tr>
<tr bgcolor="">			
    <td colspan="3">  </td><!-- pot_tel -->
    <td colspan="7"> Sisa Kasbon : <?php echo "Rp ".number_format($row_posPayroll[sisa_kasbon],2,',','.');?> </td>
    <td colspan="2"> Jamsostek</td><!-- Sub Gaji  -->
    <td><?php echo "Rp ".number_format($row_posPayroll[jamsos],2,',','.');?> </td>
</tr>		
<tr bgcolor="">				
    <td colspan="10"></td>
    <td colspan="2"> Kelebihan Gaji</td><!-- Sub Gaji  -->
    <td><?php echo "Rp ".number_format($row_posPayroll[over_gaji],2,',','.');?> </td>
</tr>
<tr bgcolor="">				
    <td colspan="10"></td>
    <td colspan="2"> Kekurangan Gaji</td><!-- Sub Gaji  -->
    <td><?php echo "Rp ".number_format($row_posPayroll[def_gaji],2,',','.');?> </td>
</tr>	

<tr bgcolor="">				
    <td colspan="10"></td>
    <td colspan="2"> Total Gaji</td><!-- Sub Gaji  -->
    <td><?php echo "Rp ".number_format($row_posPayroll[tg_all],2,',','.');?> </td>
</tr -->
</table><br><br>
<?php  
			$gaji_all=$gaji_all+$row_posPayroll[tg_all];
		} 
		echo "Gaji all = Rp ".number_format($gaji_all,2,',','.');
		?>		
<div class="clear"></div>

<!--Footer-->

</body>
</html>