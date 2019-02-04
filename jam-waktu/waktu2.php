<?php
echo "Jam Masuk : ".$jam_masuk="01:00:00";
echo "<br>";
echo "Jam Keluar : ".$jam_keluar="24:10";
echo "<br>";
function selisih($jam1,$jam2) {
	list($h,$m,$s) = explode(":",$jam1);
	$dtAwal = mktime($h,$m,$s,"1","1","1");
	list($h,$m,$s) = explode(":",$jam2);
	$dtAkhir = mktime($h,$m,$s,"1","1","1");
	$dtSelisih = $dtAkhir-$dtAwal;
	$totalmenit=$dtSelisih/60;
	$jam =explode(".",$totalmenit/60);
	$sisamenit=($totalmenit/60)-$jam[0];
	$sisamenit2=$sisamenit*60;
	$jml_jam=$jam[0];
	//$jam=$jml_jam;
	//$menit=$sisamenit2;
	//echo $jam;
	//echo $menit;
	return $jml_jam.$sisamenit2;
	//return $jml_jam." jam ".$sisamenit2." menit";
	//return $jml_jam;
	//return $sisamenit2;
}
$waktuku=selisih($jam_masuk,$jam_keluar);
echo "WAktu Kerja : ".selisih($jam_masuk,$jam_keluar);
echo "<br>jam  :".SUBSTR($waktuku,0,-2)."<br>";
echo "Menit    :".SUBSTR($waktuku, -2)."<br>";
list($h,$m,$s)= explode(":",$jam_masuk);
$dt_x= mktime($h,$m,$s,"1","1","1");
$dt_y=explode(":","07:00:00");
echo "Mktime    :".$dt_y[2]."<br>";
?>