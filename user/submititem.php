<?php

/**
* 
* @package auction
* 
* These classes are a complete auction framework, ready to implement using a minimum amount of procedural PHP code, 
* and a templating system like Smarty. The database abstraction layer AdoDB is used.
* @version $Id: submititem.php,v 1.6 2005/07/28 04:02:29 woostachris Exp $
* @copyright 2005
/

/**
* Copyright (C) 2005 Vickie Comrie, Nicolas Connault, Christopher Vance
* 
* Vickie Comrie: <vrcomrie@myway.com>
* Nicolas Connault: <nicou@sweetpeadesigns.com.au>
* Christopher Vance: <christopher.vance@gmail.com>
* 
* This program is free software; you can redistribute it and/or
* modify it under the terms of the GNU General Public License
 as published by the Free Software Foundation; either version 2
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

/**
 This page presents the user with an entry form for submitting new items for sale at the auction

 It also handles the form data and processes it
* 
* It works a little differently from the other pages: it is split into four phases:
* 	1. Submission of item
* 	2. Validation of data
* 	3. Preview of listing
* 	4. Confirmation and registration of listing
* 
* I decided to do it all on this page to avoid the need to set up JavaScript validation
* The form data is propagated through the session variable $listing
*/

require_once '../include.php';

$main_content = new Template('user_submititem');
$sidebar = new Template('user_sidebar');
$main_content->set('sidebar', $sidebar->fetch());

$message = "";
$stage = "submission";

$check_fields = array();

if(isset($_POST['formdata']) && $_POST['formdata'] == 'submission'){
	
	foreach(array('description', 'buyoutprice', 'startprice') as $f){
		if($_POST[$f] == 'optional') $_POST[$f] = '';
	}
	
	$item = new Item($_POST);
	
    $result = true;
	
	if($result === true && empty($check_fields)){         
		
		ob_start();
		$id = Auction::addItem($item);
		$item = Auction::getItem($id);
		
		if(User::hasPermission('Send Match')){
			$message = new Message();
			$vehicle_matches = Auction::getVehicleMatches($item);
			
			mail('matt@motoreach.com','Matches',serialize($vehicle_matches));

			$groups_preferred = User::loadGroupPreferred($_POST['userID']);
			foreach($vehicle_matches as $m){
				$message_data = $message->getMessageData(9, $m['ID'], $groups_preferred);
				$message->sendMessage($item->data, $message_data);
			}
			$log = $message->getMatchLog($id);
			mail('matt@motoreach.com','Match Log Sent',serialize($log));
			$ob = ob_get_contents();
			ob_end_clean();
		}
		
		header('location: /items.php?itemID='.$id.'&new');
	}else{        
		$stage = "submission";
		$message = $result['message'];
		$error_field = $result['field'];
	}
	
} else if(isset($_POST['formdata']) && $_POST['formdata'] == 'register'){
    
} 

$main_content->set('check_fields', $check_fields);
$main_content->set('auction', $auction);
$main_content->set('stage', $stage);
$main_content->set('message', $message);

$template->set('content', $main_content->fetch());
echo $template->fetch();

?>