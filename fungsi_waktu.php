<?php
function selisih($jam1,$jam2) {
	list($h,$m,$s) = explode(":",$jam1);
	$dtAwal = mktime($h,$m,$s,"2","2","2");
	list($h,$m,$s) = explode(":",$jam2);
	$dtAkhir= mktime($h,$m,$s,"2","2","2");
	$dtSelisih = $dtAkhir-$dtAwal;
	$totalmenit=$dtSelisih/60;
	$jam =explode(".",$totalmenit/60);
	$sisamenit=($totalmenit/60)-$jam[0];
	$sisamenit2=$sisamenit*60;
	$jml_jam=$jam[0];
	//$hasil=$jaml_jam.$sisamenit2;
	return "$jml_jam:$sisamenit2";
	//return $hasil;	
}
?>