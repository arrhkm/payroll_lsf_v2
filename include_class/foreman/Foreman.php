<?php

class Foreman {
    public $name;
    public $nik;

    function __construct($link, $emp_id)
    {
        $sql = "SELECT a.*, b.leader_id, c.emp_name	FROM child_foreman a JOIN foreman b ON(b.id = a.foreman_id)
		LEFT JOIN employee c ON (c.emp_id = b.leader_id)
		WHERE a.employee_emp_id = '$emp_id'";
		if ($rs = mysqli_query($link, $sql)){
            $row = mysqli_fetch_assoc($rs);
            //$foreman = $row['emp_name']." : ".$row['leader_id'];
            //$this->name = $row['emp_name'];
            $this->nik = $row['leader_id'];
            $this->name = $row['emp_name'];
		}else{
            $this->nik = "Blank";
            $this->name = "Blank";
        }
    }
    
}