<html>
<head>
<title>Fungsi Waktu -- Ri32</title>
</head>
</html>
<?php
echo "Jam Mulai : ".$jam_mulai='08:30:09';
echo "<br>";
echo "Jam Selesai : ".$jam_selesai='09:45:01';
echo "<br>";
$times = array($jam_mulai,$jam_selesai);
//$times = array('08:30:22','09:45:53');
$seconds = 0;
foreach ( $times as $time )
{
	list( $g, $i, $s ) = explode( ':', $time );
	$seconds += $g * 3600;
	$seconds += $i * 60;
	$seconds += $s;
}
$hours = floor( $seconds / 3600 );
$seconds -= $hours * 3600;
$minutes = floor( $seconds / 60 );
$seconds -= $minutes * 60;
echo "Hasil penjumlahan : {$hours}:{$minutes}:{$seconds}";
echo "<hr>";






$tambahwaktu = date("d F Y", mktime(0,0,0,date("m"),date("d")+3,date("Y"))); 
/*menghasilkan 27 February 2002*/
echo ("Tiga hari yg akan datang jatuh pada tgl $tambahwaktu");
echo "<hr>";
$kurangtanggal = date("d F Y", mktime(0,0,0,date("m"),date("d")-14,date("Y"))); 
/*menghasilkan 10 February 2002*/
echo ("Dua minggu yg lalu jatuh pada tgl $kurangtanggal");
echo "<hr>";






echo "Jam Masuk : ".$jam_masuk="08:30:09";
echo "<br>";
echo "Jam Keluar : ".$jam_keluar="09:45:01";
echo "<br>";
function selisih($jam_masuk,$jam_keluar) {
	list($h,$m,$s) = explode(":",$jam_masuk);
	$dtAwal = mktime($h,$m,$s,"1","1","1");
	list($h,$m,$s) = explode(":",$jam_keluar);
	$dtAkhir = mktime($h,$m,$s,"1","1","1");
	$dtSelisih = $dtAkhir-$dtAwal;
	$totalmenit=$dtSelisih/60;
	$jam =explode(".",$totalmenit/60);
	$sisamenit=($totalmenit/60)-$jam[0];
	$sisamenit2=$sisamenit*60;
	$jml_jam=$jam[0];
	return $jml_jam." jam ".$sisamenit2." menit";
}
echo "WAktu Kerja : ".selisih($jam_masuk,$jam_keluar);


?>
