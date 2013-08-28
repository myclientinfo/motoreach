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

?>
<table width="700" align="center">
<tr>
	<td colspan="2"><img src="<?php echo ONLINE_PATH ?>images/logo.png" align="right" /></td>
</tr>
</table>

<table width="780" align="center" id="main_content" cellspacing="0" bgcolor="white" style="font-size: 12px;">
<tr>
	<td colspan="2" style="padding: 15px;">
	<h1>A new vehicle has been listed in <?php echo $data['region'] ?> that matches your saved interests.</h1><br />
	<?php if($data['user_type_id'] == 5){ ?>

	<h1>THIS IS A PUBLIC VEHICLE</h1>
	<h2>This vehicle is from the MyMotoReach public site and as such we kindly remind that they be treated in accordance. <a href="<?php echo ONLINE_PATH?>items.php?itemID=<?php echo $data['auction_id']?>&request_contact">Request seller's contact information</a></h2>
	<h2>70% of people selling a vehicle are also looking to replace it. We recommend treating public sales as a prospect.</h2>
		
	<?php } ?>
	<br /><br />
	</td>
</tr>
<tr>
	<td valign="top" width="50%">

<table align="center" id="main_content" cellspacing="5" bgcolor="white" style="font-size: 12px;">
<tr>
	<td valign="top" width="45%" style="color: #FF7F00; text-align: right; ">Vehicle</td>
	<td valign="top" width="55%"><a href="http://www.motoreach.com/items.php?itemID=<?php echo $data['ID']?>"><?php echo Site::drawPlainText('model', $data['make'] . ' ' . $data['model'] . ' ' . @$data['badge']  . ' ' . @$data['series'])?></a></td>
</tr><?php
$month_array = Site::getShortMonthsArray();

if($data['user_type_id'] == 5){
?>
<tr>
	<td valign="top" class="label" style="color: #FF7F00; text-align: right; ">Year</td>
	<td valign="top"><?php echo Site::drawPlainText('year', $data['year']) ?></td>
</tr>
<?php } else { ?>
<tr>
	<td valign="top" class="label" style="color: #FF7F00; text-align: right; ">Build Date</td>
	<td valign="top"><?php echo Site::drawPlainText('year', ($data['build_month']=='111'?'Various':str_replace('Month','',$month_array[$data['build_month']])).' '.$data['year']) ?></td>
</tr>
<?php if($_SESSION['l10n']['country_code']!='IE'){ ?>
<tr>
	<td valign="top" class="label" style="color: #FF7F00; text-align: right; ">Compliance Date</td>
	<td valign="top"><?php echo Site::drawPlainText('comp_year', ($data['comp_month']=='111'?'Various':str_replace('Month','',$month_array[$data['comp_month']])).' '.$data['comp_year']) ?></td>
</tr>
<?php } else { ?>
<tr>
	<td valign="top" class="label" style="color: #FF7F00; text-align: right; ">NCT</td>
	<td valign="top"><?php echo Site::drawPlainText('nct', $data['nct_month'].' '.$data['nct_year']).BR2 ?></td>
</tr>
<?php } ?>
<?php } ?>
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
	<td valign="top"><?php echo Site::drawPlainText('city', $data['region'])?></td>
</tr>
<?php if($data['startprice']){ ?>
<tr>
	<td valign="top" class="label" style="color: #FF7F00; text-align: right; ">Offers From</td>
	<td valign="top"><?php echo Site::drawPlainText('current_price', $_SESSION['l10n']['currency_symbol'].number_format($data['startprice']))?></td>
</tr>
<?php } ?>
<?php if(false){ ?>
<tr>
	<td valign="top" class="label" style="color: #FF7F00; text-align: right; ">Own It For</td>
	<td valign="top"><?php 
	if($data['buyoutprice']){ 
		echo Site::drawPlainText('buyoutprice', $_SESSION['l10n']['currency_symbol'].number_format($data['buyoutprice'])); 
	}?></td>
</tr>
<?php } ?>
<?php if($data['spend']){ ?>
<tr>
	<td valign="top" class="label" style="color: #FF7F00; text-align: right; ">To Spend</td>
	<td valign="top"><?php echo Site::drawPlainText('spend', $_SESSION['l10n']['currency_symbol'].$data['spend'])?></td>
</tr>
<?php } 
if($data['registration']==0){
	$rego = 'No rego';
} else if($data['is_lot'] && $data['registration']=='111'){
	$rego = 'Various';
} else {
	$rego = $data['registration'];
}
?>
<!--<tr>
	<td valign="top" class="label" style="color: #FF7F00; text-align: right; ">Rego Ends</td>
	<td valign="top"><?php echo Site::drawPlainText('registration', $rego)?></td>
</tr>-->
</table>

	</td>
	<td valign="top" width="50%">
	
<table align="center" id="main_content" cellspacing="5" bgcolor="white" style="font-size: 12px;">
<tr>
	<td valign="top" width="50%" style="color: #FF7F00; text-align: right; ">Personal Import</td>
	<td valign="top" width="50%"><?php echo $data['import']?'Yes':'No'?></td>
</tr>
<tr>
	<td valign="top" class="label" style="color: #FF7F00; text-align: right; ">Colour</td>
	<td valign="top"><?php echo $data['is_lot'] && $data['colour_id'] == '111' ? 'Various' : $data['colour'] ?></td>
</tr>
<tr>
	<td valign="top" class="label" style="color: #FF7F00; text-align: right; ">Interior</td>
	<td valign="top"><?php echo $data['is_lot'] && $data['interior_type_id'] == '111' ? 'Various' : $data['interior'] ?></td>
</tr>
<tr>
	<td valign="top" class="label" style="color: #FF7F00; text-align: right; ">Interior Colour</td>
	<td valign="top"><?php echo $data['is_lot'] && $data['interior_colour_id'] == '111' ? 'Various' : $data['interior_colour'] ?></td>
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
	<td valign="top" class="label" style="color: #FF7F00; text-align: right; ">Engine Size</td>
	<td valign="top"><?php echo $data['engine_size'] ?></td>
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
	
	<?php if(true){ ?>
	
	<br /><br />
	
	<table align="center" cellspacing="10" style="font-size: 12px;">
	<tr>
		<td align="right" valign="top" style="color: #FF7F00; "><strong><?php echo $data['user_type_id'] == 5 ? 'Seller' : 'Dealer' ?></td>
		<td valign="top"><?php echo $data['fullname'] ?></td>
	</tr>
	<?php if($data['user_type_id'] != 5){ ?>
	<tr>
		<td align="right" valign="top" style="color: #FF7F00; "><strong>Mobile</strong></td>
		<td valign="top"><?php echo $data['mobile'] ?></td>
	</tr>
	<?php } ?>
	<tr>
		<td align="right" valign="top" style="color: #FF7F00; "><strong>Phone</strong></td>
		<td valign="top"><?php echo $data['phone'] ?></td>
	</tr>
	<?php if($data['user_type_id'] != 5){ ?>
	<tr>
		<td align="right" valign="top" style="color: #FF7F00; "><strong>Dealership</strong></td>
		<td valign="top"><?php echo $data['dealership_name'] ?>, <?php echo $data['city2'] ?></td>
	</tr>
	<?php } ?>
	</table>
	<?php } else { ?>
		Interested in buying? <a href="<?php echo ONLINE_PATH ?>items.php?itemID=<?php echo $data['auction_id']?>&request_contact">Request seller's contact information</a>.<br /><br />
		
		Make requests before <?php echo date(DATE_TIME, $data['auction_end'])?><br /><br />
	<?php } ?>
	
	
	
	Do not wish to see <?php echo $data['make'] . ' ' . $data['model'] ?> in future? Do not send me <a href="<?php echo ONLINE_PATH ?>user/editaccount.php?edit=match&mode=add_exclusion&itemID=<?php echo $data['auction_id'] ?>&&do_not_want"><?php echo $data['make'] . ' ' . $data['model']?></a>. Do not send me <a href="<?php echo ONLINE_PATH ?>user/editaccount.php?edit=match&mode=add_exclusion&itemID=<?php echo $data['auction_id'] ?>&do_not_want=make">Any <?php echo $data['make'] ?></a>.<br /><br />
	
	Extremely popular vehicles may get many interested offers. Improve your chances and <a href="<?php echo ONLINE_PATH ?>items.php?itemID=<?php echo $data['auction_id']?>&offer">make a provisional offer</a>.
	</td>
</tr>
</table>


</body>
</html>