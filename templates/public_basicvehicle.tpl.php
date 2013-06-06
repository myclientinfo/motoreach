

<script>
jQuery(document).ready(function(){
	$('#model_id').bind('change blur mouseup', function(){
		$('#model').val($('#model_id option:selected').text());
		$('#badge_id').trigger('change');
	});	
	$('#badge_id').bind('change blur mouseup', function(){
		$('#badge').val($('#badge_id option:selected').text());
	});	
	$('#model_id').trigger('change');
});
</script>


<div id="miniform_box">
<img alt="" src="/images/public_miniform_bg_top.png"><?php 
echo Site::drawDiv('miniform_box_inner');
$auction_lengths = array(3=>'3 Days', 5=>'5 Days', 7=>'7 Days', 9=>'9 Days', 11=>'11 Days');

$make_array = array_combine(array_keys($GLOBALS['make_models']), array_keys($GLOBALS['make_models']));

echo Site::drawForm('miniform', 'sell_vehicle.php', 'POST', 'multipart/form-data');

echo Site::drawHidden('stage', 'submission');
echo Site::drawHidden('is_lot', 0);
echo Site::drawHidden('lot_amount', 0);
echo Site::drawHidden('uniqueID', Auction::getUniqueId());
//if(User::hasPermission('Vehicles')) echo Site::drawSelect('userID', Site::getAdminFormattedUsers(), '', '', 'Dealership').BR2;
echo Site::drawHidden('userID', 0);
echo Site::drawHidden('model', '');
echo Site::drawHidden('badge', '');
echo Site::drawHidden('mini_form', 1);

echo Site::drawHidden('ID', 0);
echo Site::drawHidden('sale_type_id', 0);
echo Site::drawHidden('processed', 'no');
echo Site::drawHidden('formdata', 'miniform');
echo Site::drawHidden('categoryID', 0);

echo Site::drawLabel('make_id', 'Make').BR2;
echo Site::drawSelect('make_id', $make_array, @$_POST['make_id']).BR2;
echo Site::drawLabel('model_id', 'Model').BR;
echo Site::drawSelect('model_id', array(''=>'select a make'), @$_POST['model_id']).BR2;
echo Site::drawLabel('badge_id', 'Badge/Model Type').BR;
echo Site::drawSelect('badge_id', array('select a model'), @$_POST['badge_id']).BR2;
echo Site::drawLabel('year', 'Year');
echo Site::drawText('year', (isset($_POST['year'])?@$_POST['year']:''));
echo Site::drawDiv('', true);
echo Site::drawLabel('mileage', 'Mileage');
echo Site::drawText('mileage', (isset($_POST['mileage'])?@$_POST['mileage']:'')).BR2;

echo Site::drawHidden('auctionlength', 1);

echo Site::drawHidden('startprice', 0);
echo Site::drawHidden('buyoutprice', 0);
echo Site::drawHidden('spend', 0);

echo Site::drawHidden('max_requests', 1000);

$rego_array[] = 'No Rego';

for($i=0;$i<=12;$i++){
	$rego_time = mktime (12, 0, 0, date("n")+$i, 15, date("Y"));
	$rego_array[date('Y-m', $rego_time)] = date('Y-m', $rego_time);
}

echo Site::drawSubmitImage('miniform_continue', '/images/public_button_continue.png', array('alt' => 'click here to continue'));
echo Site::drawForm();
echo Site::drawDiv('', true);
echo Site::drawDiv();
?><img alt="" src="/images/public_miniform_bg_bottom.png">
</div>