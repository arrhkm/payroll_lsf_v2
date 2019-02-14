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
            $theValue = ($theValue != "") ? intval($theValue) : "NULL";
            break;
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
    
    $insertSQL = sprintf("INSERT INTO plusmin_gaji (kd_plusmin, kd_periode, emp_id, tgl_plusmin, jml_plus, jml_min, ket) VALUES (%s, %s, %s, %s, %s, %s, %s)",
          GetSQLValueString($_POST['kd_plusmin'], "int"),
          GetSQLValueString($_POST['kd_periode'], "int"),
          GetSQLValueString($_POST['emp_id'], "text"),
          GetSQLValueString($_POST['tgl_plusmin'], "text"),
          GetSQLValueString($_POST['jml_plus'], "decimal"),
          GetSQLValueString($_POST['jml_min'], "decimal"),
          GetSQLValueString($_POST['ket'], "text"));                       


    $result1 = mysqli_query($link, $insertSQL) or die(mysqli_error($link));

    $insertGoTo = "create_plusmin.php?";
    if (isset($_SERVER['QUERY_STRING'])) {
      $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
      $insertGoTo .= $_SERVER['QUERY_STRING'];
    }
    header(sprintf("Location: %s", $insertGoTo));
     
    //var_dump($_POST);
}
else if (isset($_POST["btn_edit"])) {
	$updateSQL= sprintf("UPDATE plusmin_gaji SET kd_periode=%s, emp_id=%s, tgl_plusmin=%s, jml_plus=%s, jml_min=%s, ket=%s WHERE kd_plusmin=%s", 						
						GetSQLValueString($_POST['kd_periode'], "int"),
						GetSQLValueString($_POST['emp_id'], "text"),
						GetSQLValueString($_POST['tgl_plusmin'], "text"),					
						GetSQLValueString($_POST['jml_plus'], "decimal"),
						GetSQLValueString($_POST['jml_min'], "decimal"),						
						GetSQLValueString($_POST['ket'], "text"),
						GetSQLValueString($_POST['kd_plusmin'], "int"));
	
	$result1= mysqli_query($link, $updateSQL) or die (mysqli_error($link));
	$updateGoTo .= "create_plusmin.php?";
	if (isset($_SERVER['QUERY_STRING'])) {
		$updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
		$updateGoTo .= $_SERVER['QUERY_STRING'];
	}
	header(sprintf("Location:%s", $updateGoTo));
}
else if ($_REQUEST["delete"]==1) {
			
	$deleteSQL= sprintf("DELETE FROM plusmin_gaji WHERE kd_plusmin=%s",
						GetSQLValueString($_REQUEST['kd_plusmin'], "text"));
	
	
	
	$result1= mysqli_query($link, $deleteSQL) or die (mysqli_error($link));
	$deleteGoTo .="create_plusmin.php";
	if (isset($_SERVER['QUERY_STRING'])) {
		$deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
		$deleteGoTo .= $_SERVER['QUERY_STRING'];
	}
	header(sprintf("Location:%s", $deleteGoTo));
}
?>

