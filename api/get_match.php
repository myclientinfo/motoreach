<?php

require_once '../include.php';

$data = Auction::getItem($_GET['itemID']);

$main_user = User::getCurrentUser($data->data['userID']);
$main_user_permissions = User::loadUserPermissions($data->data['userID']);

$log = Message::getMatchLog($_GET['itemID']);
//$GLOBALS['debug']->printr($log);
if(!in_array('Send Match', $main_user_permissions)) die('No one will receive any match from this user as they do not have "Send Match" permissions set.');



$matches = Auction::getVehicleMatches($data, 1);

?>
<h3>Send Report for this item</h3>


<?php
echo Site::drawDiv('core_info');
echo Site::drawPlainText('vehicle', $data->data['make'] . ' ' . $data->data['model'] . ' ' . $data->data['badge'], true).BR2;
echo Site::drawPlainText('location', $data->data['city'], true).BR2;
echo Site::drawDiv();
//echo '<b>'. . '</b><br><br>';
?>

<table>
<tr>
	<th>Name</th>
	<th>Company</th>
	<th>Email</th>
	<th>Match</th>
	<th>Log</th>
	<th>Details</th>
</tr>
<?php
foreach($matches as $m){
	$perms = User::loadUserPermissions($m['ID']);
	$m_user = User::getCurrentUser($m['ID']);
	?>
<tr>
	<td><?php echo $m['fullname']?></td>
	<td><?php echo $m['email']?></td>
	<td><?php echo $m['dealership_name']?></td>
	<td><?php echo in_array('Match', $perms)? 'Yes' : 'No'?></td>
	<td><?php echo isset($log[$m['ID']]) ? 'Yes' : 'No'?></td>
	<td><?php echo $data->dateentered < strtotime($m_user['signup_time'])? 'User was not signed up at this time.' : ''?></td>
</tr>
<?php
}

?>
</table>