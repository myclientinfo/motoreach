<?php
/**
* 
* @package auction
* 
* These classes are a complete auction framework, ready to implement using a minimum amount of procedural PHP code, 
* and a templating system like Smarty. The database abstraction layer AdoDB is used.
* @version $Id: editaccount.php,v 1.2 2005/07/28 04:02:29 woostachris Exp $
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
* On this page you may edit and view your user details, and view your bids and items on auction.
*/ 

require_once '../include.php';
$main_content = new Template('user_edit');
$sidebar = new Template('user_sidebar');
$main_content->set('sidebar', $sidebar->fetch());

$message = "";
if(isset($_GET['mode'])&& $_GET['mode'] == 'add_exclusion'){
	$data = get_object_vars(Auction::getItem($_GET['itemID']));
	$data['data']['match_type_id'] = 2;
	$data['data']['mileage'] = 0;
	if(isset($_GET['do_not_want']) && $_GET['do_not_want']=='make'){
		$data['data']['model_id'] = 0;
	}
	User::addPref($data['data']);
}

// If the user is trying to update her/his details, handle the form data
if(isset($_POST['formdata']) && $_POST['formdata'] == 'update'){
    $result = true;
    
    if($result === true){
        
		$result2 = User::updateUser($_POST);
		
		if($result2){
			foreach($result2 as $k => $v){
				$_SESSION['auction']->user->$k = $v; 
			}
			header('location: /user/editaccount.php?edit=details');
        }else{
            $message = 'AUCTION_USER_UPDATE_FAILURE' . $result2['message'];
            $error_field = $result2['field'];
        }
    }else{
        $message = 'AUCTION_USER_UPDATE_FAILURE' . $result['message'];
        $error_field = $result['field'];
    }    
} elseif(isset($_POST['formdata']) && $_POST['formdata'] == 'notify_preference'){
	$ne = 1;
	$ne = 2;
	foreach($_POST['not'] as $k=>$v){
		Message::setMessagePreference($k, $v);
	}
}


if(isset($error_field)){
    $main_content->set('error_field', $error_field);
}

if($_GET['edit']=='match'){
	
	$matches_interface = new Template('matches_interface');	
	//getLookupTable($table, $id, $value, $order = false, $active = false, $blank = false, $use_cache = true, $force_cache = false, $where = false)
	$main_content->set('all_regions', Auction::getRegions());
	$main_content->set('states', Site::getLookupTable('states', 'id', 'state', 'id', true, false, false));
	$main_content->set('matches_interface', $matches_interface->fetch());

}



$main_content->set('message', $message);
$main_content->set('user', get_object_vars($_SESSION['auction']->user));
$main_content->set('notification_options', Message::getPreferenceOptions());
$main_content->set('user_notification', Message::getAllUserPreferences());
$main_content->set('match_prefs', User::getPrefs());

$template->set('content', $main_content->fetch());
echo $template->fetch();


?>