<?php
class Jamsostek {
	public $jml_potongan;	
	//public $db;	
	public function setdb($link, $query) {		
		//$this->db=$db;
		//$rs_potongan=$this->db->query($query);
                $rs_potongan = mysqli_query($link, $query);
		//$row_potongan=$this->db->fetch_array($rs_potongan);
                $row_potongan= mysqli_fetch_assoc($rs_potongan);
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