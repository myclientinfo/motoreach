
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
	<p>Your offer on this <a href="<?php echo ONLINE_PATH ?>items.php?itemID='. <?php echo $data['ID'].'">'.$data['make'] . ' ' . $data['model'] . ' ' . $data['badge'].'</a>' ?> has been sent to <?php echo $data['fullname'] ?> at <?php echo $data['dealership_name'] ?>.</p>
	</td>
</tr>
</table>



</body>
</html>

<?php

?>