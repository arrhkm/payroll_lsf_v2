<?php
require_once('include_class/durasi/Durasi.php');
require_once('include_class/periode/Periode.php');
require_once('include_class/periode/DayPeriode.php');
require_once('include_class/gaji/Gaji.php');
require_once('include_class/tunjangan/Tunjangan.php');
require_once('include_class/tunjangan/Tjam12.php');
require_once('include_class/kasbon/Kasbon.php');
require_once('include_class/safety/Safety.php');
require_once('include_class/jamsostek/Jamsostek.php');
require_once('include_class/plusmin/Plusmin.php');
require_once('include_class/gaji/Grandtotal.php');
Class Employee {
	public $emp_id;
	public $emp_name;
	public $gaji_pokok;	
	public $jamsos;	
	public $tjam12;
	public $tmasakerja;
	public $jabatan;
	public $norekening;
	public $emp_group;
        public $pot_telat;
	
	//public $Periode;
	public function __construct() {
		$this->Durasi = New Durasi();
		$this->Periode = New Periode();
		$this->DayPeriode = New DayPeriode();
		$this->Gaji = New Gaji();
		$this->Tunjangan = New Tunjangan();
		$this->Tjam = New Tjam12();
		$this->Kasbon = New Kasbon();
		$this->Safety = New Safety();
		$this->Jamsostek = New Jamsostek();
		$this->Plusmin = New Plusmin();
		$this->Grandtotal = New Grandtotal();
	}
	public function setEmp($vemp_id, $vemp_name, $vjamsos, $vgaji_pokok, $vtjam12, $vtmasakerja, $vjabatan, $vnorekening, $vemp_group, $vpot_telat) {
	
		$this->emp_id=$vemp_id;
		$this->emp_name=$vemp_name;
		$this->jamsos=$vjamsos;
		$this->gaji_pokok=$vgaji_pokok;	
		$this->tjam12=$vtjam12;	
		$this->tmasakerja=$vtmasakerja;
		$this->jabatan=$vjabatan;
		$this->norekening=$vnorekening;
		$this->emp_group=$vemp_group;
                $this->pot_telat=$vpot_telat;
	}
	public function getEmp(){
		return $this->emp_name;
	}
}
?>