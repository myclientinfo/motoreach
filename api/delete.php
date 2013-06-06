<?php
$_GET['id'] = (int)@$_GET['id'];
if(!isset($_GET['type']) || $_GET['id'] == 0) {
	header("HTTP/1.0 404 Not Found") ;
	die();
}

require_once '../include.php';
require_once '../classes/class.extend_auction.php';
require_once '../classes/class.extend_user.php';


if(User::hasPermission('Admin')){
	if ($_GET['type'] == 'user') {
		if(Extend_User::deleteUser($_GET['id'])){
			die('SUCCESS');
		}
	} else if ($_GET['type'] == 'item') {
		if(Extend_Auction::deleteAuction($_GET['id'])){
			die('SUCCESS');
		}
	}
}

?>
FAILED