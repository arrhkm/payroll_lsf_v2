<?php 

require_once('../connections/conn_mysqli_procedural.php');
//require_once 'menu.txt';
if($_REQUEST['delete']){
    //echo "ini sedang di delete";
    $sqldel = "delete from machine_att where id = '$_REQUEST[id]'";
    if (mysqli_query($link, $sqldel)){
        header("location:from_linux_machine.php");
    }else echo "gagal delete";
}
if (isset($_REQUEST['id'])){
    $sql= "SELECT * FROM machine_att WHERE id = $_REQUEST[id]";
    $rs = mysqli_query($link, $sql);
    $model = mysqli_fetch_assoc($rs);
    $edit = TRUE;
    //var_dump($model);
}
if (isset($_REQUEST['add'])){
    $id_ai = new DbAutoIncrement();
    $id_ai->setDb($link, "machine_att");
    $new_id = $id_ai->getlastId('id');
    //echo "new id :".$new_id;
    $add = TRUE;
    $model = array('id'=>$new_id,'ip'=>'', 'port'=>'', 'com'=>'');
    //var_dump($model);
}
    ?>
    <link href="../themes/orange/css/style.css" rel="stylesheet" type="text/css"> 
    <div class="outerbox">
    <?php include ("menu.txt"); ?>
    <div id="isinya">
    <div class="mainHeading"><h2> Machine Attendance </h2></div>
    <br><br>
    <form action="_form_machine.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $model['id'];?>">
        <div> Ip: <input type="Text" name="ip" value="<?=$model['ip']?>" size=15></div>
        <div> Port : <input type="Text" name="port" size="5" value="<?=$model['port']?>"></div>
        <div> Com : <input type="Text" name="com" size="5" value="<?=$model['com']?>"></div>
        <div> 
            <input name="btn_submit" type="Submit" value="<?php if($edit){echo "save";} else echo "add"; ?>">
            <input type="button" value="Back" onclick="window.location.href='from_linux_machine.php'">
        </div>
    </form>
    <?php
     //var_dump($_POST);
    if (isset($_POST['btn_back'])){
        echo "btn back";
        //header("location:from_linux_machine.php");
    }
    if (isset($_POST['btn_submit']) && $_POST['btn_submit']=='save'){
        $sqlsave = "UPDATE machine_att   SET com = '$_POST[com]' WHERE id = '$_POST[id]'";
        if (mysqli_query($link, $sqlsave)){
            header("location:from_linux_machine.php");
        }else {
            echo "gagal Update";
        }
        
    } elseif (isset ($_POST['btn_submit']) && $_POST['btn_submit']=='add'){
        //echo "Ini Penambahan";
        $sqlinsert = "INSERT INTO machine_att (id, ip, port, com) "
        . "VALUES ( '$_POST[id]', '$_POST[ip]', '$_POST[port]', '$_POST[com]')";
        if (mysqli_query($link, $sqlinsert)){
            header("location:from_linux_machine.php");
        } else echo "Gagal Insert";
        //var_dump($_POST);
        echo "New id : ".$new_id;
    }


?>


