<html>
<head>
	<title>Jam Database -- Ri32</title>
</head>
</html>
<h1>Jam Kerja Karwayan</h1>
<?php
include "koneksi.php";
$query=mysql_query("select * from waktu_kerja");


while($row=mysql_fetch_array($query)){
	$nama_pegawai=$row['nama_pegawai'];
	$jam_masuk=$row['jam_masuk'];
	$jam_keluar=$row['jam_keluar'];
	
	echo "Nama : ".$nama_pegawai;
	echo "<br>";
	echo "Jam Masuk : ".$jam_masuk;
	echo "<br>";
	echo "Jam Keluar : ".$jam_keluar;
	echo "<br>";
	echo "<b>Waktu Kerja : </b> ".selisih($jam_masuk,$jam_keluar);
	echo "<br>";
	echo "<hr>";

}

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
?>
<a href="waktu.php">Lihat Waktu</a>