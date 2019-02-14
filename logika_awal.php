<?php
//LOGIKA GANTUNGAN
require_once('includes/fungsi_selisih_jam.php');
if ($tgl_ini < "2013-11-24") {
$jam_start=7;
$jam_end=15;
$start="07:00:00";
$end="15:00:00";
}
else 
{
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
//Menghitung Jam Lembur
if ($so>0)
{	
	$jam_lembur=$so;
	$jam_ev=0;
	//uang makan
	$UM=0;	
}
else {
	$jam_ev=0;
	$jam_lembur=0;
	$UM=0;
} 

//----------GAJI LEMBUR---------------
$part1=0; $part2=0;
if($jam_lembur>=2) {
	
	$part1=1.5*(1)*($row_emp[gaji_pokok]/7);
	$part2=2*($jam_lembur-1)*($row_emp[gaji_pokok]/7);
	$GL=$part1+$part2;	
		
} else {
	$GL=1.5*$jam_lembur*($row_emp[gaji_pokok]/7);
}
//-------------end------------------

//$GL=round($jam_lembur*$row_emp[gaji_pokok]);//jumlah gaji lembur
//--------------------------end-------------------------
?>