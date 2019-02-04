<?php require_once('connections/conn_mysqli_procedural.php'); ?>
<?php
if ($_POST['luar_pulau'])
	$_POST['luar_pulau']=1;
else $_POST['luar_pulau']=0;
if (empty($_POST['penanggungjawab'])) 
$_POST['penanggungjawab']="*";
if (empty($_POST['jabatan'])) 
$_POST['jabatan']="*";

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
  $insertSQL = sprintf("INSERT INTO project (kd_project, nama_project, luar_pulau, penanggungjawab, jabatan) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['kd_project'], "int"),
                       GetSQLValueString($_POST['nama_project'], "text"),
					   GetSQLValueString($_POST['luar_pulau'], "int"),
					   GetSQLValueString($_POST['penanggungjawab'], "text"),
					   GetSQLValueString($_POST['jabatan'], "text"));
                       
             

  //mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysqli_query($link, $insertSQL, $koneksi) or die(mysql_error());

  $insertGoTo = "insert_m_project.php?add=1&edit=0";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
else if (isset($_POST["btn_edit"])) {
	$updateSQL= sprintf("UPDATE project SET nama_project=%s, luar_pulau= %s, penanggungjawab=%s, jabatan=%s WHERE kd_project=%s", 						
						GetSQLValueString($_POST['nama_project'], "text"),
						GetSQLValueString($_POST['luar_pulau'], "int"),
						GetSQLValueString($_POST['penanggungjawab'], "text"),
						GetSQLValueString($_POST['jabatan'], "text"),
						GetSQLValueString($_POST['kd_project'], "int"));
	//mysql_select_db($database, $koneksi);
	$result1= mysqli_query($link, $updateSQL);
	$updateGoTo .= "m_project.php";
	if (isset($_SERVER['QUERY_STRING'])) {
		$updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
		$updateGoTo .= $_SERVER['QUERY_STRING'];
	}
	header(sprintf("Location:%s", $updateGoTo));
}
else if ($_REQUEST["delete"]==1) {
	$delprj=sprintf("DELETE FROM ikut_project WHERE kd_project=%s",
			  GetSQLValueString($_REQUEST['kd_project'], "int"));
	$deleteSQL= sprintf("DELETE FROM project WHERE kd_project=%s",
						GetSQLValueString($_REQUEST['kd_project'], "int"));
	//mysql_select_db($database, $koneksi);
	$result_delprj=mysqli_query($link, $delprj);
	$result1= mysqli_query($link, $deleteSQL);
	$deleteGoTo .="m_project.php";
	if (isset($_SERVER['QUERY_STRING'])) {
		$deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
		$deleteGoTo .= $_SERVER['QUERY_STRING'];
	}
	header(sprintf("Location:%s", $deleteGoTo));
}

?>

