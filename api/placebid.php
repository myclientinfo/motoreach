<?php
/**
* 
* @package auction
* 
* These classes are a complete auction framework, ready to implement using a minimum amount of procedural PHP code, 
* and a templating system like Smarty. The database abstraction layer AdoDB is used.
* @version $Id: placebid.php,v 1.2 2005/07/28 04:02:29 woostachris Exp $
* @copyright 2005
*/

/**
* Copyright (C) 2005 Vickie Comrie, Nicolas Connault, Christopher Vance
* 
* Vickie Comrie: <vrcomrie@myway.com>
* Nicolas Connault: <nicou@sweetpeadesigns.com.au>
* Christopher Vance: <christopher.vance@gmail.com>
* 
* This program is free software; you can redistribute it and/or
* modify it under the terms of the GNU General Public License
* as published by the Free Software Foundation; either version 2
* of the License, or (at your option) any later version.
* 
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.
* 
* You should have received a copy of the GNU General Public License
* along with this program; if not, write to the Free Software
* Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
*/
require_once '../include.php';
//$_REQUEST['amount'] = Site::numbersOnly($_REQUEST['amount']);
$_REQUEST['amount'] = Site::numbersOnly(@$_REQUEST['amount']);

$is_buyout = @$_REQUEST['is_buyout'] && $_REQUEST['buyout_temp'] == $_REQUEST['amount']?true:false;

// A user could enter the itemID in the URL, which means he could bid on his own item.
// This must be prevented
//echo '<pre>';

if($_SESSION['authorised'] == "valid"){
    $item = Auction::getItem($_REQUEST['itemID']);
	
	//$GLOBALS['debug']->printr($item);
	
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
	
	$bid_id = $bid->recordBid($type_id);
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
		print_r($item->data['count_requests']);
		print_r($item->data['max_requests']);
		//if($item->data['count_requests'] <= $item->data['max_requests']){
		if(true){
			if($_REQUEST['offer'] == 0){
			
				//$GLOBALS['debug']->printr($item);
			
				if($item->data['user_type_id'] != 5){
				
					// SEND EMAIL TO SELLER WITH BUYER'S DETAILS
					echo 'THIS SHOULD BE SENT TO SELLER';
					
					$message = new Message();
					$message_data = $message->getMessageData(10, $item->data['userID']);
					$item->data['bidder_data'] = $bid->getBid($bid_id);
					$message->sendMessage($item->data, $message_data, true);
				
				}
				
				// SEND EMAIL TO BUYER WITH SELLER'S DETAILS
				echo 'THIS SHOULD BE SENT TO BUYER';
				
				$message = new Message();
				$message_data = $message->getMessageData(11, $user->ID);
				$message->sendMessage($item->data, $message_data);
				
			} else {
				
				// SEND EMAIL TO SELLER WITH BUYER'S DETAILS
				echo 'THIS SHOULD BE SENT TO SELLER';
				
				$message = new Message();
				$message_data = $message->getMessageData(13, $item->data['userID']);
				$item->data['bidder_data'] = $bid->getBid($bid_id);
				$message->sendMessage($item->data, $message_data, true);
				
			}
		} else {
		
			// SEND EMAIL TO BUYER WITH SELLER'S DETAILS
			echo 'VEHICLE MAX REQUESTS EXCEEDED';
			
			$message = new Message();
			$message_data = $message->getMessageData(15, $user->ID);
			$message->sendMessage($item->data, $message_data);
		}
	}
}
?>