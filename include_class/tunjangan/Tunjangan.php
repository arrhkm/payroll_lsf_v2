<?php 
class Tunjangan {
	public $jamev;
	public $jamot;
	//public $tunjangan;
	public $logika;	
	public $tgl_ini;
	public $link;
	public $start_work;
	public $absen;

	public $kenaikan;
	
	public function setTmasakerja($vjamev, $vjamot, $vlogika, $start_work, $tgl_ini,$link, $absen) {
		$this->jamev=$vjamev;
		$this->jamot=$vjamot;
		//$this->tunjangan=$vtmasakerja;
		$this->logika=$vlogika;
		$this->tgl_ini = $tgl_ini;
		$this->link = $link;
		$this->start_work = $start_work;
		$this->absen = $absen;
		//$this->kenaikan = 1000;
		

	}

	public function isDayOff(){
        $query = "
        SELECT * FROM tanggal_libur WHERE tgl_libur = '{$this->tgl_ini}' 
        ";
        $rs = mysqli_query($this->link, $query);
        if ($rs->num_rows >0){
            return TRUE;
        }else {
            return false;
        }
    }

	public function getTmasakerja() {
		if ($this->jamev>0){
			$tmsker = $this->tarikTmasakerja();
		//}elseif($this->absen == 'CT' || $this->absen == "SK" || $this->logika=="libur"){
		}elseif($this->absen == 'CT' || $this->absen == "SK" || $this->isDayOff()){
			$tmsker = $this->tarikTmasakerja();	
		}elseif($this->logika=="minggu") {
			if ($this->jamot>0){
				$tmsker = $this->tarikTmasakerja();	
			}else {
				$tmsker = 0;
			}
		
		}
		else {
			$tmsker = 0;
		}
		
		return $tmsker;
	}

	public function getLamaKerja(){
		$obj_tgl_ini = date_create($this->tgl_ini);
		$obj_start_work = date_create($this->start_work);
		$date_diff = date_diff($obj_tgl_ini, $obj_start_work);		
		return $date_diff->y;
	}

	public function tarikTmasakerja(){
		$nilai = 0;
		$lama_kerja = $this->getLamaKerja();

		$query = "SELECT * FROM  tarif_tunjangan_masakerja WHERE masa_kerja = $lama_kerja";
		$rs = mysqli_query($this->link, $query);
		
		$query_max = "SELECT * FROM tarif_tunjangan_masakerja WHERE masa_kerja = (SELECT MAX(masa_kerja) FROM tarif_tunjangan_masakerja)";
		$rs_max = mysqli_query($this->link, $query_max);
		$row_max = mysqli_fetch_assoc($rs_max);

		
		if ($row = mysqli_fetch_assoc($rs)){
			$nilai = $row['nilai_tunjangan'];
		}else if ($lama_kerja >=$row_max['masa_kerja']){
			$nilai = $row_max['nilai_tunjangan'];
		}else {
			$nilai = 0;
		}
		
		return $nilai;

	}

	
}