<?php 
# Koneksi 
require_once('../connections/CConnect.php');
$db=New Database();
$db->connect();
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
		window.location.href = "./set_emp_gaji.php"
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
	   $qry_input = "UPDATE employee SET gaji_pokok = '$data[1]' WHERE emp_id='$data[0]'";
	   $db->query($qry_input) or die(mysql_error());
	}
fclose($datacsv);
//echo "<SCRIPT>alert onclick ='myFunction()' ('".$jml." baris data berhasil dibaca');</SCRIPT>";
}
?>
<input type="button" onclick="myFunction()" value="<?php echo $jml." baris data berhasil dibaca"; ?>">
</body>
</html>