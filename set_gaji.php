<?php
# Koneksi and  select DB 
require_once ("/connections/CConnect.php");

$db= New Database();
$db->Connect();
$uang_makan=0;
$gaji_lembur=0;
$t_jabatan=0;
$t_masakerja=0;
$t_insentif=0;
$gaji_pokok=84615.38;
	$SQL_update="UPDATE employee SET uang_makan='$uang_makan', gaji_lembur='$gaji_lembur', t_jabatan='$t_jabatan', t_masakerja='$t_masakerja',
				t_insentif='$t_insentif', gaji_pokok='$gaji_pokok'";
	$db->query($SQL_update);


?>