<?php 
//$GLOBALS['debug']->printr($email);
//$GLOBALS['debug']->printr($data);


?>
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
	width: 120px;
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
	You have successfully registered for MotoReach. Your access details are as follows:<br /><br />
	
	<label for="user">User: </label><?php echo $_POST['email'] ?><br />
	<label for="password">Password:</label> <?php echo $_POST['password'] ?><br /><br />

	If you need any help, please contact us immediately. Feel free to <a href="<?php echo ONLINE_PATH ?>">take a look at the site</a> straight away if you have not already.
	</td>
</tr>
</table>


</body>
</html>

<?php

?>