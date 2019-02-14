<?php

function fx_hari($nm_hari){
if ($nm_hari=="Thursday"){ 
	$hari="Kamis";}
if ($nm_hari=="Friday"){
    $hari="Jumat";}
if ($nm_hari == "Saturday"){
    $hari="Sabtu";}        
if ($nm_hari == "Sunday"){
    $hari="Minggu";}         
if ($nm_hari== "Monday"){
    $hari="Senin";}    
if ($nm_hari =="Tuesday"){
    $hari="Selasa";}        
if ($nm_hari == "Wednesday"){
    $hari="Rabu";} 		
	return $hari;
}
?>
