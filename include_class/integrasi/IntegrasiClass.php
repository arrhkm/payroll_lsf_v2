<?php
//date_default_timezone_set('UTC');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of integrasiClass
 *
 * @author itlintech
 */
class IntegrasiClass {
    public $log=array();
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
    public function timeInToDateTime($time_integer){
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
        
        $log_emp_day = array();//declare variable
        foreach ($this->log as $vlog){
           if (($vlog['id']==$this->card_id)){
                $x = $this->timestampTodate($vlog['timestamp']);
                $dtime1 = $vlog['timestamp'];
                $dtime2 = strtotime($dtime1);
                $dtime3 = $this->timeInToDateTime($dtime2);
                if ($x==$this->date_integration){
                    if (strtotime($vlog['timestamp'])>=$DayStartTime && (strtotime($vlog['timestamp'])< $DayNextTime)){
                        if (count($vlog['timestamp'])!=0){
                            array_push($log_emp_day, strtotime($vlog['timestamp']));
                        }
                        
                    }
                }
            }

        }
     
        $this->out = max($log_emp_day);        
        $this->in = min($log_emp_day);
    }
    
}
function println($dtprint){
    echo $dtprint."<br>";
}
/*
$log =array (
  0 => 
    array (
      'id' => '76', 
      'timestamp' => '2019-01-30 06:09:35', 
      'verifikasi' => '15', 
      'status' => 0,
    ),
    1 => 
    array (
      'id' => '76', 
      'timestamp' => '2019-01-30 17:09:35', 
      'verifikasi' => '15', 
      'status' => 0,
    ),
    2 => 
    array (
      'id' => '76', 
      'timestamp' => '2019-01-30 07:09:35', 
      'verifikasi' => '15', 
      'status' => 0,
    ),
    3 => 
    array (
      'id' => '76', 
      'timestamp' => '2019-01-30 05:09:35', 
      'verifikasi' => '15', 
      'status' => 0,
    ),
    4 => 
    array (
      'id' => '76', 
      'timestamp' => '2019-01-30 20:09:35', 
      'verifikasi' => '15', 
      'status' => 0,
    )
);

$card = 76;
$date_now= '2019-01-30';
$it = new IntegrasiClass($log, $card, $date_now);
function println($value){
    echo $value."<br>";
}
println($it->date_integration);
println($it->card_id);
$it->getLog();
echo "IN : ".date("Y-m-d H:i:s", $it->in). " Out : ".date("Y-m-d H:i:s",$it->out);
*/
