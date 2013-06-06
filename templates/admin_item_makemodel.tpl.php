<?php
$match_log = Message::getLog(9, $data['auction_id']);
?>

<style>
#comp_year, #year {width: 100px;}
#admin_form label{margin-top: 3px; margin-bottom: 10px;}
#admin_form input, #admin_form select{margin-bottom: 10px;}

#submit_item_opt_right {width: 500px; float: right;}
div#submit_item_opt_right label#description_label {
	margin-bottom: 10px;
	text-align: right;
	margin-left: 0px;
}
div#submit_item_opt_right #description {
	margin-left: 0px;
	width: 300px;
	margin-bottom: 20px;
}

#submit_item_opt_left {
	width: 380px;
	float: left;
}

label {
	color: #FF7F00;
	font-family: tahoma, verdana, sans-serif;
}

#build_month, #comp_month {
	width: 80px;
}
</style>

<script>

jQuery(document).ready(function(){
	<?php if(User::getSimpleUser() == 13 || User::getSimpleUser() == 106 ){ ?>
	$('#make_fake2').bind('click',function(){
		$('#year, #comp_year').val('2008').css('color', 'black');
		$('#build_month, #comp_month').val('6');
		$('#make_id').val('Demo');
		$('#make_id').trigger('change');
		$('#auctionlength').val(2);
		$('#max_requests, #colour_id').val(5);
		$('#mileage').val('140,000');
		$('#transmission_id, #body_id, #drive_type_id, #fuel_type_id, #roof_type_id, #interior_type_id, #interior_colour_id, #doors, #cylinders').val(3);
		$('#spend').val('140,000');
		$('#startprice').val('10,000');
		$('#description').val('This is a test vehicle created by MotoReach staff for maintenance purposes. Please disregard this vehicle.').css('color', 'black');
	});
	<?php } ?>
	<?php if(!$new){?>
	
	$('#send_match_checkbox').click(function(){
		if($(this).attr('checked')=='true') alert('Warning: this will resend match emails to all matched dealers.');
	});
	
	
	<?php } else { ?>
	alert('Vehicle added for user: sent to <?php echo count($match_log)?> dealers');
	<?php } ?>
	
	
	
	$('#delete').click(function(){
		if(confirm('In most cases making the vehicle inactive is safer, and deleting can impact on reports and stats. Are you sure you want to delete this vehicle?')){
			
			$.get("/api/delete.php", {'id': $('#auction_id').val(), type: 'item'}, function(data){
				window.location = 'items.php';
			});
		}
		
	});
	
	<?php 
	//if(isset($_POST['auction_id']) && $_GET['auction_id'] == 0){ 
		
	?>
	
	$('#make_id').val("<?php echo $data['make'] ?>");
	$('#make_id').trigger('change');
	
	var t = setTimeout(function(){
		$('#model_id').val("<?php echo $data['model_id'] ?>");
		$('#model_id').trigger('change');
	},1000);
	
	var t = setTimeout(function(){
		$('#badge_id').val("<?php echo $data['badge_id'] ?>");
	},3000);
	
	<?php 
	//} 
	?>
	
	
});
</script>
<?php echo $data['make']?>

<?php if(User::getSimpleUser() == 13 || User::getSimpleUser() == 106 ){ ?>
<div id="make_fake2" style="border: 1px solid #CCCCCC; background-color: #EBEBEB; float: left; margin-right: 15px;padding: 5px; width: 160px; text-align: center; margin-bottom: 15px; display: block; cursor: pointer;">Create Test</div>

<div id="delete" style="border: 1px solid #CCCCCC;  float: left;background-color: #FF0000; color:white; padding: 5px; width: 160px; text-align: center; margin-bottom: 15px; display: block; cursor: pointer;">Delete</div>
<div style="clear: both;"></div>
<?php } ?>

<div style="">

<?php if(isset($_GET['vpc_TxnResponseCode'])){ 
	$response = Credit::getResponseDescription($_GET['vpc_TxnResponseCode']); ?>
	
	Credit Card Result: <?php echo $response['success']? 'Success' : 'Failed'?><br /><br />
	
	Credit Card Response: <?php echo $response['message']?><br /><br />
<?php } ?>

Sent to <?php echo count($match_log)?> dealers.<br />
</div>
<?php

echo Site::drawHidden('auction_id', @$data['auction_id'])."\n";
echo Site::drawHidden('ID', @$data['auction_id'])."\n";
echo Site::drawHidden('vd_id', @$data['id'])."\n";
echo Site::drawHidden('categoryID', 1)."\n";

if($data['user_type_id'] == 5){
}

if(isset($_REQUEST['dialer'])) echo Site::drawHidden('categoryID', 1)."\n";

if(isset($_GET['user_id'])){
	echo Site::drawHidden('userID', $_GET['user_id']);
} else {
	echo Site::drawSelect('userID', Site::getAdminFormattedUsers(), $data['userID'], '', 'Dealership').BR2;
}

//$GLOBALS['debug']->printr($data);

//if($_GET['auction_id']||($_GET['auction_id']==0 && isset($_POST['auction_id']) && $_POST['auction_id']!='')){
if(false){
	echo Site::drawPlaintext('make', $data['make'] . ' ' . $data['model'], 'Vehicle').BR2;
	$bdg = $data['make'].'_'.$data['model'];
	$badge_array = isset($GLOBALS['model_badges'][$bdg]) ? $GLOBALS['model_badges'][$bdg] : array();
	$series_array = isset($GLOBALS['model_series'][$bdg]) ? $GLOBALS['model_series'][$bdg] : array();
	//$GLOBALS['model_series'][$data['make'].'_'.$data['model']];
} else {
	$make_array = array_combine(array_keys($GLOBALS['make_models']), array_keys($GLOBALS['make_models']));
	echo Site::drawSelect('make_id', $make_array, @$_POST['make_id'], '', 'make').BR;
	echo Site::drawSelect('model_id', array(''=>'select a make'), @$_POST['model_id'], '', 'model').BR;
	
	$badge_array = array();
	$series_array = array();
}

echo Site::drawSelect('badge_id', $badge_array, @$data['badge_id'], '', 'badge', ' ').BR;
echo Site::drawDiv('', true);
echo Site::drawSelect('series_id', $series_array, @$data['series_id'], '', 'series', ' ').BR2;

echo Site::drawSelect('send_match', array('0'=>'No','1'=>'Yes'), empty($data)?'1':'0', '', 'Send Emails').BR2;

?>
<div style="clear: both;"></div>