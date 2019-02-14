<?php 
class Gaji {
	public $ev;
	public $ot; 
	public $gaji;	
	public $logika;
	public $tolate;
	public $ket_absen;
    public $ms_kerja;//untuk LSF
    public $pot_telat;//LSF
	
	private $const_workday_of_month = 26;//untuk LSF 
        //untuk LDP --> //private $const_workday_of_month = 25;
	
	//public function setGaji($vgaji, $vev, $vot, $vtolate, $vlogika, $vket_absen){//LDP
        public function setGaji($vgaji, $vev, $vot, $vtolate, $vlogika, $vket_absen, $vms_kerja, $vpot_telat){//LSF
		$this->gaji=$vgaji;
		$this->ot=$vot;
		$this->ev=$vev;
		$this->tolate=$vtolate;
		$this->logika=$vlogika;
		$this->ket_absen=$vket_absen;
        $this->ms_kerja=$vms_kerja;
        $this->pot_telat = $vpot_telat;
	}
	
	
	
	public function gajiPokok(){
		$ijin=$this->ket_absen;
		if ($ijin=="SK" || $ijin=="CT" || $ijin=="PD"){
			$gp=$this->gaji;
		}else {
		
			if ($this->logika == "awal") {
				//$gp=0;		
				//update 2018
				$gp=$this->ev*($this->gaji/7);	
			}
			if ($this->logika =="sabtu") {
				$gp=$this->ev*($this->gaji/5);
				//$gp=1000;
			}
			elseif ($this->logika == "libur") {
				$gp=$this->gaji;
			}
			else {
				$gp=$this->ev*($this->gaji/7);
			}			
		}
		return round($gp);
	}	
	 public function gajiPengaliLembur() {
			return (($this->gaji * $this->const_workday_of_month)+($this->ms_kerja*$this->const_workday_of_month))/173;//26 hari / 173 jam evektif
	}
	
	
	public function gajiLembur(){
			$v_gajilembur = $this->gajiPengaliLembur();
	
		if ($this->logika=="libur" OR $this->logika=="minggu") {
			$ot=$this->ot;
			//$gaji_ot=2*($this->gaji/7)*$this->ot;
			if ($this->ot==8){
				//$gaji_ot=3*($this->gaji/7)*$this->ot;
				$gj1=2*($v_gajilembur)*($this->ot-1);
				$gj2=3*($v_gajilembur)*1;
				$gaji_ot=$gj1+$gj2;
			}
			//elseif ($ot>=9) {
			elseif ($this->ot >=9) {
				//$gaji_ot=4*($this->gaji/7)*$this->ot;
				$gj1=2*($v_gajilembur)*7;
				$gj2=3*($v_gajilembur)*1;
				$gj3=4*($v_gajilembur)*($this->ot-8);
				$gaji_ot=$gj1+$gj2+$gj3;
				//$gaji_ot=100;
			}
			else {
				$gaji_ot=2*($v_gajilembur)*$this->ot;
			}
			
		} else {
			if ($this->ot<=9 AND $this->ot>0){
				$part1=1.5*($v_gajilembur);
				$part2=2*($this->ot -1)*($v_gajilembur);
				$gaji_ot=$part1+$part2;
			}
			elseif ($this->ot>9){
				$part1=1.5*($v_gajilembur);
				$part2=2*8*($v_gajilembur);
				$part3=3*($this->ot-9)*($v_gajilembur);
				$gaji_ot=$part1+$part2+$part3;
			}else {
				$gaji_ot=0;
			}
		}		
		//return round($gaji_ot);
		return $gaji_ot;
	}
	public function gajiTelat() {
		//if ($this->tolate>=1 and $this->tolate <=25) {
        if ($this->ev < 7){
            if ($this->logika =="sabtu"){
                if ($this->ev ==5){
                    $telat=$this->pot_telat;
                    return round($telat);
                }else {                 
                	$telat=0;
                	return round($telat);
            	}
            }
            
        }else
        {
        	if ($this->tolate>=1 and $this->tolate <5) {
				//$telat = 1*($this->gaji/7);
	            $telat = 0; //for LSF
	            return round($telat);
			} 
			
			else {
				//$telat=0;
	            $telat = $this->pot_telat; //for LSF 
	            return round($telat);
			}
		}


		//return round($telat);
	}
}
?>