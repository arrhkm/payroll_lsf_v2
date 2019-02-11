<?php
//date_default_timezone_set('UTC');


/**
 * Description of integrasiClass
 *
 * @Hakam itlintech
 */
class IntegrasiClass {
    public $log = array();
    public $card_id;
    public $date_integration;
    
    public $in;
    public $out;
    
    function __construct($c_log, $c_cardid, $c_date) {
        $this->log=$c_log;
        $this->card_id = $c_cardid;
        $this->date_integration=$c_date;
    }
    public function timestampTodate($datetime){
        return substr($datetime, 0,10);
    }
    public function timeInToDateTime($time_integer){ //merubah time ke dateTime format
        return date("Y-m-d H:i:s", $time_integer);
    }
    public function getLog()
    {
        //Set frame login in 1 day 
        $punchDate = $this->date_integration;                      
        $DayStart = $punchDate." 05:00:00";// Batas awal cek IN OUT absensi per emloye per 1 day
        $DayStartTime = strtotime($DayStart);
        $dn = strtotime($DayStart."+1 day");
        $DayNext = $this->timeInToDateTime($dn);
        
        $DayNextTime = strtotime($DayNext);
        $vlog = array();
        $log_emp_day = array();//declare variable
        foreach ($this->log as $vlog){
           if (($vlog['id']==$this->card_id)){ //Jika id log mesin sama dengan id log employee
                $x = $this->timestampTodate($vlog['timestamp']);// conversi log time ke date
                //$dtime1 = $vlog['timestamp'];
                //$dtime2 = strtotime($dtime1);// konversi log ke time
                //$dtime3 = $this->timeInToDateTime($dtime2);
                if ($x==$this->date_integration){
                    if (strtotime($vlog['timestamp'])>=$DayStartTime && (strtotime($vlog['timestamp'])< $DayNextTime)){
                       
                        array_push($log_emp_day, strtotime($vlog['timestamp']));
                        
                        
                    }
                }
            }

        }
        if (isset($log_emp_day) && count($log_emp_day)>0){
            $this->out = max($log_emp_day);        
            $this->in = min($log_emp_day);
        }else {
            $this->in= Null;
            $this->out= Null;
        }
     
        
    }
    
}
function println($dtprint){
    echo $dtprint."<br>";
}
?>
