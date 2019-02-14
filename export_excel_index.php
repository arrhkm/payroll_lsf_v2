<?php 
require_once('connections/conn_mysqli_procedural.php');

    if (isset($_REQUEST['kd_periode']) && isset($_REQUEST['kd_project'])){
        $kd_periode = $_REQUEST['kd_periode'];
        $kd_project = $_REQUEST['kd_project'];
    }
    $data_excel = array();
    $sql_exp_pos = "SELECT * FROM pos_payroll WHERE kd_periode='$kd_periode' AND kd_project='$kd_project'";
    $rs_exp_pos = mysqli_query($link, $sql_exp_pos) or die(mysqli_error($link));
    $jml_emp = mysqli_num_rows($rs_exp_pos);
    //$dt_emp = mysqli_fetch_assoc($rs_exp_pos);
    //$test = mysqli_fetch_array($rs_exp_pos);
    //var_dump(mysqli_fetch_all($result));
    $filename = "data_cost".".xls";		 
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=\"$filename\"");
    echo 'emp_id' . "\t" . 'tgl' . "\t" . 'jam_in' . "\t". 'jam_out' . "\t". 'jam_ev' . "\t". 'ot'. "\t". 'gp' 
        . "\t". 'gl' . "\t". 'premi' . "\t". 't_jam12' . "\t". 't_msker' . "\t". 'gt' . "\t". 'cicil_kasbon'
        . "\t". 'jamsos'. "\t". 'over_gaji'. "\t". 'def_gaji'
        . "\n";
    while($dt_pos= mysqli_fetch_assoc($rs_exp_pos)){
        $sql_exp_det= "SELECT * FROM pos_payroll_day "
            . "WHERE kd_periode='$kd_periode' "
            . "AND kd_project= '$kd_project' "
            . "AND emp_id='$dt_pos[emp_id]'";    
        $rs_exp_det= mysqli_query($link, $sql_exp_det) or die(mysqli_error($link));

        
        while($dt_det= mysqli_fetch_assoc($rs_exp_det)){
            array_push($data_excel, [
                'emp_id'=>$dt_det['emp_id'],
                'tgl'=>$dt_det['tgl'],
                'jam_in'=>$dt_det['jam_in'],
                'jam_out'=>$dt_det['jam_out'],
                'jam_ev'=>$dt_det['jam_ev'],
                'gp'=>$dt_det['gp'],
                'gl'=>$dt_det['gl'],
                'premi'=>$dt_det['pot_tel'],
                't_jam12'=>$dt_det['t_jam12'],
                't_msker'=>$dt_det['t_msker'],
                'tg'=>$dt_det['tg']            
            ]);
            echo $dt_det['emp_id']."\t" .$dt_det['tgl']."\t" .$dt_det['jam_in']."\t" .$dt_det['jam_out']."\t" 
                .$dt_det['jam_ev']."\t" .$dt_det['ot']."\t" .$dt_det['gp']."\t" .$dt_det['gl']."\t" .$dt_det['pot_tel']."\t" 
                .$dt_det['t_jam12']."\t" .$dt_det['t_msker']."\t" .$dt_det['tg']."\t".'0'."\t"
                .'0'."\t".'0'."\t".'0'
                ."\n";
        }
        echo $dt_pos['emp_id']."\t" .'0'."\t" .'0'."\t" .'0'."\t" .'0'."\t" .'0'
                ."\t" .'0'."\t" .'0'."\t" .'0'."\t" .'0'."\t" .'0'."\t".'0'."\t"
                .$dt_pos['cicil_kasbon']."\t".$dt_pos['jamsos']."\t".$dt_pos['over_gaji']."\t".$dt_pos['def_gaji']
                ."\n";
        
    }
