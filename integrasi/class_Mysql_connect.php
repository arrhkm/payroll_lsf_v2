<?php
class Konek_Mysql{
	var $koneksi;
	function Konek_Mysql($server_mysql,$database,$user_myql,$password_mysql)
	{		
		$this->koneksi = mysql_connect ($server_mysql, $user_myql, $password_mysql)
        or die ("Koneksi data base Mysql gagal <br />");		
		mysql_select_db($database, $this->koneksi);
	}
	
	function Exec_Query_Mysql($query)
	{
		$hasil = mysql_query($query);
		if(!$hasil)
		{//die("Query gagal dieksekusi : " . mysql_error() . "<br />");
		$hasil=false;
		}			
		return $hasil;
	}	
	function Jumlah_Baris_Selected($hasil)
	{
		return mysql_num_rows($hasil);
	}	
	function Jumlah_Kolom_Selected($hasil)
	{
		return mysql_num_fields($hasil);
	}		
	function Close_Mysql()
	{
		mysql_close ($this->koneksi);
	}
}
?>
