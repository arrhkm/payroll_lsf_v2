<?php
class Kasbon {
	public $kd_kasbon;
	public $emp_id;
	public $tgl;
	//public $ket;
	public $jml_kasbon;
	public $status;
	public $sisa_cicil;
	public $jml_cicil;
	
	public function setKasbon ($vkd_kasbon, $vemp_id, $vtgl, $vket, $vjml_kasbon, $vstatus, $vsisa_cicil, $vjml_cicil) {		
		$this->kd_kasbon = $vkd_kasbon; 
		$this->emp_id=$vemp_id;		 
		$this->tgl=$vtgl;		 
		//$this->ket=$vket;
		$this->jml_kasbon=$vjml_kasbon;
		$this->status=$vstatus;
		$this->sisa_cicil=$vsisa_cicil;
		$this->jml_cicil=$vjml_cicil;
	}

}
?>