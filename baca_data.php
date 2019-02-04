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
	//$pemisah=",";
	//ini_set("auto_detect_line_endings", 1);   // lakukan ini_set SEBELUM fopen file
	//$datacsv = fopen($myFile, "r");
	// lakukan while loop seperti biasa
        /*
	while (($data = fgetcsv($datacsv,10000, $pemisah)) !== FALSE)
	{
            $jml++;
	   // proses data seperti biasa, data berupa array kolom per baris
	   //echo "$data[0] / $data[1] / $data[2] / $data[3]<br>";
	   //$qry_input = "REPLACE INTO absensi (tgl, emp_id, jam_in, jam_out, loc_code) VALUES ('$data[0]', '$data[1]', '$data[2]', '$data[3]', 'LSF')";
           $qry_input = "REPLACE INTO absensi SET tgl='$data[0]', emp_id = '$data[1]', jam_in = '$data[2]', jam_out='$data[3]', loc_code ='LSF')";
	   /*if (mysqli_query($link, $qry_input)){
               echo "berhasil";
               
           }else echo "Gagal bosss";
            
            
           //array_push($dtlog, ['tgl'=>$data[0], 'emp_id'=>$data[1], 'jam_in'=>$data[2], 'jam_out'=>data[3]]);
	}
        var_dump($data);*/
//fclose($datacsv);
//echo "<SCRIPT>alert onclick ='myFunction()' ('".$jml." baris data berhasil dibaca');</SCRIPT>";
        
        //---------------------------
        
        if (($handle = fopen($myFile, "r")) !== FALSE) {
            //ini_set("auto_detect_line_endings", 1);
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) { 
                $emp_id = $data[1];
                echo $emp_id." adalah :".gettype($emp_id)."<br>";
                echo $data[0]." - ".$emp_id." - ".$data[2]." - ".$data[3]."<br>";               
                $qry_input="REPLACE INTO absensi SET tgl ='$data[0]', emp_id='".$data[1]."', jam_in='$data[2]', jam_out='$data[3]', loc_code='LSF'";
                mysqli_query($link, $qry_input);
                
                echo "--------------------------------<br>";
                
            }
            fclose($handle);
            
        }
        

}
$rs= mysqli_query($link, "select * from absensi where emp_id = 'LSF180' and tgl between '2019-01-28' and '2019-01-30'");
            while($dtku = mysqli_fetch_assoc($rs)){
                    echo "data :".$dtku['tgl']." - ".$dtku['emp_id']." - ".$dtku['jam_in']." - ".$dtku['jam_out']."<br>";
            }
?>
<input type="button" onclick="myFunction()" value="<?php echo $jml." baris data berhasil dibaca"; ?>">
</body>
</html>