<?php 

//namespace connections;

 $host = "localhost";
 $db = "ldp";
 $user = "hkm";
 $passwd = "hkm";
 //-----------------------------
$conn = new mysqli($host, $user, $passwd, $db);
/*
$sql_cek="SELECT * FROM user_admin WHERE user_name='hakam' AND user_password=md5('hakam')";
	
$result = $con->query($sql_cek);

if ($result->num_rows > 0 ){
    echo "Ada <br>";
} else echo "Tidak ada";

while ($dt = $result->fetch_assoc()) 
{
    echo $dt['user_name']." - ".$dt['user_level']." - ".$dt['user_password'];
}
*/



?>