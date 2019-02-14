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
  $insertSQL = sprintf("INSERT INTO safety_talk (kd_safety, emp_id, tgl_safety, jml_safety) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['kd_safety'], "int"),
                       GetSQLValueString($_POST['emp_id'], "text"),
					   GetSQLValueString($_POST['tgl_safety'], "text"),
					   GetSQLValueString($_POST['jml_safety'], "decimal"));                       
             
  
  $result1 = mysqli_query($link, $insertSQL) or die(mysqli_error($link));

  $insertGoTo = "create_safetytalk.php?";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
else if (isset($_POST["btn_edit"])) {
	$updateSQL= sprintf("UPDATE safety_talk SET emp_id=%s, tgl_safety=%s, jml_safety=%s WHERE kd_safety=%s", 						
						GetSQLValueString($_POST['emp_id'], "text"),
						GetSQLValueString($_POST['tgl_safety'], "text"),					
						GetSQLValueString($_POST['jml_safety'], "decimal"),
						GetSQLValueString($_POST['kd_safety'], "int"));
	
	$result1= mysqli_query($link, $updateSQL) or die (mysqli_error($link));
	$updateGoTo .= "create_safetytalk.php?";
	if (isset($_SERVER['QUERY_STRING'])) {
		$updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
		$updateGoTo .= $_SERVER['QUERY_STRING'];
	}
	header(sprintf("Location:%s", $updateGoTo));
}
else if ($_REQUEST["delete"]==1) {
			
	$deleteSQL= sprintf("DELETE FROM safety_talk WHERE kd_safety=%s",
						GetSQLValueString($_REQUEST['kd_safety'], "text"));
	
	
	
	$result1= mysqli_query($link, $deleteSQL) or die (mysqli_error($link));
	$deleteGoTo .="create_safetytalk.php";
	if (isset($_SERVER['QUERY_STRING'])) {
		$deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
		$deleteGoTo .= $_SERVER['QUERY_STRING'];
	}
	header(sprintf("Location:%s", $deleteGoTo));
}
?>

