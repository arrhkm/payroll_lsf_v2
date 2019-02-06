<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Log In</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="templatemo_style.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" height="500"  border="0" cellpadding="0" cellspacing="0" align="center">
  <tr>
    <td>
	<form action="act_login.php" method="post" name="form1" target="MainFrame" id="comment_form">
      <table width="100%"  border="0" align="center" cellpadding="2" cellspacing="2">
        <tr>
          <td colspan="2" align="left"><img src="images/lintech.jpg" width="300" height="80">
		  </td>
		</tr>
		<tr>
		  <td colspan="2" align="center">
		  <?php 
		  if (isset($_REQUEST['msg']) && $_REQUEST['msg']==0) echo "Username dan password yang anda input salah !! "; 
		  if (isset($_REQUEST['msg']) && $_REQUEST['msg']==1) echo "Username Kosong !! "; 
		  if (isset($_REQUEST['msg']) && $_REQUEST['msg']==1) echo "Password Kosong !! "; 		  
		  ?>
		  </td>
          </tr>
        <tr class="isi">
          <td align="right">&nbsp;</td>
          <td align="left">&nbsp;</td>
        </tr>
        <tr class="isi">
          <td width="" align="right">Username : </td>
          <td width="" align="left"><input name="txt_username" type="text" id="txt_username"></td>
        </tr>
        <tr class="isi">
          <td align="right">Password : </td>
          <td align="left"><input name="txt_password" type="password" id="txt_password"></td>
        </tr>
        <tr class="isi">
          <td>&nbsp;</td>
          <td align="left"><input name="login" type="submit" id="login" value="Login"></td>
        </tr>
      </table>
    </form></td>
  </tr>
  <tr>
    <td align="center"></td>
  </tr>
</table>
</body>
</html>
