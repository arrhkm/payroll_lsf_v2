<?php 
//require_once ('connections/CConnect.php');
class Periode 
{
	public $kd_periode;
	public $tgl_awal;
	public $tgl_akhir;
	public $nama_periode;	
	public $potongan_jamsos;
	public $sql_periode;
	public $selisih;
	public $tgl_ini=array();

	
	public function __construct(){
		
	}
	public function setId($vkd_periode){
		$this->kd_periode=$vkd_periode;
		$this->sql_periode="SELECT * FROM periode WHERE kd_periode=$vkd_periode";
	}
	
	public function setPeriode($vtgl_awal, $vtgl_akhir, $vnama_periode, $vpotongan_jamsos) {		
		
		$this->tgl_awal=$vtgl_awal;
		$this->tgl_akhir=$vtgl_akhir;
		$this->nama_periode=$vnama_periode;
		$this->potongan_jamsos=$vpotongan_jamsos;
		
	}
	
	public function setSelisih() {
		$pecah1 = explode("-", $this->tgl_awal);
		$date1 = $pecah1[2];
		$month1 = $pecah1[1];
		$year1 = $pecah1[0];

		// memecah string tanggal akhir untuk mendapatkan
		// tanggal, bulan, tahun
		$pecah2 = explode("-", $this->tgl_akhir);
		$date2 = $pecah2[2];
		$month2 = $pecah2[1];
		$year2 =  $pecah2[0];

		// mencari total selisih hari dari tanggal awal dan akhir
		$jd1 = GregorianToJD($month1, $date1, $year1);
		$jd2 = GregorianToJD($month2, $date2, $year2);

		$selisih = $jd2 - $jd1;
		return $selisih;
	}
	
	public function tglIni($vselisih) {
		
		for ($i=0;$i<=$vselisih;$i++) { 
			//setting tanggal ini 
			
			$tgl = strtotime("+$i day" ,strtotime($this->tgl_awal));
			$this->tgl_ini[$i]= date('Y-m-d', $tgl);
			//echo "<br> tanggal ke- $i | ".$this->tgl_ini[$i]."";
		}
	}
		
}
?>