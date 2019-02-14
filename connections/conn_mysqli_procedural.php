<?php

 $host = "localhost";
 $database = "lsf_payroll";
 $user = "lsf";
 $password = "Payrolllsf32#";
 $port = 3306;
 $socket = 1226;
 //-----------------------------
$link = mysqli_connect($host, $user, $password);
//$link = mysqli_connect($host, $user, $password, $database, $port, $socket);
mysqli_select_db($link, $database);
/*
$query_rsPeriode = "SELECT * FROM periode ORDER BY kd_periode DESC";
$result = mysqli_query($link, $query_rsPeriode);
while ($dt = mysqli_fetch_assoc($result)){
    echo $dt['kd_periode']." - ".$dt['nama_periode']." <br>";
}
*/

class DbAutoIncrement
{
    private $id;
    public $link;
    public $table_name;
    public function setDb($link, $table){
        $this->link = $link;
        $this->table_name = $table;
    }
    
    public function getlastId($field_name)
    {
        $sql = "SELECT MAX($field_name)as nmax FROM $this->table_name";
        $rs = mysqli_query($this->link, $sql);
        $dt = mysqli_fetch_assoc($rs);
        if ($dt['nmax']>0){
            $this->id = $dt['nmax']+1;
        } else {
            $this->id = 1;
        }
        return $this->id;
    }
    /*{
        $sql = "SELECT MAX('".$field_name."')as nmax FROM '".$this->table_name."' WHERE machine_id='".id_machine."'";
        $rs = mysqli_query($this->link, $sql);
        $dt = mysqli_fetch_assoc($rs);
        if ($dt['nmax']>0){
            $this->id = $dt['nmax']+1;
        } else {
            $this->id = 1;
        }
        return $this->id;
    }*/
    
    public function maxValue($field_name)
    {
        $sql2 = "SELECT MAX(timestamp)as maxtime FROM hs_hr_emp_absensi";
        $rs2 = mysqli_query($this->link, $sql2);
        $dt2 = mysqli_fetch_assoc($rs2);
        return $dt2['maxtime'];
    }
}
function mysqli_result($result, $counter, $field_name){
    $dt = mysqli_fetch_field_direct($result, $counter);    
    if ($field_name ==='no_kartu'){
        return $dt['no_kartu'];
    } elseif ($fiels_name==='emp_id') {
        return $dt['emp_id'];
    }else{
        return $dt['emp_name'];    
    }    
}
?>
