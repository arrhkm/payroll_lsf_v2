<?php
class Grandtotal{
	public $gp;
	public $gl;
	public $tmasakerja;
	public $tjam12;		
	public $pottelat;
	public $potsafety;
	public $ket_absen;
	public $gaji_dasar;
	public $t_resiko;
	public $logika;
	
	public function setGrandtotal($vgp, $vgl, $vtmasakerja, $vtjam12, $vpottelat, $vpotsafety, $vket_absen, $vgaji_dasar, $vresiko, $vlogika) {
		$this->gp=$vgp;
		$this->gl=$vgl;
		$this->tmasakerja=$vtmasakerja;	
		$this->tjam12=$vtjam12;			
		$this->pottelat=$vpottelat;
		$this->potsafety=$vpotsafety;
		$this->ket_absen=$vket_absen;
		$this->gaji_dasar=$vgaji_dasar;
		$this->logika=$vlogika;
		$this->t_resiko = $vresiko;
		
	}
	public function getGrandtotal() {
		$ijin=$this->ket_absen;
		$logikaku=$this->logika;
		if ($ijin=="SK" || $ijin=="CT" || $ijin=="PD"){
			if ($logikaku=="awal"){	
				//$grand_total=0;//update 2018
				$grand_total= $this->gaji_dasar + $this->tmasakerja;
			} else {
				$grand_total= $this->gaji_dasar + $this->tmasakerja; 
			}
		} else {		
                    //LDP //$grand_total=($this->gp+$this->gl+$this->tmasakerja+$this->tjam12) -($this->pottelat+$this->potsafety);
		
                    $grand_total=($this->gp+$this->gl+$this->tmasakerja+$this->tjam12 +$this->pottelat +$this->t_resiko) -($this->potsafety);//LSF
                }       
		
		return round($grand_total);
	}
}
?>