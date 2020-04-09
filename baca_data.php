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
            echo $data[0]." , ".$data[1]." , ".$data[2]." , ". $data[3]."<br>";  
            $tgl = $data[0];
            $emp_id = $data[1];
            $jam_in = $data[2];
            $jam_out = $data[3];         
            /*$qry_input = "REPLACE INTO absensi (tgl, emp_id, jam_in, jam_out)
                VALUES ($data[0], $data[1],  $data[2], $data[3])";
            mysqli_query($link, $qry_input);            
          */
            echo "--------------------------------<br>";
            $jml++;
            if (mysqli_query($link, "REPLACE INTO absensi (tgl, emp_id, jam_in, jam_out) VALUES ('$tgl', '$emp_id', '$jam_in', '$jam_out')")){
              echo "success";

            }else { 
              echo "Gagal";
            }
        }
        //mysqli_query($link, "REPLACE INTO absensi (tgl, emp_id, jam_in, jam_out) VALUES ('2020-03-30', 'POB012', '08:01:06', '24:00:00')");
        
        fclose($handle);

    }
        
}

?>
<input type="button" onclick="myFunction()" value="<?php echo $jml." baris data berhasil dibaca"; ?>">
</body>
</html>