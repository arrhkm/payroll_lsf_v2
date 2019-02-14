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
        $insertSQL = sprintf("INSERT INTO employee (emp_id, emp_name, no_rekening, kd_jabatan, gaji_pokok, gaji_lembur, 
        pot_jamsos, t_jabatan, t_masakerja, t_insentif, pot_telat, uang_makan, start_work, emp_group) 
        VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
            GetSQLValueString($_POST['emp_id'], "text"),
            GetSQLValueString($_POST['emp_name'], "text"),
            GetSQLValueString($_POST['no_rekening'], "text"),
            GetSQLValueString($_POST['kd_jabatan'], "text"),
            GetSQLValueString($_POST['gaji_pokok'], "decimal"),
            GetSQLValueString($_POST['gaji_lembur'], "decimal"),
            GetSQLValueString($_POST['pot_jamsos'], "decimal"),
            GetSQLValueString($_POST['t_jabatan'], "decimal"),
            GetSQLValueString($_POST['t_masakerja'], "decimal"),
            GetSQLValueString($_POST['t_insentif'], "decimal"),					   
            GetSQLValueString($_POST['pot_telat'], "decimal"),
            GetSQLValueString($_POST['uang_makan'], "decimal"),
            GetSQLValueString($_POST['start_work'], "date"), 
            GetSQLValueString($_POST['emp_group'], "text"));

        //mysql_select_db($database_koneksi, $koneksi);
        $Result1 = mysqli_query($link, $insertSQL) or die(mysqli_error($link));

        $insertGoTo = "insert_m_employee.php?add=1&edit=0";
            if (isset($_SERVER['QUERY_STRING'])) {
                $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
                $insertGoTo .= $_SERVER['QUERY_STRING'];
            }
        header(sprintf("Location: %s", $insertGoTo));
    }
    else if (isset($_POST["btn_edit"])) {

        /*$updateSQL= sprintf("UPDATE employee SET emp_name=%s, no_rekening=%s, kd_jabatan=%s, gaji_pokok=%s, gaji_lembur=%s, 
        pot_jamsos=%s, t_jabatan=%s, t_masakerja=%s, t_insentif=%s, pot_telat=%s, uang_makan=%s, start_work=%s, emp_group=%s WHERE emp_id=%s", 						
            GetSQLValueString($_POST['emp_name'], "text"),
            GetSQLValueString($_POST['no_rekening'], "text"),
            GetSQLValueString($_POST['kd_jabatan'], "text"),
            GetSQLValueString($_POST['gaji_pokok'], "decimal"),
            GetSQLValueString($_POST['gaji_lembur'], "decimal"),
            GetSQLValueString($_POST['pot_jamsos'], "decimal"),
            GetSQLValueString($_POST['t_jabatan'], "decimal"),
            GetSQLValueString($_POST['t_masakerja'], "decimal"),
            GetSQLValueString($_POST['t_insentif'], "decimal"),
            GetSQLValueString($_POST['pot_telat'], "decimal"),
            GetSQLValueString($_POST['uang_makan'], "decimal"),
            GetSQLValueString($_POST['start_work'], "date"),
            GetSQLValueString($_POST['emp_group'], "text"),
            GetSQLValueString($_POST['emp_id'], "text"));            

        */
        $updateSQL = "
            UPATE enployee SET emp_name = '$_POST[emp_name]', 
            no_rekening = '$_POST[no_rekening]',
            kd_jabatan = '$_POST[kd_jabatan]',
            gaji_pokok = '$_POST[gaji_pokok]', 
            gaji_lembur = '$_POST[gaji_lembur]',
            pot_jamsos = '$_POST[pot_jamsos]',
            t_jabatan = '$_POST[t_jabatan]',
            t_masakerja = '$_POST[t_masakerja]',
            t_insentif = '$_POST[t_insentif]',
            pot_telat = '$_POST[pot_telat]',
            uang_makan = '$_POST[uang_makan]',
            start_work = '$_POST[start_work]', 
            emp_group = '$_POST[emp_group]'
            WHERE emp_id = '$_POST[emp_id]'
        ";
        //$result1= 
        mysqli_query($link, $updateSQL);
        $updateGoTo .= "m_employee.php";
        if (isset($_SERVER['QUERY_STRING'])) {
                $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
                $updateGoTo .= $_SERVER['QUERY_STRING'];
        }
        header(sprintf("Location:%s", $updateGoTo));
        //echo $_POST['emp_group'];

    }
    else if ($_REQUEST["delete"]==1) {
        $deleteSQL_absen= sprintf("DELETE FROM absensi WHERE emp_id=%s",GetSQLValueString($_REQUEST['emp_id'], "text"));	
        $deleteSQL_plusmin_gaji= sprintf("DELETE FROM plusmin_gaji WHERE emp_id=%s",GetSQLValueString($_REQUEST['emp_id'], "text"));
        $deleteSQL_kasbon= sprintf("DELETE FROM kasbon WHERE emp_id=%s",
                                                GetSQLValueString($_REQUEST['emp_id'], "text"));	
        $deleteSQL_kartu= sprintf("DELETE FROM hs_hr_emp_kartu WHERE emp_number_kartu=%s",
                                                GetSQLValueString($_REQUEST['emp_id'], "text"));
        $deleteSQL_kontrak= sprintf("DELETE FROM kontrak_kerja WHERE emp_id=%s",
                                                GetSQLValueString($_REQUEST['emp_id'], "text"));
        $deleteSQL_kontrakmsg= sprintf("DELETE FROM kontrak_message WHERE emp_id=%s",
                                                GetSQLValueString($_REQUEST['emp_id'], "text"));
        $deleteSQL_ikutproject= sprintf("DELETE FROM ikut_project WHERE emp_id=%s",
                                                GetSQLValueString($_REQUEST['emp_id'], "text"));
        $deleteSQL_jm= sprintf("DELETE FROM jm_has_employee WHERE employee_emp_id=%s",
                                                GetSQLValueString($_REQUEST['emp_id'], "text"));

        $deleteSQL= sprintf("DELETE FROM employee WHERE emp_id=%s or emp_id=''",
                                                GetSQLValueString($_REQUEST['emp_id'], "text"));
        
        $result9= mysqli_query($link, $deleteSQL_jm);
        $result8= mysqli_query($link, $deleteSQL_ikutproject);
        $result7= mysqli_query($link, $deleteSQL_kontrak );
        $result6= mysqli_query($link, $deleteSQL_kontrakmsg);
        $result5= mysqli_query($link, $deleteSQL_kartu );
        $result4= mysqli_query($link, $deleteSQL_kasbon);
        $result3= mysqli_query($link, $deleteSQL_plusmin_gaji);
        $result2= mysqli_query($link, $deleteSQL_absen);
        $result1= mysqli_query($link, $deleteSQL);
        $deleteGoTo .="m_employee.php";
        if (isset($_SERVER['QUERY_STRING'])) {
                $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
                $deleteGoTo .= $_SERVER['QUERY_STRING'];
        }
        header(sprintf("Location:%s", $deleteGoTo));
    }
?>

