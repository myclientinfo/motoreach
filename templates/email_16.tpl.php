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

</style>
</head>

<body bgcolor="#15008B" style="background-color: #15008B; color: black; font-family: verdana;" >
<?php
//$GLOBALS['debug']->printr($data);
?>
<table width="700" align="center">
<tr>
	<td colspan="2"><img src="<?php echo ONLINE_PATH ?>images/logo.png" align="right" /></td>
</tr>
</table>


<table width="780" align="center" id="main_content" cellspacing="0" bgcolor="white" style="font-size: 12px;">
<tr>
	<td colspan="2" style="padding: 15px;">
	
	You recently expressed interest in the following vehicle, but it had already received more than 10 interested parties. It has now been re-listed and you are able to request the seller's information again.<br /><br />
	</td>
</tr>
<tr>
	<td valign="top" width="50%">

<table align="center" id="main_content" cellspacing="5" bgcolor="white" style="font-size: 12px;">
<tr>
	<td valign="top" width="45%" style="color: #FF7F00; text-align: right; ">Vehicle</td>
	<td valign="top" width="55%"><?php echo Site::drawPlainText('model', $data['make'] . ' ' . $data['model'] . ' ' . $data['badge']  . ' ' . $data['series'])?></td>
</tr><?php
$month_array = Site::getShortMonthsArray();
?>
<tr>
	<td valign="top" class="label" style="color: #FF7F00; text-align: right; ">Build Date</td>
	<td valign="top"><?php echo Site::drawPlainText('year', $month_array[$data['build_month']].' '.$data['year']) ?></td>
</tr>
<tr>
	<td valign="top" class="label" style="color: #FF7F00; text-align: right; ">Mileage</td>
	<td valign="top"><?php echo Site::drawPlainText('mileage', $data['mileage'].'km').BR2 ?></td>
</tr>
<tr>
	<td valign="top" class="label" style="color: #FF7F00; text-align: right; ">Listed</td>
	<td valign="top"><?php echo Site::drawPlainText('auction_starts', date(DATE_TIME, $data['dateentered']))?></td>
</tr>
<tr>
	<td valign="top" class="label" style="color: #FF7F00; text-align: right; ">Listed Until</td>
	<td valign="top"><?php echo Site::drawPlainText('auction_ends', date(DATE_TIME, $data['auction_end'])).BR2?></td>
</tr>
<tr>
	<td valign="top" class="label" style="color: #FF7F00; text-align: right; ">Location</td>
	<td valign="top"><?php echo Site::drawPlainText('city', $data['city'])?></td>
</tr>
<tr>
	<td valign="top" class="label" style="color: #FF7F00; text-align: right; ">Offers From</td>
	<td valign="top"><?php echo Site::drawPlainText('current_price', $_SESSION['l10n']['currency_symbol'].number_format($data['startprice']))?></td>
</tr>
<?php if($data['buyoutprice']!=''){ ?>
<tr>
	<td valign="top" class="label" style="color: #FF7F00; text-align: right; ">Own It For</td>
	<td valign="top"><?php if($data['buyoutprice']){ echo Site::drawPlainText('buyoutprice', $_SESSION['l10n']['currency_symbol'].number_format($data['buyoutprice'])); }?></td>
</tr>
<?php } ?>
<tr>
	<td valign="top" class="label" style="color: #FF7F00; text-align: right; ">To Spend</td>
	<td valign="top"><?php echo Site::drawPlainText('spend', $_SESSION['l10n']['currency_symbol'].$data['spend'])?></td>
</tr>
<tr>
	<td valign="top" class="label" style="color: #FF7F00; text-align: right; ">Rego Ends</td>
	<td valign="top"><?php echo Site::drawPlainText('registration', $data['registration'])?></td>
</tr>
</table>

	</td>
	<td valign="top" width="50%">
	
<table align="center" id="main_content" cellspacing="5" bgcolor="white" style="font-size: 12px;">
<tr>
	<td valign="top" width="50%" style="color: #FF7F00; text-align: right; ">Personal Import</td>
	<td valign="top" width="50%"><?php echo $data['import']?'Yes':'No'?></td>
</tr>
<tr>
	<td valign="top" class="label" style="color: #FF7F00; text-align: right; ">Flood Affected</td>
	<td valign="top"><?php echo $data['flood_affected']?'Yes':'No' ?></td>
</tr>
<tr>
	<td valign="top" class="label" style="color: #FF7F00; text-align: right; ">Update Model</td>
	<td valign="top"><?php echo $data['upgrade']?'Yes':'No'?></td>
</tr>
<tr>
	<td valign="top" class="label" style="color: #FF7F00; text-align: right; ">Colour</td>
	<td valign="top"><?php echo $data['colour'] ?></td>
</tr>
<tr>
	<td valign="top" class="label" style="color: #FF7F00; text-align: right; ">Interior</td>
	<td valign="top"><?php echo $data['interior'] ?></td>
</tr>
<tr>
	<td valign="top" class="label" style="color: #FF7F00; text-align: right; ">Interior Colour</td>
	<td valign="top"><?php echo $data['interior_colour'] ?></td>
</tr>
<tr>
	<td valign="top" class="label" style="color: #FF7F00; text-align: right; ">Fuel</td>
	<td valign="top"><?php echo $data['fuel'] ?></td>
</tr>
<tr>
	<td valign="top" class="label" style="color: #FF7F00; text-align: right; ">Transmission</td>
	<td valign="top"><?php echo $data['transmission'] ?></td>
</tr>
<tr>
	<td valign="top" class="label" style="color: #FF7F00; text-align: right; ">Body</td>
	<td valign="top"><?php echo $data['body'] ?></td>
</tr>
<tr>
	<td valign="top" class="label" style="color: #FF7F00; text-align: right; ">Drive</td>
	<td valign="top"><?php echo $data['drive'] ?></td>
</tr>
<tr>
	<td valign="top" class="label" style="color: #FF7F00; text-align: right; ">Doors</td>
	<td valign="top"><?php echo $data['doors'] ?></td>
</tr>
<tr>
	<td valign="top" class="label" style="color: #FF7F00; text-align: right; ">Cylinders</td>
	<td valign="top"><?php echo $data['cylinders'] ?></td>
</tr>
<tr>
	<td valign="top" class="label" style="color: #FF7F00; ">Comments</td>
	<td valign="top"></td>
</tr>
<tr>
	<td valign="top" colspan="2"><?php echo $data['description'] ?></td>
</tr>
</table>

	</td>
</tr>
<tr>
	<td colspan="2" style="padding: 15px;">
	Accepting offers from <?php echo $_SESSION['l10n']['currency_symbol'].number_format($data['startprice'])?>. Interested in buying? <a href="<?php echo ONLINE_PATH ?>items.php?itemID=<?php echo $data['ID']?>&request_contact">Request seller's contact information</a>.<br /><br />
	
	Make requests before <?php echo date(DATE_TIME, $data['auction_end'])?><br /><br />
	
	</td>
</tr>
</table>


</body>
</html>