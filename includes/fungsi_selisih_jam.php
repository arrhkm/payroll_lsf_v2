<?php
$jam_1=strtotime("01:00:00");
function date_range($date1, $date2)
{
	//$dates_range[]=$date1;
    $date1=strtotime($date1);
    $date2=strtotime($date2);
	if ($date2>$date1)
	{	   
	   $hasil=($date2-$date1)-3600;
       $date_range=date("H:i:s", $hasil);
	}
	return $date_range; 
}

function h_ev1($sio, $si, $so)
{
	if ($so <0){ $so=0;}
	$h_ev1=$sio-($si+$so);	
	return $h_ev1;
}
function h_ev2($sio, $si, $so)
{
	if ($so <0){ $so=0;}
	$h_ev2=$sio-($si+$so+1);
	return $h_ev2;
}

function fx_jam ($jam1, $jam2)
{
	if ($jam2>$jam1){
	$jam1=explode(":", $jam1);
	$jam2=explode(":", $jam2);
	$fx_jam=$jam2[0]-$jam1[0];
	}
	return $fx_jam;
}
function fx_telat_menit ($jam1, $jam2)
{
	if ($jam2>$jam1){
	$jam1=explode(":", $jam1);
	$jam2=explode(":", $jam2);
	$fx_telat_menit=$jam2[0]-$jam1[0];
	}
	return $fx_telat_menit;
}
?>