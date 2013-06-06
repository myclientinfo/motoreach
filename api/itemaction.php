<?php


// check user and that vehicle belongs to user

include_once '../include.php';
include_once '../classes/class.vehicle_details.php';

//$GLOBALS['debug']->printr($_POST);
$id = $_POST['ID'];
$action = $_POST['owner_actions'];
$amount = NULL;


Auction::performAuctionAction($id, $action);
$vehicle = new Auction();
$this_vehicle = $vehicle->getItem($id);
$vehicle_data = $this_vehicle->data;

//$item = $auction->getItem($_REQUEST['itemID']);

$history_type = '';

switch($action){
	case 'notify': $history_type = 3; $type = 'Notify'; break;
	case 'sell': $history_type = 5; $new_status = 3; $type = 'Sold'; break; 
	case 'withdraw': $history_type = 6; $new_status = 5; $type = 'Withdrawn'; break;
	case 'extend': $history_type = 7; $type = 'Extended'; break;
}

if($action=='notify' && $_POST['owner_actions_notify'] == 'top10') $history_type = 4;

if($action=='sell') $amount = $_POST['amount'];

$history_id = $vehicle->recordHistory($id, $history_type, $amount);

if( $action == 'sell' || $action == 'withdraw' ){
	$auction->setStatus($id, $new_status);
	$template = new Template('history');
	$template->set('content', $history);
	echo $template->fetch();
} else if($action == 'extend'){
	echo 'extending';
	$new_end = Auction::extendListing($id);
	
	$content = new VehicleDetails($id, false, true, 'vehicle_details', '');
	
	/*
	Auction::sendVehicleMatches($id, $content->data['userID'], $content);
	
	$failed = $vehicle->getFailedRequests($vehicle_data['ID']);
	
	if($vehicle_data['count_extended'] == 0){
		$message = new Message();
		foreach($failed as $f){
			$message_data = $message->getMessageData(16, $f['user_id']);
			$message->sendMessage($vehicle_data, $message_data);
		}
	}
	*/
}

// notifications:
$message = new Message();
if($action == 'sell'){
	// recipient is current winner.
	$message_data = $message->getMessageData(5, $vehicle_data['latest_bidder']);
	$message->sendMessage($vehicle_data, $message_data);
} else if($action == 'withdrawn'){
	$message_data = $message->getMessageData(4, $vehicle_data['latest_bidder']);
	$message->sendMessage($vehicle_data, $message_data);
}

?>