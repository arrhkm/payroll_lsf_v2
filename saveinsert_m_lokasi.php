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
  $insertSQL = sprintf("INSERT INTO hs_hr_location (loc_code, loc_name, loc_state, loc_city, loc_add, loc_zip, loc_phone, loc_fax, loc_comments) VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s)",
                       GetSQLValueString($_POST['loc_code'], "text"),
                       GetSQLValueString($_POST['loc_name'], "text"),
					   GetSQLValueString($_POST['loc_state'], "text"),
					   GetSQLValueString($_POST['loc_city'], "text"),
					   GetSQLValueString($_POST['loc_add'], "text"),
					   GetSQLValueString($_POST['loc_zip'], "int"),
					   GetSQLValueString($_POST['loc_phone'], "text"),
					   GetSQLValueString($_POST['loc_fax'], "text"),
					   GetSQLValueString($_POST['loc_comments'], "text"));
                       
             

  //mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysqli_query($link, $insertSQL);

  $insertGoTo = "insert_m_lokasi.php?add=1&edit=0";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
else if (isset($_POST["btn_edit"])) {
	$updateSQL= sprintf("UPDATE hs_hr_location SET loc_name=%s, loc_state=%s, loc_city=%s, loc_add=%s, loc_zip=%s, loc_phone=%s, loc_fax=%s, loc_comments=%s WHERE loc_code=%s",				
						
                       GetSQLValueString($_POST['loc_name'], "text"),
					   GetSQLValueString($_POST['loc_state'], "text"),
					   GetSQLValueString($_POST['loc_city'], "text"),
					   GetSQLValueString($_POST['loc_add'], "text"),
					   GetSQLValueString($_POST['loc_zip'], "int"),
					   GetSQLValueString($_POST['loc_phone'], "text"),
					   GetSQLValueString($_POST['loc_fax'], "text"),
					   GetSQLValueString($_POST['loc_comments'], "text"),
					   GetSQLValueString($_POST['loc_code'], "text"));
	//mysql_select_db($database, $koneksi);
	$result1= mysqli_query($link, $updateSQL);
	$updateGoTo .= "m_lokasi.php";
	if (isset($_SERVER['QUERY_STRING'])) {
		$updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
		$updateGoTo .= $_SERVER['QUERY_STRING'];
	}
	header(sprintf("Location:%s", $updateGoTo));
}
else if ($_REQUEST["delete"]==1) {
			
	$deleteSQL= sprintf("DELETE FROM hs_hr_location WHERE loc_code=%s",
						GetSQLValueString($_REQUEST['loc_code'], "int"));
	//mysql_select_db($database, $koneksi);
	
	$result1= mysql_query($link, $deleteSQL);
	$deleteGoTo .="m_lokasi.php";
	if (isset($_SERVER['QUERY_STRING'])) {
		$deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
		$deleteGoTo .= $_SERVER['QUERY_STRING'];
	}
	header(sprintf("Location:%s", $deleteGoTo));
}
?>

