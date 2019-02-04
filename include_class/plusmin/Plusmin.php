<?php
//require_once('connections/CConnect.php');
class Plusmin{
	//public $db;
	public $jml_plus;
	public $jml_min;

	public function setdbPlusmin($link, $query){
		//$this->db=$db;
		$rs_plusmin=mysqli_query($link, $query);
		$row_plusmin=mysqli_fetch_assoc($rs_plusmin);
		
		$this->jml_plus=$row_plusmin['jml_plus'];
		$this->jml_min=$row_plusmin['jml_min'];
	}
	public function getPlus(){
		if (empty($this->jml_plus)) {
			return 0;
		} else {
			return $this->jml_plus;
		}
	}
	public function getMin(){
		if (empty($this->jml_min)) {
			return 0;
		} else {
			return $this->jml_min;
		}
	}
}
?>