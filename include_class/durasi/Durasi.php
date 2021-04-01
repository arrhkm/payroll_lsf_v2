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
	public $tgl_ini;
	//---------------------
	public $emp_id;
	public $link;


	
	public function setTime($vmust_in, $vmust_out, $vtime_in, $vtime_out, $vlogika, $tgl_ini, $emp_id, $link) {
		$this->must_in=$vmust_in;
		$this->must_out=$vmust_out;	
		$this->time_in=$vtime_in;
		$this->time_out=$vtime_out;
		$this->logika=$vlogika;
		$this->tgl_ini = $tgl_ini;	
		$this->emp_id = $emp_id;
		$this->link = $link;	
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
			$person_in=(int)$ht_in_array[0];
			$ht_out_array=explode (":", $this->time_out);
			if((int)$ht_out_array[0] < 6) { $person_out=(int)$ht_out_array[0]+24;} 
			else { $person_out=(int)$ht_out_array[0];}
			
			//JAM IN dan OUT OFFICE
			$hm_in_array=explode (":", $this->must_in);
			$office_in=(int)$hm_in_array[0];
			
			$hm_out_array=explode (":", $this->must_out);
			$office_out=(int)$hm_out_array[0];
			
			
			//if ($this->logika=="normal" OR $this->logika=="jumat" OR $this->logika=="akhir" OR $this->logika=="sabtu") { //logika normal /akhir /sabtu
			if (in_array($this->logika, ['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu'])){	
				$fsi=$office_in - $person_in; //SELISIH IN		
				//var_dump($office_in);
				//var_dump($office_out);	
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

			$p_out = (int)$person_out[0];
			$o_out = (int)$office_out[0];
			$o_in =  (int)$office_in[0];
			
			//Jika sabtu mulai lembur = 14:00:00, pulang jam 12:00:00
			
			if ($logikaku == 'sabtu'){
			
				if ($p_out > 13){
					if ($p_out <= 18){
						$ot = ($p_out-$o_out)-1;
					}else {
						$ot = ($p_out-$o_out)-2;
					}
				}					
				
			}
			elseif ($logikaku == 'minggu'){
				if ($p_out >12){
					if ($p_out >=18){
						$ot = ($p_out - $o_in) - 2;
					}else {
						$ot = ($p_out - $o_in) -1;
					}
									
				}else {
					$ot = $p_out - $o_in;
				}
				
			}else {// Jika Normal hari biasa
				if ($p_out >=18){
					$ot = ($p_out-$o_out) -1;
				}else {
					$ot = $p_out-$o_out;
				}
			}		
			
			
		}
		return $ot;		
	}

	public function getOverTimeSpkl(){
		$query_spl = "SELECT * FROM spl WHERE date_spl = '$this->tgl_ini' AND employee_emp_id ='$this->emp_id'";
        $rs_spl = mysqli_query($this->link, $query_spl);
       
		if ($rs_spl){
			$row_spl = mysqli_fetch_assoc($rs_spl);
			$nilai = $row_spl['overtime_value'];

		}else {
			$nilai = 0;
		}
		
        return $nilai;
	}

	public function getOverTimeDecition(){ //overtime dengan keputusan AI
		if ($this->getOverTimeSpkl() < $this->getOverTime()){
			return $this->getOverTimeSpkl();

		}elseif($this->getOverTime() < $this->getOverTimeSpkl()){
			return $this->getOverTime();
		}
		else return 0;
	}

	public function getOverTimeActual(){ //overtime dengan AKTUAL Saja

		if ($this->getOverTime() > 0 ){
			return $this->getOverTime();
		}
		else {
			return 0;
		}
	}
	
	public function fSio()
	{
		if ($this->time_in==Null OR $this->time_out== Null) {
				return 0;
		} else 
		{
			$person_in= explode (":", $this->time_in);
			$person_out= explode (":", $this->time_out);
			$sio=(int)$person_out[0]-(int)$person_in[0];
			return $sio;
		}	
	}
	
	public function fSi(){
	if ($this->time_in==Null OR $this->time_out== Null) {
			return 0;
		}else {
			$person_in= explode (":", $this->time_in);
			$office_in= explode (":", $this->must_in);
			$si=(int)$office_in[0]-(int)$person_in[0];
			return $si;
		}
	}
	public function fSo(){
		if ($this->time_in==Null OR $this->time_out== Null) {
				return 0;
		} else {
			$person_out= explode (":", $this->time_out);
			$office_out= explode (":", $this->must_out);
			$so=(int)$person_out[0]-(int)$office_out[0];
			return $so;
		}
	}
	
	public function getTolate(){
		if ($this->time_in==Null OR $this->time_out== Null) {
			$tolate=0;
		} else {
			$person_in= explode (":", $this->time_in);
			$office_in= explode (":", $this->must_in);
			if ((int)$person_in[0]<(int)$office_in[0]) {
				$tolate=0;
			}
			else{			
				if ((int)$person_in[0]==(int)$office_in[0]) { //Jika jam in emp = jam masuk kantor  maka diuji menit nya
					$tolate=(int)$person_in[1]-(int)$office_in[1];				
					
					if ($tolate == 6) {	//tolate in minut											
						if ((int)$person_in[2]>=1){
							$tolate=1;
						}
						else {
							$tolate = 0;
						}
					} elseif ($tolate>6) {
						$tolate = $tolate -6;
					}else {
						$tolate = 0;
					}
				} else {
					$tl1=((int)$person_in[0]-(int)$office_in[0])*60;
					$tl2=(int)$person_in[1];
					$tolate=($tl1+$tl2) -6; //potongan telat ketika masuk 6 menit
				}
				
			}
		}
		return $tolate;
		
	}
}
?>
