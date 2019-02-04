<?php
//require_once('connections/CConnect.php');
class Potongan{
	public $jml_potongan;	
	public $db;
	
	public function setdb($db, $query) {		
		$this->db=$db;
		$rs_potongan=$this->db->query($query);
		$row_potongan=$this->db->fetch_array($rs_potongan);		
		$this->setPotongan($row_potongan);
	}	
	
	public function setPotongan($vjml){		
		$this->jml_potongan=$vjml;
	}
	public function getPotongan() {
		if (!empty($this->jml_potongan)){
			return $this->jml_potongan;
		}
		else{
			return 0;
		}
	}
}
?>