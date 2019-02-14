<?php 
# Koneksi 
require_once('connections/koneksi.php');
# select DB 
mysql_select_db($database_koneksi, $koneksi);
?>
<html>
<body>
<script>
function myFunction()
{
	var r=confirm("Press a button");
	if (r==true)
	  {
		//x="You pressed OK!";
		window.location.href = "./upload_file_absen.php"
	  }
	else
	  {
	  x="You pressed Cancel!";
	  } 
}
</script>
<?php
//------------------------------------------------
// Program FIX
if (!empty($_FILES["filecsv"]["tmp_name"]))
{
	$myFile = $_FILES['filecsv']['tmp_name'];
	$pemisah=",";
	ini_set("auto_detect_line_endings", 1);   // lakukan ini_set SEBELUM fopen file
	$datacsv = fopen($myFile, "r");
	// lakukan while loop seperti biasa
	while (($data = fgetcsv($datacsv,10000, $pemisah)) !== FALSE)
	{
		$jml++;
	   // proses data seperti biasa, data berupa array kolom per baris
	   //echo "$data[0] / $data[1] / $data[2] / $data[3]<br>";
	   $qry_input = "REPLACE INTO absensi (tgl, emp_id, ket_absen, loc_code) VALUES ('$data[0]', '$data[1]', '$data[2]', 'LDP_LOC001')";
	   $rs_input = mysql_query($qry_input, $koneksi) or die(mysql_error());
	}
fclose($datacsv);
//echo "<SCRIPT>alert onclick ='myFunction()' ('".$jml." baris data berhasil dibaca');</SCRIPT>";

}

?>
<input type="button" onclick="myFunction()" value="<?php echo $jml." baris data berhasil dibaca"; ?>">
</body>
</html>