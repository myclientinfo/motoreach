<?php
/**
* 
* @package auction
* 
* These classes are a complete auction framework, ready to implement using a minimum amount of procedural PHP code, 
* and a templating system like Smarty. The database abstraction layer AdoDB is used.
* @version $Id: register.php,v 1.3 2005/07/28 04:02:29 woostachris Exp $
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
* The user uses this page to register as a new user on this site
*/

require_once 'include.php';
require_once 'classes/class.extend_user.php';
$main_content = new Template('register');
$message = "";

// If form data has been sent, validate it before entering new user in database

if(isset($_POST['formdata']) && $_POST['formdata']=='register'){

	if(trim($_POST['rep_number'])=='Office use only - leave blank if unknown' || trim($_POST['rep_number'])=='Office use only'){
		$_POST['rep_number'] = '';
	}
    $user = new User($_POST);
    $validate = new Validate();
    //$_SESSION = $_POST;
    $result = $validate->checkForm($_POST);
	
	if($_POST['password'] == '' || $_POST['confirmpassword'] == '' || $_POST['fullname'] == '' || $_POST['email'] == '' ) $result = false;
	
	if($GLOBALS['project'] == 'public') $result = true;
	
    if($result === true){
		
		$user_save = $user->recordUser();
		
		
		mail('evelyn.curry@motoreach.com, matt@motoreach.com', 'New dealer on motoreach.com', 'New dealer on motoreach: http://www.motoreach.com/admin/users.php?ID='.$user_save);
		
        if(!strstr($user_save, 'RROR:')){
            $_SESSION['authorised'] = "valid";
            $auction->addUser($user);
            $_SESSION['auction'] = $auction;
            $user->setCookie($user);
			
			$user = new Extend_User($user_save, false, true, 'auction_users');
			User::addCampaignMonitorSubscriber($user->data);
			
			if($GLOBALS['project'] == 'public'){ 
				header('location: /vehicle.php');
			} else {
				$message = new Message();
				$message_data = $message->getMessageData(12, User::getSimpleUser() );
				$message->sendMessage('', $message_data);
				header('location: /user/welcome.php');
			}
			
			die();
        }else{
            $_SESSION['authorised'] = "invalid";
            //$message = AUCTION_DUPLICATE_ALIAS;
			
			if(strstr($user_save, 'Duplicate')){
			
				$fail_field = str_replace(array("'", 'key '), '', strstr($user_save, 'key '));
				$main_content->set('message', 'This '.$fail_field.' is already in use.');
				$main_content->set('fail_fields', array($fail_field));
			}
			
			
			
        }
        
        
    }else{
		$_SESSION['authorised'] = "invalid";
        //$message = AUCTION_USER_REGISTER_FAILURE . $result['message'];
        $error_field = $result['field'];
        $main_content->set('error_field', $result['field']);
        $main_content->set('message', $result['message']);
    }
} else if(isset($_POST['formdata']) && $_POST['formdata'] == 'miniform') {
	$_SESSION['step']['miniform'] = $_POST;
	
}




//$main_content = new Template('register');
$miniform = new Template('basicvehicle');

$main_content->set('miniform', $miniform->fetch());
$template->set('content', $main_content->fetch());
echo $template->fetch();

?>