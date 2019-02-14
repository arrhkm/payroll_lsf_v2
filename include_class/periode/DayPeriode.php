<?php 
//require_once('connections/CConnect.php');
class DayPeriode 
{
	public $db;
	public $tgl_ini;
	public $name_of_day;
	public $logika_periode;
	public $liburan;
	
	public function setDay($vtgl_ini, $vtgl_awal, $vtgl_akhir, $vliburan=''){		
		
		$this->tgl_ini=$vtgl_ini;
		$this->awal=$vtgl_awal;
		$this->akhir=$vtgl_akhir;
		$this->liburan=$vliburan;
	}
	public function getDay(){
		$i=date("N", strtotime($this->tgl_ini));
		switch ($i) {
		case 1:
			$name= "Senin";
			break;
		case 2:
			$name= "Selasa";
			break;
		case 3:
			$name= "Rabu";
			break;
		case 4:
			$name= "Kamis";
			break;
		case 5:
			$name= "Jumat";
			break;
		case 6:
			$name= "Sabtu";
			break;
		case 7:
			$name= "Minggu";
			break;
		}
		return $this->name_of_day=$name;
	}
	public function logikaPeriode(){
		if (date("N", strtotime($this->tgl_ini))==7) {// Jika Logika hari = hari Minggu
			$this->logika_periode="minggu";		
		}
		elseif ($this->liburan>0) { // Jika logika hari liburan tanggal merah
			$this->logika_periode="libur";		
		}
		elseif ( date("N", strtotime($this->tgl_ini)) == 6) {
			$this->logika_periode="sabtu";
		} else {		
			if ($this->tgl_ini == $this->awal) {
				//$this->logika_periode="awal";
				//update 2018
				$this->logika_periode="normal";
			}
			else if ($this->tgl_ini==$this->akhir) {
				//$this->logika_periode="akhir";
				$this->logika_periode="normal";
			}
			else
			{
				$this->logika_periode="normal";			
			}
		}
	}
}
?>