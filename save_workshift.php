<?php require_once('connections/conn_mysqli_procedural.php');

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
  $insertSQL = sprintf("INSERT INTO workshift (id_workshift, name_shift) VALUES (%s, %s)",
                       GetSQLValueString($_POST['id_workshift'], "int"),
                       GetSQLValueString($_POST['name_shift'], "text"));
                       
             

 
  mysqli_query($link, $insertSQL);

  $insertGoTo = "m_workshift.php?add=1&edit=0";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
else if (isset($_POST["btn_edit"])) {
	$updateSQL= sprintf("UPDATE workshift SET name_shift=%s WHERE id_workshift=%s", 						
						GetSQLValueString($_POST['name_shift'], "text"),
						GetSQLValueString($_POST['id_workshift'], "int"));
	
	$result1= mysqli_query($link, $updateSQL);
	$updateGoTo .= "m_workshift.php";
	if (isset($_SERVER['QUERY_STRING'])) {
		$updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
		$updateGoTo .= $_SERVER['QUERY_STRING'];
	}
	header(sprintf("Location:%s", $updateGoTo));
}
else if ($_REQUEST["delete"]==1) {
			
	$deleteSQL= sprintf("DELETE FROM workshift WHERE id_workshift=%s",
						GetSQLValueString($_REQUEST['id_workshift'], "int"));
	$deleteSQL2= sprintf("DELETE FROM detil_workshift WHERE id_workshift=%s",
						GetSQLValueString($_REQUEST['id_workshift'], "int"));
	
	$result1= mysqli_query($link, $deleteSQL);
	$result2= mysqli_query($link, $deleteSQL2);
	$deleteGoTo .="m_workshift.php";
	if (isset($_SERVER['QUERY_STRING'])) {
		$deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
		$deleteGoTo .= $_SERVER['QUERY_STRING'];
	}
	header(sprintf("Location:%s", $deleteGoTo));
}
?>

