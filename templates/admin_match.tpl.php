<style>
#newitem label {
margin-bottom: 5px;
}
</style>

<div id="inner_content_white">

<h2>Match Send Report</h2>

<a href="/admin/">Admin Home</a><br /><br />

<?php
echo Site::drawDiv('newitem');
echo Site::drawPlainText('vehicle', $data->data['year'] . ' ' . $data->data['make'] . ' ' . $data->data['model'] . ' ' . $data->data['badge'], true).BR;
echo Site::drawPlainText('fullname', $data->data['fullname'], 'Listed By').BR;
echo Site::drawPlainText('dealership', $data->data['dealership_name'], true).BR;
echo Site::drawPlainText('location', $data->data['city'], true).BR2;
echo Site::drawDiv();


if(!in_array('Send Match', $main_user_permissions)) echo '<b>No one will receive any match from this user as they do not have "Send Match" permissions set.</b>';

?>

<table class="admin_list">
<tr>
	<th><a>Name</a></th>
	<th><a>Company</a></th>
	<th><a>Email</a></th>
	<th><a>Match</a></th>
	<th><a>Log</a></th>
	<th><a>Details</a></th>
</tr>
<?php 
$i=0;
foreach($matches as $m){
	$perms = User::loadUserPermissions($m['ID']);
	$m_user = User::getCurrentUser($m['ID']);
	?>
<tr>
	<td><?php echo $m['fullname']?></td>
	<td><?php echo $m['dealership_name']?></td>
	<td><?php echo $m['email']?></td>
	<td><?php echo in_array('Match', $perms)? 'Yes' : 'No'?></td>
	<td><?php echo isset($log[$m['ID']]) ? 'Yes' : 'No'?></td>
	<td>
	<?php echo $data->dateentered < strtotime($m_user['signup_time'])? 'User was not signed up at this time.' : ''?>
	<?php echo $data->userID == $m_user['ID'] ? 'Is own vehicle, will not send. ' : '' ?>
	</td>
</tr>
<?php 
	$i++;
} ?>
</table>

</div>