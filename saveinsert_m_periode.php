<?php 
    //require_once('connections/koneksi.php'); 
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
      $insertSQL = sprintf("INSERT INTO periode (kd_periode, nama_periode, tgl_awal, tgl_akhir) VALUES (%s, %s, %s, %s)",
            GetSQLValueString($_POST['kd_periode'], "int"),
            GetSQLValueString($_POST['nama_periode'], "text"),
            GetSQLValueString($_POST['tgl_awal'], "text"),
            GetSQLValueString($_POST['tgl_akhir'], "text") );

      //mysql_select_db($database_koneksi, $koneksi);
      $Result1 = mysqli_query($link, $insertSQL) or die(mysqli_errno($link));

      $insertGoTo = "insert_m_periode.php?add=1&edit=0";
      if (isset($_SERVER['QUERY_STRING'])) {
        $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
        $insertGoTo .= $_SERVER['QUERY_STRING'];
      }
      header(sprintf("Location: %s", $insertGoTo));
    }
    else if (isset($_POST["btn_edit"])) {
            $updateSQL= sprintf("UPDATE periode SET nama_periode=%s, tgl_awal=%s, tgl_akhir=%s WHERE kd_periode=%s", 						
                                                    GetSQLValueString($_POST['nama_periode'], "text"),
                                                    GetSQLValueString($_POST['tgl_awal'], "text"),
                                                    GetSQLValueString($_POST['tgl_akhir'], "text"),

                                                    GetSQLValueString($_POST['kd_periode'], "int"));
            //mysql_select_db($database, $koneksi);
            $result1= mysqli_query($link, $updateSQL) or die (mysqli_error($link));
            $updateGoTo .= "m_periode.php";
            if (isset($_SERVER['QUERY_STRING'])) {
                    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
                    $updateGoTo .= $_SERVER['QUERY_STRING'];
            }
            header(sprintf("Location:%s", $updateGoTo));

    }
    else if ($_REQUEST["delete"]==1) {
            $sql_deltgllibur= sprintf("Delete from tanggal_libur where kd_periode=%s",
                                            GetSQLValueString($_REQUEST['kd_periode'], "int"));	
            $delete_jamsostek= sprintf("DELETE FROM jamsostek WHERE kd_periode=%s",
                                                    GetSQLValueString($_REQUEST['kd_periode'], "int"));
            $deleteSQL= sprintf("DELETE FROM periode WHERE kd_periode=%s",
                                                    GetSQLValueString($_REQUEST['kd_periode'], "int"));

            //mysql_select_db($database, $koneksi);
            $result_deltgllibur=mysqli_query($link, $sql_deltgllibur) or die (mysqli_error($link));
            $result_del_jamsostek=mysqli_query($link, $delete_jamsostek) or die (mysqli_error($link));
            mysqli_query($link, "Delete from jamsostek_pending WHERE kd_periode1='$_REQUEST[kd_periode]'");
            $result1= mysqli_query($link, $deleteSQL) or die (mysqli_error($link));
            $deleteGoTo .="m_periode.php";
            if (isset($_SERVER['QUERY_STRING'])) {
                    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
                    $deleteGoTo .= $_SERVER['QUERY_STRING'];
            }
            header(sprintf("Location:%s", $deleteGoTo));
    }
    
    mysqli_close($link);
?>

