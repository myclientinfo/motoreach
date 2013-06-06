<?php
class Reporting {

	function getDealerVehicles($user_id = false, $from = false, $to = false, $item_id = false){
	
		$query = 'SELECT b.*, colour, make, model, a.dateentered, u.dealership_name, startprice, a.ID AS itemID,
					SUM(IF(b.typeID = 9, 1, 0) ) requests,
					GROUP_CONCAT(IF(b.typeID = 9, CONCAT(b.userID, "|",u2.dealership_name), false) SEPARATOR ",") AS requesters
				FROM auction_items AS a
			LEFT JOIN auction_bids AS b ON a.ID = b.itemID
			LEFT JOIN auction_users AS u ON u.ID = a.userID
			LEFT JOIN vehicle_details AS vd ON vd.auction_id = a.ID
			LEFT JOIN auction_users AS u2 ON u2.ID = b.userID
			LEFT JOIN '.$_SESSION['l10n']['table_prefix'].'models AS md ON md.id = vd.model_id
			LEFT JOIN '.$_SESSION['l10n']['table_prefix'].'makes AS mk ON md.make_id = mk.id
			LEFT JOIN type_colours AS c ON vd.colour_id = c.id
			WHERE u.group_id != 1 ';
		
		if(!$item_id){
		
			if($user_id) $query .= ' AND a.userID = '.$user_id;
			else ' AND u.user_type_id != 5';
			
			if($from) $query .= ' AND dateentered > "'.$from.'"';
			if($to) $query .= ' AND dateentered < "'.$to.'"';
			$query .= ' GROUP BY vd.auction_id ORDER BY dateentered DESC';
		
		} else {
			$query .= ' AND a.ID = '.$item_id;
			$query .= ' GROUP BY vd.auction_id ORDER BY dateentered DESC';
			
			return Site::getData($query, true);
		
		}
		
		$array = Site::getData($query, false, 'itemID');
		
		if(!$item_id){
			$query = 'SELECT m.item_id, count(m.*) as message_count FROM message_log AS m
					WHERE message_type_id = 9 ';
					
			if($from) $query .= ' AND dateentered > "'.$from.'"';
			if($to) $query .= ' AND dateentered < "'.$to.'"';
			
			$query.= ' GROUP BY item_id';
		}
		return $array;

	}
	
	function getItemStats($id){
	
		
	}
	
	
	function getDealerSentLeads(){
		$query = 'SELECT m.message_time, CONCAT(d.year, " ", make, " ", model) as description, u.city, d.sell_reason AS replacing FROM message_log as m 
			LEFT JOIN auction_items AS i ON m.item_id = i.ID 
			LEFT JOIN auction_users AS u ON u.ID = i.userID
			LEFT JOIN vehicle_details AS d ON d.auction_id = i.ID
			LEFT JOIN '.$_SESSION['l10n']['table_prefix'].'models AS md ON md.id = d.model_id
			LEFT JOIN '.$_SESSION['l10n']['table_prefix'].'makes AS mk ON mk.id = md.make_id
			WHERE `user_id` = 235
			AND `message_type_id` = 9
			AND message_time > "2011-11-21 00:00:01"';
			
	}
	
	function getStats($from = false, $to = false){
		$query = 'SELECT u.dealership_name, u.ID,
			SUM(IF(b.typeID = 9, 1, 0) ) requests,
			COUNT(DISTINCT a.ID) AS listed
					FROM auction_users AS u
						LEFT JOIN auction_items AS a ON u.ID = a.userID
				LEFT JOIN auction_bids AS b ON a.ID = b.itemID AND b.typeID = 9
				WHERE u.group_id != 1 AND u.user_type_id != 5 
				AND u.country_id = '.$_SESSION['l10n']['country_id'];
				
		if($from) $query .= ' AND dateentered > "'.$from.'"';
		if($to) $query .= ' AND dateentered < "'.$to.'"';
		
		$query .= ' GROUP BY u.dealership_name
				 ORDER BY u.dealership_name';
		
		//$GLOBALS['debug']->printr($query);
		
		$array = Site::getData($query, false, 'dealership_name' );
		
		$query = 'SELECT u.dealership_name, u.ID, count(*) as requests_made FROM auction_bids AS b 
				LEFT JOIN auction_items AS a ON a.ID = b.itemID
				LEFT JOIN auction_users AS u ON u.ID = b.userID
				WHERE 1';
			 
			 
		if($from) $query .= ' AND dateentered > "'.$from.'"';
		if($to) $query .= ' AND dateentered < "'.$to.'"';
		
		$query .= ' AND b.typeID = 9
					AND u.country_id = '.$_SESSION['l10n']['country_id'].' 
			 GROUP BY u.dealership_name';
		
		
		$array2 = Site::getData($query, false, 'dealership_name' );
		
		if(!empty($array2)){
			foreach($array2 as $k => $v){
				$array[$k]['requests_made'] = $v['requests_made'];
				$array[$k]['ID'] = $v['ID'];
				
			}
		}
		@ksort($array);
		return $array;
	}
	
	
	function getPublicListedVehicles($user_id = false, $vehicle_id = false, $from = false, $to = false, $public = true){
	
		$query = 'SELECT ast.status, a.dateentered, u.city, u.dealership_name, u.fullname, b.*, ct.*,colour, make, model, a.ID AS itemID,
					SUM(IF(b.typeID = 9, 1, 0) ) requests, GROUP_CONCAT(req.dealership_name SEPARATOR ", ") AS requested_by, sell_reason
				FROM auction_items AS a
			LEFT JOIN auction_users AS u ON u.ID = a.userID
			LEFT JOIN auction_status AS ast ON ast.id = a.statusID
			LEFT JOIN auction_bids AS b ON a.ID = b.itemID
			LEFT JOIN auction_users AS req ON b.userID = req.ID AND b.typeID = 9
			LEFT JOIN vehicle_details AS vd ON vd.auction_id = a.ID
			LEFT JOIN credit_transactions AS ct ON a.ID = ct.item_id
			LEFT JOIN '.$_SESSION['l10n']['table_prefix'].'models AS md ON md.id = vd.model_id
			LEFT JOIN '.$_SESSION['l10n']['table_prefix'].'makes AS mk ON md.make_id = mk.id
			LEFT JOIN type_colours AS c ON vd.colour_id = c.id
			WHERE u.group_id != 1 AND u.country_id = '.$_SESSION['l10n']['country_id'];
		
		if($user_id) $query .= ' AND a.userID = '.$user_id;
		if($vehicle_id) $query .= ' AND b.item_id = '.$vehicle_id;
		
		if($from) $query .= ' AND dateentered > "'.$from.'"';
		if($to) $query .= ' AND dateentered < "'.$to.'"';
		
		if($public)  $query .= ' AND u.user_type_id = 5';
		else $query .= ' AND u.user_type_id != 5';
		
		$query .= ' GROUP BY a.ID ORDER BY a.dateentered';
		//$GLOBALS['debug']->printr($query);
		
		return Site::getData($query, false);

	}
	
	
	
	
	function getAllUsersListedVehicles($from = false, $to = false){
	
		$query = 'SELECT u.ID AS user_id, u.dealership_name, fullname, count(a.ID) AS vehicles
				FROM auction_users AS u
			JOIN auction_items AS a ON u.ID = a.userID	';
		
		if($from) $query .= ' AND dateentered > "'.$from."\"\n";
		if($to) $query .= ' AND dateentered < "'.$to."\"\n";
		
		$query .= ' WHERE u.group_id != 1 AND u.country_id = '.$_SESSION['l10n']['country_id']."\n";
		
		
		
		$query .= ' GROUP BY u.ID';
		
		$array = Site::getData($query, false);
		
		ksort($array);
		
		return $array;

	}
	
	function getRequests($user_id = false, $vehicle_id = false, $from = false, $to = false, $user_type = 'b.userID'){
	
		$query = 'SELECT u.dealership_name, count(b.id) AS '.($user_type == 'b.userID'?'buyer':'seller').'_requests 
				FROM auction_bids AS b
			LEFT JOIN auction_items AS a ON a.ID = b.itemID
			LEFT JOIN vehicle_details AS vd ON vd.auction_id = a.ID
			LEFT JOIN '.$_SESSION['l10n']['table_prefix'].'models AS md ON md.id = vd.model_id
			LEFT JOIN auction_users AS u ON u.ID = '.$user_type.'
			LEFT JOIN '.$_SESSION['l10n']['table_prefix'].'makes AS mk ON md.make_id = mk.id
			LEFT JOIN type_colours AS c ON vd.colour_id = c.id
			WHERE u.group_id != 1';
		
		$query .= ' AND b.typeID = 9 AND u.country_id = '.$_SESSION['l10n']['country_id'];
		
		if($user_id) $query .= ' AND '.$user_type.' = '.$user_id;
		if($vehicle_id) $query .= ' AND b.item_id = '.$vehicle_id;
		
		if($from) $query .= ' AND datesubmitted > "'.$from.'"';
		if($to) $query .= ' AND datesubmitted < "'.$to.'"';
		
		$query .= ' GROUP BY '.$user_type;
		
		$array = Site::getData($query, false, 'dealership_name');
		ksort($array);
		
		return $array;

	}
	
	function getDealerships($from = false, $to = false, $rep = false){
		
		$query = 'SELECT u.*, COUNT(a.ID) AS vehicles FROM auction_users AS u 
					LEFT JOIN auction_items AS a ON a.userID = u.ID 
					WHERE 1 ';
		if($from) $query .= ' AND signup_time > "'.date('Y-m-d H:i:s', $from)."\" \n";
		if($to) $query .= ' AND signup_time < "'.date('Y-m-d H:i:s', $to)."\" \n";
		if($rep) $query .= ' AND rep_number = "'.$rep."\" \n";
		
		$query .= ' GROUP BY u.ID
					ORDER BY signup_time ASC';
		
		return Site::getData($query, false);
	}
	
}


?>