<?php 
//$GLOBALS['debug']->printr($email);
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
	<p>You have a motor dealer interested in your vehicle being wholesaled on MotoReach.com. The following is the contact information for the interested dealer. Please contact them regarding this vehicle.</p>
	
	<table align="center" cellspacing="10" style="font-size: 12px;">
	<tr>
		<td align="right" valign="top" width="100" style="color: #FF7F00; "><strong>Vehicle</strong></td>
		<td valign="top"><?php echo '<a href="'.ONLINE_PATH.'items.php?itemID='. $data['ID'].'">'.$data['make'] . ' ' . $data['model'] . ' ' . $data['badge'].'</a>' ?></td>
	</tr>
	<tr>
		<td align="right" valign="top" style="color: #FF7F00; "><strong>Colour</strong></td>
		<td valign="top"><?php echo $data['bidder_data']['colour'] ?></td>
	</tr>
	<tr>
		<td align="right" valign="top" style="color: #FF7F00; "><strong>Dealer</td>
		<td valign="top"><?php echo $data['bidder_data']['fullname'] ?></td>
	</tr>
	<?php if($data['bidder_data']['mobile']!=''){ ?>
	<tr>
		<td align="right" valign="top" style="color: #FF7F00; "><strong>Mobile</strong></td>
		<td valign="top"><?php echo $data['bidder_data']['mobile'] ?></td>
	</tr>
	<?php } ?>
	<tr>
		<td align="right" valign="top" style="color: #FF7F00; "><strong>Phone</strong></td>
		<td valign="top"><?php echo $data['bidder_data']['phone'] ?></td>
	</tr>
	<tr>
		<td align="right" valign="top" style="color: #FF7F00; "><strong>Dealership</strong></td>
		<td valign="top"><?php echo $data['bidder_data']['dealership_name'] ?>, <?php echo $data['bidder_data']['city'] ?></td>
	</tr>
	</table>
	</td>
</tr>
</table>



</body>
</html>

<?php

?>