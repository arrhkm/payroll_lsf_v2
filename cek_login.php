<?php
session_start();
if (!isset($_SESSION['user_name']) or ($_SESSION['user_level']<1))
{
	header("location:login.php");
	//header(location:javascript:void window.open('login.php','1395882331015','width=400,height=500,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=500,top=300');return false;);
	//echo "user name : ".$_SESSION['user_name']. " level : ". $_SESSION[user_level];
}
//if ($_SESSION[user_level]!=1)
//{
	//header("location:login.php");
//}

?>