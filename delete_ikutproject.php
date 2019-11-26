<?php 

require_once('connections/conn_mysqli_procedural.php');

//var_dump($_POST['cek']);
if (isset($_POST['cek'])){
    if (count($_POST['cek'])> 0)
    {

        $dtarr=[];
        for($i=0;$i<count($_POST['cek']);$i++){
            $emp_id=$_POST['cek'][$i];	
        
            $sql_del="DELETE 
            FROM ikut_project 
            WHERE  emp_id = '$emp_id' AND kd_project = '$_POST[kd_project]'";
            if(mysqli_query($link, $sql_del)){
                array_push($dtarr, $emp_id);
            }else mysqli_error($conn);
            
        }
        mysqli_close($link);
        header("Location:m_project.php?kd_project='$_POST[kd_project]'");
    
    } 

}
else {
    
    header("Location:m_project.php?kd_project='$_POST[kd_project]'");
  
    
   
}
