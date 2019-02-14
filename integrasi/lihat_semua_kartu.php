<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Manajemen Kartu</title>

<link href="../themes/orange/css/style.css" rel="stylesheet" type="text/css" />
<script src="../includes/jquery-1.3.2.min.js" type="text/javascript"></script>    	
<script type="text/javascript" src="../includes/scripts-pack.js"></script>   

	<script language="JavaScript">
	
	$(document).ready(function() {
            //  Randomly Create Data Rows
          /*  for (var i = 0; i < 50; i++) {
                var tr = $("<tr>" +
					"<td>Value" + Math.floor(Math.random() * 500) + "</td>" + 
					"<td>" + Math.floor(Math.random() * 500) + " </td>" + 
					"<td>" + (Math.random() > 0.5 ? "yes" : "no") + "</td>" + 
					"<td>" + (Math.random() <= 0.333 ? "Item 1" : Math.random() > 0.5 ? "Item 2" : "Item 3") + "</td>" + 
					"<td></td>" +
					"<td>" + parseInt(10 + Math.random() * 18) + "/" + parseInt(10 + Math.random() * 2) + "/2009</td>" + 					
					
					"</tr>");
                $('#demotable1 tbody').append(tr);
            }*/
			
			/*for (var i = 0; i < 50; i++) {
                var tr = $("<tr><td>Value(2) " + Math.floor(Math.random() * 500) + "</td></tr>");
                $('#demotable2 tbody').append(tr);
            }*/

            // Initialise Plugin
            var options1 = {
                //additionalFilterTriggers: [$('#onlyyes'), $('#onlyno'), $('#quickfind')],
                clearFiltersControls: [$('#cleanfilters')],
                /*matchingRow: function(state, tr, textTokens) {
                    if (!state || !state.id) { return true; }					
					var val =  tr.children('td:eq(2)').text();
					switch (state.id) {
						case 'onlyyes': return state.value !== 'true' || val === 'yes';
						case 'onlyno': return state.value !== 'true' || val === 'no';
						default: return true;
					}
                }*/
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
		// we are defining the destination DIV id, must be stored in global variable (ajaxdestination)
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
<form action="" method="post">
<?php
//include("../connections/koneksi.php");
require_once('../connections/conn_mysqli_procedural.php');
//include ("connect.php");
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
<?php include ("menu.txt"); ?>
		<div id="isinya">
			<div class="mainHeading"><h2>Daftar Kartu Absensi</h2></div>
			<?php 
			if(isset($_POST['tambah']))
			{
				$no_kartu = $_POST['no_kartu'];
				$x = $_POST['emp_number_kartu'];
				$vals = explode(",",$x);
				$emp_number_kartu = $vals[0];
				
				
				$qry_loc="select loc_code from hs_hr_location ";
				$rs_loc=mysqli_query($link, $qry_loc);
				$row_loc=mysqli_fetch_assoc($rs_loc);
				
				$query_cek="select count(*) as number from hs_hr_emp_kartu where no_kartu='$no_kartu' and lokasi='$nama_mesin'";
				//echo $query_add;
				$hasil_cek = mysqli_query($link, $query_cek);
				$row_cek = mysqli_fetch_assoc($hasil_cek);
				//$total_cek = mysql_num_rows($hasil_cek); 
				$number = $row_cek['number'];				
					//echo $no_kartu_cek;
					if ($number>0){					
					$comment = "Kartu No. ".$no_kartu." sudah digunakan";					
					}
					else
					{
						$query="insert into `hs_hr_emp_kartu`(`no_kartu`,`emp_number_kartu`,`staff_dw`,`lokasi`) values 
						( '$no_kartu','$emp_number_kartu','$staff_dw','$nama_mesin')";
					
						mysqli_query($link, $query);
						$comment = "Data Kartu No. ".$no_kartu." Berhasil Disimpan";
					}																	
			}
			
			?>
			
			  <div class="searchbox">
			  <table width="350" border="0" cellpadding="0" cellspacing="0" style="padding-bottom:10px; padding-left:8px; padding-right:8px;">
                <!--DWLayoutTable-->
				<tr><td colspan="3" valign="top" style="padding-bottom:10px;"><b>Tambah Kartu</b></td></tr>
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
						
						/*$query2="select a.loc_code, b.loc_name from hs_hr_emp_locations a, hs_hr_location b where a.emp_number='".$row['emp_number_kartu']."' and a.loc_code=b.loc_code";

						$hasil2 = mysqli_query($link, $query2);
						$row2 = mysqli_fetch_assoc($hasil2);*/
						
						$emp_number_kartu = $row['emp_number_kartu'];
						
						/*$query2="select a.emp_firstname,a.emp_number, b.loc_name from hs_hr_employee a, hs_hr_location b, hs_hr_emp_locations c where b.loc_code not in (select lokasi from hs_hr_emp_kartu) and c.emp_number=a.emp_number and b.loc_code = c.loc_code order by emp_firstname asc";*/
						
						$query2="
						select a.* 
						from employee a					
						order by emp_name asc";
						
						//$comment=$query2;
						$hasil2 = mysqli_query($link, $query2);
						while($row2 = mysqli_fetch_assoc($hasil2))
							{
									$emp_firstname = $row2['emp_name'];
									$emp_number = $row2['emp_id'];
									$lokasi = $nama_lokasi;
									$location =$nama_mesin;
									//$join = array ($emp_number,$location);
							?>
							
							<option value="<?php echo $emp_number; ?>,<?php echo $location; //echo $emp_number; ?>" <?php $value = $emp_number; if($value==$emp_number_kartu) { echo('selected="selected"');}?>><?php echo $emp_firstname; ?> - <?php echo $lokasi; ?></option>
								<?php }?>
					</select>				  </td>
                </tr>
                <tr>
                  <td height="10"></td>
                  <td></td>
                  <td></td>
                </tr>
                <tr>
                  <td height="24"></td>
                  <td></td>
                  <td valign="middle">
				
				  <input name="tambah" id="tambah" type="submit" class="button" value="Tambah">
				 				           &nbsp;&nbsp;
                    <input name="reset" type="button" class="button" onClick="res();" value="Reset"></td>
                </tr>
                <tr>
                  <td height="24"></td>
                  <td></td>
                  <td valign="middle"><b><?php echo $comment;?></b></td>
                </tr>

                <script language="javascript">
				function res()
				{
					location.href ="index.php";
				}
              </script>
 </form>             
 </table>
<form name="set_lokasi" method="POST"> 
<table>
<tr>
<td colspan=3> Set All employee to Lokasi : </td>
</tr>
<tr>
<td> Lokasi </td>
<td>
	<select name="lokasi">
		<?php 
		$sql_lokasi="SELECT * FROM hs_hr_location";
		$rs_lokasi = mysqli_query($link, $sql_lokasi);
		while($row_lokasi = mysqli_fetch_assoc($rs_lokasi))	{
		
		?>
		<option value="<?php echo $row_lokasi['loc_code'];?>"><?php echo $row_lokasi['loc_name'];?></option>
		<?php } ?>
	</select>
</td>
<td><input name="btn_lokasi" type="submit" class="button" value="Set Lokasi all"></td>
</tr>
</table>
</form> 


</div>
<br />
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
