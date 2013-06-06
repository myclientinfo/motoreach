<?php

require_once '../include.php';

Auction::closeClosed();


$closes = Auction::getUpcomingCloses();
foreach($closes as $b){
	$message = new Message();
	$message_data = $message->getMessageData(7, $b['userID']);
	print "get message in placebid\n";
	print_r($message_data);
	$message->sendMessage($item->data, $message_data);
}

?>