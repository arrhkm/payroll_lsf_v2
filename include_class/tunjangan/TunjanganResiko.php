<?php 

class TunjanganResiko {

	//public $link;
	public $emp_id;
	public $tgl_ini;
	public $link;
	public $period_awal;
	public $period_akhir;
	

	public function __construct(){
		
	}
	public function setTunjanganResiko($link, $emp_id, $period_awal, $period_akhir){
		$this->emp_id = $emp_id; 
		//$this->selisih = $selisih;
		$this->period_awal= $period_awal;
		$this->period_akhir = $period_akhir;
		$this->link = $link;
	}
	public function getTunjanganResiko($tgl_ini){		
		//mysqli_select_db($link, "lsf_payroll");
		$sql = "SELECT * FROM insentif_resiko WHERE employee_emp_id = '$this->emp_id' AND date_insentif = '$tgl_ini'";
		$rs_risk = mysqli_query($this->link, $sql);
		$row_risk = mysqli_fetch_assoc($rs_risk);
		return $row_risk['value'];
	}

	public function getTunjanganResikoPeriod(){
		//$arr = ['2019-11-14', '2019-11-15', '2019-11-16'];
		//$data = implode(',',$arr);
		//$data = ".$data.";

		$sql = "SELECT SUM(a.value) as total
		FROM lsf_payroll.insentif_resiko a
		WHERE a.employee_emp_id='$this->emp_id'
		AND a.date_insentif BETWEEN '$this->period_awal' AND '$this->period_akhir'
		GROUP BY a.employee_emp_id";
		if ($rs = mysqli_query($this->link, $sql)){
			$row = mysqli_fetch_assoc($rs);
			return $row['total'];			
		}
		else return Null;
	}
}