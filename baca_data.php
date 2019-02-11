<?php 
# Koneksi 
require_once('connections/conn_mysqli_procedural.php');

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

    if (($handle = fopen($myFile, "r")) !== FALSE) {
        //ini_set("auto_detect_line_endings", 1);
        $jml=0;
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {                                
            echo $data[0]." - ".$emp_id." - ".$data[2]." - ". $data[3]."<br>";           
            $qry_input = "REPLACE INTO absensi (tgl, emp_id, jam_in, jam_out)
                VALUES ('$data[0]','$data[1]', '$data[2]', '$data[3]')";
            mysqli_query($link, $qry_input);            

            echo "--------------------------------<br>";
            $jml++;
        }
        fclose($handle);

    }
        
}

?>
<input type="button" onclick="myFunction()" value="<?php echo $jml." baris data berhasil dibaca"; ?>">
</body>
</html>