<?php
session_start();
require_once ('connections/conn_mysqli_procedural.php');
//var_dump($_POST);

if (isset($_POST['login']))
{
	$sql_cek="SELECT * FROM user_admin WHERE user_name='$_POST[txt_username]' AND user_password=md5('$_POST[txt_password]')";
	
        $rs_cek = mysqli_query($link, $sql_cek);

        if (mysqli_num_rows($rs_cek) > 0 )
	{
            $dt_cek=mysqli_fetch_assoc($rs_cek);
            $_SESSION['user_name']=$dt_cek['user_name'];
            $_SESSION['user_pasword']=md5($_POST['txt_password']);
            $_SESSION['user_level']=$dt_cek['user_level'];		
            header("location:index.php");

	}
	else{
            header("location:login.php?msg=0");
        }
}
else if (empty($_POST['txt_username'])) 
header("location:login.php?mslog=1");
else if (empty($_POST['txt_password'])) 
header("location:login.php?msg=2");
mysqli_close($link);

?>