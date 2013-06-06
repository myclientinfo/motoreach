<?php
/**
 * 
 * @package auction
 * 
 * These classes are a complete auction framework, ready to implement using a minimum amount of procedural PHP code, 
 * and a templating system like Smarty. The database abstraction layer AdoDB is used.
 * @version $Id: class_user.php,v 1.11 2005/06/24 03:33:30 nicolasconnault Exp $
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
 * User
 * 
 * Represents a user of the auction (either seller or buyer)
 * 
 * @package auction
 * @author nicolas 
 * @copyright Copyright (c) 2005
 * @version $Id: class_user.php,v 1.11 2005/06/24 03:33:30 nicolasconnault Exp $
 * @access public 
 */

class User {
    
    /**
     * Constructor function : uses form data or sql results to create a new User object
     * 
     * @todo Add error checking for incomplete fields
     * @param array $fields The user's attributes
     */
    function User($fields = null) {
        if (is_array($fields)) {
			foreach($fields as $k => $v){
				$this->$k = $v;
			}
		}

        if (isset($ID)) $this->ID = $ID;
    } 

    /**
     * Enters the user in the database
     * 
     * @return boolean True if user was succesfully entered in DB, false if the user is already entered
     */
    function recordUser() {
		
		$approved = $this->rep_number ? 1 : 0;
		$public = $this->rep_number ? 1 : 0;
		
		if($_SESSION['l10n']['country_code']=='IE') $location_id = $_POST['city'];
		else $location_id = User::getRegion($this->zip);
		
        $query = "INSERT INTO auction_users (
            fullname, email, password, streetaddress, account_email, account_phone, 
			dealership_name, city, state, zip, phone, mobile, dealer_name, country_id, 
			dealer_number, location_id, rep_number, signup_time, user_type_id, approved, public_preferred)
            VALUES(
            '".mysql_real_escape_string($this->fullname)."', '".mysql_real_escape_string($this->email)."', '".MD5($this->password)."', '".mysql_real_escape_string($this->streetaddress)."', '".mysql_real_escape_string($this->account_email)."', '".mysql_real_escape_string($this->account_phone)."', 
			'".mysql_real_escape_string($this->dealership_name)."', '".mysql_real_escape_string($this->city)."', '".mysql_real_escape_string($this->state)."', '".mysql_real_escape_string($this->zip)."', '".mysql_real_escape_string($this->phone)."', '".mysql_real_escape_string($this->mobile)."', '".mysql_real_escape_string($this->dealer_name)."', '".mysql_real_escape_string($this->country_id)."',
			'".mysql_real_escape_string($this->dealer_number)."', '".mysql_real_escape_string($location_id)."', '".mysql_real_escape_string($this->rep_number)."', NOW(), '".mysql_real_escape_string($this->user_type_id)."', '".mysql_real_escape_string($approved)."', '".mysql_real_escape_string($public)."')";
        
        $user_id = Site::runQuery($query);
		
		if(strstr($user_id, 'RROR:')){
			return $user_id;
		}
		
		User::newUserPermissions($user_id);
		
		if($this->user_type_id != 5){
			User::createDefaultMatchPreference($user_id, $location_id);
		}
		
		return $user_id;
    }
	
	function createDefaultMatchPreference($user_id, $location_id){
		$query = 'INSERT INTO match_prefs (user_id, make_id, model_id, from_year, to_year, location) VALUES ('.$user_id.', 0, 0, 1900, '.date('Y').', "'.$location_id.'")';
		Site::runQuery($query);
	}
	
	function newUserPermissions($user_id){
		$roles = array(1 => array(1, 3, 4, 5, 6, 9), 2 => array(1, 3, 4, 9), 3 => array(1, 3, 4, 9), 4 => array(1, 3, 4, 5, 9), 5 => array(3, 4, 9), 
		6 => array(1, 3, 4, 9), 7 => array(1, 2, 3, 4, 9), 8 => array(1, 3) );
		
		$roles = $roles[$_POST['user_type_id']];
		
		$i = 0;
		$query = 'INSERT INTO user_permissions(user_id, permission_id) VALUES';
		foreach($roles as $perm){
			$query .= ($i>0?', ':'').'('.$user_id.', '.$perm.')';
			$i++;
		}
		
		Site::runQuery($query);
	}
	
	function loadUserPermissions($id = false){
		
		$query = 'SELECT p.id, p.action FROM permissions AS p
					JOIN user_permissions AS up ON up.permission_id = p.id
					WHERE up.user_id = '. ( $id ? $id : User::getSimpleUser() );
		
		$data = Site::getData($query, false, 'id', 'action');
		
		$_SESSION['auction']->user->approved = 1;
		
//		print_r($query);
		
		if($id){
			return $data;
		} else {
			$_SESSION['permissions'] = array_values($data);
			return $_SESSION['permissions'];
		}
	}
	
	
	function loadGroupPreferred($id = false){
		
		if(@$_SESSION['auction']->user->group_name=='') return array();
	
		$query = 'SELECT * FROM group_preferred WHERE group_id = '.($id ? $id : $_SESSION['auction']->user->group_id);
		
		$data = Site::getData($query, false, 'id', 'user_id');
		$data = array_values($data);
		if(!$id){
			$_SESSION['group_preferred'] = $data;
		}
		return $data;
	}
	
	
	
	function getBidVehicles(){
		$query = 'SELECT *, SUM(CASE WHEN b.typeID = 1 OR b.typeID = 8 THEN 1 ELSE 0 END ) AS count_bids FROM auction_bids AS b 
					LEFT JOIN auction_items AS i ON b.itemID = i.ID
					JOIN vehicle_details AS vd ON vd.auction_id = b.itemID
						LEFT JOIN '.$_SESSION['l10n']['table_prefix'].'models AS md ON md.id = vd.model_id
						LEFT JOIN '.$_SESSION['l10n']['table_prefix'].'makes AS mk ON mk.id = md.make_id
						LEFT JOIN '.$_SESSION['l10n']['table_prefix'].'badges AS bd ON bd.model_id = vd.badge_id
						LEFT JOIN '.$_SESSION['l10n']['table_prefix'].'series AS s ON s.model_id = vd.series_id
						LEFT JOIN type_colours AS c ON c.id = vd.colour_id ';
		$query.= ' WHERE b.userID = '.User::getSimpleUser();
		$query.= ' AND b.typeID = 9 AND auction_end > UNIX_TIMESTAMP() GROUP BY i.ID';
		
		return Site::getData($query, false);
	}
	
	
	function hasPermission($permission){
		if(!isset($_SESSION['permissions'])) return false;
		if(in_array('Super Admin', $_SESSION['permissions'])) return true;
		
		$user_type_id = User::getSD('user_type_id');
		
		$user_types = array( 1 => 'Motor Dealer',
							4 => 'Rental',
							5 => 'Public',
							6 => 'MotoReach Rep',
							7 => 'MotoReach Admin',
							8 => 'MotoReach Support'
						);
						
		$user_type = $user_types[$user_type_id];
		
		if(in_array($permission, $_SESSION['permissions'])){
			return true;
		} else {
			if($user_type == 'MotoReach Rep'){
				if($permission == 'Edit') return true;
				if($permission == 'Admin') return true;
				if($permission == 'Utility') return false;
				if($permission == 'Reporting') return true;
				if($permission == 'Tasks') return false;
			} else if($user_type == 'MotoReach Support'){
				if($permission == 'Edit') return true;
				if($permission == 'Admin') return true;
				if($permission == 'Utility') return false;
				if($permission == 'Reporting') return false;
				if($permission == 'Tasks') return false;
			} else if($user_type == 'MotoReach Admin'){
				if($permission == 'Edit') return true;
				if($permission == 'Admin') return true;
				if($permission == 'Utility') return true;
				if($permission == 'Reporting') return true;
				if($permission == 'Tasks') return true;
			} else {
				return false;
			}
		}
	}
	
	function getRecentHistory($user_id, $bids_made_only = false){
		$query = 'SELECT h.ID, type, h.userID as bidder, h.statusID, i.userID as seller, amount, startprice, h.datesubmitted, itemID, 
						vd.year, make, model, badge, "made" as label 
					FROM auction_bids AS h
					JOIN auction_items AS i ON h.itemID = i.id
					JOIN auction_bid_type AS t ON h.typeID = t.id
					JOIN vehicle_details AS vd ON vd.auction_id = h.itemID
						LEFT JOIN '.$_SESSION['l10n']['table_prefix'].'models AS md ON md.id = vd.model_id
						LEFT JOIN '.$_SESSION['l10n']['table_prefix'].'makes AS mk ON mk.id = md.make_id
						LEFT JOIN '.$_SESSION['l10n']['table_prefix'].'badges AS bd ON bd.model_id = vd.badge_id
						LEFT JOIN '.$_SESSION['l10n']['table_prefix'].'series AS s ON s.model_id = vd.series_id
						WHERE '.($bids_made_only?'h':'i').'.userID = '. $user_id ;
		if($bids_made_only) $query .= ' AND t.type = "Bid Entered"';
		$query .= '				ORDER BY h.datesubmitted ASC';
		
		$array =  Site::getData($query, false);
		
		if(!is_array($array) || empty($array)) return array();
		
		foreach($array as $i){
			$temp_array[$i['itemID']][$i['type']] = $i;
		}
		
		$array = array();
		foreach($temp_array as $t){
			foreach($t as $i) $array[$i['datesubmitted']] = $i;
		}
		
		krsort($array);
		return $array;
	}
	
    /**
     * Deletes this user from the database
     * 
     * @return boolean true if successful, error message if failure
     */
    function deleteUser() {
        $myDB = &ADONewConnection(DSN);
        $query = "DELETE FROM auction_users WHERE ID = {$this->ID}";
        $rs = &$myDB->Execute($query);
        if (!$rs) {
            return ADMIN_USER_REMOVE_FAILURE;
        } else {
            return true;
        } 
    } 

    /**
     * User::getUser()
     * 
     * Using the given alias and password, retrieves a user from the database. This object's attributes will be updated
     * 
     * @param string $alias 
     * @param string $password 
     * @return string TRUE if user was successfully retrieved, error message if an error occurred.
     */
    function getUser($alias, $password) {
        $validate = new Validate();
        $result = $validate->checkUser($alias, $password); 
		
		// If user data has been validated, update this object with the result from the query
        if (isset($result['ID'])) {
            $this->User($result);
            return true;
        } else {
            return $result;
        } 
    } 
	
	
	
    /**
     * Sometimes a user is simply retrieved from the current session, which does not hold 
     * ID numbers. Using the unique alias, we retrieve this ID number.
     * 
     * @return int ID number of this user, retrieved from the database
     */
    function getID() {
    	if(!isset($this->email)) return false;
        $myDB = &ADONewConnection(DSN);
        $query = "SELECT * FROM auction_users WHERE email = '{$this->email}'";
        $rs = &$myDB->Execute($query);
        if (!$rs) {
            return AUCTION_NO_USER_FOUND;
        } else {
            $this->User($rs->fields);
            $this->ID = $rs->fields['ID'];
            return $this->ID;
        } 
    } 
	
	function getUserFromEmail($email){
		$query = 'SELECT * FROM auction_users WHERE email = "'.$email.'"';
		return Site::getData($query, true);
	}
	
	function getCurrentUser($id){
		$query = 'SELECT u.*, g.group_name, g.id as group_id, t.type FROM auction_users AS u 
					LEFT JOIN groups AS g ON u.group_id = g.id 
					LEFT JOIN user_types AS t ON t.id = u.user_type_id
					WHERE u.ID = '.$id;
		
		return Site::getData($query, true);
	}
	
	function checkUserAuth(){
		$auth = $_REQUEST['auth'];
		$data = User::getCurrentUser($_REQUEST['userID']);
		$md5 = md5(SALT.$data['email'].$data['fullname']);
		
		if($auth == $md5) return true;
		else return false;
	}
	
	
	
	function resetPassword(){
		$query = 'UPDATE auction_users SET password = MD5("'.$_POST['password'].'") WHERE ID = '.$_POST['userID'].' LIMIT 1';
		Site::runQuery($query);
	}
	
    /**
     * User::updateUser()
     * 
     * When the user updates his details in editaccount.php, this function makes the changes in the database.
     * It also updates the current user object.
     * 
     * @param integer $userID 
     * @return string TRUE if successfully updated, error message if not
     */
    function updateUser($fields) {
        extract($fields);
        // Deal with the password separately
        if (isset($password) && $password != "" && isset($confirmpassword) && $confirmpassword != "" && $password == $confirmpassword) {
			$query = "UPDATE auction_users SET password = MD5('$password') WHERE ID = '$ID' LIMIT 1";
            Site::runQuery($query);
        } 
		
		if( $zip >= 2470 && $zip <= 2487 ){
			$location_id = 4;
		} else {
			$location_id = substr($zip, 0, 1);
		}
		
        $query = "UPDATE auction_users SET
					streetaddress = '$streetaddress',
					city = '$city',
					state = '$state',
					email = '$email',
					zip = '$zip',
					phone = '$phone',
					mobile = '$mobile',
					fullname = '$fullname',
					account_email = '$account_email',
					account_phone = '$account_phone',
					dealer_name = '$dealer_name',
					dealership_name = '$dealership_name',
					location_id = '$location_id'
					WHERE ID = '$ID'
					LIMIT 1";
        
		Site::runQuery($query);
		
		return $fields;
    } 
    
    function isLoggedIn(){
    	if(isset($_SESSION['authorised']) && $_SESSION['authorised'] == 'valid' && isset($_SESSION['auction']->user->ID)) return $_SESSION['auction']->user->ID;
		else return false;
	}
	
	function setCookie($user_id, $clear = false){
		if($clear){
			$time = time()-13600;
			$user_id = '';
		} else {
			$time = time()+1209600;
		}
		
		if(is_object($user_id)) $user_id = $user_id->ID;
		
		setcookie('user_id', $user_id, $time, '/');
	}
	
	
	function getUserData($id){
		$query = 'SELECT * FROM auction_users WHERE ID = '.$id;
		return Site::getData($query, true);
	}
	
	function setLastOnline(){
		$query = 'UPDATE auction_users SET last_online = UNIX_TIMESTAMP() WHERE ID = ' . $_SESSION['auction']->user->id;
		Site::runQuery($query);
	}
	
	function checkLogin(){
		
		if(isset($_SESSION['authorised']) && $_SESSION['authorised'] == 'valid' && @is_object($_SESSION['auction']->user)){
			$uid = $_SESSION['auction']->user->ID;
			User::setCookie($uid);
			$_SESSION['authorised'] = 'valid';
			User::loadUserPermissions();
			User::loadGroupPreferred();
		} else if(isset($_COOKIE['user_id'])){
			$uid = $_COOKIE['user_id'];
			$u_temp = User::getCurrentUser($uid);
			$_SESSION['auction']->user = new User($u_temp);
			$_SESSION['authorised'] = 'valid';
			User::loadUserPermissions();
			User::loadGroupPreferred();
			return $_SESSION['auction']->user;
		} else {
			return false;
		}
		return User::getCurrentUser($uid);
	}
	
	function getSimpleUser(){
		return @$_SESSION['auction']->user->ID;
	}
	
	
	function addCampaignMonitorSubscriber($user){
		require_once $_SERVER['DOCUMENT_ROOT'].'/classes/campaignmonitor/csrest_subscribers.php';
		//$GLOBALS['debug']->printr($user);
		switch($user['user_type_id']){
			case 4: $list_id = 'fd07f65ad46a1a3dc7910635d58a9c14'; break;
			case 5: $list_id = '175ce758a880156b6dd04fa04f01d3f7'; break;
			default: $list_id = '527f5260491413f80b98abc5956b8a12'; break;
		}
		
		$wrap = new CS_REST_Subscribers($list_id, '77fc96cc1dd9ff540bcb31e0ba3f89df');
		$result = $wrap->add(array(
			'EmailAddress' => $user['email'],
			'Name' => $user['fullname']
		));
		
		
	}
	
	function getCountry($id = false){
		
		if(!$id){
			
			if(($GLOBALS['project'] == $_SERVER['HTTP_HOST']) || $_SERVER['HTTP_HOST'] == 'motopublic'){
				// irish IP
				$ip = sprintf("%u", ip2long('178.250.117.6'));
				
				// australian IP
				//$ip = sprintf("%u", ip2long('124.171.169.124'));
			} else {
				$ip = sprintf("%u", ip2long($_SERVER['REMOTE_ADDR']));
			}
			
			//echo $ip;
			
			$query = 'SELECT * FROM country_ips AS ci 
						LEFT JOIN countries AS c ON c.id = ci.country_id
						WHERE '.$ip.' >= ci.begin_num AND '.$ip.' <= ci.end_num';
		} else {
			//echo 'ip provided';
			
			$query = 'SELECT * FROM country_ips AS ci 
						LEFT JOIN countries AS c ON c.id = ci.country_id
						WHERE c.id = "'.$id.'" LIMIT 1';
		}
		//$GLOBALS['debug']->printr($query, true);
		//print_r('here');
		$data = Site::getData($query, true);
		return $data;
	}
	
	
	function getRegion($postcode, $value = 'id'){
		$query = 'SELECT r.id, r.region FROM regions AS r 
					JOIN region_map AS m ON r.id = m.region_id
					WHERE m.max_post > '.$postcode.' AND m.min_post < '.$postcode;
		
		if($_SESSION['l10n']['country_code'] == 'IE'){
			if(!$value) return array('id' => $_POST['state_id']);
			else return $_POST['state'];
		}
		
		$region = Site::getData($query, true);
		
		if(!$value) return $region;
		else return $region[$value];
	}
	
	function addPref($manual = false, $user_id = false){
		
		$data = $manual ? $manual : $_POST;
		$user_id = $user_id ? $user_id : User::getSimpleUser();
		
		if($data['make_id'] == '') $data['model_id'] = '';
		
		if(isset($data['regions'])){
			sort($data['regions']);
			$location = '"'.implode(',', $data['regions']).'"';
		} else {
			if($_SESSION['l10n']['country_code']!='IE') $location = '"1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23"';
			else $location = '"28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53"';
		}
		//$GLOBALS['debug']->printr($data);
		if(!isset($data['from_year']) || @$data['from_year'] == '' || @$data['from_year'] == 0 || @$data['from_year'] == 100){
			$data['from_year'] = 1900;
		} else {
			$data['from_year'] = date('Y') - $data['from_year'];
		}
		
		if(!isset($data['to_year']) || @$data['to_year'] == '' || @$data['to_year'] == 0 || @$data['to_year'] == 100){
			$data['to_year'] = date('Y');
		} else {
			$data['to_year'] = date('Y') - $data['to_year'];
		}
		
		$query = 'INSERT INTO match_prefs(user_id, match_type_id, make_id, model_id, from_year, to_year, mileage, location) VALUES ("'.$user_id.'", "'.$data['match_type_id'].'", "'.$data['make_id'].'", "'.$data['model_id'].'", "'.@$data['from_year'].'", "'.@$data['to_year'].'", "'.(@$data['mileage']=='Any'?'':$data['mileage']).'", '.$location.')';
		Site::runQuery($query);
	}
	
	function deletePref($id){
		$query = 'DELETE FROM match_prefs WHERE id = ' . $id;
		Site::runQuery($query);
	}
	
	function getPrefs(){
		$query = 'SELECT p.*, match_type, make, model FROM match_prefs AS p 
					LEFT JOIN match_types AS t ON p.match_type_id = t.id 
					LEFT JOIN '.$_SESSION['l10n']['table_prefix'].'makes AS mk ON mk.id = p.make_id
					LEFT JOIN '.$_SESSION['l10n']['table_prefix'].'models AS md ON md.id = p.model_id
					WHERE user_id = ' . (isset($_GET['ID']) ? $_GET['ID'] : User::getSimpleUser()) . ' ORDER BY make ASC';
		//
		return Site::getData($query, false, 'id', false, 'match_type');
	}
	
	function isBoxHidden(){
		return User::getSD('ob_hidden');
	}
	
	function getSD($option = false){
		if(!$option) return $_SESSION['auction']->user;
		else{
			if(!isset($_SESSION['auction']->user->$option)) return false;
			else return $_SESSION['auction']->user->$option;
		}
	}
	
	
	
	function setSD($option, $value){
		$_SESSION['auction']->user->$option = $value;
	}
	
	function setOrangeBox($setting){
		$query = 'UPDATE auction_users SET ob_hidden = ' .$setting. ' WHERE ID = '.User::getSimpleUser();
		Site::runQuery($query);
		User::setSD('ob_hidden', $setting);
	}
	
	
	
} 

?>