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
	font-size: 10px;
}

td, th {
font-size: 12px;
}

#main_content {
	background-color: white;
	
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


<table width="600" align="center" id="main_content" cellspacing="15"  bgcolor="white" style="font-size: 12px;">
<tr>
	<td>
	
<h3>PUBLIC VEHICLES</h3>	
	
<table class="admin_list" cellspacing="0" cellpadding="5" width="100%">
<tr>
	<th><a>Name</a></th>
	<th><a>Vehicle</a></th>
	<th><a>Location</a></th>
	<th><a>Date</a></th>
	<th><a>Buying</a></th>
	<th><a>Requests</a></th>
</tr>
<?php 
if(!empty($vehicles)){
$requests = 0;
$amount = 0;
foreach($vehicles as $v){
	$requests += $v['requests'];
	if($v['status']=='Active') $amount += $v['amount'];

	$req = explode(', ', $v['requested_by']);
	$req2 = array();
	foreach($req as &$r){
		if(trim($r)!='')$req2[] = $r;
	}
	
	$req = implode(', ', $req2);
?>
<tr>
	<td><?php echo $v['fullname']?></td>
	<td><a href="vehicle.php?id=<?php echo $v['itemID']?>"><?php echo $v['make']?> <?php echo $v['model'] ?></a></td>
	<td><?php echo $v['city']?></td>
	<td><?php echo date('d M - h:i ', $v['dateentered'])?></td>
	<td><?php echo $v['sell_reason']?'Yes':'No'?></td>
	<td><?php echo $v['requests']?><?php echo $req!=''?' - '.$req:''?></td>
</tr>
<?php } ?>
<tr style="background-color: #ffc994;">
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td><?php echo $requests?></td>
</tr>
<?php } else { ?>
<tr>
	<td colspan="5">There have been no matching vehicles listed.</td>
</tr>
<?php } ?>
</table>


<h3>DEALER VEHICLES</h3>

<table class="admin_list" cellspacing="0" cellpadding="5" width="100%">
<tr>
	<th><a>Name</a></th>
	<th><a>Vehicle</a></th>
	<th><a>Location</a></th>
	<th><a>Date</a></th>
	<th><a>Requests</a></th>
</tr>
<?php 
if(!empty($dealer_vehicles)){
$requests = 0;
$amount = 0;
foreach($dealer_vehicles as $v){
	$requests += $v['requests'];
	if($v['status']=='Active') $amount += $v['amount'];

	$req = explode(', ', $v['requested_by']);
	$req2 = array();
	foreach($req as &$r){
		if(trim($r)!='')$req2[] = $r;
	}
	
	$req = implode(', ', $req2);
?>
<tr>
	<td><?php echo $v['dealership_name']?></td>
	<td><a href="vehicle.php?id=<?php echo $v['itemID']?>"><?php echo $v['make']?> <?php echo $v['model'] ?></a></td>
	<td><?php echo $v['city']?></td>
	<td><?php echo date('d M - h:i ', $v['dateentered'])?></td>
	<td><?php echo $v['requests']?><?php echo $req!=''?' - '.$req:''?></td>
</tr>
<?php
}
?>
<tr style="background-color: #ffc994;">
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td><?php echo $requests?></td>
</tr>
<?php } else { ?>
<tr>
	<td colspan="5">There have been no matching vehicles listed.</td>
</tr>
<?php } ?>
</table>


	
	</td>
</tr>
</table>



</body>
</html>

<?php

?>