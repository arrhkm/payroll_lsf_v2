<?php require_once('connections/koneksi.php'); ?>
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
  $insertSQL = sprintf("INSERT INTO cabang (kd_cabang, nama_cabang) VALUES (%s, %s)",
                       GetSQLValueString($_POST['kd_cabang'], "int"),
                       GetSQLValueString($_POST['nama_cabang'], "text"));
                       
             

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($insertSQL, $koneksi) or die(mysql_error());

  $insertGoTo = "Insert_mCabang.php?add=1&edit=0";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
else if (isset($_POST["btn_edit"])) {
	$updateSQL= sprintf("UPDATE cabang SET nama_cabang=%s WHERE kd_cabang=%s", 						
						GetSQLValueString($_POST['nama_cabang'], "text"),
						GetSQLValueString($_POST['kd_cabang'], "int"));
	mysql_select_db($database, $koneksi);
	$result1= mysql_query($updateSQL, $koneksi) or die (mysql_error());
	$updateGoTo .= "mCabang.php";
	if (isset($_SERVER['QUERY_STRING'])) {
		$updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
		$updateGoTo .= $_SERVER['QUERY_STRING'];
	}
	header(sprintf("Location:%s", $updateGoTo));
}
else if ($_REQUEST["delete"]==1) {
	$deleteSQL= sprintf("DELETE FROM cabang WHERE kd_cabang=%s",
						GetSQLValueString($_REQUEST['kd_cabang'], "int"));
	mysql_select_db($database, $koneksi);
	$result1= mysql_query($deleteSQL, $koneksi) or die (mysql_error());
	$deleteGoTo .="mCabang.php";
	if (isset($_SERVER['QUERY_STRING'])) {
		$deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
		$deleteGoTo .= $_SERVER['QUERY_STRING'];
	}
	header(sprintf("Location:%s", $deleteGoTo));
}
?>

