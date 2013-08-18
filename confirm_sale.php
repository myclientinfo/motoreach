<?php
require_once 'include.php';
require_once 'classes/class.extend_auction.php';
require_once 'classes/class.extend_user.php';
require_once 'classes/class.credit.php';
require_once 'classes/class.vehicle_details.php';

if(isset($_GET['vpc_MerchTxnRef'])){
	$_REQUEST['auction_id'] = $_GET['vpc_MerchTxnRef'];
	$_GET['auction_id'] = $_GET['vpc_MerchTxnRef'];
}

$id = isset($_REQUEST['auction_id']) ? (int)$_REQUEST['auction_id'] : false ;
$user_id = isset($_GET['user_id'])? (int)$_GET['user_id'] : false;

$content = new VehicleDetails($id, false, true, 'vehicle_details', '');

if($user_id){
	$user = new Extend_User($user_id, 'false', true, 'auction_users', '');
	$user = $user->data;
} else if($id) {
	$user = new Extend_User($content->data['userID'], 'false', true, 'auction_users', '');
	$user = $user->data;
}

$user_id = $user['ID'];
$response = false;
$log = false;

if(isset($_GET['auction_id'])){

	Auction::setStatus($id, 2);
	Auction::sendVehicleMatches($id, $user['ID'], $content);

	$log = Message::getLog(9, $id);
	
	$message = new Message();
	$message_data = $message->getMessageData(17, $user_id);
	$message->sendMessage($content->data, $message_data);
	
} 

$main_content = new Template('confirm_sale');
$main_content->set('response', $response);
$main_content->set('log', $log);
$main_content->set('content', $content->data);

$template->set('content', $main_content->fetch());
echo $template->fetch();
?>