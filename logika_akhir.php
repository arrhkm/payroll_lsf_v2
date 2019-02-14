<?php
require_once('includes/fungsi_selisih_jam.php');
if ($emp_id=="P202")
{
$jam_start=8;
$jam_end=16;
$start="08:00:00";
$end="16:00:00";
}
else if ($tgl_ini == "2013-11-21" OR $tgl_ini == "2013-11-22" OR $tgl_ini=="2013-11-23" OR $tgl_ini=="2013-11-24") {
$jam_start=7;
$jam_end=15;
$start="07:00:00";
$end="15:00:00";
}
else {
	if ($emp_id=="P077" OR $emp_id== "P210" OR $emp_id=="P174" OR $emp_id=="P132" OR $emp_id=="P073" OR $emp_id=="P166") 
	{ 
		$jam_start=7;
		$jam_end=15;
		$start="07:00:00";
		$end="15:00:00";
	}
	else 
	{
		$jam_start=8;
		$jam_end=16;
		$start="08:00:00";
		$end="16:00:00";
	}
}

$n_in=$row_time[Hin];
if ($row_time[Hout] <5){
$n_out=$row_time[Hout] + 24;
}else {
$n_out=$row_time[Hout];
}

$si=$jam_start-$n_in; //Jam in - jam 7 ( batas masuk kerja)	
$so=$n_out-$jam_end;	// jam Out - jam 15 ( batas jam evektif ) 
$sio=$n_out-$n_in;
//----------------------------------
//menghitung jam evektif
//JIKA pulang >= jam 13:00

if ($row_time[Hout]>=13)
	$j_ev=h_ev2($sio, $si, $so);
else 
	$j_ev=h_ev1($sio, $si, $so);
$jam_ev=$j_ev;

//-------------end------------------

//Menghitung jam lembur
$jam_lembur=0;
$GL=0;//jumlah gaji lembur
//-------------end------------------


//Menghitung uang makan 
if ($jam_ev>=5) {
	$UM=0;//$UM=$row_emp['uang_makan'];
} else {
	$UM=0;
}
//------------end-------------------
//----------------------------------------------------|
//                  Menghitung jam telat              |
//----------------------------------------------------|
$telat="kosong";

$stlt= date_range( $start, $row_time[Tin]);
$tlt=explode(":", $stlt);
$tlt1=(int)$tlt[0];
$tlt2=(int)($tlt[1]);

//Potongan telat			
if ($tlt1<1) 
{
	if($tlt2>5)
	{
		$potongan_telat=2*($row_emp['gaji_pokok']/7);
		$telat="telat";
	}
	else
	{
		$potongan_telat=0;
		$telat="tidak";
	}
}
else 
{ 
	$potongan_telat=2*($row_emp['gaji_pokok']/7);
	$telat="telat";	
}		

?>