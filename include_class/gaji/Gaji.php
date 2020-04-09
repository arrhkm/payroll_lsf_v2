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
        public $emp_id;
        public $period_id;
        public $link;
        public $tgl_ini;
	
    private $const_workday_of_month = 26;//untuk LSF 
    //untuk LDP --> //private $const_workday_of_month = 25;

    //public function setGaji($vgaji, $vev, $vot, $vtolate, $vlogika, $vket_absen){//LDP
    public function setGaji($vgaji, $vev, $vot, $vtolate, $vlogika, $vket_absen, $vpot_telat, $masakerja, $emp_id, $period_id, $tgl_ini,  $link){//LSF
        $this->gaji=$vgaji;
        
        $this->ot=$vot;
        $this->ev=$vev;
        $this->tolate=$vtolate;
        $this->logika=$vlogika;
        $this->ket_absen=$vket_absen;        
        $this->pot_telat = $vpot_telat;
        $this->ms_kerja=$masakerja;
        $this->emp_id = $emp_id;
        $this->period_id = $period_id;
        $this->link = $link;
        $this->tgl_ini = $tgl_ini;
    }

    public function getLamakerja(){
        $query = "SELECT * FROM  employee WHERE emp_id = '$this->emp_id'";
        $rs = mysqli_query($this->link, $query);
        $row = mysqli_fetch_assoc($rs);
        $start_work =  $row['start_work'];
        $obj_tgl_ini = date_create($this->tgl_ini);
		$obj_start_work = date_create($start_work);
		$date_diff = date_diff($obj_tgl_ini, $obj_start_work);		
		return $date_diff->y;
    }
    
    
    
    //-------------------------------tunjangan tidak tetap--------------------------------------------------
    public function getListTunjanganTidakTetap(){
        $query_period = "SELECT * FROM periode WHERE kd_periode = $this->period_id";
        $rs_period = mysqli_query($this->link, $query_period);
        $row_period = mysqli_fetch_assoc($rs_period);

        $query = " SELECT a.employee_emp_id, a.jenis_tunjangan_id,  count(a.tanggal) as jml_tunjangan, b.nama_jenis, b.nilai_tunjangan
            FROM tunjangan a
            LEFT JOIN jenis_tunjangan b ON(b.id = a.jenis_tunjangan_id)
            WHERE employee_emp_id ='$this->emp_id'
            AND tanggal BETWEEN '$row_period[tgl_awal]' AND '$row_period[tgl_akhir]'
            group By (jenis_tunjangan_id);

        ";
        $rs = mysqli_query($this->link, $query);
        $dt_arr = [];

        while ($row_tj = mysqli_fetch_assoc($rs)) {
        //while ($row_tj = mysqli_fetch_assoc($rs)){
            array_push($dt_arr, [
                'emp_id' => $row_tj['employee_emp_id'],
                'jenis_tunjangan_id'=> $row_tj['jenis_tunjangan_id'],
                'jml_tunjangan' => $row_tj['jml_tunjangan'],
                'nilai_tunjangan'=>$row_tj['nilai_tunjangan'],
                'nama_tunjangan'=>$row_tj['nama_jenis'],
            ]);
        }
        return $dt_arr;

    }

    public function getKetTunjanganTidakTetap(){
        $string_tj = "";
        foreach ($this->getListTunjanganTidakTetap() as $dttj){
            $string_tj  .= ' ' . $dttj['nama_tunjangan']."(".$dttj['jml_tunjangan'].")";
        }
        return $string_tj;
    }
    

    public function getTotalTunjanganTidakTetap(){
        $tunjangan = $this->getListTunjanganTidakTetap();
        $jml = 0;
        foreach ($tunjangan as $dt){
            $jml = $jml + ($dt['nilai_tunjangan']*$dt['jml_tunjangan']);
        }
       
       
        if($this->logika=="normal") {
            if ($this->ev > 1){
                $nilai = $jml;
            }else {
                $nilai =0;
            }
        }
        
        return $jml;
    }
    //END TUNJANGAN TIDAK TETAP 



    public function gajiPokok(){
            $ijin=$this->ket_absen;
            if ($ijin=="SK" || $ijin=="CT" || $ijin=="PD"){
                    $gp=$this->gaji;
            }else {
                if ($this->logika == "libur") {
                    //$gp=$this->gaji;
                    if ($this->ot>0){
                        $gp = 0;
                    }else {
                       
                        $gp = $this->gaji;//Update 2020
                        
                    }
                    
                }else {
                    if ($this->logika == "awal") {
                        //$gp=0;		
                        //update 2018
                        $gp=$this->ev*($this->gaji/7);	
                    }
                    elseif ($this->logika =="sabtu") {
                            $gp=$this->ev*($this->gaji/5);
                            
                    }
                    
                    elseif($this->logika == 'minggu'){
                        $gp = 0;
                    }
                    else {
                            $gp=$this->ev*($this->gaji/7);
                    }			

                }                    

                
            }
            return round($gp);
    }	
    public function gajiPengaliLembur() {
        //return ($this->gaji * $this->const_workday_of_month)/173; //LDP const_workday_of_month = 25 hari
        //RUMUS LSF gaji pengali lembur = ((GP 1 hari * 26) + (Tmasakerja*26))/173

        return (($this->gaji * $this->const_workday_of_month)+($this->ms_kerja*$this->const_workday_of_month))/173;
        //return $this->ms_kerja;

    }


    public function gajiLembur(){
        //----------SPL---------
        /*$query_spl = "SELECT * FROM spl WHERE date_spl = '$this->tgl_ini' AND employee_emp_id ='$this->emp_id'";
        $rs_spl = mysqli_query($this->link, $query_spl);
        $row_spl = mysqli_fetch_assoc($rs_spl);

        ///--------execution SPKL -----------/
        
        $ot_spl = $row_spl['overtime_value'];
        if ($this->ot > $ot_spl){
            $this->ot = $ot_spl;
        }else if (empty($ot_spl)){
            $this->ot = 0;
        }
        //-----ende execution SPKL------------/
        
        
        //--------end SPL------- 
        */
        
        $v_gajilembur = $this->gajiPengaliLembur();
        $today = date_create($this->tgl_ini);
        $w_day = $today->format('w');
        $num_day = (int)$w_day;
        /*if ($num_day = 6){
            $gaji_ot = $num_day;
        }*/
        if ($this->logika=="libur" OR $this->logika=="minggu") {
                $ot=$this->ot;
                
                if ($num_day == 6){//jika sabtu
                    if ($this->ot>0 && $this->ot<=5){
                        $gaji_ot = 2*5*($v_gajilembur);
                        //$gaji_ot = $v_gajilembur;

                    }elseif ($this->ot ==6){   
                        $gj1 = 2*5*($v_gajilembur);
                        $gj2 = 3*($v_gajilembur);
                        $gaji_ot = $gj1+$gj2;             
                     
                    }elseif ($this->ot>=7){
                        $gj1 = 4*($this->ot-6)*($v_gajilembur);
                        $gj2 = 3*($v_gajilembur);
                        $gj3 = 2*5*($v_gajilembur);
                        $gaji_ot = $gj1+$gj2+$gj3;
                    }
                }
                elseif ($this->ot==8){
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
        
        return $gaji_ot;
        //return $ot_spl;
    }
    public function gajiTelat() {
            //if ($this->tolate>=1 and $this->tolate <=25) {
                    //if ($this->logika == "minggu" OR $this->logika=="libur"){

        if ($this->ev < 7){
            if ($this->logika =="sabtu"){

                if ($this->ev ==5){
                    if ($this->tolate>=1){
                         $telat=0;
                         return $telat;
                    }else {
                        $telat=$this->pot_telat;
                        return round($telat);
                    }

                }else {                 
                    $telat=0;
                    return round($telat);
                }
            }elseif ($this->logika=="minggu" OR $this->logika=="libur"){
                if ($this->ot>=1){
                    if($this->tolate>=1){
                        return 0;
                    }else {
                        return round($this->pot_telat);
                    }
                }
            }
            
        }else{

            if ($this->tolate>=1) {
                //$telat = 1*($this->gaji/7);
                $telat = 0; //for LSF
                return $telat;
            } 
            else {              
                $telat = $this->pot_telat; //for LSF 
                return round($telat);
            }
        }

    }   
}
?>