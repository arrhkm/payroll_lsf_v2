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
  $insertSQL = sprintf("INSERT INTO insentif_overjam (kd_ijam, kd_periode, emp_id, tgl_ijam, jml_ijam) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['kd_ijam'], "int"),
					   GetSQLValueString($_POST['kd_periode'], "int"),
                       GetSQLValueString($_POST['emp_id'], "text"),
					   GetSQLValueString($_POST['tgl_ijam'], "text"),
					   GetSQLValueString($_POST['jml_ijam'], "decimal"));                       
             

  $result1 = mysqli_query($link, $insertSQL) or die(mysqli_error($link));

  $insertGoTo = "insert_insentifjam.php?kd_periode=$_POST[kd_periode]";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
else if (isset($_POST["btn_edit"])) {
	$updateSQL= sprintf("UPDATE insentif_overjam SET kd_periode=%s, emp_id=%s, tgl_ijam=%s, jml_ijam=%s WHERE kd_ijam=%s", 						
            GetSQLValueString($_POST['kd_periode'], "int"),
            GetSQLValueString($_POST['emp_id'], "text"),
            GetSQLValueString($_POST['tgl_ijam'], "text"),					
            GetSQLValueString($_POST['jml_ijam'], "decimal"),						
            GetSQLValueString($_POST['kd_ijam'], "int"));
	;
	$result1= mysqli_query($link, $updateSQL) or die (mysqli_error($link));
	$updateGoTo .= "insert_insentifjam.php?kd_periode=$_POST[kd_periode]";
	if (isset($_SERVER['QUERY_STRING'])) {
		$updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
		$updateGoTo .= $_SERVER['QUERY_STRING'];
	}
	header(sprintf("Location:%s", $updateGoTo));
}
else if ($_REQUEST["delete"]==1) {
			
	$deleteSQL= sprintf("DELETE FROM insentif_overjam WHERE kd_ijam=%s",
						GetSQLValueString($_REQUEST['kd_ijam'], "text"));
	
	
	
	$result1= mysqli_query($link, $deleteSQL) or die (mysqli_error($link));
	$deleteGoTo .="insert_insentifjam.php?kd_periode=$_REQUEST[kd_periode]";
	if (isset($_SERVER['QUERY_STRING'])) {
		$deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
		$deleteGoTo .= $_SERVER['QUERY_STRING'];
	}
	header(sprintf("Location:%s", $deleteGoTo));
}

?>

