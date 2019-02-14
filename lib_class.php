<?php

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
//*******************************************************************************
class gajiku extends konek_mysql{#kelas gaji parameter periode
#Properties Class
  
	public function __constract_gajiku()
	{
		#Constructor	
		parent::konek_mysql();        
		//$this->koneksi = mysql_connect ($server_mysql, $user_mysql, $password_mysql)
        //or die ("Koneksi data base Mysql gagal <br />");		
		 mysql_select_db($database_mysql, $this->koneksi);
		
	}			
	
	#kabon
	public function kasbon($emp_id) 
	{
		//mysql_select_db($this->db, $this->koneksi);	
		$sql_saldo="SELECT  a.status, a.jml_kasbon
		FROM kasbon a, employee b, cicilan_kasbon c
		WHERE a.emp_id=b.emp_id
		AND b.emp_id='$emp_id'
		AND c.kd_kasbon=a.kd_kasbon
		AND a.status=1
		";
		$rs_saldo=$this->exec_query($sql_saldo);
		$row_saldo=mysql_fetch_assoc($rs_saldo);	
		return $kasbon=$row_saldo[jml_kasbon];
	}
	#sisa kasbon
	public function sisa_kasbon($emp_id) 
	{
		//mysql_select_db($this->db, $this->koneksi);	
		$sql_saldo="SELECT  a.status, a.jml_kasbon, b.emp_id, a.jml_kasbon-(sum(c.jml_cicilan)) as saldo
		FROM kasbon a, employee b, cicilan_kasbon c
		WHERE a.emp_id=b.emp_id
		AND b.emp_id='$emp_id'
		AND c.kd_kasbon=a.kd_kasbon
		AND a.status=1
		";
		//$rs_saldo=mysql_query($sql_saldo, $this->koneksi) or die(mysql_error());
		$rs_saldo= $this->exec_query($sql_saldo);
		$row_saldo=mysql_fetch_assoc($rs_saldo);	
		return $sisa_kasbon=$row_saldo[saldo];
	}
	#Cicilan
	public function cicilan($kd_periode, $emp_id) 
	{
		//mysql_select_db($this->db, $this->koneksi);	
		$sql_kasbon="SELECT a.kd_cicilan, a. kd_kasbon, a.kd_periode, sum(a.jml_cicilan) as jml_cicilan, c.emp_id 
		from cicilan_kasbon a, kasbon b, employee c
		WHERE b.kd_kasbon=a.kd_kasbon
		AND b.emp_id=c.emp_id
		AND a.kd_periode =$kd_periode
		AND c.emp_id='$emp_id'";
		//$rs_kasbon=mysql_query($sql_kasbon, $this->koneksi) or die(mysql_error());
		$rs_kasbon= $this->exec_query($sql_kasbon);
		$row_kasbon=mysql_fetch_assoc($rs_kasbon);
		return $cicilan=$row_kasbon[jml_cicilan];
	}
	#Potongan Jamsostek
	public function jamsostek($kd_periode, $emp_id) 
	{
		//mysql_select_db($this->db, $this->koneksi);	
		$sql_jmstk="SELECT * FROM jamsostek 
		WHERE kd_periode='$kd_periode' AND emp_id='$emp_id'";
		//$rs_jmstk=mysql_query($sql_jmstk,$this->koneksi) or die(mysql_error());
		$rs_jmstk = $this->exec_query($sql_jmstk);
		$row_jmstk=mysql_fetch_assoc($rs_jmstk);				
		return $jamsostek = $row_jmstk['pot_jamsostek'];		
	}
	
	#Potongan safety talk dalam 1 periode tertentu ...
	public function potsafety ($emp_id, $p_start, $p_end){
		//mysql_select_db($this->db, $this->koneksi);
		$sql_safety="SELECT SUM(jml_safety) as jml_safety FROM safety_talk
		WHERE emp_id='$emp_id' AND 
		tgl_safety between '$p_start' AND '$p_end'";
		//$rs_safety=mysql_query($sql_safety,$this->koneksi) or die(mysql_error());
		$rs_safety=$this->exec_query($sql_safety);
		$row_safety=mysql_fetch_assoc($rs_safety);				
		return $potsafety = $row_safety['jml_safety'];	
	
	}	
	
	#Kelebihan Gaji
	public function get_min($kd_periode, $emp_id) 
	{
		//mysql_select_db($this->db, $this->koneksi);	
		$sql_plusmin="SELECT SUM(jml_plus) as jml_plus, sum(jml_min) as jml_min 
		FROM plusmin_gaji 
		where kd_periode=$kd_periode AND emp_id='$emp_id'";
		//$rs_plusmin=mysql_query($sql_plusmin,$this->koneksi) or die (mysql_error());
		$rs_plusmin=$this->exec_query($sql_plusmin);
		$row_plusmin=mysql_fetch_assoc($rs_plusmin);
		$jml_min=$row_plusmin['jml_min'];	
		return $jml_min;
	}
	
	#Kekurangan Gaji
	public function get_plus($kd_periode, $emp_id) 
	{
		//mysql_select_db($this->db, $this->koneksi);	
		$sql_plusmin="SELECT SUM(jml_plus) as jml_plus, sum(jml_min) as jml_min 
		FROM plusmin_gaji 
		where kd_periode=$kd_periode AND emp_id='$emp_id'";
		//$rs_plusmin=mysql_query($sql_plusmin,$this->koneksi) or die (mysql_error());
		$rs_plusmin=$this->exec_query($sql_plusmin);
		$row_plusmin=mysql_fetch_assoc($rs_plusmin);
		$jml_plus=$row_plusmin['jml_plus'];	
		return $jml_plus;
	}
	#Tunjangan Jabatan 
	public function get_tjab($emp_id, $p_start, $p_end) {
		//mysql_select_db($this->db, $this->koneksi);	
		$sql_tjab="	SELECT a.emp_id, SUM(b.t_jabatan) as tjab  FROM  absensi a, employee b
		WHERE b.emp_id=a.emp_id
		AND a.tgl between DATE_ADD('$p_start',INTERVAL 1 DAY) AND '$p_end'
		AND b.emp_id='$emp_id'
		AND a.jam_in !='Null'
		AND a.jam_out !='Null'";
		//$rs_tjab=mysql_query($sql_tjab,$this->koneksi) or die (mysql_error());
		$rs_tjab=$this->exec_query($sql_tjab);
		$row_tjab=mysql_fetch_assoc($rs_tjab);
		return $row_tjab[tjab];	
	}
	
	#Tunjangan Masa Kerja 
	public function get_tmsker($emp_id, $p_start, $p_end) {
		//mysql_select_db($this->db, $this->koneksi);	
		$sql_tmsker="	SELECT a.emp_id, SUM(b.t_masakerja) as t_msker  FROM  absensi a, employee b
		WHERE b.emp_id=a.emp_id
		AND a.tgl between DATE_ADD('$p_start',INTERVAL 1 DAY) AND '$p_end'
		AND b.emp_id='$emp_id'
		AND a.jam_in !='Null'
		AND a.jam_out !='Null'";
		//$rs_tmsker=mysql_query($sql_tmsker,$this->koneksi) or die (mysql_error());
		$rs_tmsker=$this->exec_query($sql_tmsker);
		$row_tmsker=mysql_fetch_assoc($rs_tmsker);
		return $row_tmsker[t_msker];	
	}
	
	#insentif Jam 
	public function get_ijam($kd_periode, $emp_id) 
	{
		$sql_ijam="SELECT SUM(jml_ijam) as jml_ijam 
		FROM insentif_overjam
		where kd_periode =$kd_periode AND emp_id='$emp_id'";
		//$rs_ijam=mysql_query($sql_ijam, $this->koneksi);		
		$rs_ijam=$this->exec_query($sql_ijam);
		$row_ijam=mysql_fetch_array($rs_ijam);		
		$jml_ijam=$row_ium['jml_ijam'];
		if ($jml_ijam<=0) 
		{
			return 0;
		} else 
		{
			return $jml_ijam;
		}
	}
	
	#Insentif Uang makan
	public function get_ium($kd_periode, $emp_id)
	{
		//mysql_select_db($this->db, $this->koneksi);		
		$sql_ium="SELECT SUM(jml_ium) as jml_ium FROM insentif_uang_makan WHERE kd_periode =$kd_periode AND emp_id='$emp_id'";
		//$rs_ium=mysql_query($sql_ium, $this->koneksi);
		$rs_ium=$this->exec_query($sql_ium);		
		$row_ium=mysql_fetch_array($rs_ium);		
		$jml_ium=$row_ium['jml_ium'];
		if ($jml_ium<=0) {
		return 0;
		} else {
		return $jml_ium;}
	}
	
	
}
//--------------------------------------------------


?>