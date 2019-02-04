<?php
class Durasi
{	
	public $time_in;
	public $time_out;
	public $must_in;
	public $must_out;
	public $evective_hour;
	public $fsio;
	public $fsi;
	public $fso;
	public $person_in;
	public $office_in;
	public $person_out;
	public $office_out;	
	public $logika;
	public $tolate;


	
	public function setTime($vmust_in, $vmust_out, $vtime_in, $vtime_out, $vlogika) {
		$this->must_in=$vmust_in;
		$this->must_out=$vmust_out;	
		$this->time_in=$vtime_in;
		$this->time_out=$vtime_out;
		$this->logika=$vlogika;
		
	}
		
	public function getEvectiveHour() {
		//Jam IN dan OUT EMP		
		if ($this->time_in==Null OR $this->time_out==Null) { //JIKA Alpha
			$fsio=0;
			$fsi=0;
			$fso=0;				
			$this->evective_hour=0;
		}		
		else
		{			
			$ht_in_array=explode (":", $this->time_in);
			//JAM IN dan OUT PEKERJA
			$person_in=$ht_in_array[0];
			$ht_out_array=explode (":", $this->time_out);
			if($ht_out_array[0] < 6) { $person_out=$ht_out_array[0]+24;} 
			else { $person_out=$ht_out_array[0];}
			
			//JAM IN dan OUT OFFICE
			$hm_in_array=explode (":", $this->must_in);
			$office_in=$hm_in_array[0];
			
			$hm_out_array=explode (":", $this->must_out);
			$office_out=$hm_out_array[0];
			
			
			if ($this->logika=="normal" OR $this->logika=="akhir" OR $this->logika=="sabtu") { //logika normal /akhir /sabtu
				
				$fsi=$office_in - $person_in; //SELISIH IN			
				if(($person_out - $office_out)<0) {
					$so=0;
				}
				else {
					$so=$person_out - $office_out;
				}
				$fso=$so;//SELISIH OUT
				$fsio=$person_out - $person_in;//SELISIH IN-OUT

				$evective_hour=$fsio-($fsi+$fso);
				if($evective_hour>5) {
					$evective_hour=$evective_hour-1;
				}
				$this->evective_hour= $evective_hour;
				
				
			//}elseif ($this->logika=="awal" OR $this->logika=="libur") { //logika awal lama
			}elseif ($this->logika=="awal") { //logika awal lama
				$this->evective_hour=0;
			}
			elseif ($this->logika == "libur" OR $this->logika="minggu") { //logika libur 
				$this->evective_hour=0;			
			}
			return $this->evective_hour;
		}		
	}
	
	public function getOverTime() {
		$logikaku=$this->logika;
		if ($this->time_in==Null OR $this->time_out == Null) {
			$ot=0;
		}	
		else 
		{ 			
			$person_in= explode (":", $this->time_in);
			$office_in= explode (":", $this->must_in);
			$person_out= explode (":", $this->time_out);
			$office_out= explode (":", $this->must_out);
			
			$sio=$person_out[0]-$person_in[0];
			if ($office_in[0]>$person_in[0]) {
				$si=$office_in[0]-$person_in[0];
			}
			else {
				$si=$person_in[0]-$office_in[0];
			}
			$so=$person_out[0]-$office_out[0];
			
			if ($logikaku=="normal") {
				$ot=$person_out[0]-$office_out[0];
				if ($ot<0) $ot=0;
			}
			elseif ($logikaku=="libur" OR $logikaku=="minggu") {
				if ($person_out[0]>=13) {
					$ot=$sio-($si+1);// 1 jam istirahat jam 12:00
					if ($ot<0) $ot=0;
				}else {//lembur sampai di bawah jam 13:00
					$ot=$sio-($si);
					if ($ot<0) $ot=0;				
				}
			}
			elseif ($logikaku=="sabtu") {
				if ($person_out[0]>=13) {
					$ot=$person_out[0]-$office_out[0]-1;//(-1 = istirahat 1 jam)
					if ($ot<0) $ot=0;
				} else {
					$ot=0;
				}
			}
			elseif ($logikaku=="awal") {
				$ot=$person_out[0]-$office_out[0];
				if ($ot<0) $ot=0;
			}
			else{
				$ot=0;
			}						
		}
		return $ot;		
	}
	
	public function fSio()
	{
		if ($this->time_in==Null OR $this->time_out== Null) {
				return 0;
		} else 
		{
			$person_in= explode (":", $this->time_in);
			$person_out= explode (":", $this->time_out);
			$sio=$person_out[0]-$person_in[0];
			return $sio;
		}	
	}
	
	public function fSi(){
	if ($this->time_in==Null OR $this->time_out== Null) {
			return 0;
		}else {
			$person_in= explode (":", $this->time_in);
			$office_in= explode (":", $this->must_in);
			$si=$office_in[0]-$person_in[0];
			return $si;
		}
	}
	public function fSo(){
		if ($this->time_in==Null OR $this->time_out== Null) {
				return 0;
		} else {
			$person_out= explode (":", $this->time_out);
			$office_out= explode (":", $this->must_out);
			$so=$person_out[0]-$office_out[0];
			return $so;
		}
	}
	
	public function getTolate(){
		if ($this->time_in==Null OR $this->time_out== Null) {
			$tolate=0;
		} else {
			$person_in= explode (":", $this->time_in);
			$office_in= explode (":", $this->must_in);
			if ($person_in[0]<$office_in[0]) {
				$tolate=0;
			}
			else{
			
				if ($person_in[0]==$office_in[0]) {
					$tolate=$person_in[1]-$office_in[1];
					if ($tolate>5) {
						//$tolate=$tolate-5; //telat adalah 5 menit 
						$tolate=$tolate-4; //Potongan telat ketika masuk 5 menit
					}else {
						$tolate=0;
					}
				} else {
					$tl1=($person_in[0]-$office_in[0])*60;
					$tl2=$person_in[1];
					//$tolate=($tl1+$tl2) -5;
					$tolate=($tl1+$tl2) -4; //potongan telat ketika masuk 5 menit
				}
			}
		}
		return $tolate;
		/*if ($tolate>=1) {
			return $tolate;
		} else {
			return 0;
		}
		*/
	}
}
?>
