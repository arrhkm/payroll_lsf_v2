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
      $insertSQL = sprintf("INSERT INTO tanggal_libur (kd_libur, kd_periode, tgl_libur, ket) VALUES (%s, %s, %s, %s)",
                           GetSQLValueString($_POST['kd_libur'], "int"),
                           GetSQLValueString($_POST['kd_periode'], "int"),
                                               GetSQLValueString($_POST['tgl_libur'], "text"),
                                               GetSQLValueString($_POST['ket'], "text"));



      //mysql_select_db($database_koneksi, $koneksi);
      $Result1 = mysqli_query($link, $insertSQL) or die(mysqli_errno($link));

      $insertGoTo = "tgl_libur.php?kd_libur=$_REQUEST[kd_libur]&kd_periode=$_REQUEST[kd_periode]";
      if (isset($_SERVER['QUERY_STRING'])) {
        $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
        $insertGoTo .= $_SERVER['QUERY_STRING'];
      }
      header(sprintf("Location: %s", $insertGoTo));
    }
    else if ($_REQUEST["delete"]==1) {
            $deleteSQL= sprintf("DELETE FROM tanggal_libur WHERE kd_libur=%s",
                                                    GetSQLValueString($_REQUEST['kd_libur'], "int"));
            
            $result1= mysqli_query($link, $deleteSQL) or die (mysqli_errno($link));
            $deleteGoTo .="tgl_libur.php?kd_libur=<?php echo $_REQUEST[kd_libur];?>";
            if (isset($_SERVER['QUERY_STRING'])) {
                    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
                    $deleteGoTo .= $_SERVER['QUERY_STRING'];
            }
            header(sprintf("Location:%s", $deleteGoTo));
    }
?>

