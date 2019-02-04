<!DOCTYPE html>
<html>
<head>
<script>
function myFunction()
{
	var r=confirm("Press a button");
	if (r==true)
	  {
		//x="You pressed OK!";
		window.location.href = "./m_periode.php"
	  }
	else
	  {
	  x="You pressed Cancel!";
	  } 
}
</script>
</head>
<body>

<input type="button" onclick="myFunction()" value="Show alert box">

</body>
</html>