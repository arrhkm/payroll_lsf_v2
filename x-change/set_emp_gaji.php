<?php
# Koneksi and  select DB 
require_once ("../connections/CConnect.php");

$db= New Database();
$db->Connect();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>PT. Lintech</title>
<meta name="keywords" content="orando template, blog page, website template, CSS, HTML, drop down menu" />
<meta name="description" content="Orando Template, Blog Page, Free Template with Drop Down menu, designed by templatemo.com" />
<link href="templatemo_style.css" rel="stylesheet" type="text/css" />

<link rel="stylesheet" type="text/css" href="../css/ddsmoothmenu.css" />

<script type="text/javascript" src="../js/jquery.min.js"></script>
<script type="text/javascript" src="../js/ddsmoothmenu.js">
/***********************************************
* Smooth Navigational Menu- (c) Dynamic Drive DHTML code library (www.dynamicdrive.com)
* This notice MUST stay intact for legal use
* Visit Dynamic Drive at http://www.dynamicdrive.com/ for full source code
***********************************************/

</script>

<script type="text/javascript">

ddsmoothmenu.init({
	//Menu javascript untuk setting tampilan menu letaknya ada di :\htdocs\payroll\css\ddsmoothmenu.css
	mainmenuid: "templatemo_menu", //menu DIV id
	orientation: 'h', //Horizontal or vertical menu: Set to "h" or "v"
	classname: 'ddsmoothmenu', //class added to menu's outer DIV
	customtheme: ["#", "#"],
	contentsource: "markup" //"markup" or ["container_id", "path_to_menu_file"]
})

</script>

<link rel="stylesheet" href="../css/slimbox2.css" type="text/css" media="screen" /> 
<script type="text/JavaScript" src="../js/slimbox2.js"></script> 

</head>
<body>
<!-- Header Menu -->


<div id="templatemo_main" class="wrapper">
	<!-- Tempat Menaruh Tabel ISI -->
	    <h2>Upload File emp Gaji CSV</h2>
		<h5> Format file example : P001, 89500 </h5><br>
		<h5>Ketik dulu di Open Office / Ms. excel seperti berikut :</h5><br>
		
		
		
		<h5> <br><br><hr> Lalu simpan dalam format *.CSV dengan splitter ", "</h5>
		<br>Tekan Browse dan pilih File yang sudah anda simpan dalam format CSV tadi,
		<br> Ingat pastikan tanggal In dan Out sudah sesuai yang diinginkan !.
		<br>
		<hr>
		<form action="baca_set_emp_gaji.php" method="post" enctype="multipart/form-data" name="FUpload" id="FUpload"> 
		<p>File  :
		<input name="filecsv" type="file" id="filecsv" size="30" />
		</p>
		<p><input type="submit" name="btn_upload" id="btn_upload" value="Upload" /></p>
		</form>   	
	<div class="clear"></div>
	</div>
<!--Footer-->
</body>
</html>