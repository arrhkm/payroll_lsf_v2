<?php require_once('connections/conn_mysqli_procedural.php'); ?>
<?php
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
  $insertSQL = sprintf("INSERT INTO cicilan_kasbon (kd_cicilan, kd_kasbon, kd_periode, jml_cicilan) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['kd_cicilan'], "int"),
                       GetSQLValueString($_POST['kd_kasbon'], "int"),
					   GetSQLValueString($_POST['kd_periode'], "int"),
					   GetSQLValueString($_POST['jml_cicilan'], "decimal"));                       
             
  
  $Result1 = mysqli_query($link, $insertSQL) or die(mysqli_error($link));
  //echo "$_POST[kd_cicilan] - $_POST[kd_kasbon] - $_POST[kd_periode] - $_POST[jml_cicilan]";
  $insertGoTo = "add_cicilan_kasbon.php?add=1&kd_kasbon=$_POST[kd_kasbon]";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
else if (isset($_POST["btn_edit"])) {
	$updateSQL= sprintf("UPDATE cicilan_kasbon SET kd_periode=%s, jml_cicilan=%s WHERE kd_cicilan=%s", 				
						GetSQLValueString($_POST['kd_periode'], "int"),
						GetSQLValueString($_POST['jml_cicilan'], "decimal"),
						GetSQLValueString($_POST['kd_cicilan'], "int"));
	
	$result1= mysqli_query($link, $updateSQL) or die (mysqli_error($link));
	$updateGoTo .= "add_cicilan_kasbon.php?add=1&kd_kasbon=$_POST[kd_kasbon]";
	if (isset($_SERVER['QUERY_STRING'])) {
		$updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
		$updateGoTo .= $_SERVER['QUERY_STRING'];
	}
	header(sprintf("Location:%s", $updateGoTo));
}
else if ($_REQUEST["delete"]==1) {
			
	$deleteSQL= sprintf("DELETE FROM cicilan_kasbon WHERE kd_cicilan=%s",
						GetSQLValueString($_REQUEST['kd_cicilan'], "int"));
	
	
	$result1= mysqli_query($link, $deleteSQL) or die (mysqli_error($link));
	$deleteGoTo .="add_cicilan_kasbon.php?add=1&kd_kasbon=$_REQUEST[kd_kasbon]";
	if (isset($_SERVER['QUERY_STRING'])) {
		$deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
		$deleteGoTo .= $_SERVER['QUERY_STRING'];
	}
	header(sprintf("Location:%s", $deleteGoTo));
}

?>

