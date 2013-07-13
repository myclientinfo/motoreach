<?php

require_once '../include.php';
require_once '../classes/class.extend_auction.php';
require_once '../classes/class.extend_user.php';
require_once '../classes/class.credit.php';
require_once '../classes/class.vehicle_details.php';

$user = new Extend_User(false, false, true, 'auction_users');

$_POST['signup_time'] = date('Y-m-d H:i:s');
$_POST['statusID'] = 6;
$_POST['location_id'] = User::getRegion($_POST['zip']);

if($_POST['description'] == 'optional') $_POST['description'] = '';

$user_id = $user->save();
$user = new Extend_User($user_id, false, true, 'auction_users');
User::addCampaignMonitorSubscriber($user->data);

$_POST['userID'] = $user_id;
$_POST['id'] = $user_id;

$content = new VehicleDetails(false, false, true, 'vehicle_details');

$id = $content->save();	

echo $id;

//$content = new VehicleDetails($id, false, true, 'vehicle_details');

//$desc = $content->data['year'].' '.$content->data['make'].' '.$content->data['model'].' '.@$content->data['badge'];
//$return_page = 'http://'.$_SERVER['HTTP_HOST'].'/confirm_sale.php';



//header('location: confirm_sale.php?auction_id='.$id);
die();
?>