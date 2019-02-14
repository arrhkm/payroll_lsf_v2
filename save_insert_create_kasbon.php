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
      $insertSQL = sprintf("INSERT INTO kasbon (kd_kasbon, emp_id, tgl, keterangan, jml_kasbon) VALUES (%s, %s, %s, %s, %s)",
                           GetSQLValueString($_POST['kd_kasbon'], "int"),
                           GetSQLValueString($_POST['emp_id'], "text"),
                                               GetSQLValueString($_POST['tgl'], "text"),
                                               GetSQLValueString($_POST['keterangan'], "text"),	
                                               GetSQLValueString($_POST['jml_kasbon'], "decimal"));                       

      $result1 = mysqli_query($link, $insertSQL) or die(mysqli_error($link));

      $insertGoTo = "create_kasbon.php?add=1&emp_id=$_POST[emp_id]";
      if (isset($_SERVER['QUERY_STRING'])) {
        $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
        $insertGoTo .= $_SERVER['QUERY_STRING'];
      }
      header(sprintf("Location: %s", $insertGoTo));
    }
    else if (isset($_POST["btn_edit"])) {
            $updateSQL= sprintf("UPDATE kasbon SET tgl=%s, keterangan=%s, jml_kasbon=%s WHERE kd_kasbon=%s", 						
                                                    GetSQLValueString($_POST['tgl'], "text"),
                                                    GetSQLValueString($_POST['keterangan'], "text"),					
                                                    GetSQLValueString($_POST['jml_kasbon'], "decimal"),
                                                    GetSQLValueString($_POST['kd_kasbon'], "int"));
            
            $result1= mysqli_query($link, $updateSQL) or die (mysqli_error($link));
            $updateGoTo .= "create_kasbon.php?&emp_id=$_REQUEST[emp_id]";
            if (isset($_SERVER['QUERY_STRING'])) {
                    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
                    $updateGoTo .= $_SERVER['QUERY_STRING'];
            }
            header(sprintf("Location:%s", $updateGoTo));
    }
    else if ($_REQUEST["delete"]==1) {
            $deleteCicilan= sprintf("DELETE FROM cicilan_kasbon WHERE kd_kasbon=%s",
                                            GetSQLValueString($_REQUEST['kd_kasbon'], "int"));		
            $deleteSQL= sprintf("DELETE FROM kasbon WHERE kd_kasbon=%s",
                                                    GetSQLValueString($_REQUEST['kd_kasbon'], "int"));
            
            $result1= mysqli_query($link, $deleteCicilan) or die (mysqli_error($link));
            $result2= mysqli_query($link, $deleteSQL) or die (mysqli_error($link));
            $deleteGoTo .="create_kasbon.php?add=1&kd_emp=$_REQUEST[emp_id]";
            if (isset($_SERVER['QUERY_STRING'])) {
                    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
                    $deleteGoTo .= $_SERVER['QUERY_STRING'];
            }
            header(sprintf("Location:%s", $deleteGoTo));
    }
    else if ($_REQUEST["lunas"]==1) {

            $deleteSQL= sprintf("UPDATE kasbon SET status=0 WHERE kd_kasbon=%s",						
                                                    GetSQLValueString($_REQUEST['kd_kasbon'], "int"));
            //$delete_cicilan= sprintf("DELETE FROM cicilan_kasbon WHERE kd_kasbon=%s",
                                                    //GetSQLValueString($_REQUEST['kd_kasbon'], "text"));
            $result1= mysqli_query($link, $deleteSQL) or die (mysqli_error($link));
            $lunasGoTo .="create_kasbon.php?add=1&kd_emp=$_REQUEST[emp_id]";
            if (isset($_SERVER['QUERY_STRING'])) {
                    $lunasGoTo .= (strpos($lunasGoTo, '?')) ? "&" : "?";
                    $lunasGoTo .= $_SERVER['QUERY_STRING'];
            }
            header(sprintf("Location:%s", $lunasGoTo));
    }
    else if ($_REQUEST["lunas2"]==1) {

            $deleteSQL= sprintf("UPDATE kasbon SET status=0 WHERE kd_kasbon=%s",						
                                                    GetSQLValueString($_REQUEST['kd_kasbon'], "int"));
            //$delete_cicilan= sprintf("DELETE FROM cicilan_kasbon WHERE kd_kasbon=%s",
                                                    //GetSQLValueString($_REQUEST['kd_kasbon'], "text"));
            $result1= mysqli_query($link, $deleteSQL) or die (mysqli_error($link));
            $lunasGoTo .="create_kasbon.php?add=1&kd_emp=$_REQUEST[emp_id]";
            if (isset($_SERVER['QUERY_STRING'])) {
                    $lunasGoTo .= (strpos($lunasGoTo, '?')) ? "&" : "?";
                    $lunasGoTo .= $_SERVER['QUERY_STRING'];
            }
            header(sprintf("Location:%s", $lunasGoTo));
    }
?>

