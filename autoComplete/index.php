<?php
$koneksi=mysql_connect("localhost", "root", "");
mysql_select_db("etika");

?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Ajax Auto Suggest</title>

<script type="text/javascript" src="./autoComplete/jquery-1.2.1.pack.js"></script>
<script type="text/javascript">
	function lookup(inputString) {
		if(inputString.length == 0) {
			// Hide the suggestion box.
			$('#suggestions').hide();
		} else {
			$.post("./autoComplete/rpc.php", {queryString: ""+inputString+""}, function(data){
				if(data.length >0) {
					$('#suggestions').show();
					$('#autoSuggestionsList').html(data);
				}
			});
		}
	} // lookup
	
	function fill(thisValue) {
		$('#inputString').val(thisValue);
		setTimeout("$('#suggestions').hide();", 200);
	}
</script>

<style type="text/css">
	body {
		font-family: Helvetica;
		font-size: 11px;
		color: #000;
	}
	
	h3 {
		margin: 0px;
		padding: 0px;	
	}

	.suggestionsBox {
		position: relative;
		left: 30px;
		margin: 10px 0px 0px 0px;
		width: 200px;
		background-color: #212427;
		-moz-border-radius: 7px;
		-webkit-border-radius: 7px;
		border: 2px solid #000;	
		color: #fff;
	}
	
	.suggestionList {
		margin: 0px;
		padding: 0px;
	}
	
	.suggestionList li {
		
		margin: 0px 0px 3px 0px;
		padding: 3px;
		cursor: pointer;
	}
	
	.suggestionList li:hover {
		background-color: #659CD8;
	}
</style>

</head>

<body>


	<div>
		<form action=index.php>
			<div>
				Type your county:
				<br />
				<input type="text" name= "inputString" size="30" value="" id="inputString" onkeyup="lookup(this.value);" onblur="fill();" />
				<input type=submit name="src" value="Search">
			</div>
			
			<div class="suggestionsBox" id="suggestions" style="display: none;">
				<img src="upArrow.png" style="position: relative; top: -12px; left: 30px;" alt="upArrow" />
				<div class="suggestionList" id="autoSuggestionsList">
					&nbsp;
				</div>
			</div>
		</form>
	</div>
<?php
$emp=explode("-",$_REQUEST[inputString]);
if ($emp[0]!="") {
$sql_data="SELECT * FROM employee WHERE emp_id='$emp[0]'";
$rs_data=mysql_query($sql_data, $koneksi);
}
else {
$sql_data="SELECT * FROM employee";
$rs_data=mysql_query($sql_data, $koneksi);
}
?>
<table>
<?php while ($row_data=mysql_fetch_assoc($rs_data)) { ?>
<tr>
<td><?php echo $row_data[emp_id];?></td><td><?php echo $row_data[emp_name];?></td>
</tr>
<?php } ?>
</table>
</body>
</html>
