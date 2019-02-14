<?php 
class Tunjangan {
	public $jamev;
	public $jamot;
	public $tunjangan;
	public $logika;	
	
	public function setTmasakerja($vjamev, $vjamot, $vtmasakerja, $vlogika) {
		$this->jamev=$vjamev;
		$this->jamot=$vjamot;
		$this->tunjangan=$vtmasakerja;
		$this->logika=$vlogika;
	}
	public function getTmasakerja() {
		$logika_ini=$this->logika;
		if ($logika_ini=="sabtu") {
			if ($this->jamev >=5) {
				$tmsker=$this->tunjangan;			
			}else {
				$tmsker=0;
			}
		}
		elseif ($logika_ini=="libur") {
			if ($this->jamot>0) {
				$tmsker=$this->tunjangan;			
			}else {
				$tmsker=0;
			}		
		}
		elseif ($logika_ini=="minggu") {
			if ($this->jamot>=5) {
				$tmsker=$this->tunjangan;			
			}else {
				$tmsker=0;
			}		
		}
		else { 		
			if ($this->jamev >=7) {
				$tmsker=$this->tunjangan;			
			}else {
				$tmsker=0;
			}			
		}
		return $tmsker;
	}
}