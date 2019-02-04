<?php
//Database Utama
 $hostname_koneksi = "localhost";
 $database_koneksi = "ldp";
 $username_koneksi = "hkm";
 $password_koneksi = "hkm";
 //-----------------------------------
 
 //SETING DB Zsoft
 $zsoft_hostname = "localhost";
 $zsoft_database = "zsofttadb";
 $zsoft_username = "root";
 $zsoft_password = "";
 
 //-----------------------------------
 // SETTING ODBC for DB ACCESS
 $name_odbc="system_access";
 //$name_odbc="system_nila";
 $username_odbc="";
 $password_odbc="";
 
 
 //------------------------------------
 // SETTING PDO_ODBC
 //$dbName = 'D:\Att2008\att2000.mdb';
 $dbName = "//192.168.100.26/Att2008/att2000.mdb";
 $string_conn = "odbc:DRIVER={Microsoft Access Driver (*.mdb)}; DBQ=$dbName; Uid=; Pwd=;";
  
 //-----------------------------------
 // SETTING ABSENSI 
 $nama_mesin="LDP";
 $nama_lokasi="LDP";
 
 //global $hostname_koneksi,$database_koneksi, $username_koneksi, $pasword_koneksi;
$koneksi = mysql_pconnect($hostname_koneksi, $username_koneksi, $password_koneksi) or trigger_error(mysql_error(),E_USER_ERROR); 
//$mysqli = new mysqli($hostname_koneksi, $username_koneksi, $password_koneksi, $database_koneksi);

?>