<?php

/**
 * 
 * @package auction
 * 
 * These classes are a complete auction framework, ready to implement using a minimum amount of procedural PHP code, 
 * and a templating system like Smarty. The database abstraction layer AdoDB is used.
 * @version $Id: class_auction.php,v 1.33 2005/07/28 04:29:34 woostachris Exp $
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

/**
 * Auction
 * 
 * Represents the state of the current auction
 * 
 * @package auction
 * @author nicolas 
 * @copyright Copyright (c) 2005
 * @version $Id: class_auction.php,v 1.33 2005/07/28 04:29:34 woostachris Exp $
 * @access public 
 */


class Auction {
    
    /**
     * @var array Contains all the settings for this auction
     */
    var $auction_settings = array();    

    /**
     * 
     * @var array $users Array containing User objects
     */
    var $users;

    /**
     * 
     * @var object $user A User object which contains the logged-in user's information
     */
    var $user;

    /**
     * Constructor function. Initialises auction settings from the Database.
     */
    function Auction() {               
        // Retrieve info about the hosting company       
        $myDB = &ADONewConnection(DSN);
		
        $query = "SELECT * FROM admin_config";
        $rs = &$myDB->Execute($query); 
        if (!$rs) {
            print "The admin_config table is not set up, please restart the installation.";
        } else {
            for ($i = 0; $i < $rs->RecordCount(); $i++) {
                $setting = $rs->fields['setting'];
                $value = $rs->fields['value'];
                $this->auction_settings[$setting] = $value;
                $rs->MoveNext();
            }            
        }
        /*
        $query = "SELECT * FROM auction_items";
        $rsitems = &$myDB->Execute($query);
        for($i = 0; $i < $rsitems->RecordCount(); $i++) {
            $this->items[] = new Item($rsitems->fields);
            $rsitems->MoveNext();
        }
		*/
        //$this->users = array();
        //$this->users = $this->getUsers();
    } 

    /**
     * Adds an item to the auction object and to the database. It also gets the new itemID from this entry.
     * 
     * @param object $item 
     * @return boolean true if successful, error message otherwise
     */
    function addItem($item) {
        //$this->items[] = $item;
        $id = $item->recordItem();
        if($id){
			Auction::recordVehicleDetails($id);
			Auction::recordHistory($id, 2, $_POST['startprice']);
		}
		return $id;
		
    } 
	
	
	function getUniqueId(){
		$query = 'SELECT UUID() as uuid';
		$array = Site::getData($query, true);
		return $array['uuid'];
	}
	
	function getAuctionLength($type){
		$array = Site::getLookupTable('auction_lengths', 'id', 'lis', 'id', false, false, false);
		return @$array[$type];
	}
	
	function recordHistory($id, $history_type = 1, $amount = false){
		$query = 'INSERT INTO auction_bids(itemID, userID, datesubmitted, amount, statusID, typeID) VALUES('.$id.', '.$_SESSION['auction']->user->ID.', '.time().', "'.Site::numbersOnly($amount).'", 1, '.$history_type.')';
		
		return Site::runQuery($query);
	}

	
	function checkFields(){
		$missing = array();
		foreach($_POST as $k => $v){
			if(in_array($k, array('description','buyoutprice','badge_id'))) continue;
			if($v == '') $missing[] = $k;
		}
		return $missing;
	}
	
	function recordVehicleDetails($id){
		
		if($_POST['max_requests']==0) $_POST['max_requests'] = 10;
		
		$query = 'INSERT INTO vehicle_details (
					auction_id, model_id, colour_id, badge_id, series_id, sale_type_id, 
					transmission_id, body_id, drive_type_id, fuel_type_id, roof_type_id, interior_type_id, interior_colour_id, 
					spend, mileage, build_month, year, comp_month, comp_year, doors, cylinders, engine_size, VIN, import, registration, max_requests,
					nct_month, nct_year
					) VALUES (
					"'.$id.'", "'.$_POST['model_id'].'", "'.$_POST['colour_id'].'", "'.@$_POST['badge_id'].'", "'.@$_POST['series_id'].'", 
						"'.$_POST['sale_type_id'].'", "'.$_POST['transmission_type_id'].'", "'.$_POST['body_id'].'", "'.$_POST['drive_type_id'].'", 
						"'.$_POST['fuel_type_id'].'", "'.$_POST['roof_type_id'].'", "'.$_POST['interior_type_id'].'", "'.$_POST['interior_colour_id'].'", 
						"'.$_POST['spend'].'", "'.$_POST['mileage'].'", 
						"'.@$_POST['build_month'].'", "'.$_POST['year'].'", "'.@$_POST['comp_month'].'", "'.@$_POST['comp_year'].'", 
						"'.$_POST['doors'].'", "'.$_POST['cylinders'].'", "", "", 
						"'.$_POST['import'].'", "'.@$_POST['registration'].'", "'.$_POST['max_requests'].'",
						"'.@$_POST['nct_month'].'", "'.$_POST['nct_year'].'")';
		
		return Site::runQuery($query);
	}
	
	
    /**
     * Adds a given User object to the auction
     * @todo Add error checking for incomplete user object
     * @param object $user 
     */
    function addUser($user) {
		
    	$this->user = $user;
        $this->user->id = $user->getID();
        return true;
    } 
	
	/**
     * Returns an array of the items which belong to the requested categoryID
     * 
     * @param integer $categoryID 
     * @param boolean $complete false if you only need objects still in auction, true if you want them all
     * @param string $type returns items in an array of "objects" or "keys"
     * @return array $items if successful, error message otherwise
     */
    function getItems($categoryID = 0, $complete = false, $type = "object") {
        $items = array();
        $myDB = &ADONewConnection(DSN);        
        $query = "";

        $filter = "";
        // Setting up filter: $complete as true will return all items instead of just those for auction
        if (!$complete) {
            $filter = "WHERE processed != 'yes'";
        } 
        // If categoryID = 0, it means that the user requested to see ALL the items
        if ($categoryID == 0) {
            $query = "SELECT auction_items.* FROM auction_items $filter";
        } elseif ($categoryID > 0) {
            $query = "SELECT auction_items.* FROM auction_items WHERE categoryID = $categoryID AND processed != 'yes'";
        } elseif ($categoryID < 0) {
            return "categoryID must not be a negative number";
        } 
        
        $rs = &$myDB->Execute($query);
        if (!$rs OR $rs->RecordCount() < 1) {
            return false;
        } else {
            for($i = 0; $i < $rs->RecordCount(); $i++) {
                $items[] = new Item($rs->fields);
                $rs->MoveNext();
            } 
            if ($type == "keys") {
                $items = array_merge($items, $items);
            } 
            return $items;
        } 
    } 
	
	function getRegions(){
		$query = 'SELECT s.state, r.id, r.region FROM regions AS r 
					JOIN states AS s ON s.id = r.state_id
					WHERE country_id = '.$_SESSION['l10n']['country_id'].'
					ORDER BY state_id ASC, region ASC';
		
		return Site::getData($query, false, 'id', 'region', 'state');
		
	}
	
	
	function performAuctionAction($id, $action){
		$action_string = false;
		if($action == 'notify'){
			
		} else if($action == 'sell') {
			$action_string = 3;
		} else if($action == 'withdraw') {
			$action_string = 5;
		} else if($action == 'extend') {
		}
		
		if($action_string){
			$query = 'UPDATE auction_items SET status_id = ' . $action_string . ' WHERE ID = ' . $id;
			$GLOBALS['db']->Execute($query);
		}
		
		/* NOTIFICATION RULES NEED TO BE FOLLOWED */
	}
	
	
	function getRecentBids($user_id){
		$query = 'SELECT a.*, b.* FROM auction_items AS a 
					LEFT JOIN auction_bids AS b ON b.itemID = a.ID
					LEFT JOIN vehicle_details AS v ON v.auction_id = a.ID 
						LEFT JOIN '.$_SESSION['l10n']['table_prefix'].'models AS md ON md.id = v.model_id 
							LEFT JOIN '.$_SESSION['l10n']['table_prefix'].'makes AS mk ON mk.id = md.make_id 
						LEFT JOIN '.$_SESSION['l10n']['table_prefix'].'badges AS bg ON bg.id = v.badge_id';
		$query .= 	' AND a.userID = '.$user_id;
		$query .= 	' AND b.typeID = 1 ORDER BY datesubmitted DESC LIMIT 5';
		
		return Site::getData($query);
	}
	
	function getUpcomingCloses(){

		$query = 'SELECT b.*, MAX(amount), MIN(b.statusID), t.* FROM auction_bids AS b
					LEFT JOIN auction_items as i ON i.ID = b.itemID
					LEFT JOIN notification_preference AS p ON p.user_id = b.userID AND p.item_id = 7
					LEFT JOIN notification_preference_type AS t ON t.id = p.preference_id
					WHERE 1
					AND i.auction_end > "'.(time() + 830).'" 
					AND i.auction_end <= "'.(time() + 930).'"
					GROUP BY b.userID
					ORDER BY amount ASC
					LIMIT 1,3';
		return Site::getData($query);
	}
	
	function incrementBids($id){
		$query = 'UPDATE auction_items SET bid_count = bid_count + 1 WHERE ID = '.$id;
		Site::runQuery($query);
	}
	
	function getUserItems($user_id){
		//Site::mysqlConnect();
		
		$query = 'SELECT a.*, year, make, model, badge, MAX(b.amount) as highest_bid, c.colour, COUNT(DISTINCT b.typeID = 1) AS count_bids, 
							aus.status as auction_status 
						FROM auction_items AS a 
					LEFT JOIN auction_bids AS b ON b.itemID = a.ID AND b.typeID = 1
					LEFT JOIN auction_status AS aus ON a.statusID = aus.id
					LEFT JOIN vehicle_details AS v ON v.auction_id = a.ID 
						LEFT JOIN '.$_SESSION['l10n']['table_prefix'].'models AS md ON md.id = v.model_id 
							LEFT JOIN '.$_SESSION['l10n']['table_prefix'].'makes AS mk ON mk.id = md.make_id 
						LEFT JOIN '.$_SESSION['l10n']['table_prefix'].'badges AS bg ON bg.id = v.badge_id
						LEFT JOIN type_colours AS c ON c.id = v.colour_id 
						LEFT JOIN type_transmission AS t ON t.id = v.transmission_id 
						LEFT JOIN type_body AS tb ON tb.id = v.body_id 
						LEFT JOIN type_drives AS td ON td.id = v.drive_type_id 
						LEFT JOIN type_fuel AS tf ON tf.id = v.fuel_type_id
						WHERE auction_end > '.time();
		$query .= 	' AND a.userID = '.$user_id.'
						GROUP BY a.ID
							ORDER BY auction_end DESC';
		
		return Site::getData($query, false, 'ID');
	}
	
	
	function getUserBids($user_id){
		//Site::mysqlConnect();
		
		$query = 'SELECT a.*, year, make, model, badge, MAX(b.amount) as highest_bid, c.colour, COUNT(DISTINCT b.typeID = 1) AS count_bids, aus.status as auction_status 
						FROM auction_items AS a 
					LEFT JOIN auction_bids AS b ON b.itemID = a.ID AND b.typeID = 1
					LEFT JOIN auction_status AS aus ON a.statusID = aus.id
					LEFT JOIN vehicle_details AS v ON v.auction_id = a.ID 
						LEFT JOIN '.$_SESSION['l10n']['table_prefix'].'models AS md ON md.id = v.model_id 
							LEFT JOIN '.$_SESSION['l10n']['table_prefix'].'makes AS mk ON mk.id = md.make_id 
						LEFT JOIN '.$_SESSION['l10n']['table_prefix'].'badges AS bg ON bg.id = v.badge_id
						LEFT JOIN type_colours AS c ON c.id = v.colour_id 
						LEFT JOIN type_transmission AS t ON t.id = v.transmission_id 
						LEFT JOIN type_body AS tb ON tb.id = v.body_id 
						LEFT JOIN type_drives AS td ON td.id = v.drive_type_id 
						LEFT JOIN type_fuel AS tf ON tf.id = v.fuel_type_id
						WHERE 1 ';
		$query .= 	'AND b.userID = '.$user_id.'
						GROUP BY a.ID
							ORDER BY auction_end DESC';

		return Site::getData($query, false, 'ID', false, 'auction_status');
		
	}
	
	
	
	
	function getAllItems(){
		
		$query = 'SELECT a.*, year, make, model, badge, colour, MAX(b.amount) as highest_bid, COUNT(DISTINCT b.typeID = 1) AS count_bids, u.city, st.state, st.state_short, aus.status as auction_status 
						FROM auction_items AS a 
					LEFT JOIN auction_bids AS b ON b.itemID = a.ID AND b.typeID = 1
					LEFT JOIN auction_status AS aus ON a.statusID = aus.id
					LEFT JOIN auction_users AS u ON a.userID = u.ID
					LEFT JOIN states AS st ON u.state = st.id
					LEFT JOIN vehicle_details AS v ON v.auction_id = a.ID 
						LEFT JOIN '.$_SESSION['l10n']['table_prefix'].'models AS md ON md.id = v.model_id 
							LEFT JOIN '.$_SESSION['l10n']['table_prefix'].'makes AS mk ON mk.id = md.make_id 
						LEFT JOIN '.$_SESSION['l10n']['table_prefix'].'badges AS bg ON bg.id = v.badge_id
						LEFT JOIN type_colours AS c ON c.id = v.colour_id 
						LEFT JOIN type_transmission AS t ON t.id = v.transmission_id 
						LEFT JOIN type_body AS tb ON tb.id = v.body_id 
						LEFT JOIN type_drives AS td ON td.id = v.drive_type_id 
						LEFT JOIN type_fuel AS tf ON tf.id = v.fuel_type_id
						WHERE a.auction_end > '.time().'
							AND u.country_id = '.$_SESSION['l10n']['country_id'].'
							AND a.statusID = 2
							AND a.userID != '.User::getSimpleUser();
		
		if(isset($_GET['type']) && $_GET['type'] == 'public'){
			$query .= ' AND u.user_type_id = 5';
		} else if(isset($_GET['type']) && $_GET['type'] == 'dealer'){
			$query .= ' AND u.user_type_id != 5';
		}
		
		$query .= '	GROUP BY a.ID';
		
		$array = Site::getData($query, false);
		
		if(empty($array)) return array();
		
		foreach($array as $item){
			$array2[$item['make']][$item['model']][] = $item; 
		}
		
		return $array2;
	}
	
	
	function getSearch(){

		list($price['min'], $price['max']) = explode(' - ', str_replace($_SESSION['l10n']['currency_symbol'], '' , $_POST['amount']));

		$advanced_fields = array('fuel_type_id', 'transmission_type_id', 'drive_type_id', 'body_id', 'doors');

		$query = 'SELECT a.*, year, make, model, badge, a.currentprice as highest_bid, COUNT(DISTINCT b.typeID = 1) AS count_bids, aus.status as auction_status 
						FROM auction_items AS a 
					LEFT JOIN auction_bids AS b ON b.itemID = a.ID AND b.typeID = 1
					LEFT JOIN auction_status AS aus ON a.statusID = aus.id
					LEFT JOIN vehicle_details AS v ON v.auction_id = a.ID 
						LEFT JOIN '.$_SESSION['l10n']['table_prefix'].'models AS md ON md.id = v.model_id 
							LEFT JOIN '.$_SESSION['l10n']['table_prefix'].'makes AS mk ON mk.id = md.make_id 
						LEFT JOIN '.$_SESSION['l10n']['table_prefix'].'badges AS bg ON bg.id = v.badge_id
						LEFT JOIN type_colours AS c ON c.id = v.colour_id 
						LEFT JOIN type_transmission AS t ON t.id = v.transmission_id 
						LEFT JOIN type_body AS tb ON tb.id = v.body_id 
						LEFT JOIN type_drives AS td ON td.id = v.drive_type_id 
						LEFT JOIN type_fuel AS tf ON tf.id = v.fuel_type_id
						WHERE 1 ';
		
		$query .= ' AND a.currentprice > '.$price['min'];
		$query .= ' AND a.currentprice < '.$price['max'];
		$query .= ' AND v.model_id = '.$_POST['model_id'];
		
		
		if($_POST['year_min']) $query .= ' AND year >= '.$_POST['year_min'];
		if($_POST['year_max']) $query .= ' AND year <= '.$_POST['year_max'];
		
		foreach($advanced_fields as $fld){
			if($_POST[$fld]) $query .= ' AND v.'.$fld.' = '.$_POST[$fld];
		}
		
		$query .= '	AND a.statusID = 2
						GROUP BY a.ID';
		
		return $GLOBALS['db']->getAll($query);
	}

	function getUserMatches($type = 1){
		
		$array = array();
		$query = 'SELECT vd.*, a.*, make, model, badge, c.colour, state, a.ID FROM match_prefs AS p
			JOIN '.$_SESSION['l10n']['table_prefix'].'makes AS mk ON mk.id = p.make_id
			JOIN '.$_SESSION['l10n']['table_prefix'].'models AS md ON md.make_id = mk.id
			JOIN vehicle_details AS vd ON vd.model_id = md.id
				LEFT JOIN '.$_SESSION['l10n']['table_prefix'].'badges AS bdg ON bdg.id = vd.badge_id
				LEFT JOIN type_colours AS c ON c.id = vd.colour_id
				LEFT JOIN auction_items AS a ON a.ID = vd.auction_id
					LEFT JOIN auction_users AS us ON us.ID = a.userID
				WHERE ((p.make_id > 0 AND p.model_id = 0) OR  (p.make_id > 0 AND p.model_id > 0) )
					AND a.auction_end > '.time().'
					AND vd.year <= p.to_year 
					AND vd.year >= p.from_year
					AND p.match_type_id = '.$type.'
					AND p.user_id = '.User::getSimpleUser().'
					AND a.userID != '.User::getSimpleUser().'
					ORDER BY make, model DESC';
		
		if($type != 1) $array = Site::getData($query, false, 'ID');
		
		if($type == 1) $pref_all = Auction::getPrefAll($type);
		else{
			$pref_all = array();
		}
		
		if(!empty($pref_all)){
			$query = 'SELECT vd.*, a.*, make, model, badge, c.colour, a.ID FROM auction_items AS a
				LEFT JOIN auction_users AS us ON us.ID = a.userID
				JOIN vehicle_details AS vd ON vd.auction_id = a.ID
				LEFT JOIN type_colours AS c ON c.id = vd.colour_id
				JOIN '.$_SESSION['l10n']['table_prefix'].'models AS md ON md.id = vd.model_id
				JOIN '.$_SESSION['l10n']['table_prefix'].'makes AS mk ON mk.id = md.make_id
				LEFT JOIN '.$_SESSION['l10n']['table_prefix'].'badges AS bdg ON bdg.id = vd.badge_id
				WHERE 1 ';
				if($pref_all['to_year'])	$query .= ' AND vd.year <= "'.$pref_all['to_year'].'" ';
				$query .= '		AND vd.year >= "'.$pref_all['from_year'].'"
						AND us.location_id IN('.$pref_all['location'].')
						AND a.userID != '.User::getSimpleUser().'
						AND a.auction_end > '.time().'
						ORDER BY make, model DESC';
			
			
			
			$array2 = Site::getData($query, false, 'ID');
			
			foreach($array2 as $k => $v){
				$array[$k] = $v;
			}
		}
		
		if($type == 1){
			$exclusions = Auction::getUserMatches(2);
			
			foreach(array_keys($exclusions) as $k){
				unset($array[$k]);
			}
		}
		return $array;
	
	}
	
	function getPrefAll(){
		$query = 'SELECT * FROM match_prefs 
					WHERE model_id = 0 
					AND make_id = 0 
						AND user_id = '.User::getSimpleUser();
		return Site::getData($query, true);
	}
	
	function loadLocation($location = false, $force = false){
		
		if(isset($_SESSION['l10n']) && !$location && !isset($_GET['force_country'])) return $_SESSION['l10n'];
		
		if(!$location && User::getSD('country_id')){
			$location = User::getSD('country_id');
		}
		
		if(isset($_GET['force_country'])) $location = $_GET['force_country'];
		
		$array = User::getCountry($location);
		
		if(!isset($array['country_code'])) $array['country_code'] = '';
		
		if($array['country_code'] != 'AU'){
			$array['table_prefix'] = 'uk_';
			$array['phone'] = '015547206';
			$array['fax'] = 'info@motoreach.ie';
			$array['public_phone'] = '+353 (0) 51 349 267';
			$array['address'] = 'Confederation house<br />Waterford business park<br />Cork Rd<br />Co. Waterford, Waterford City<br />Ireland';
			$array['rate_list'] = 'xxxxx';
			$array['rate_public_list'] = '995';
			$array['rate_monthly'] = 'xxxxx';
			$array['processor'] = 'worldpay';
			$array['processor_long'] = 'WorldPay';
			$array['currency'] = 'EUR';
			$array['currency_long'] = 'Euro';
			$array['currency_symbol'] = '&euro;';
			$array['term_state'] = 'province';
			$array['term_suburb'] = 'county';
			$array['term_wholesale'] = 'trade';
			$array['term_wholesaling'] = 'trading';
			$array['term_dealers'] = 'motor dealers';
			$array['term_local_state_interstate'] = '';
			$array['term_traded_or_wholesaled'] = 'traded';
			
		} else {
			$array['table_prefix'] = '';
			$array['phone'] = '1300 417 700';
			$array['fax'] = '(07) 3252 5043';
			$array['public_phone'] = '1300 369 370';
			$array['address'] = '55 McLachlan Street, Fortitude Valley';
			$array['rate_list'] = '';
			$array['rate_public_list'] = '95';
			$array['processor'] = 'anz';
			$array['processor_long'] = 'ANZ eGate';
			$array['currency'] = 'AUD';
			$array['currency_long'] = 'Australian Dollars';
			$array['currency_symbol'] = '$';
			$array['term_state'] = 'state';
			$array['term_suburb'] = 'suburb';
			$array['term_wholesale'] = 'wholesale';
			$array['term_wholesaling'] = 'wholesaling';
			$array['term_dealers'] = 'government licensed motor dealers';
			$array['term_local_state_interstate'] = 'local, state and interstate';
			$array['term_traded_or_wholesaled'] = 'traded or wholesaled';		}
		
		if(!$force) $_SESSION['l10n'] = $array;
		return $array;
	}
	
	
	function getVehicleMatches($data, $type = 1, $debug = false, $table_prefix = ''){
		
		if(is_object($data)){
			$data = get_object_vars($data);
		}
		
		$is_public = $data['data']['user_type_id'] == 7 && $type == 1;
		$is_public = false;
		
		$query = 'SELECT u.*, mk.make, md.model, u.ID FROM auction_users AS u 
					JOIN match_prefs AS p ON u.ID = p.user_id
					LEFT JOIN '.$_SESSION['l10n']['table_prefix'].'models AS md ON md.id = p.model_id
					LEFT JOIN '.$_SESSION['l10n']['table_prefix'].'makes AS mk ON mk.id = p.make_id
					JOIN user_permissions AS up ON up.user_id = u.ID AND up.permission_id = 6
					WHERE (p.make_id = 0 OR p.make_id = '.$data['data']['make_id'].')
						AND (p.model_id = 0 OR p.model_id = '.$data['data']['model_id'].')
						AND p.location LIKE("%'.$data['data']['location_id'].'%") ';
		if(!$debug) $query .= ' AND u.ID != "'.User::getSimpleUser().'" ';
		
		$query .= ' AND u.country_id = '.$data['data']['country_id'];
		$query .= ' AND p.match_type_id = ' . $type . '';
		
		if($is_public) $query .= ' AND u.public_preferred > 0 ';
		
		// HANDLE MILEAGE AND YEAR
		if($type == 1) {
			$query .= ' AND (p.from_year <= '.$data['data']['year'] .' AND p.to_year >= '.$data['data']['year'].')'."\n";
			$query .= ' AND (p.mileage > '.Site::numbersOnly($data['data']['mileage']).' OR p.mileage = 0)'."\n";
		}
		
		$array = Site::getData($query, false, 'ID', false, ($is_public ? 'public_preferred' : false));
		
		if($is_public){
			$new_array = array();
			$tnum[1] = 20;
			$tnum[2] = 20;
			
			
			foreach($tnum as $t => $num){
				if(isset($array[$t])){
					
					if($tnum[$t] > count($array[$t])) $num = count($array[$t]);
					echo $tnum[$t];
					$keys = array_rand($array[$t], $tnum[$t]);
					
					foreach($array[$t] as $k => $u){
						if(in_array($k, $keys)) $new_array[$k] = $u;
					} 
				}
			}
			
			$array = $new_array;
		}
		
		
		if($debug){
			
			if($type == 1) echo 'the following users would match this vehicle<br>';
			else echo 'the following users would NOT match<br>';
			
			foreach($array as $u){
				echo $u['fullname'].' - '. $u['email'] .'<br>';
			}
			echo '<br><br>';
		}
		
		if($type == 1){
			$exclusions = Auction::getVehicleMatches($data, 2, $debug);
			foreach(array_keys($exclusions) as $k){
				unset($array[$k]);
			}
		}
		
		return $array;
	
	}
	
	
	
	/*

	function getUserBids($user_id){
		
		$query = 'SELECT a.*, year, make, model, badge, MAX(b.amount) as highest_bid, COUNT(DISTINCT b.typeID = 1) AS count_bids, aus.status as auction_status 
						FROM auction_items AS a 
					LEFT JOIN auction_bids AS b ON b.itemID = a.ID AND b.typeID = 1
					LEFT JOIN auction_status AS aus ON a.statusID = aus.id
					LEFT JOIN vehicle_details AS v ON v.auction_id = a.ID 
						LEFT JOIN '.$_SESSION['l10n']['table_prefix'].'models AS md ON md.id = v.model_id 
							LEFT JOIN '.$_SESSION['l10n']['table_prefix'].'makes AS mk ON mk.id = md.make_id 
						LEFT JOIN '.$_SESSION['l10n']['table_prefix'].'badges AS bg ON bg.id = v.badge_id
						LEFT JOIN type_colours AS c ON c.id = v.colour_id 
						LEFT JOIN type_transmission AS t ON t.id = v.transmission_id 
						LEFT JOIN type_body AS tb ON tb.id = v.body_id 
						LEFT JOIN type_drives AS td ON td.id = v.drive_type_id 
						LEFT JOIN type_fuel AS tf ON tf.id = v.fuel_type_id
						WHERE 1 ';
		$query .= 	'AND a.userID = '.$user_id.'
						GROUP BY a.ID';
	
		$array = array();
		
		foreach($GLOBALS['db']->getAll($query) as $item){
			$array[$item['auction_status']][] = $item; 
		}
		return $array;
	}
	*/
    /**
     * Returns an array of the items which belong to the requested categoryID, for the admin panels
     * 
     * @param integer $categoryID 
     * @return array $items containing
     */
    function getAdminItems($categoryID = 0) {
        $items = array();
        $myDB = &ADONewConnection(DSN); 
        $query = "";
        
        // If categoryID == 0, it means that the user requested to see ALL the items
        if ($categoryID == 0) {
            $query = "SELECT auction_items.* FROM auction_items WHERE processed != 'yes'";
        } else {
            $query = "SELECT auction_items.* FROM auction_items WHERE categoryID = $categoryID AND processed != 'yes'";
        } 
        $rs = &$myDB->Execute($query);


        if (!$rs OR $rs->RecordCount() < 1) {
            // If ResultSet does not exist or if the record count is less than 1 (if there are 0 returned rows)
            // then return an error.
            return ADMIN_NO_ITEM_IN_CATEGORY;
        } else {
            for($i = 0; $i < $rs->RecordCount(); $i++) {
                $theItem = new Item($rs->fields);
                // Why use an explicit userID (4) here? this will cause errors in unit testing
                // $theSeller = $theItem->getSeller(4);                       
                $theSeller = $theItem->getSeller();
                $theSeller->getID(); // Push ID information into the $seller object
                $category = new Category(array("ID" => $theItem->categoryID));
                $items[] = array('item' => $theItem, 'seller' => $theSeller, 'category' => $category);
                $rs->MoveNext();
            } 
            return $items;
        } 
    } 
    
	function setStatus($id, $status){
		$query = 'UPDATE auction_items SET statusID = '.$status. ' WHERE ID = ' . $id;
		Site::runQuery($query);
	}

    /**
     * Returns an item object whose itemID matches the requested ID
     * 
     * @param  $itemID 
     * @return object $item
     */
    function getItem($itemID, $object = true) {
        $myDB = &ADONewConnection(DSN);
        $query = "SELECT *, u.city, ".($_SESSION['l10n']['country_code'] == 'IE'?'rg.region AS city2, ':'')." v.model_id as model_id, roof, v.id AS vid, MAX(b.amount) as highest_bid, extended, 
						aus.status as auction_status, b.userID as latest_bidder, 
						SUM(CASE WHEN b.typeID = 1 OR b.typeID = 8 THEN 1 ELSE 0 END ) AS count_bids,
						SUM(CASE WHEN b.typeID = 9 THEN 1 ELSE 0 END) AS count_requests,
						SUM(CASE WHEN b.typeID = 7 THEN 1 ELSE 0 END) AS count_extends,
						a.userID as userID, a.ID, aus.status as status, 
						ic.colour AS interior_colour, c.colour, it.interior
							FROM auction_items AS a 
					LEFT JOIN auction_bids AS b ON b.itemID = a.ID
					LEFT JOIN auction_status AS aus ON a.statusID = aus.id
					LEFT JOIN auction_users AS u ON u.ID = a.userID
					LEFT JOIN regions AS rg ON rg.id = u.location_id
					LEFT JOIN states AS st ON st.id = u.state
					LEFT JOIN auction_lengths AS l ON l.id = a.auctionlength
					LEFT JOIN vehicle_details AS v ON v.auction_id = a.ID 
						LEFT JOIN ".$_SESSION['l10n']['table_prefix']."models AS md ON md.id = v.model_id 
							LEFT JOIN ".$_SESSION['l10n']['table_prefix']."makes AS mk ON mk.id = md.make_id 
						LEFT JOIN ".$_SESSION['l10n']['table_prefix']."badges AS bg ON bg.id = v.badge_id
						LEFT JOIN ".$_SESSION['l10n']['table_prefix']."series AS s ON s.id = v.series_id
						LEFT JOIN type_colours AS c ON c.id = v.colour_id 
						LEFT JOIN type_interiors AS it ON it.id = v.interior_type_id
						LEFT JOIN type_colours AS ic ON ic.id = v.interior_colour_id 
						LEFT JOIN type_transmission AS t ON t.id = v.transmission_id 
						LEFT JOIN type_body AS tb ON tb.id = v.body_id 
						LEFT JOIN type_roofs AS tr ON tr.id = v.roof_type_id
						LEFT JOIN type_drives AS td ON td.id = v.drive_type_id 
						LEFT JOIN type_fuel AS tf ON tf.id = v.fuel_type_id 
					WHERE a.ID = $itemID
					GROUP BY a.ID";
		
		if(!$object) return $GLOBALS['db']->getAll($query);
        else $rs = &$myDB->Execute($query);
        
        
        if (!$rs || $rs->RecordCount() < 1) {
            return false;
        } else {
        	
            $item = new Item($rs->fields);
            return $item;
        } 
    } 
	
	function getFailedRequests($id){
		$query = 'SELECT u.* FROM auction_bids AS b
					LEFT JOIN auction_users AS u ON b.user_id = u.ID
					WHERE b.typeID = 7 AND b.userID = '.$id;
					
		return Site::getData($query, false);
	}
	
	function getExpiry($id){
		$query = 'SELECT extended, auction_end FROM auction_items WHERE ID = '.$id;
		return Site::getData($query, true);
	}
	
	function closeClosed(){
		$query = 'UPDATE auction_items SET statusID = 4 WHERE statusID = 2 AND auction_end < '.time();
		Site::runQuery($query);
	}
	
	function extendListing($id){
		//$lis = $lis/2;
		
		$lis = Auction::getAuctionLength($_POST['auctionlength']);
		$end = time() + $lis;
		$query = 'UPDATE auction_items SET extended = extended + 1, auction_end = '.$end . ' WHERE ID = '.$id;
		//echo $query;
		Site::runQuery($query);
		return $lis;
	}
	
    /**
     * Returns an object with the attributes of the seller of this item (a User object)
     * 
     * @param ID $ the userID of the user to fetch
     * @return object User object: the contributor/seller
     */
    function getUserObject($ID) {
        $myDB = &ADONewConnection(DSN);
        $query = "SELECT * FROM auction_users WHERE ID = {$ID}";

        $rs = &$myDB->Execute($query);
        if (!$rs || $rs->RecordCount() < 1) {
            return AUCTION_NO_USER_FOUND;
        } else {
            $user = new User($rs->fields);
            return $user;
        } 
    } 

    /**
     * Attempts to close the current auction, usually based on expiry time
     * @return boolean True if auction successfully closed, False if not
     */
    function closeAuction() {
            // NOT YET IMPLEMENTED
    } 

    /**
     * Creates a new auction in the database
     * @param array $date Human date, [0 => "YYYY", 1 => "MM", 2 => "DD"] must be converted to timestamp
     * @param array $options 
     * @return boolean True if auction successfully created, False if not
     */
    function newAuction($date, $options) {
            // NOT YET IMPLEMENTED
    } 

    /**
     * Fetches an array of categories from the database
     * @param string $type If type is "listing", returns only categories with items in it. If "submit", returns all categories except "All items"
     * @return array $categories All categories available for listing items under, or error message
     */
    function getCategories($type = "listing") {
        $categories = array();
        $myDB = &ADONewConnection(DSN);
        if ($type == "listing") {
            // Prepare the special category "All items"
            $query = "SELECT auction_categories.ID,  auction_categories.name
                FROM auction_categories, auction_items
                WHERE auction_items.categoryID = auction_categories.ID
                AND processed != 'yes'
                GROUP BY auction_categories.ID
                ORDER BY auction_categories.name";
            $rs = &$myDB->Execute($query); 
            // If $rs doesn't exist, or no records are returned, return an error.
            if (!$rs) {
                return AUCTION_NO_CATEGORY_FOUND;
            } elseif ($rs->RecordCount() < 1) {
                // If no records are returned, then there are no items to be bid upon.
                // Show the "all items" link but a zero count for items in it
                $categories[0]['name'] = "All items";
                $categories[0]['count'] = 0;
            } else {
                $categories[0]['name'] = "All items";
                $items = $this->getItems(0);
                $categories[0]['count'] = count($items);
            } 
        } elseif ($type == "submit") {
            $query = "SELECT auction_categories.* FROM auction_categories ORDER BY auction_categories.name ";
            $rs = &$myDB->Execute($query);
            if (!$rs) {
                return AUCTION_NO_CATEGORY_FOUND;
            } else {
            } 
        } 
        // Fill the rest of the categories array with the other categories.
        for($i = 0; $i < $rs->RecordCount(); $i++) {
            $categories[$rs->fields['ID']]['name'] = $rs->fields['name'];
            $items = $this->getItems($rs->fields['ID']);
            $categories[$rs->fields['ID']]['count'] = count($items);
            $rs->MoveNext();
        } 
        $myDB->Close();
        return $categories;
    } 

    /**
     * This queries the database in order to find all the items this user is selling/contributing
     * @param integer $userID 
     * @return array An array of item objects with associated bid objects, or an error message
     */
    function getItemsUserIsSelling($userID) {
        // Empty this auction's items list to make room for this one
        $this->items = array();
        $myDB = &ADONewConnection(DSN);
        $query = "SELECT auction_items.* 
            FROM auction_items, auction_users 
            WHERE auction_users.ID = auction_items.userID
            AND processed != 'yes'
            AND auction_items.userID = $userID";
        $rs = &$myDB->Execute($query);

        if (!$rs) {
            return AUCTION_NO_ITEM_FOUND;
        } else {
            for($i = 0; $i < $rs->RecordCount(); $i++) {
                $this->items[$i] = new Item($rs->fields);
                $rs->MoveNext();
            } 
            return $this->items;
        } 
    } 
    
    
    function getMessages($message = false){
		
		$file_location = $_SERVER['DOCUMENT_ROOT'].'/cache/messages.php';
		
		if(file_exists($file_location)){
			$array = unserialize(file_get_contents($file_location));
		} else {
			$query = "SELECT constant, message FROM auction_messages WHERE locale = 'en_US'";
			
			$array = Site::getData($query, false, 'constant', 'message');
			
			@file_put_contents($file_location, serialize($array));
		}
		
		foreach($array as $k => $v){
			define($k, $v);
		}
		
		if($message) return $array[$message];
		else return $array;
		
		
	}

    /**
     * This queries the database in order to find all the items this user is bidding on
     * @param integer $userID 
     * @return array An array of item objects with associated bid objects, or an error message
     */
    function getItemsUserIsBuying($userID) {
        // Empty this auction's items list to make room for this one
        $this->items = array();
        $myDB = &ADONewConnection(DSN);
        $query = "SELECT DISTINCT auction_items.* 
            FROM auction_items, auction_users, auction_bids
            WHERE auction_bids.userID = $userID
            AND processed != 'yes'
            AND auction_items.ID = auction_bids.itemID";
        $rs = &$myDB->Execute($query); 
        // print_a($rs->fields);
        if (!$rs) {
            return AUCTION_NO_ITEM_FOUND;
        } else {
            for($i = 0; $i < $rs->RecordCount(); $i++) {
                $this->items[$i] = new Item($rs->fields);
                $this->items[$i]->setWinning($userID);
                $rs->MoveNext();
            } 
            return $this->items;
        } 
    } 

    /**
     * This queries the database in order to find all the items this user has won
     * Some of these items might no longer be held on record
     * @param integer $userID 
     * @return array An array of item objects with associated bid objects, or an error message
     */
    function getItemsUserHasWon($userID) {
        // Empty this auction's items list to make room for this one
        $this->items = array();
        $myDB = &ADONewConnection(DSN);
        $query = "SELECT auction_items.*
            FROM auction_items, auction_users, auction_bids
            WHERE auction_bids.userID = $userID
            AND auction_items.ID = auction_bids.itemID
            AND auction_bids.userID = auction_users.ID
            AND auction_bids.statusID = 1";
        $rs = &$myDB->Execute($query); 
        // print_a($rs->fields);
        if (!$rs) {
            return AUCTION_NO_WINNING_ITEM_FOUND;
        } else {
            for($i = 0; $i < $rs->RecordCount(); $i++) {
                $this->items[$i] = new Item($rs->fields);
                $this->items[$i]->setWinning($userID);
                $rs->MoveNext();
            } 
            return $this->items;
        } 
    } 

    /**
     * This queries the database in order to find all the items this user has lost
     * Some of these items might no longer be held on record
     * @param integer $userID 
     * @return array An array of item objects with associated bid objects, or an error message
     */
    function getItemsUserHasLost($userID) {
        // If the supplied userID is null or empty, return an error
        if ($userID == "" || is_null($userID)) {
            return ADMIN_USER_REMOVE_FAILURE;
        } 
        // Empty this auction's items list to make room for this one

        $this->items = array();

        $myDB = &ADONewConnection(DSN);

        $query = "SELECT auction_items.* 

            FROM auction_items, auction_users, auction_bids

            WHERE auction_bids.userID = $userID

            AND auction_items.ID = auction_bids.itemID

            AND auction_bids.userID = auction_users.ID

            AND auction_bids.statusID = 2

            AND processed = 'yes'

            GROUP BY itemID";

        $rs = &$myDB->Execute($query);

        if (!$rs) {

            return AUCTION_NO_LOSING_ITEM_FOUND;

        } else {

            for($i = 0; $i < $rs->RecordCount(); $i++) {

                $this->items[$i] = new Item($rs->fields);

                $rs->MoveNext();

            } 

            return $this->items;

        } 

    } 



    /**

     * This queries the database in order to find all the items this user has lost

     * Some of these items might no longer be held on record

     * @param integer $userID 

     * @return array An array of item objects with associated bid objects, or an error message

     */

    function getItemsUserHasSold($userID) {

        // Empty this auction's items list to make room for this one

        $this->items = array();

        $myDB = &ADONewConnection(DSN);

        $query = "SELECT auction_items.*

            FROM auction_items, auction_users, auction_bids

            WHERE auction_items.userID = $userID

            AND auction_bids.itemID = auction_items.ID

            AND auction_users.ID = auction_items.userID

            AND auction_items.processed = 'yes'

            GROUP BY userID";

        $rs = &$myDB->Execute($query);

        if (!$rs) {

            return AUCTION_NO_SOLD_ITEM_FOUND;

        } else {

            for($i = 0; $i < $rs->RecordCount(); $i++) {

                $this->items[$i] = new Item($rs->fields);

                $rs->MoveNext();

            } 

            return $this->items;

        } 

    } 



    /**

     * This queries the database in order to find all the items this user has lost

     * Some of these items might no longer be held on record

     * @param integer $userID 

     * @return array An array of item objects with associated bid objects, or an error message

     */

    function getItemsUserHasNotSold($userID) {

        $today = time(); 

        // Empty this auction's items list to make room for this one

        $this->items = array();

        $myDB = &ADONewConnection(DSN);

        $query = "SELECT auction_items. *

            FROM auction_items, auction_users

            WHERE auction_items.userID = $userID

            AND auction_users.ID = auction_items.userID

            AND auction_items.processed = 'yes'";

        $rs = &$myDB->Execute($query);

        if (!$rs) {

            return AUCTION_NO_UNSOLD_ITEM_FOUND;

        } else {

            for($i = 0; $i < $rs->RecordCount(); $i++) {

                $item = new Item($rs->fields); 

                // Add the item to the array if no bids are recorded for it

                if (count($item->bids) == 0) {

                    $this->items[$i] = $item;

                } 

                $rs->MoveNext();

            } 

            return $this->items;

        } 

    } 



    /**

     * Checks whether items in this auction are finished or not. Also checks whether they have been processed (in DB)

     * If time is out, processes the email notifications, DB modifications

     * @return array An array with an error message if error, true if successful

     */

    function checkEndOfItems() {

        $mailman = new MailMan();

        $items = $this->getItems();

		

		

		if(!is_array($items)) return $items;

		

        foreach($items as $item) {

            $time_left = $item->getSecondsLeft();

            if ($time_left <= 0 AND $item->processed != "yes") {

                // Set item as processed

                $item->setAsProcessed(); 

                // Check the item's reserve price, and whether it has been met or not

                if ($item->getCurrentPrice() < $item->reserve) {

                    // Reserve not met: email seller and all bidders

                    $losing_bids = $item->getDistinctBids(); 

                    

                    

                    // Email Losers

                    foreach($losing_bids as $losing_bid) {

                        // Record bids as losses

                        $losing_bid->setResult("lost");

                        $result = $mailman->noticeReserveNotMet($losing_bid);

                        if ($result !== true) {

                            return array("message" => $result, "field" => "");

                        } 

                    } 

                } else {

                    // Identify losers, if any

                    $losing_bids = $item->getLosingBids(); 

                    // Identify winner, if any (we take the winning bid, not the winning user)

                    $winning_bid = $item->getWinningBid(); 

                    // Record winning bid as win

                    // Check that there is a bid first

                    if(!is_string($winning_bid)) {

                        $winning_bid->setResult("won");

                    }

                    // Email winner

                    $result = $mailman->noticeWin($winning_bid);

                    if ($result !== true) {

                        return array("message" => $result, "field" => "");

                    } 

                } 

            } 

        } 

        return true;

    } 



    /**

     * Records a new message constant in the database or updates an existing one

     * @param array $fields 

     * @return boolean true if success, error message if failure

     */

    function recordMessageConstant($fields) {

        extract($fields);

        $myDB = &ADONewConnection(DSN);

        if ($formdata == "submission") {

            $query = "INSERT INTO auction_messages (`locale`, `constant`, `message`) 

                VALUES ('$locale','$constant','$message')";

        } elseif ($formdata == "update") {

            $query = "UPDATE auction_messages 

                SET constant = '$constant', message = '$message', locale = '$locale' WHERE ID = $ID";

        } 

        $rs = &$myDB->Execute($query);

        if (!$rs) {

            if ($formdata == "submission") {

                return array("message" => ADMIN_INSERT_MESSAGE_ERROR, "field" => "");

            } elseif ($formdata == "update") {

                return array("message" => ADMIN_UPDATE_MESSAGE_ERROR, "field" => "");

            } 

        } elseif($myDB->Affected_Rows() < 1) { 

            return array("message" => "No changes were made during the database operation.", "field" => "");

        } else {

            return true;

        } 

    } 



    /**

     * Retrieves all message constants from database

     * @return array $messages if successful, error message if not

     

    function getMessages() {

        $myDB = &ADONewConnection(DSN);

        $query = "SELECT * FROM auction_messages ORDER BY constant";

        $rs = &$myDB->Execute($query);

        $messages = array();

        if (!$rs || $rs->RecordCount() == 0) {

            return array("message" => ADMIN_NO_MESSAGES_FOUND, "field" => "");

        } else {

            for($i = 0; $i < $rs->RecordCount(); $i++) {

                $messages[$i] = $rs->fields;

                $rs->MoveNext();

            } 

            return $messages;

        } 

    } 

*/



	function getHistory($id, $single = false){

		$query = 'SELECT h.*, h.userID as bidder, i.userID as seller, dateentered, t.type, year, make, model FROM auction_bids AS h
					JOIN auction_items AS i ON h.itemID = i.id
					JOIN auction_bid_type AS t ON h.typeID = t.id
					JOIN vehicle_details AS vd ON vd.auction_id = h.itemID
						LEFT JOIN '.$_SESSION['l10n']['table_prefix'].'models AS md ON md.id = vd.model_id
					LEFT JOIN '.$_SESSION['l10n']['table_prefix'].'makes AS mk ON mk.id = md.make_id
					WHERE h.itemID = '.$id . ($single ? ' AND h.ID = ' . $single :'') . ' ORDER BY datesubmitted DESC';
					
		return Site::getData($query, false);
	}

	

	function setNewWinner($item_id, $id){
		$query = 'UPDATE auction_bids SET statusID = 2 WHERE itemID = '.$item_id;
		Site::runQuery($query);
		
		$query = 'UPDATE auction_bids SET statusID = 1 WHERE itemID = '.$item_id.' AND ID = '.$id;
		Site::runQuery($query);
	}

	

	function setNewPrice($item_id, $amount){
		$query = 'UPDATE auction_items SET currentprice = "'.$amount.'" WHERE ID = '.$item_id;
		Site::runQuery($query);
	}


	
	function saveVehicleDetails($id){
		$query = 'UPDATE vehicle_details SET 
					fuel_type_id = '.$_POST['fuel_type_id'].', 
					drive_type_id = '.$_POST['drive_type_id'].', 
					body_id = '.$_POST['body_id'].', 
					transmission_id = '.$_POST['transmission_id'].', 
					mileage = '.$_POST['mileage'].', 
					roof_type_id = "'.$_POST['roof_type_id'].'", 
					import = "'.$_POST['import'].'", 
					series_id = "'.$_POST['series_id'].'", 
					badge_id = "'.$_POST['badge_id'].'", 
					interior_type_id = "'.$_POST['interior_type_id'].'", 
					interior_colour_id = "'.$_POST['interior_colour_id'].'", 
					build_month = "'.$_POST['build_month'].'", 
					year = "'.$_POST['year'].'", 
					comp_month = "'.$_POST['comp_month'].'", 
					comp_year = "'.$_POST['comp_year'].'",
					doors = "'.$_POST['doors'].'", 
					cylinders = "'.$_POST['cylinders'].'",
					max_requests = "'.@$_POST['max_requests'].'", 
					spend = "'.$_POST['spend'].'",
					colour_id = "'.$_POST['colour_id'].'", 
					interior_colour_id = "'.$_POST['interior_colour_id'].'", 
					interior_type_id = "'.$_POST['interior_type_id'].'"
						WHERE id = '.$id;
						
		Site::runQuery($query);
		
		$query = 'UPDATE auction_items SET startprice = "'.$_POST['edit_amount'].'", currentprice = "'.$_POST['edit_amount'].'", description = "'.$_POST['description'].'", buyoutprice = "'.$_POST['buyoutprice'].'" WHERE ID = "'.$_POST['itemID'].'"';
		
		Site::runQuery($query);
	}
	
	
	function getWinningBid($id){

		$query = 'SELECT b.* FROM auction_bids AS b WHERE b.typeID = 1 AND b.statusID = 1 AND itemID = '.$id.' ORDER BY amount DESC LIMIT 1';
		
		return Site::getData($query, true);
	}

	function refreshBids($id, $seconds = 30){

		$query = 'SELECT h.*, type, year, badge, model, make FROM auction_bids AS h 
			JOIN auction_items AS i ON h.itemID = i.id
					JOIN auction_bid_type AS t ON h.typeID = t.id
					JOIN vehicle_details AS vd ON vd.auction_id = h.itemID
						LEFT JOIN '.$_SESSION['l10n']['table_prefix'].'models AS md ON md.id = vd.model_id
					LEFT JOIN '.$_SESSION['l10n']['table_prefix'].'makes AS mk ON mk.id = md.make_id
						LEFT JOIN '.$_SESSION['l10n']['table_prefix'].'badges AS bd ON bd.model_id = vd.badge_id
		WHERE 1 AND h.itemID = '.$id.' ORDER BY datesubmitted DESC';
		
		return Site::getData($query, false);
	}

	

    /**
     * Deletes a message from the database
     * @param integer $ID Unique ID number
     * @return boolean true if success, error message if failure
     */
    function deleteMessage($ID) {
        $myDB = &ADONewConnection(DSN);
        $query = "DELETE FROM auction_messages WHERE ID = $ID";
        $rs = &$myDB->Execute($query);
        if (!$rs) {
            return array("message" => ADMIN_DELETE_MESSAGE_FAILURE, $field => "");
        } else {
            return true;
        } 
    } 

    /**
     * Updates the settings for this auction in the database
     * @param array $fields Should be the post data from admin_auction.php
     * @return boolean true if success, error message if failure
     */
    function updateSettings($fields) {
        $myDB = &ADONewConnection(DSN);
        foreach($fields as $k => $v) {
            if ($k != "debug" AND $k != "formdata") {
                $query = "UPDATE admin_config SET value = '$v' WHERE setting = '$k'";
                $rs = &$myDB->Execute($query);
                if (!$rs) {
                    return array("message" => ADMIN_UPDATE_SETTINGS_FAILURE, $field => "");
                } else {
                } 
            } 
        } 
        return true;
    } 
    
    /**
     * Returns an array of all users in this auction, indexed by their ID number. These are user objects
     * @return array $users if successful, error message if not
     */
    function getUsers() {
        $myDB = &ADONewConnection(DSN);
        $query = "SELECT * FROM auction_users";
        $rs = &$myDB->Execute($query);
        if (!$rs  || $rs->RecordCount() < 1) {
            return false;
        } else {
            $users = array();
            for($i = 0; $i < $rs->RecordCount(); $i++) {
                $users[] = new User($rs->fields);
                $rs->MoveNext();
            } 
            return $users;
        } 
    } 

    /**
     * Returns an array of all bids in this auction, indexed by their ID number. These are bid objects
     * @return array $bids if successful, error message if not
     */
    function getBids() {
        $myDB = &ADONewConnection(DSN);
        $query = "SELECT * FROM auction_bids";
        $rs = &$myDB->Execute($query);
        if (!$rs) {
            return AUCTION_NO_BIDS_FOUND;
        } else {
            $bids = array();
            for($i = 0; $i < $rs->RecordCount(); $i++) {
                $bids[] = new Bid($rs->fields);
                $rs->MoveNext();
            } 
            return $bids;
        } 
    } 
	
	function sendVehicleMatches($id, $user_id, $content){
		$message = new Message();
		
		$vehicle_matches = Auction::getVehicleMatches($content);
		$groups_preferred = User::loadGroupPreferred($user_id);
		
		$sent = array();
		
		foreach($vehicle_matches as $m){
			$message_data = $message->getMessageData(9, $m['ID'], $groups_preferred);
			
			if(!in_array($message_data['email'], $sent)){
				$message->sendMessage($content->data, $message_data);
				$sent[] = $message_data['email'];
			}
		}
		$log = $message->getMatchLog($id);
		
		$ob = ob_get_contents();
		@ob_end_clean();
	}
} 

?>