<?php
require_once('connections/koneksi.php');
//include ("lib_class.php");
# Class Konek DB 
class konek_mysql
{
	var $koneksi;
	
	# function  contruction 
	public function konek_mysql($server_mysql,$database_mysql,$user_mysql,$password_mysql)
	{
		
		$this->koneksi = mysql_connect ($server_mysql, $user_mysql, $password_mysql)
        or die ("Koneksi data base Mysql gagal <br />");		
		 mysql_select_db($database_mysql, $this->koneksi);
	}
	
	function exec_query($query)
	{
		$hasil = mysql_query($query);
		if(!$hasil)
		{die("Query gagal dieksekusi : " . mysql_error() . "<br />");}			
		return $hasil;
	}
	
	function jml_baris($hasil)
	{
		return mysql_num_rows($hasil);
	}
	
	function jml_kolom($hasil)
	{
		return mysql_num_fields($hasil);
	}
		
	function close_mysql()
	{
		mysql_close ($this->koneksi);
	}
}

class konek_ku extends konek_mysql { // function  constructor
    public function __construct_konek_ku() {
        parent::konek_mysql();
        
		$this->koneksi = mysql_connect ($server_mysql, $user_mysql, $password_mysql)
        or die ("Koneksi data base Mysql gagal <br />");		
		 mysql_select_db($database_mysql, $this->koneksi);
    }
	
	
	#Tunjangan Masa Kerja 
	public function get_tmsker($emp_id, $p_start, $p_end) {
		
		$sql_tmsker="	SELECT a.emp_id, SUM(b.t_masakerja) as t_msker  FROM  absensi a, employee b
		WHERE b.emp_id=a.emp_id
		AND a.tgl between DATE_ADD('$p_start',INTERVAL 1 DAY) AND '$p_end'
		AND b.emp_id='$emp_id'
		AND a.jam_in !='Null'
		AND a.jam_out !='Null'";
		
		$rs_tmsker=$this->exec_query($sql_tmsker);
		$row_tmsker=mysql_fetch_assoc($rs_tmsker);
		return $row_tmsker[t_msker];	
	}
	
}
//$hostname_koneksi = "localhost";
//$database_koneksi = "ldp";
//$username_koneksi = "root";
//$password_koneksi = "";
$kon_ku = new konek_ku($hostname_koneksi, $database_koneksi, $username_koneksi, $password_koneksi); 

$tunjangan= $kon_ku->get_tmsker("P180", "2013-12-19", "2013-12-26"); 
echo "<br> Tunjangan masa kerja = ".$tunjangan; 
$kon_ku->close_mysql();
?>