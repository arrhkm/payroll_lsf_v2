<?php 
#Koneksi 
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

	$SQLlama="SELECT timestampdiff(DAY, '$_POST[start_kontrak]', '$_POST[end_kontrak]') as lama_kontrak";
	$RSlama=mysqli_query($link, $SQLlama);
	$ROWlama=mysqli_fetch_assoc($RSlama);
  $insertSQL = sprintf("INSERT INTO kontrak_kerja (id_kontrak, emp_id, no_kontrak, start_kontrak, end_kontrak, lama_kontrak) 
  VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id_kontrak'], "text"),
					   GetSQLValueString($_POST['emp_id'], "text"),
					   GetSQLValueString($_POST['no_kontrak'], "text"),                       
					   GetSQLValueString($_POST['start_kontrak'], "date"),
					   GetSQLValueString($_POST['end_kontrak'],"date"),
					   GetSQLValueString($ROWlama['lama_kontrak'],"text"));
                       
             

 
  $Result1 = mysqli_query($link, $insertSQL) or die(mysqli_error($link));

  $insertGoTo = "insert_contract.php?add=1&edit=0&emp_id=$_POST[emp_id]";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
else if (isset($_POST["btn_edit"])) {
	$SQL_lama="SELECT timestampdiff(MONTH, end_contract, start_contract) as lama_contract";
	$RS_lama=mysqli_query($link, $SQL_lama);
	$ROW_lama=mysqli_fetch_assoc($RS_lama);
	$updateSQL= sprintf("UPDATE employee SET emp_name=%s, start_contract=%s, end_contract=%s, lama_contract=%s WHERE emp_id=%s", 						
						GetSQLValueString($_POST['emp_name'], "text"),
						GetSQLValueString($_POST['start_contract'], "date"),
						GetSQLValueString($_POST['end_contract'], "date"),
						GetSQLValueString($ROW_lama['lama_contract'], "number"),
						GetSQLValueString($_POST['emp_id'], "text"));
	
	$result1= mysqli_query($link, $updateSQL) or die (mysqli_error($link));
	$updateGoTo .= "contract.php";
	if (isset($_SERVER['QUERY_STRING'])) {
		$updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
		$updateGoTo .= $_SERVER['QUERY_STRING'];
	}
	header(sprintf("Location:%s", $updateGoTo));
	
}
else if ($_REQUEST['delete']==1) {
	$SQLdelete="DELETE FROM kontrak_kerja WHERE id_kontrak = $_GET[id_kontrak]";
	$result1= mysqli_query($link, $SQLdelete) or die (mysqli_error($link));
	$updateGoTo .= "insert_contract.php?emp_id=P001";
	if (isset($_SERVER['QUERY_STRING'])) {
		$updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
		$updateGoTo .= $_SERVER['QUERY_STRING'];
	}
	header(sprintf("Location:%s", $updateGoTo));
}
?>

