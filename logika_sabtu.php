<?php
//Jam evektif = 5 jam, jam 07:00 until jam 12:00
require_once('includes/fungsi_selisih_jam.php');

/*if ($emp_id=="P202")
{
$jam_start=8;
$jam_end=14;
$start="08:00:00";
$end="14:00:00";
}else
*/
$jam_start=7;
$jam_end=12;//Batas jam hari sabtu
$start="07:00:00";
$end="12:00:00";


$n_in=$row_time[Hin];
if ($row_time[Hout] <5){
$n_out=$row_time[Hout] + 24;
}else {
$n_out=$row_time[Hout];
}

$si= $jam_start-$row_time[Hin]; //Jam in - jam 7 ( batas masuk kerja)
$so=$n_out-$jam_end;	// jam Out - jam 12 ( batas jam evektif ) 
$sio=$n_out-$n_in;

//----------------------------------
//menghitung jam evektif
$j_ev=h_ev1($sio, $si, $so);
$jam_ev=$j_ev;
//-------------end------------------

//Menghitung jam lembur
$jam_lembur=0; # Set jamlembur menjadi 0 dulu
if ($so>0) 
{
	if ($row_time[Hout]>=13)
	{	
		$jam_lembur=$so-1; 
	}
	else 
	{
		$jam_lembur=0;
	}
}
else {
	$jam_lembur=0;
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


//Menghitung uang makan 
if ($jam_ev>=5) {
	$UM=0;//$UM=$row_emp['uang_makan'];
} else {
	$UM=0;
}
//------------end-------------------
/*----------------------------------------------
|               Menghitung jam telat            |
|-----------------------------------------------|*/

//------------------------ Potongan telat	
$stlt= date_range( $start, $row_time[Tin]);
$tlt=explode(":", $stlt);
$tlt1=(int)$tlt[0];
$tlt2=(int)($tlt[1]);
		
if ($tlt1<1) 
{
	if($tlt2>5)
	{
		$potongan_telat=2*round($row_emp['gaji_pokok']/7);
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
//------------end potongan telat------------------

?>