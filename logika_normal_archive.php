<?php
//require_once('includes/fungsi_selisih_jam.php');
require_once('includes/fungsi_selisih_jam.php');
$start= $tgl_ini." 07:00:00";
$end= $tgl_ini." 15:00:00";


$si= date_range($row_absensi[punchin_time], $start);
$so= date_range($end, $row_absensi[punchout_time]);
$sio= date_range($row_absensi[punchin_time], $row_absensi[punchout_time]);

//----------------------------------
//menghitung jam evektif
//JIKA pulang >= jam 13:00
$nsi= explode(":", $si);
$nso= explode(":", $so);
$nsio= explode(":", $sio);  
if ($njam_out>=13)
	$j_ev=h_ev2($nsio[0], $nsi[0], $nso[0]);
else 
	$j_ev=h_ev1($nsio[0], $nsi[0], $nso[0]);

$jam_ev=$j_ev;
//-------------end------------------
//Menghitung jam lembur
$nj_l= explode (":", $so);
$jam_lembur=$nj_l[0];
//-------------end------------------
//Menghitung uang makan 
if ($jam_ev>=5) {
	$UM=$row_emp['uang_makan'];
} else {
	$UM=0;
}
//------------end-------------------
//Menghitung jam telat
$stlt= date_range($start, $row_absensi[punchin_time]);
$tlt=explode(":", $stlt);
$tlt1=$tlt[0];
$tlt2=$tlt[1];
//Potongan telat			
if (($tlt1 >=0) and ($tlt2>5)) {
$potongan_telat=$row_emp['pot_telat'];
}else { 
$potongan_telat=0;}

//------------end potongan telat------------------

?>