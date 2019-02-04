<?php
//require_once('connections/CConnect.php');
class Jamsostek {
	public $jml_potongan;	
	//public $db;
	
	public function setdb($query) {		
		//$this->db=$db;
		$rs_potongan=mysqli_query($link, $query);
		$row_potongan=mysqli_fetch_assoc($rs_potongan);		
		$this->setPotongan($row_potongan['pot_jamsostek']);
	}	
	
	public function setPotongan($vjml){		
		$this->jml_potongan=$vjml;
	}
	public function getPotongan() {
		if (empty($this->jml_potongan)){
			return 0;
		}
		else{
			return $this->jml_potongan;
		}
	}
}

?>