<?php
include "connection.php";
mysql_select_db($database_koneksi, $koneksi);

$sql_staff="SELECT emp_number, employee_id, emp_firstname, emp_place_of_birth, staff
FROM hr_mysql.hs_hr_employee
WHERE 
staff=1"


?>