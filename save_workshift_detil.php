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
  $insertSQL = sprintf("INSERT INTO workshift_detil (num_day, id_workshift, logika, office_in, office_out) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['num_day'], "int"),
					   GetSQLValueString($_POST['id_workshift'], "int"),
                       GetSQLValueString($_POST['logika'], "text"),
					   GetSQLValueString($_POST['office_in'], "text"),
					   GetSQLValueString($_POST['office_out'], "text"));
                       
             

 
  mysqli_query($link, $insertSQL);

  $insertGoTo = "workshift_detil.php?add=1&edit=0&id_workshift=$_POST[id_workshift]";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
else if (isset($_POST["btn_edit"])) {
	$updateSQL= sprintf("UPDATE workshift_detil SET logika=%s, office_in=%s, office_out=%s WHERE id_workshift=%s  AND num_day=%s", 						
						GetSQLValueString($_POST['logika'], "text"),
						GetSQLValueString($_POST['office_in'], "text"),
						GetSQLValueString($_POST['office_out'], "text"),
						GetSQLValueString($_POST['id_workshift'], "int"),						
						GetSQLValueString($_POST['num_day'], "int"));
	
	$result1= mysqli_query($link, $updateSQL);
	$updateGoTo .= "workshift_detil.php?id_workshift=$_POST[id_workshift]";
	if (isset($_SERVER['QUERY_STRING'])) {
		$updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
		$updateGoTo .= $_SERVER['QUERY_STRING'];
	}
	header(sprintf("Location:%s", $updateGoTo));
}
else if ($_REQUEST["delete"]==1) {
			
	$deleteSQL= sprintf("DELETE FROM workshift_detil WHERE id_workshift=%s AND num_day=%s",
						GetSQLValueString($_REQUEST['id_workshift'], "int"),
						GetSQLValueString($_REQUEST['num_day'], "int"));
	
	
	$result1= mysqli_query($link, $deleteSQL);
	$deleteGoTo .="workshift_detil.php";
	if (isset($_SERVER['QUERY_STRING'])) {
		$deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
		$deleteGoTo .= $_SERVER['QUERY_STRING'];
	}
	header(sprintf("Location:%s", $deleteGoTo));
}
?>

