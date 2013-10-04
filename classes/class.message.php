<?php

class Message{
	
	const EMAIL = 1;
	const SMS = 2;
	
	function __construct(){
		
	}
	
	function getMessagePreference($id, $user_id){
		$query = 'SELECT p.*, t.bitmask FROM notification_preference as p 
					LEFT JOIN notification_preference_type AS t ON t.id = p.preference_id 
					WHERE p.item_id = '.$id.' AND p.user_id = '.$user_id;
		$array = Site::getData($query, true);
		
		if(!isset($array[0])) return 1;
		else return $array[0]['bitmask'];
	}
	
	function getPreferenceOptions(){
		$query = 'SELECT i.*, c.category FROM notification_item AS i LEFT JOIN notification_categories AS c ON c.id = i.item_category_id WHERE active = 1';
		return Site::getData($query, false, 'id', false, 'category');
	}
	
	
	function getAllUserPreferences(){
		$query = 'SELECT * FROM notification_preference AS p LEFT JOIN notification_preference_type AS t ON t.id = p.preference_id WHERE user_id = '.$_SESSION['auction']->user->ID;
		return Site::getData($query, false, 'item_id');
	}
	
	function setMessagePreference($id, $pref){
		$query = 'REPLACE INTO notification_preference SET preference_id = '.$pref.', item_id = '.$id.', user_id = '.$_SESSION['auction']->user->ID;
		Site::runQuery($query);
	}
	
	function logMessage($message_type_id, $item_id, $user_id){
	
		$query = 'INSERT INTO message_log (message_type_id, item_id, user_id, message_time) 
						VALUES("'.$message_type_id.'", "'.$item_id.'", "'.$user_id.'", NOW())';
		
		return Site::runQuery($query);
	}
	
	function logPublicOffer($item_id, $user_id){
		$query = 'INSERT INTO public_offers (item_id, user_id) VALUES('.$item_id.', '.$user_id.')';
		return Site::runQuery($query);
	}
	
	function getLog($message_type_id, $item_id){
		$query = 'SELECT l.*, u.fullname, u.dealership_name FROM message_log AS l 
						LEFT JOIN auction_users AS u ON u.ID = l.user_id
							WHERE l.message_type_id = '.$message_type_id.' 
							AND l.item_id = '.$item_id . ' ORDER BY l.message_time DESC';
		return Site::getData($query, false);
	}
	
	function getMatchLog($id){
		$query = 'SELECT * FROM message_log WHERE item_id = '.$id.' AND message_type_id = 9'; 
		return Site::getData($query, false, 'user_id');
	}
	
	function getMessageData($message_type_id, $user_id = false, $groups_preferred = false){
		
		if(!$user_id){
			$array = (array)$_SESSION['auction']->user;
			$user_id = User::isLoggedIn();
		} else $array = User::getUserData($user_id);
		
		$pref = $this->getMessagePreference($message_type_id, $user_id);
		
		$array['send_email'] = (int)(bool)($pref & self::EMAIL);
		$array['send_sms'] = (int)(bool)($pref & self::SMS);
		$array['message_type_id'] = $message_type_id;
		
		if($message_type_id == 9){
		
			if(User::hasPermission('Admin')){
				if($array['group_id']==0){
					$array['group_preferred'] = 0;
				} else {
					$user_array = User::getUserData($_POST['userID']);
					$array['group_preferred'] = (int)(in_array($user_id, $groups_preferred)||($user_array['group_id'] != '0' && $user_array['group_id'] == $array['group_id']));
				}
			} else {
				if(!isset($_SESSION['group_preferred']) || $_SESSION['auction']->user->group_id == '0'){
					$array['group_preferred'] = 0;
				} else {
					$array['group_preferred'] = (int)(in_array($user_id, $_SESSION['group_preferred'])||($_SESSION['auction']->user->group_id != '0' && $_SESSION['auction']->user->group_id == $array['group_id']));
				}
			}
		}
		
		if($message_type_id == 10){
			$item = Auction::getItem($_REQUEST['itemID']);
			$seller_array = User::getUserData($item->userID);
		}
		
		switch($message_type_id){		
			case "1": $msg = "A bid on %vd% was received. To sell at this price reply SELL, or wait for higher bids."; break;
			case "2": $msg = "Bid Withdrawn"; break;
			case "3": $msg = "Outbid on %vd%. To bid again reply with BID: followed by a number."; break;
			case "4": $msg = "%vd% was withdrawn or expired. Your bid is no longer valid."; break;
			case "5": $msg = "You have won %vd%"; break;
			case "6": $msg = "You were unsuccessful on %vd%"; break;
			case "7": $msg = "You previously bid on %vd% but need to bid again to be successful."; break;
			case "8": $msg = "Buyout price received on %vd%. Vehicle sold."; break;
			case "9": $msg = "New vehicle matches your preferences - %vd%"; break;
			case "10": $msg = "Seller for %vd% is " . $array['fullname'].": ".$array['mobile']; break;
			case "11": $msg = "Interest in %vd% - Contact " . $array['fullname'].": ".$array['mobile']; break;
			case "12": $msg = "Welcome to MotoReach " . $array['fullname']; break;
			case "13": $msg = "Offer on %vd% - " . $POST['amount']; break;
			case "14": $msg = "Reset MotoReach password"; break;
			case "15": $msg = "MotoReach request limit reached"; break;
			case "16": $msg = "MotoReach item extended"; break;
			case "17": $msg = "MyMotoReach Confirmation"; break;
			case "19": $msg = "Report Email"; break;
			case "20": $msg = "New Dealer Message"; break;
			case "21": $msg = "Batch Email"; break;
		}
		
		$array['message'] = $msg;
		
		//$GLOBALS['debug']->printr($array);
		
		return $array;
	}
	
	function sendMessage($data, $message, $keep_alive = false){
		
		if($message['send_email']){
			if($message['email'] == '') return false;
			
			
			$body = new Template('email_'.$message['message_type_id']);
			$body->set('data', $data);
			$body->set('email', $message);
			
			if($message['message_type_id'] == 9){
				$subject = ($data['user_type_id']==5?'Public Vehicle: ':'Dealer Listing: '). $data['year'] . ' ' .$data['make'] . ' ' . $data['model'] . ' (' . $data['region'] . ')';
			} else if($message['message_type_id'] == 10){
				$subject = 'Interest in your '.$data['make'] . ' ' . $data['model'] . ' ' . @$data['badge']  . ' ' . @$data['series'];
			} else if($message['message_type_id'] == 11){
				$subject = 'Seller information from MotoReach - '.$data['make'] . ' ' . $data['model'] . ' ' . @$data['badge']  . ' ' . @$data['series'];
			} else if($message['message_type_id'] == 12){
				$subject = 'Welcome to MotoReach';
			} else if($message['message_type_id'] == 13){
				$subject = $_SESSION['l10n']['currency_symbol'].number_format($_REQUEST['amount']).' offered on '. $data['model'] . ' ' . @$data['badge']  . ' ' . @$data['series'];
			} else if($message['message_type_id'] == 14){
				$subject = 'Reset your MotoReach Password';
			} else if($message['message_type_id'] == 17){
				$subject = 'Email Confirmation from myMotoReach';
			} else if($message['message_type_id'] == 18){
				$subject = 'Listed Yesterday on MotoReach';
			} else if($message['message_type_id'] == 19){
				$subject = 'Reporting for MotoReach';
			} else {
				$subject = 'Message from MotoReach';
			}
			//$GLOBALS['debug']->printr($subject);
			$html_body = $body->fetch();
			
			$html_body = str_replace('<label ', '<label style="color: #FF7F00; display: block; width: 120px; float: left;" ', $html_body);
			
			include_once 'class.phpmailer.php';
			
			try {
				
				$mail = new PHPMailer(true); //New instance, with exceptions enabled
				
				$mail->AddReplyTo("noreply@motoreach.com", "MotoReach");
				$mail->From       = "noreply@motoreach.com";
				$mail->FromName   = "MotoReach";
				$mail->AddAddress($message['email'], $message['fullname']);
				$mail->Subject  = $subject;
				$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
				$mail->WordWrap   = 80; // set word wrap
				
				$mail->MsgHTML($html_body);
				$mail->IsHTML(true); // send as HTML
				
				if($_SERVER['HTTP_HOST']!='motoreach' && $_SERVER['HTTP_HOST']!='motopublic' && $data['make'] != 'Demo'){
					$mail->Send();

					Message::logMessage($message['message_type_id'], @$data['auction_id'], $message['ID']);
			
					//if(isset($data['user_type_id']) && $data['user_type_id'] == 7){
						//Message::logPublicOffer($data['auction_id'], $message['ID']);
					//}
				} else {

					Message::logMessage($message['message_type_id'], @$data['auction_id'], $message['ID']);
					$GLOBALS['debug']->printr($html_body, true);
				}


				
			} catch (phpmailerException $exception) {
				@mail('matt@motoreach.com', 'matches', 'error sending mail to '.$message['email'].$GLOBALS['debug']->printr($message, false, true).$exception->getMessage());
			}

		} else {
			mail('matt@motoreach.com', 'Motoreach Bug', 'Customers getting sent non-email versions?');
		}
		
		if($message['send_sms'] && $message['mobile']){
			//print_r($data);
			
			$user        = 'GSVision';
	        $password    = 'gsvGloba';
	        $to          = $message['mobile'];
	        $from        = 61423563683;
	        $message     = $message['message'];
			
			//print_r($data);
			$ch = curl_init('http://ur.ly/new.json?href=http://www.motoreach.com/items.php?itemID='.$data['ID']);
	        curl_setopt($ch, CURLOPT_POST, false);
	        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	        $output = curl_exec ($ch);
	        curl_close ($ch);
			$url = json_decode($output);
			//print_r($url);
			$url = $url->href;
	        echo $output.'<br>';
			
	        $message	 = str_replace('%vd%', 'LOT #'.$data['ID'], $message); 
	        //Encode content and send to SMS Global
	        $content =  'action=sendsms'.
	                    '&user='.rawurlencode($user).
	                    '&password='.rawurlencode($password).
	                    '&to='.rawurlencode($to).
	                    '&from='.rawurlencode($from).
	                    '&text='.rawurlencode($message); 
	        print $content;
	        //return false;
			$ch = curl_init('http://www.smsglobal.com/http-api.php');
	        curl_setopt($ch, CURLOPT_POST, true);
	        curl_setopt($ch, CURLOPT_POSTFIELDS, $content);
	        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	        $output = curl_exec ($ch);
	        curl_close ($ch);
	        //echo $output.'<br>';
	        
	        Credit::subtractUserBalance($message['userID'], PRICE_SMS);
		}
	}
	
	
	function getSellerDetails($data){
		$GLOBALS['debug']->printr($data);
	}
	
	function getBuyerDetails($data){
		$GLOBALS['debug']->printr($data);
	}
	
}

?>