<?php 
class Tjam12 {
	public $jam12;
	public $tujangan;
	
	
	public function setTunjangan ($vjam12, $vtunjangan) {
		$this->jam12=$vjam12;
		$this->tunjangan=$vtunjangan;
		
	}
	public function getTunjangan() {
		$pulangjam12 = $this->jam12;
		if ($pulangjam12) {
			$nilai_tunjangan=$this->tunjangan;
		}
		else {
			$nilai_tunjangan=0;		
		}
		return $nilai_tunjangan;
	}
}