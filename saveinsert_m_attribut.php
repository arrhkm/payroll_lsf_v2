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
    $insertSQL = sprintf("INSERT INTO attribut_payroll (kd_attribut, nama_project, nama_staff, safety_talk, hrd_manager, deputi, director, mng_operasional) 
    VALUES (%s,%s,%s,%s,%s,%s,%s,%s)",
    GetSQLValueString($_POST['kd_attribut'], "int"),
    GetSQLValueString($_POST['nama_project'], "text"),
    GetSQLValueString($_POST['nama_staff'], "text"),
    GetSQLValueString($_POST['safety_talk'], "decimal"),
    GetSQLValueString($_POST['hrd_manager'], "text"),
    GetSQLValueString($_POST['deputi'], "text"),
    GetSQLValueString($_POST['director'], "text"),
    GetSQLValueString($_POST['mng_operasional'], "text"));                       
             
    $Result1 = mysqli_query($link, $insertSQL);

    $insertGoTo = "m_attribut.php?add=1&edit=0";
    if (isset($_SERVER['QUERY_STRING'])) {
        $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
        $insertGoTo .= $_SERVER['QUERY_STRING'];
    }
    header(sprintf("Location: %s", $insertGoTo));
}
else if (isset($_POST["btn_edit"])) {
	$updateSQL= sprintf("UPDATE attribut_payroll 
            SET nama_project=%s, 
            nama_staff=%s, 
            safety_talk=%s, 
            hrd_manager=%s, 
            deputi=%s, 
            director=%s, 
            mng_operasional=%s 
            WHERE kd_attribut=%s",				
            GetSQLValueString($_POST['nama_project'], "text"),
            GetSQLValueString($_POST['nama_staff'], "text"),
            GetSQLValueString($_POST['safety_talk'], "decimal"),
            GetSQLValueString($_POST['hrd_manager'], "text"),
            GetSQLValueString($_POST['deputi'], "text"),
            GetSQLValueString($_POST['director'], "text"),
            GetSQLValueString($_POST['mng_operasional'], "text"),
            GetSQLValueString($_POST['kd_attribut'], "int"));
//mysql_select_db($database, $koneksi);
	$result1= mysqli_query($link, $updateSQL);
	$updateGoTo .= "m_attribut.php";
	if (isset($_SERVER['QUERY_STRING'])) {
		$updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
		$updateGoTo .= $_SERVER['QUERY_STRING'];
	}
	header(sprintf("Location:%s", $updateGoTo));
}
else if ($_REQUEST["delete"]==1) {
			
	$deleteSQL= sprintf("DELETE FROM attribut_payroll WHERE kd_attribut=%s",
						GetSQLValueString($_REQUEST['kd_attribut'], "int"));
	//mysql_select_db($database, $koneksi);
	
	$result1= mysqli_query($link, $deleteSQL);
	$deleteGoTo .="m_attribut.php";
	if (isset($_SERVER['QUERY_STRING'])) {
		$deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
		$deleteGoTo .= $_SERVER['QUERY_STRING'];
	}
	header(sprintf("Location:%s", $deleteGoTo));
}
?>

