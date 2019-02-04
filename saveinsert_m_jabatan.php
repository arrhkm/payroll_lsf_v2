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
      $insertSQL = sprintf("INSERT INTO jabatan (kd_jabatan, nama_jabatan) VALUES (%s, %s)",
                           GetSQLValueString($_POST['kd_jabatan'], "int"),
                           GetSQLValueString($_POST['nama_jabatan'], "text"));



      
      $Result1 = mysqli_query($link, $insertSQL);

      $insertGoTo = "insert_m_jabatan.php?add=1&edit=0";
      if (isset($_SERVER['QUERY_STRING'])) {
        $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
        $insertGoTo .= $_SERVER['QUERY_STRING'];
      }
      header(sprintf("Location: %s", $insertGoTo));
    }
    else if (isset($_POST["btn_edit"])) {
            $updateSQL= sprintf("UPDATE jabatan SET nama_jabatan=%s WHERE kd_jabatan=%s", 						
                                                    GetSQLValueString($_POST['nama_jabatan'], "text"),
                                                    GetSQLValueString($_POST['kd_jabatan'], "int"));
            
            $result1= mysqli_query($link, $updateSQL);
            $updateGoTo .= "m_jabatan.php";
            if (isset($_SERVER['QUERY_STRING'])) {
                    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
                    $updateGoTo .= $_SERVER['QUERY_STRING'];
            }
            header(sprintf("Location:%s", $updateGoTo));
    }
    else if ($_REQUEST["delete"]==1) {

            $deleteSQL= sprintf("DELETE FROM jabatan WHERE kd_jabatan=%s",
                                                    GetSQLValueString($_REQUEST['kd_jabatan'], "int"));
            

            $result1= mysqli_query($link, $deleteSQL);
            $deleteGoTo .="m_jabatan.php";
            if (isset($_SERVER['QUERY_STRING'])) {
                    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
                    $deleteGoTo .= $_SERVER['QUERY_STRING'];
            }
            header(sprintf("Location:%s", $deleteGoTo));
    }
?>

