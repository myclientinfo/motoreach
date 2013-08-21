<?php

require_once '../include.php';
$_REQUEST['amount'] = Site::numbersOnly(@$_REQUEST['amount']);

$is_buyout = @$_REQUEST['is_buyout'] && $_REQUEST['buyout_temp'] == $_REQUEST['amount']?true:false;

if($_SESSION['authorised'] == "valid"){
    $item = Auction::getItem($_REQUEST['itemID']);
	
    $bidamount = $_REQUEST['amount'];
    $user = $_SESSION['auction']->user;
    $user->getID();
    $submitted = false;
    $itemokay = $item->checkUser($user->ID);
}

// If user has placed bid, process form data, unless the page has been refreshed
if(isset($_REQUEST['formdata'])){
	$bid = new Bid(array("itemID" => $_REQUEST['itemID'], "userID" => $user->ID));
	
	$type_id = $is_buyout?8:($_REQUEST['action_type']=='request'?'9':'1');
	
	$bid_id = $bid->recordBid();
	
	if(!$bid) die('FAILED');
	
    if($_REQUEST['action_type']!='request'){
    	Auction::setNewWinner($_REQUEST['itemID'], $bid_id);
		Auction::incrementBids($_REQUEST['itemID']);
		
		if($is_buyout){
			Auction::setStatus($_REQUEST['itemID'], 3);
		}
    	$item = $auction->getItem($_REQUEST['itemID']);
        
		$content[0] = $bid->getBid($bid_id);

		$message_type_id = $is_buyout?8:1;
		
        $message = new Message();
		$message_data = $message->getMessageData($message_type_id, $item->data['userID']);
		$message->sendMessage($item->data, $message_data);
		
		if($is_buyout){
			$message_data = $message->getMessageData(5, $user->ID);
			$message->sendMessage($item->data, $message_data);
		}
		
		$tpl = new Template('history_line');
        $tpl->set('content', $content);
		$tpl->set('type', 'placebid');
        echo $tpl->fetch();
			
		
		
    }else {
		
		$item = Auction::getItem($_REQUEST['itemID']);

		if(true){
			if($_REQUEST['offer'] == 0){
			
				if($item->data['user_type_id'] != 5){
				
					$message = new Message();
					$message_data = $message->getMessageData(10, $item->data['userID']);
					$item->data['bidder_data'] = $bid->getBid($bid_id);
					$message->sendMessage($item->data, $message_data, true);
				
				}
				
				$message = new Message();
				$message_data = $message->getMessageData(11, $user->ID);
				$message->sendMessage($item->data, $message_data);
				
			} else {
								
				$message = new Message();
				$message_data = $message->getMessageData(13, $item->data['userID']);
				$item->data['bidder_data'] = $bid->getBid($bid_id);
				$message->sendMessage($item->data, $message_data, true);
				
			}
		} else {
		
			$message = new Message();
			$message_data = $message->getMessageData(15, $user->ID);
			$message->sendMessage($item->data, $message_data);
		}
	}
}
?>