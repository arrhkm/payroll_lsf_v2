<?php

require_once('../connections/conn_mysqli_procedural.php');
if (isset($_POST['tambah'])){
    $sql_cek = "SELECT * FROM hs_hr_emp_kartu "
            . "WHERE no_kartu='$_POST[no_kartu]'";
    $rs_cek = mysqli_query($link, $sql_cek);
    
    if (mysqli_num_rows($rs_cek)>0){					
        $comment = "Kartu No. ".$_POST['no_kartu']." sudah digunakan";
        //echo $comment;
        header('location:lihat_semua_kartu.php?comment='.$comment);
        //var_dump($_POST);
    }
    else
    {
        $sql_ins="INSERT INTO hs_hr_emp_kartu (no_kartu, emp_number_kartu, staff_dw, lokasi) "
                . "VALUES ('$_POST[no_kartu]', '$_POST[emp_number_kartu]', '0', 'LSF')";
        
        
        
        if (mysqli_query($link, $sql_ins)){        
            $comment = "Data Kartu No. ".$_POST['no_kartu']." Berhasil Disimpan";
            header('location:lihat_semua_kartu.php?comment=<?php echo$comment;?>');
            //echo $comment;
        }else {
            echo "gagal simpan";
        }
        
     
        
    }	
    
}
