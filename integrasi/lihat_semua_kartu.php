
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Manajemen Kartu</title>

<link href="../themes/orange/css/style.css" rel="stylesheet" type="text/css" />
<script src="../includes/jquery-1.3.2.min.js" type="text/javascript"></script>    	
<script type="text/javascript" src="../includes/scripts-pack.js"></script>   

<script language="JavaScript">	
    $(document).ready(function() {  
        var options1 = {                
            clearFiltersControls: [$('#cleanfilters')],                
        };
        $('#demotable1').tableFilter(options1);	
        var grid2 = $('#demotable2');
        var options2 = {                
            filteringRows: function(filterStates) {										
                grid2.addClass('filtering');
            },
            filteredRows: function(filterStates) {      															
                grid2.removeClass('filtering');					
                setRowCountOnGrid2();
            }
        };			
        function setRowCountOnGrid2() {
            var rowcount = grid2.find('tbody tr:not(:hidden)').length;
            $('#rowcount').text('(Rows ' + rowcount + ')');										
        }
			
        grid2.tableFilter(options2); // No additional filters			
        setRowCountOnGrid2();
    });
		
		// here we define global variable
    var ajaxdestination="";
    function getdata(what,where) { // get data from source (what)
        try {
            xmlhttp = window.XMLHttpRequest?new XMLHttpRequest():
            new ActiveXObject("Microsoft.XMLHTTP");
        }
        catch (e) { /* do nothing */ }
        document.getElementById(where).innerHTML ="<center><img src='../images/loading.gif'></center>";
        ajaxdestination=where;
        xmlhttp.onreadystatechange = triggered; // when request finished, call the function to put result to destination DIV
        xmlhttp.open("GET", what);
        xmlhttp.send(null);
        return false;
    }
    function triggered() { // put data returned by requested URL to selected DIV
      if (xmlhttp.readyState == 4) if (xmlhttp.status == 200) 
            document.getElementById(ajaxdestination).innerHTML =xmlhttp.responseText;
    }	    
</script> 
</head>
<body>

<?php

require_once('../connections/conn_mysqli_procedural.php');

if(isset($_GET['hapus']))
{	
	$hapus=$_GET['hapus'];
	$nama=$_GET['nama'];
	$query="delete from hs_hr_emp_kartu where no_kartu='$hapus'";	
        mysqli_query($link, $query);
	//mysqli_query($link, $query);
	$comment="Data kartu ".$nama." berhasil dihapus";	
}
if(isset($_POST['btn_lokasi'])) {
	$sql_SetLokasi="UPDATE hs_hr_emp_kartu SET lokasi='$_POST[lokasi]'";
	//mysqli_query($link, $sql_SetLokasi);
        mysqli_query($link, $sql_SetLokasi);
	$comment="tabel hs_hr_emp_kartu  berhasil diubah";

}
?>
<div class="outerbox">
<?php include 'menu.txt'; ?>
    
<div id="isinya">
<div class="mainHeading"><h2>Daftar Kartu Absensi</h2></div>
			
<div class="searchbox">
    <form action="save_card.php" method="post">
        <table>    
        <tr>
            <td colspan="3" valign="top" style="padding-bottom:10px;"><b>Tambah Kartu</b></td>
        </tr>
        <tr style="padding-bottom:10px; padding-left:8px; padding-right:8px;">
            <td width="100" height="22" valign="top" class="arial01">No Kartu </td>
            <td width="10" valign="top">:</td>
            <td valign="middle"><input name='no_kartu' type='text' id='no_kartu' value='<?php echo $row['no_kartu'];?>'/></td>
        </tr>
        <tr>
            <td height="22" valign="top" class="arial01">Pegawai</td>
            <td valign="top">:</td>
            <td valign="middle">
                <select name="emp_number_kartu" id="emp_number_kartu">
                    <option value="0">Tidak ada data pegawai</option>
                    <?php 			
                        //$emp_number_kartu = $row['emp_number_kartu'];
			
                        $query2="
                            SELECT a.emp_id, a.emp_name FROM employee as a 
                            LEFT JOIN hs_hr_emp_kartu as b ON(b.emp_number_kartu = a.emp_id)
                            AND b.no_kartu=NULL					
                            order by a.emp_name asc";

                        $hasil2 = mysqli_query($link, $query2);
                        while($row2 = mysqli_fetch_assoc($hasil2))
                        {?>                                  			
                    <option value="<?=$row2['emp_id']?>"><?php echo $row2['emp_name']." - ".$row2['emp_id']; ?></option><?php }?>
                </select>				  
            </td>
        </tr>
        <tr>
            <td height="10"></td>
            <<td></td>
            <td></td>
        </tr>
        <tr>
            <td height="24"></td>
            <td></td>
            <td valign="middle">
                <input name="tambah" type="submit" class="button" value="Tambah">
				 				           
                <input name="reset" type="button" class="button" onClick="res();" value="Reset"></td>
        </tr>
        <tr>
            <td height="24"></td>
            <td></td>
            <td valign="middle"><b>
            <?php 
                if (isset($_REQUEST['comment'])){
                    echo "Note : ".$_REQUEST['comment'];
                }
            ?>
                </b></td>
        </tr>
            <script language="javascript">
                function res()
                {
                        location.href ="index.php";
                }
            </script>
                
    </table>
    </form> 



</div>
<br/>
	<a id="cleanfilters" href="#">Clear Filters</a>
<br/>
    <table border="1" cellspacing="0" width="900" id='demotable1'> 
        <thead>
        <tr >
            <th filter='false'>No</th>
            <th filter='true'>emp_id</th>
            <th filter='true'>No.Kartu</th>
            <th filter='true'>Pegawai</th>
            <th filter-type='ddl'>Staff/DW</th>
            <th style='width:100px;'  filter-type='ddl'>Lokasi</th>
            <th filter='false'>Aksi</th>
        </tr>
        </thead>	
								
        <tbody>			
            <?php  				
            $query="SELECT a.emp_id, a.emp_name, b.staff_dw, b.no_kartu, b.lokasi
            FROM employee a, hs_hr_emp_kartu b 
            WHERE b.emp_number_kartu=a.emp_id order by no_kartu ASC";
            $hasil = mysqli_query($link, $query);
            $a=1;
            while ($row = mysqli_fetch_assoc($hasil)) {?>
            <tr align='center'>
            <td><?php echo $a++;?></td>
            <td width="50"><?php echo $row['emp_id'];?></td>
            <td width="30"><?php echo $row['no_kartu'];?></td>
            <td align= "left"width="200"><div><?php echo $row['emp_name'];?></div></td>
            <td><?php if($row['staff_dw']==0) echo "DW"; else echo "Staff";?></td>
            <td ><?php echo $row['lokasi'];?></td>

            <td width="100"> 
                    <a href='?hapus=<?php echo $row['no_kartu'];?>&nama=<?php echo $row['emp_name'];?>'>Hapus</a> 
            </td>					
             </tr>	
            <?php	}	?>
        </tbody>
    </table>
</div>	
</div> <!-- end of body wrapper -->
<?php  
mysqli_close($link);
	?>
 <!-- end of footer wrapper -->

</body>
</html>
