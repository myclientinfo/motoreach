<?php 

require_once '../include.php';

require_once '../classes/class.extend_auction.php';
require_once '../classes/class.extend_user.php';
require_once '../classes/class.vehicle_details.php';
require_once '../classes/class.reporting.php';
require_once '../classes/class.credit.php';

if(!User::hasPermission('Admin')){
	header('location: /index.php');
	die();
}

if(isset($_GET['vpc_MerchTxnRef'])){
	$_REQUEST['auction_id'] = $_GET['vpc_MerchTxnRef'];
	$_GET['auction_id'] = $_GET['vpc_MerchTxnRef'];
}

$id = isset($_REQUEST['auction_id']) ? (int)$_REQUEST['auction_id'] : false ;

$new = (int)$id === 0;
$user_id = isset($_GET['user_id'])? (int)$_GET['user_id'] : false;
$list = $id !== false ? false : true;
$country_id = isset($_GET['country_id'])? (int)$_GET['country_id'] : 1;

if(!isset($_GET['ob'])) $_GET['ob'] = 'dateentered';
if(!isset($_GET['od'])) $_GET['od'] = 'DESC';

$where = 'u.country_id = '.User::getSD('country_id');
$content = new VehicleDetails($id, $list, true, 'vehicle_details', '', $where);


if($user_id){
	echo 'if';
	$user = new Extend_User($user_id, 'false', true, 'auction_users', '');
	$user = $user->data;
	$country_id = $user['country_id'];
} else if($id) {
	echo 'else if';
	$user = new Extend_User($content->data['userID'], 'false', true, 'auction_users', '');
	$user = $user->data;
	$country_id = $user['country_id'];
} else {
	echo 'else';
	$country_id = User::getSD('country_id');
}

$content = new VehicleDetails($id, $list, true, 'vehicle_details', '', $where);

if(!empty($_POST)){
	
    $id = $content->save();
	
	$content = new VehicleDetails($id, false, true, 'vehicle_details', '', $where);
	
	if($new && $user['user_type_id']==5){
		
		$desc = $content->data['year'].' '.$content->data['make'].' '.$content->data['model'].' '.@$content->data['badge'];
		
		if(!isset($_REQUEST['dialer'])){
			$return_location = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
			$credit_string = Credit::createCCString(PRICE_PUBLIC_LIST, $id, $return_location, $desc);
			header('location:'.$credit_string);
		} else {
			$return_location = 'http://www.mymotoreach.com/confirm_sale.php';
			$credit_string = Credit::createCCString(PRICE_PUBLIC_LIST, $id, $return_location, $desc);
			echo '<a id="anzlink" href="'.$credit_string.'" target="_blank" style="font-size: 20px; ">process credit card</a>';
		}
		
		die();
		
		
	} else if(isset($_POST['send_match']) && $_POST['send_match'] == 1){
		Auction::sendVehicleMatches($id, $content->data['userID'], $content);
	}
	
}

// data is returning from the CC processor
if(isset($_GET['vpc_MerchTxnRef'])){
	Credit::logTransaction($user['ID'], $id, $_GET['vpc_Amount'], $_GET['vpc_TxnResponseCode']);
	$response = Credit::getResponseDescription($_GET['vpc_TxnResponseCode']);
	if($response['success']){
		Auction::setStatus($id, 2);
		Auction::sendVehicleMatches($id, $user['ID'], $content);
	}
	$new = true;
	
} else if(isset($_GET['token'])){
	$check = Credit::GetShippingDetails($_GET['token']);
	if($check['is']){
		Credit::ConfirmPayment();
	}
}

if(!$list){
	$form_insert = new Template('admin_user_checkboxes');
	$form_insert->set('user_permissions', User::loadUserPermissions($id));
	
	$set_new = isset($_POST['ID']) && ($_POST['ID']==0||$_POST['ID']=='') ? true : false;
	
	$info_insert = new Template('admin_item_makemodel');
	$info_insert->set('new', $set_new);
	$info_insert->set('data', $content->data);
	
	$insert_array['before'] = array('mileage'=> Site::drawDiv('submit_item_opt_left').$info_insert->fetch(), 'registration'=> Site::drawDiv('submit_item_opt_right'));
	$insert_array['after'] = array('spend' => Site::drawText('startprice', $content->data['buyoutprice'], 'Offers around').BR2, 'comp_year' => BR, 'auction_length' => BR, 'max_requests' => BR2.Site::drawDiv(), 'description'=>Site::drawDiv());
	
	if($new){
		$content->data['signup_time'] = date('Y-m-d H:i:s');
		$content->data['status'] = 1;
		$content->data['approved'] = 1;
		$content->data['admin_entered'] = 1;
		
		if($user['user_type_id'] == 5){
			$content->data['statusID'] = 6;
			$content->data['auction_length'] = 14;
			$content->data['max_requests'] = 10;
			
			
			$content->table_field_mapping['build_month'] = array('type'=>'hidden');
			$content->table_field_mapping['comp_month'] = array('type'=>'hidden');
			$content->table_field_mapping['comp_year'] = array('type'=>'hidden');
			$content->table_field_mapping['spend'] = array('type'=>'hidden');
			$content->table_field_mapping['max_requests'] = array('type'=>'hidden');
			$content->table_field_mapping['auctionlength'] = array('type'=>'hidden');
			$content->table_field_mapping['statusID'] = array('type'=>'hidden');
			$content->table_field_mapping['year'] = array('type'=>'text', 'label' => 'Year');
			$insert_array['after']['comp_year'] = '';
			$insert_array['after']['spend'] = '';
			$insert_array['after']['auction_length'] = '';
			$insert_array['after']['max_requests'] = Site::drawDiv();
			
		} else {
			
			if(isset($_GET['dialer'])){
				$content->table_field_mapping['statusID'] = array('type'=>'hidden');
			}
			
			if(!isset($_GET['public'])){
				$content->table_field_mapping['sell_reason'] = array('type'=>'hidden');
			}
			
			$content->data['statusID'] = 2;
		}
	}
} 


$main_content = new Template('generic_form');
$main_content->set('list', $list);
$main_content->set('type', 'Vehicle');

if($id && $content->data['buyoutprice'] == 0) $content->data['buyoutprice'] = '';

$main_content->set('content', $list ? $content->data_listing : $content->data);
$main_content->set('table_fields', $content->table_fields);
$main_content->set('table_field_mapping', $content->table_field_mapping);

if($list){
	$main_content->set('list_header', $content->list_header);
} else {
	
	$main_content->set('new', $new);
	$main_content->set('insert', $insert_array);
	$main_content->set('ediv', array('account_phone'=>'', 'approved'=>''));
	$main_content->set('no_br', array('build_month','comp_month'));

	$manual_select['max_requests'] = array('5'=>'5', '10'=>'10', '15'=>'15', '20'=>'20', '30'=>'30', '50'=>'50');
	$manual_select['build_month'] = Site::getShortMonthsArray();
	$manual_select['comp_month'] = Site::getShortMonthsArray();
	$manual_select['doors'] = array(2=>2,3=>3,4=>4,5=>5);
	$manual_select['cylinders'] = array(3=>3, 4=>4, 5=>5,6=>6,8=>8,10=>10,12=>12,16=>16);
	$rego_array[] = 'No Rego';
	
	for($i=0;$i<=12;$i++){
		$rego_time = mktime (12, 0, 0, date("n")+$i, 15, date("Y"));
		$rego_array[date('m-Y', $rego_time)] = date('m-Y', $rego_time);
	}
	
	$manual_select['registration'] = $rego_array;

	$main_content->set('manual_select', $manual_select);
}

$template->set('content', $main_content->fetch());
echo $template->fetch();



?>