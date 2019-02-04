<?php
session_start();
require_once ('connections/conn_mysqli.php');

//$koneksi = mysql_pconnect($hostname_koneksi, $username_koneksi, $password_koneksi);

//mysql_select_db($database_koneksi, $koneksi);
/*
$host = "localhost";
$db = "ldp";
$user = "hkm";
$passwd = "hkm";
 //-----------------------------
$con = new mysqli($host, $user, $passwd, $db);
*/
if (isset($_POST['login']))
{
	//$sql_cek="SELECT * FROM user_admin WHERE user_name=".$_POST['txt_username']."  AND user_password=md5(".$_POST['txt_password'].")";
	$sql_cek="SELECT * FROM user_admin WHERE user_name='$_POST[txt_username]' AND user_password=md5('$_POST[txt_password]')";
	
	//$rs_cek= $con->query($sql_cek);
        $rs_cek = $conn->query($sql_cek);

        if ($rs_cek->num_rows > 0 )
	//if ($rs_cek->num_rows > 0)
	{
		$dt_cek=$rs_cek->fetch_assoc();
		//while ($dt_cek = $rs_cek->fetch_assoc()){
			$_SESSION['user_name']=$dt_cek['user_name'];
			$_SESSION['user_pasword']=md5($_POST['txt_password']);
			$_SESSION['user_level']=$dt_cek['user_level'];
		//}
		
		
		//echo "User : ".$dt_cek[user_name]." Level :". $dt_cek[user_level];echo "sucseesss";
		header("location:index.php");
		
	}
	else
	//$conn->close();
	header("location:login.php?msg=0");
}
else if (empty($_POST['txt_username'])) 
header("location:login.php?mslog=1");
else if (empty($_POST['txt_password'])) 
header("location:login.php?msg=2");
$conn->close();
?>