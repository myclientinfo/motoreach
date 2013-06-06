
<html>
<head>
<style>
body {
	background-color: #15008B;
	color: black;
	font-family: verdana;
	
}

#main_content {
	background-color: white;
	font-size: 12px;
}

strong {
	font-weight: bold;
	color: #FF7F00;
}

label {
	color: #FF7F00;
	display: block;
	width: 80px;
	float: left;
	
}

span {
	display: block;
}
</style>
</head>

<body bgcolor="#15008B" style="background-color: #15008B; color: black; font-family: verdana;" >

<table width="600" align="center">
<tr>
	<td colspan="2"><img src="<?php echo ONLINE_PATH ?>images/logo.png" align="right" /></td>
</tr>
</table>


<table width="600" align="center" id="main_content" cellspacing="15" bgcolor="white" style="font-size: 12px;">
<tr>
	<td>
	<p style="font-size: 14px">Thank you for confirming your email address with us. This is required for the security of your account. It is now possible to update the password connected with this email.</p>
	
	<p style="font-size: 14px">Please continue to <a href="<?php echo ONLINE_PATH ?>login.php?reset&userID=<?php echo $email['ID']?>&auth=<?php echo md5(SALT.$email['email'].$email['fullname'])?>">reset your password</a>
	
	</p>
	</td>
</tr>
</table>



</body>
</html>

<?php

?>