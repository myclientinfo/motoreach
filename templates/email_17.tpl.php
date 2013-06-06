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

<table width="700" align="center">
<tr>
	<td colspan="2"><img src="<?php echo ONLINE_PATH ?>../images/public_logo.png" align="right" /></td>
</tr>
</table>

<table width="780" align="center" id="main_content" cellspacing="0" bgcolor="white" style="font-size: 12px;">
<tr>
  <td style="padding: 15px;"><table border="0" cellspacing="0" cellpadding="0" width="764">
    <tr>
      <td width="764" valign="top"><p>MotoReach</p>
        <p>55 McLachlan Street<br>
          Fortitude Valley, QLD 4006<br>
          Phone  <span id="phone">1300 369 370</span></p>
        <h3><strong>ABN: 68 149 519 666</strong></h3></td>
    </tr>
    </table></td>
</tr>
<tr>
  <td style="padding: 15px;">
   
    <p>Congratulations! You have now sent your vehicle to the MotoReach Vehicle Dealer Network.<br /><br />
    A summary of the details we have in our system are as follows:  </p></td>
  </tr>
<tr>
  <td style="padding: 15px;"><table width="63%" align="center" cellspacing="5" bgcolor="white" id="main_content3" style="font-size: 12px;">
    <tr>
      <td valign="top" width="52%" style="color: #FF7F00; text-align: right; ">Contact Name</td>
      <td valign="top" width="48%"><?php echo Site::drawPlainText('fullname', $data['fullname']) ?></td>
      </tr>
    <tr>
      <td valign="top" class="label" style="color: #FF7F00; text-align: right; ">Email</td>
      <td valign="top"><?php echo Site::drawPlainText('email', $data['email']) ?></td>
      </tr>
    <tr>
      <td valign="top" class="label" style="color: #FF7F00; text-align: right; ">Phone</td>
      <td valign="top"><?php echo Site::drawPlainText('phone', $data['phone'])?></td>
      </tr>
    <tr>
      <td valign="top" width="52%" style="color: #FF7F00; text-align: right; ">Address</td>
      <td valign="top" width="48%"><?php echo Site::drawPlainText('streetaddress', $data['streetaddress']) ?></td>
      </tr>
    <tr>
      <td valign="top" class="label" style="color: #FF7F00; text-align: right; ">Suburb</td>
      <td valign="top"><?php echo Site::drawPlainText('city', $data['city']) ?></td>
      </tr>
    <tr>
      <td valign="top" class="label" style="color: #FF7F00; text-align: right; ">State</td>
      <td valign="top"><?php echo Site::drawPlainText('state', $data['text_state'])?></td>
      </tr>
    <tr>
      <td valign="top" class="label" style="color: #FF7F00; text-align: right; ">Postcode</td>
      <td valign="top"><?php echo Site::drawPlainText('zip', $data['zip'])?></td>
      </tr>
    <tr>
      <td valign="top" width="45%" style="color: #FF7F00; text-align: right; ">Vehicle</td>
      <td valign="top" width="55%"><?php echo Site::drawPlainText('model', $data['make'] . ' ' . $data['model'] . ' ' . @$data['badge']  . ' ' . @$data['series'])?></td>
      </tr>
    <tr>
      <td valign="top" class="label" style="color: #FF7F00; text-align: right; ">Mileage</td>
      <td valign="top"><?php echo Site::drawPlainText('mileage', $data['mileage'].'km').BR2 ?></td>
      </tr>
  </table></td>
  </tr>

</table>


</body>
</html>