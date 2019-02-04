<?php 
require_once('connections/conn_mysqli_procedural.php');


function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if (isset($_POST["btn_save"]))  {
  $insertSQL = sprintf("INSERT INTO insentif_uang_makan (kd_ium, kd_periode, emp_id, tgl_ium, jml_ium) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['kd_ium'], "int"),
					   GetSQLValueString($_POST['kd_periode'], "int"),
                       GetSQLValueString($_POST['emp_id'], "text"),
					   GetSQLValueString($_POST['tgl_ium'], "text"),
					   GetSQLValueString($_POST['jml_ium'], "decimal"));                       
             
  mysql_select_db($database_koneksi);
  $result1 = mysqli_query($link, $insertSQL) or die(mysqli_error($link));

  $insertGoTo = "insert_insentif_ium.php?kd_periode=$_POST[kd_periode]";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
else if (isset($_POST["btn_edit"])) {
	$updateSQL= sprintf("UPDATE insentif_uang_makan SET kd_periode=%s, emp_id=%s, tgl_ium=%s, jml_ium=%s WHERE kd_ium=%s", 						
            GetSQLValueString($_POST['kd_periode'], "int"),
            GetSQLValueString($_POST['emp_id'], "text"),
            GetSQLValueString($_POST['tgl_ium'], "text"),					
            GetSQLValueString($_POST['jml_ium'], "decimal"),						
            GetSQLValueString($_POST['kd_ium'], "int"));
	
	$result1= mysqli_query($link, $updateSQL) or die (mysqli_error($link));
	$updateGoTo .= "insert_insentif_ium.php?kd_periode=$_POST[kd_periode]";
	if (isset($_SERVER['QUERY_STRING'])) {
		$updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
		$updateGoTo .= $_SERVER['QUERY_STRING'];
	}
	header(sprintf("Location:%s", $updateGoTo));
}
else if ($_REQUEST["delete"]==1) {
			
	$deleteSQL= sprintf("DELETE FROM insentif_uang_makan WHERE kd_ium=%s",
						GetSQLValueString($_REQUEST['kd_ium'], "text"));
	
	
	
	$result1= mysqli_query($link, $deleteSQL) or die (mysqli_error($link));
	$deleteGoTo .="insert_insentif_ium.php?kd_periode=$_REQUEST[kd_periode]";
	if (isset($_SERVER['QUERY_STRING'])) {
		$deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
		$deleteGoTo .= $_SERVER['QUERY_STRING'];
	}
	header(sprintf("Location:%s", $deleteGoTo));
}

?>

