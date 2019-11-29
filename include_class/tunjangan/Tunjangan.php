<?php 
class Tunjangan {
	public $jamev;
	public $jamot;
	public $tunjangan;
	public $logika;	
	public $tgl_ini;
	public $link;
	public $start_work;

	public $kenaikan;
	
	public function setTmasakerja($vjamev, $vjamot, $vtmasakerja, $vlogika, $start_work, $tgl_ini) {
		$this->jamev=$vjamev;
		$this->jamot=$vjamot;
		$this->tunjangan=$vtmasakerja;
		$this->logika=$vlogika;
		$this->tgl_ini = $tgl_ini;
		$this->link = $link;
		$this->start_work = $start_work;
		$this->kenaikan = 1000;
	}
	public function getTmasakerja() {
		$logika_ini=$this->logika;
		if ($logika_ini=="sabtu") {
			if ($this->jamev >=5) {
				//$tmsker=$this->tunjangan;		
				$tmsker = $this->tarikTmasakerja();
			}else {
				$tmsker=0;
			}
		}
		elseif ($logika_ini=="libur") {
			if ($this->jamot>0) {
				//$tmsker=$this->tunjangan;
				$tmsker = $this->tarikTmasakerja();			
			}else {
				$tmsker=0;
			}		
		}
		elseif ($logika_ini=="minggu") {
			if ($this->jamot>=5) {
				//$tmsker=$this->tunjangan;
				$tmsker = $this->tarikTmasakerja();			
			}else {
				$tmsker=0;
			}		
		}
		else { 		
			if ($this->jamev >=7) {
				//$tmsker=$this->tunjangan;
				$tmsker = $this->tarikTmasakerja();			
			}else {
				$tmsker=0;
			}			
		}
		return $tmsker;
	}

	public function tarikTmasakerja(){
		$obj_tgl_ini = date_create($this->tgl_ini);
		$obj_start_work = date_create($this->start_work);
		$date_diff = date_diff($obj_tgl_ini, $obj_start_work);
		$tunjnagan_masakerja = $date_diff->y * $this->kenaikan;
		return $tunjnagan_masakerja;

	}

	public function getLamaKerja(){
		$obj_tgl_ini = date_create($this->tgl_ini);
		$obj_start_work = date_create($this->start_work);
		$date_diff = date_diff($obj_tgl_ini, $obj_start_work);
		//$tunjnagan_masakerja = $date_diff->y * $this->kenaikan;
		return $date_diff->y;
	}
}