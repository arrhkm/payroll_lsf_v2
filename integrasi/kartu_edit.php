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
<form action="kartu_edit.php" method="post">
<?php
include("../connections/koneksi.php");
include ("connect.php");
$qry_edit="SELECT * FROM hs_hr_emp_kartu WHERE no_kartu ='$_GET[no_kartu]'";
$rs_edit=mysql_query($qry_edit, $koneksi);
$row_edit=mysql_fetch_array($rs_edit);

if(isset($_GET['hapus']))
{	
	$hapus=$_GET['hapus'];
	$nama=$_GET['nama'];
	$query="delete from hs_hr_emp_kartu where no_kartu='$hapus'";	
	$Konek->Exec_Query_Mysql($query);
	$comment="Data kartu ".$nama." berhasil dihapus";	
}


?>
<div class="outerbox">
<?php include ("menu.txt"); ?>
		<div id="isinya">
			<div class="mainHeading"><h2>Daftar Kartu Absensi</h2></div>
			<?php 
			if(isset($_POST[tambah]))
			{
				$no_kartu = $_POST['no_kartu'];
				$x = $_POST['emp_number_kartu'];
				$vals = explode(",",$x);
				$emp_number_kartu = $vals[0];
				
				
				$qry_loc="select loc_code from hs_hr_location ";
				$rs_loc=$Konek->Exec_Query_Mysql($qry_loc);
				$row_loc=mysql_fetch_array($rs_loc);
				$lokasi=$nama_mesin;
				$location=$row_loc[loc_code];
				$query_cek="select count(*) as number from hs_hr_emp_kartu where no_kartu='$no_kartu'";
				//echo $query_add;
				$hasil_cek = $Konek->Exec_Query_Mysql($query_cek);
				$row_cek = mysql_fetch_array($hasil_cek);
				//$total_cek = mysql_num_rows($hasil_cek); 
				$number = $row_cek['number'];				
					//echo $no_kartu_cek;
					if ($number>0){					
					$comment = "Kartu No. ".$no_kartu." sudah digunakan";					
					}
					else
					{
						$query="insert into `hs_hr_emp_kartu`(`no_kartu`,`emp_number_kartu`,`staff_dw`,`lokasi`) values 
						( '$no_kartu','$emp_number_kartu','$staff_dw','$location')";
					
						$Konek->Exec_Query_Mysql($query);
						$comment = "Data Kartu No. ".$no_kartu." Berhasil Disimpan";
					}																	
			}
			
			?>
			
			  <div class="searchbox">
			  <table width="350" border="0" cellpadding="0" cellspacing="3" style="padding-bottom:10px; padding-left:8px; padding-right:8px;">
                <!--DWLayoutTable-->
				<tr><td colspan="3" valign="top" style="padding-bottom:10px;"><b>Edit Kartu</b></td></tr>
                <tr style="padding-bottom:10px; padding-left:8px; padding-right:8px;">
                  <td width="100" height="22" valign="top" class="arial01">No Kartu</td>
                  <td width="10" valign="top">:</td>
                  <td valign="TOP"><input name='no_kartu' type='hidden' id='no_kartu' value='<?php if($_GET[edit]==1) echo $_GET[no_kartu];?>'/><?php echo $_GET[no_kartu];?></td>
                </tr>
                <tr>
                  <td height="22" valign="top" class="arial01">Pegawai</td>
                  <td valign="top">:</td>
                  <td valign="middle">
				  <select name="emp_number_kartu" id="emp_number_kartu">
						<option value="0">Tidak ada data pegawai</option>
						<?php 
																		
						$emp_number_kartu = $row['emp_number_kartu'];
												
						$query2="
						select a.* 
						from employee a					
						order by emp_name asc";
						
						//$comment=$query2;
						$hasil2 = $Konek->Exec_Query_Mysql($query2);
						while($row2 = mysql_fetch_array($hasil2))
							{
									$emp_firstname = $row2['emp_name'];
									$emp_number = $row2['emp_id'];
									$lokasi = $nama_mesin;
									$location =$nama_mesin;
									
							?>
							
							<option value="<?php echo $emp_number; ?>,<?php echo $location; //echo $emp_number; ?>" <?php $value = $emp_number; if($row2[emp_id]==$row_edit[emp_number_kartu])  echo "selected";?>><?php echo $emp_firstname." - ".$row2[emp_id]." - ".$lokasi; ?></option>
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
				
				  <input name="save" id="save" type="submit" class="button" value="save">
				 				           &nbsp;&nbsp;
                    <input name="Cancel" type="button" class="button" onClick="location='lihat_semua_kartu.php'";" value="Cancel"></td>
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
              </table>		
			  </div>
		
			 
	</div>	
</div> <!-- end of body wrapper -->

  <?php  
	$Konek->Close_Mysql();
	?>
 <!-- end of footer wrapper -->
</form>
</body>
</html>
