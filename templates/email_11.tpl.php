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
	<p>You have expressed an interest in a vehicle being wholesaled on MotoReach.com. The following information is from the seller of this vehicle. Please contact them regarding this sale. The seller has also been sent your contact details.</p>
	
	<?php if($data['user_type_id']==5){ ?>
	<p style="font-weight: bold">The vehicle you have requested is being listed by a member of the public. Please deal with them accordingly.</p>
	<?php } ?>
	
	<table align="center" cellspacing="10" style="font-size: 12px;">
	<tr>
		<td align="right" valign="top" width="100" style="color: #FF7F00; "><strong>Vehicle</strong></td>
		<td valign="top"><?php echo '<a href="'.ONLINE_PATH.'items.php?itemID='. $data['ID'].'">'.$data['make'] . ' ' . $data['model'] . ' ' . $data['badge'].'</a>' ?></td>
	</tr>
	<tr>
		<td align="right" valign="top" style="color: #FF7F00; "><strong>Colour</strong></td>
		<td valign="top"><?php echo $data['colour'] ?></td>
	</tr>
	
	<tr>
		<td align="right" valign="top" style="color: #FF7F00; "><strong><?php echo $data['user_type_id'] == 5 ? 'Name' : 'Dealer' ?></td>
		<td valign="top"><?php echo $data['fullname'] ?></td>
	</tr>
	<tr>
		<td align="right" valign="top" style="color: #FF7F00; "><strong>Mobile</strong></td>
		<td valign="top"><?php echo $data['mobile'] ?></td>
	</tr>
	<tr>
		<td align="right" valign="top" style="color: #FF7F00; "><strong>Phone</strong></td>
		<td valign="top"><?php echo $data['phone'] ?></td>
	</tr>
	<?php if($data['user_type_id'] == 5){ ?>
	<tr>
		<td align="right" valign="top" style="color: #FF7F00; "><strong>Location</strong></td>
		<td valign="top"><?php echo $data['city'] ?></td>
	</tr>
	<?php } else { ?>
	<tr>
		<td align="right" valign="top" style="color: #FF7F00; "><strong>Dealership</strong></td>
		<td valign="top"><?php echo $data['dealership_name'] ?>, <?php echo $data['city'] ?></td>
	</tr>
	<?php } ?>
	</table>
	<p>If you are not able to contact this seller, you may wish to <a href="<?php echo ONLINE_PATH.'items.php?itemID='. $data['ID'] .'&offer' ?>">make a provisional offer</a>. You will not be charged for this.</p>
	
	</td>
</tr>
</table>



</body>
</html>

<?php

?>