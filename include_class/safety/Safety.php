<?php
//require_once('connections/CConnect.php');
class Safety{
	public $emp_id;
	public $tgl;
	public $jml_potongan;
	public $numrow;
	public $logika;
	//public $db;
	
	//public function setdb($db, $query, $vlogika) {
        public function setdb($link, $query, $vlogika) {
		$this->logika=$vlogika;
		//$this->db=$db;
		//$rs_safety=$this->db->query($query);
                $rs_safety = mysqli_query($link, $query);
		//$row_safety=$this->db->fetch_array($rs_safety);
                $row_safety = mysqli_fetch_assoc($rs_safety);
		//$num_row=$this->db->num_rows($rs_safety);
                $num_row = mysqli_num_rows($rs_safety);		
                $this->setPotongan($row_safety['emp_id'], $row_safety['tgl_safety'], $row_safety['jml_safety'], $num_row );
	}
	
	
	public function setPotongan($vemp_id, $vtgl, $vjml, $vnumrow){
		$this->emp_id=$vemp_id;
		$this->tgl=$vtgl;
		$this->jml_potongan=$vjml;
		$this->numrow=$vnumrow;
		
	}
	public function getPotongan() {
		if ($this->numrow >0){
			if ($this->logika=="awal") {
				$potongan=0;
			}
			else {
				$potongan= $this->jml_potongan;
			}
		}else {
			$potongan= 0;
		}
		return $potongan;
	}
}
?>