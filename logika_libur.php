<?php
require_once('includes/fungsi_selisih_jam.php');


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

$n_in=$row_time[Hin];
if ($row_time[Hout] <5){
$n_out=$row_time[Hout] + 24;
}else {
$n_out=$row_time[Hout];
}

$si=$jam_start-$n_in; //Jam in - jam 7 ( batas masuk kerja)	
$sio=$n_out-$n_in;

//----------------------------------
//menghitung jam Lembur
//JIKA pulang tidak terbatas
$jam_ev=0;
$GL=0;
if ($row_time[Hout]>=13)
	$jam_lembur=$sio-($si+1);
else 
	$jam_lembur=$sio-$si;
	
$GL=$jam_lembur*($row_emp[gaji_pokok]/7)*2;//jumlah gaji lembur

//------------------------------------
//Menghitung uang makan 
if (($jam_lembur>=4) OR ($row_emp[luar_pulau]==1)) {
	$UM=0;//$UM=$row_emp['uang_makan'];
} else {
	$UM=0;
}
//------------end-------------------
/*----------------------------------------------
|               Menghitung jam telat            |
|-----------------------------------------------|*/
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
//-----------------------------------------------------------
?>