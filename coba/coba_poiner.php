<?php
function printr($value){
    echo $value."<br>";
}
$dt_array=array(5, 3, 4);
var_dump($dt_array);

printr(min($dt_array));