<?php
require_once('connections/conn_mysqli_procedural.php');
//mysql_select_db($database_koneksi);
/*
if ($_REQUEST['delete']==1) {
		$qry_del="DELETE FROM jamsostek WHERE kd_periode='$_REQUEST[kd_periode]' AND emp_id='$_REQUEST[emp_id]'";
		if (mysqli_query($link, $qry_del)){
		header("location:jamsostek.php?kd_periode=$_REQUEST[kd_periode]");
		}
	
}
else if ($_REQUEST['del_all']==1) {
	$qry_del="DELETE FROM jamsostek WHERE kd_periode=$_REQUEST[kd_periode]";
		if (mysqli_query($link, $qry_del)){
		header("location:jamsostek.php?kd_periode=$_REQUEST[kd_periode]");
		}
}
elseif(count($_POST['cek']) < 1)
{
        ?>
                <meta http-equiv='refresh' content='0; url=<?php echo "insert_jamsostek.php?kd_periode=".$_POST['kd_periode']."&emp_id=".$_POST['emp_id'];?>'>
                <script type="text/javascript">
                        alert("Tidak ada data yang terpilih...!!!");
                </script>
        <?php
}
else
{
        echo "Tambah <br>";
        //memeasukkan data kedalam tabel software secara berulang-ulang selama kurang dari count ($_POST['cek'])
        //$kd_ijam=$row_ijam[n]+1;		
        for($i=0;$i<count($_POST['cek']);$i++){
            $emp_id=$_POST['cek'][$i];	
            $qry_emp="SELECT pot_jamsos FROM employee WHERE emp_id='$emp_id'";
            $rs_emp=mysqli_query($link, $qry_emp);
            $row_emp=mysqli_fetch_assoc($rs_emp);
            $SQL_add="INSERT IGNORE jamsostek (kd_periode, emp_id, pot_jamsostek) 
            VALUES ('$_POST[kd_periode]', '$emp_id', '$row_emp[pot_jamsos]')";
            //mysqli_query($link, $SQL_add); 
            //$kd_ijam++;
            echo "kd_periode= $_POST['kd_periode'] - $emp_id - $row_emp['pot_jamsos']<br>";


            //var_dump($_POST['cek']);
        }
        ?>
        <!-- meta http-equiv='refresh' content='0; url=<?php echo "insert_jamsostek.php?emp_id=".$emp_id."&kd_periode=".$_POST[kd_periode];?>'>
        <script type="text/javascript">
                alert("Data yang terpilih berhasil ditambah..!!!");
        </script -->	
        <?php
}
 * *
 */
//var_dump($_POST);

if (isset($_POST['btn_tambah'])) {
    if(count($_POST['cek']) < 1)
    {
        ?>
            <meta http-equiv='refresh' content='0; url=<?php echo "insert_jamsostek.php?kd_periode=".$_POST['kd_periode']."&emp_id=".$_POST['emp_id'];?>'>
            <script type="text/javascript">
                    alert("Tidak ada data yang terpilih...!!!");
            </script>
        <?php
    }else {
        //var_dump($_POST['cek']);
        for($i=0;$i<count($_POST['cek']);$i++){
            $emp_id=$_POST['cek'][$i];	
            $qry_emp="SELECT pot_jamsos FROM employee WHERE emp_id='$emp_id'";
            $rs_emp=mysqli_query($link, $qry_emp);
            $row_emp=mysqli_fetch_assoc($rs_emp);
            $SQL_add="INSERT IGNORE jamsostek (kd_periode, emp_id, pot_jamsostek) 
            VALUES ('$_POST[kd_periode]', '$emp_id', '$row_emp[pot_jamsos]')";
            mysqli_query($link, $SQL_add); 
            
            //echo "kd_periode= ".$_POST['kd_periode']." emp id  : ".$emp_id." jamsos : ".$row_emp['pot_jamsos']."<br>";
            

           
        }
        ?>
        <meta http-equiv='refresh' content='0; url=<?php echo "insert_jamsostek.php?emp_id=".$emp_id."&kd_periode=".$_POST[kd_periode];?>'>
        <script type="text/javascript">
                alert("Data yang terpilih berhasil ditambah..!!!");
        </script>	
        <?php
    }
        
} else if (isset($_REQUEST['delete']) && $_REQUEST['delete']==1) {
		$qry_del="DELETE FROM jamsostek WHERE kd_periode='$_REQUEST[kd_periode]' AND emp_id='$_REQUEST[emp_id]'";
		if (mysqli_query($link, $qry_del)){
		header("location:jamsostek.php?kd_periode=$_REQUEST[kd_periode]");
		}
	
}
else if (isset($_REQUEST['del_all'])&& $_REQUEST['del_all']==1) {
	$qry_del="DELETE FROM jamsostek WHERE kd_periode=$_REQUEST[kd_periode]";
		if (mysqli_query($link, $qry_del)){
		header("location:jamsostek.php?kd_periode=$_REQUEST[kd_periode]");
		}
}
?>