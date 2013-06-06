<div id="admin_permissions_checks" style="margin-bottom: 10px;<?php echo $is_new?' display: none;':''?>" >
<label style="text-align: left;">Permissions</label><br /><br />
<?php
$permissions = Site::getLookupTable('permissions', 'id', 'action');

$i = 1;
foreach($permissions as $k => $p){ 
	//if($p == 'Admin') continue;
	if($p == 'Super Admin') continue;
	if($p == 'Bid') continue;
?>
<span style="<?php echo $i%2 ? '' : 'margin-left: 60px;' ?>"><?php echo $p?></span><input value="<?php echo $k?>" <?php echo (in_array($p, $user_permissions)?' checked="true"':'') ?> type="checkbox" name="permission[<?php echo $p?>]"><?php echo $i%2 ? '' : '<br /><br />' ?>
<?php 
$i++;
}
echo Site::drawDiv('', true);
?>
</div>