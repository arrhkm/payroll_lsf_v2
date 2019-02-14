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

if (isset($_POST["btn_save"]))  { // JIKA SAVE
  $ket_absen=strtoupper($_POST['ket_absen']);
  $insertSQL = sprintf("REPLACE INTO absensi_cuti (tgl, emp_id, ket_absen) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['tgl'], "date"),
                       GetSQLValueString($_POST['emp_id'], "text"),
					   GetSQLValueString($ket_absen, "text")); 
					   
  
  $Result1 = mysqli_query($link, $insertSQL) or die(mysqli_error($link));

  $insertGoTo = "insert_cuti.php?add=1&edit=0";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
else if ($_REQUEST["delete"]==1) {//Jika DELETE 
			
	$deleteSQL= sprintf("DELETE FROM absensi_cuti WHERE tgl=%s and emp_id=%s",
						GetSQLValueString($_REQUEST['tgl'], "date"),
						GetSQLValueString($_REQUEST['emp_id'], "text"));
	
	
	$result1= mysqli_query($link, $deleteSQL) or die (mysqli_error($link));
	$deleteGoTo .="insert_cuti.php";
	if (isset($_SERVER['QUERY_STRING'])) {
		$deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
		$deleteGoTo .= $_SERVER['QUERY_STRING'];
	}
	header(sprintf("Location:%s", $deleteGoTo));
}
else if ($_REQUEST["clear"]==1) {// JIka hapus absensi CUTI semua nya 
	$clearSQL= sprintf("TRUNCATE TABLE  absensi_cuti ");
	
	
	$result_clear= mysqli_query($link, $clearSQL) or die (mysqli_error($link));
	$clearGoTo .="insert_cuti.php";
	if (isset($_SERVER['QUERY_STRING'])) {
		$clearGoTo .= (strpos($clearGoTo, '?')) ? "&" : "?";
		$clearGoTo .= $_SERVER['QUERY_STRING'];
	}
	header(sprintf("Location:%s", $clearGoTo));
}
else if ($_REQUEST["post"]==1) {
		
		$qry_cuti=mysqli_query($link, "SELECT * FROM absensi_cuti") or die (mysqli_error($link));
		while ($row_cuti=mysqli_fetch_assoc($qry_cuti)) { 
		mysqli_query($link, "REPLACE INTO absensi (tgl, emp_id, ket_absen) VALUES ('$row_cuti[tgl]', '$row_cuti[emp_id]', '$row_cuti[ket_absen]')");
		//echo "berhasil ditambahkan ";
	}
	$clearSQL= sprintf("TRUNCATE TABLE  absensi_cuti ");	
	$result_clear= mysqli_query($link, $clearSQL) or die (mysqli_error($link));
	$clearGoTo .="insert_cuti.php";
	if (isset($_SERVER['QUERY_STRING'])) {
		$clearGoTo .= (strpos($clearGoTo, '?')) ? "&" : "?";
		$clearGoTo .= $_SERVER['QUERY_STRING'];
	}
	header(sprintf("Location:%s", $clearGoTo));
}
?>

