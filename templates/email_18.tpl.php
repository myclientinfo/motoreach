<?php 
$total = $content['total'];
unset($content['total']);
//$GLOBALS['debug']->printr($content);
?>
<html>
<head>
	<title>Message from MotoReach</title>
	<style>
	body{
		background-color: #15008b;
		font-family: Tahoma, sans-serif;
		font-size: 12px;
	}
	a {
		color: #FF7F00;
		font-weight: bold;
		font-size: 12px;
		text-decoration: none;
		
	}
	a:hover {text-decoration: underline;}
	h3 {
		color: #FF7F00;
		font-size: 14px;
	}
	td {font-size: 12px;}
	table table td { padding: 5px;}
	table table table td { padding: 2px; font-size: 11px;}
	</style>
</head>

<body bgcolor="#15008b">

	<table align="center" width="600">
	<tr>
		<td><img src="http://www.motoreach.com/images/logo.png" /></td>
	</tr>
	<tr>
		<td bgcolor="white">
		
			<p style="margin: 5px; margin-bottom: 0px; font-size: 13px;"><b>The following vehicles have been put on the site yesterday. Please "request seller contact information" if you are interested in purchasing one of these vehicles.</b></p>
		
			<table>
			<?php 
			$i = 1;
			foreach($data as $v){ ?>
			<tr>
				<td>
				<h3><?php echo $v['vehicle']?></h3>
				
				
				
					<table align="center" border="0" style="background-color: #ebebeb; margin-left:10px;">
					<tr>
						<td colspan="6" align="center" style="padding-top: 5px; font-size: 14px;"><b>Vehicle Details</b><br><br></td>
					</tr>
					<tr>
						<td width="80"><b>Location</b></td>
						<td width="180"><?php echo $v['city']?></td>
						<td width="80"><b>Mileage</b></td>
						<td width="180"><?php echo $v['mileage']?></td>
						<td width="80"><b>Spend</b></td>
						<td width="180">$<?php echo $v['spend']?></td>
					</tr>
					<tr>
						<td><b>Colour</b></td>
						<td><?php echo $v['colour']?></td>
						<td><b>Interior</b></td>
						<td><?php echo $v['interior']?></td>
						<td><b>Int Colour</b></td>
						<td><?php echo $v['interior_colour']?></td>
					</tr>
					<tr>
						<td><b>Fuel</b></td>
						<td><?php echo $v['fuel']?></td>
						<td><b>Transmission</b></td>
						<td><?php echo $v['transmission']?></td>
						<td><b>Drive</b></td>
						<td><?php echo $v['drive']?></td>
					</tr>
					<tr>
						<td><b>Roof</b></td>
						<td><?php echo $v['roof']?></td>
						<td><b>Body</b></td>
						<td><?php echo $v['body']?></td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td><b>Doors</b></td>
						<td><?php echo $v['doors']?></td>
						<td><b>Cylinders</b></td>
						<td><?php echo $v['cylinders']?></td>
						<td></td>
						<td></td>
					</tr>
					</table>
				
				<?php echo $v['description'] != '' ? '<p><span style="font-weight: bold; font-size: 14px;">Description</span> <br><br>'.nl2br($v['description']).'</p>' : '' ?>
				
				<a href="">request seller contact information</a>
				
				<?php if($i<$total){ ?>
				<br><br>
				<hr>
				<?php } ?>
				</td>
			</tr>
			<?php 
				$i++;
			} ?>
			<tr height="5">
				<td></td>
				<td></td>
				<td></td>
			</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td><img src="http://www.motoreach.com/images/email_footer.gif" /></td>
	</tr>
	</table>

</body>
</html>
