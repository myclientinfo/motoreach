<?php

require_once 'include.php';
require_once 'classes/class.extend_user.php';
require_once 'classes/class.vehicle_details.php';
require_once 'classes/class.extend_auction.php';
require_once 'classes/class.extend_user.php';


if(isset($_POST['formdata']) && $_POST['formdata'] != 'miniform'){
	
	
	
	$user = new Extend_User(false, false, true, 'auction_users');
	$_POST['signup_time'] = date('Y-m-d H:i:s');
	$_POST['statusID'] = 6;
	$_POST['location_id'] = User::getRegion($_POST['zip']);
	
	if($_POST['description'] == 'optional') $_POST['description'] = '';
	
	$user_id = $user->save();
	$user = new Extend_User($user_id, false, true, 'auction_users');
	User::addCampaignMonitorSubscriber($user->data);
	
	$_POST['userID'] = $user_id;
	$_POST['id'] = $user_id;
	
	$content = new VehicleDetails(false, false, true, 'vehicle_details');
	
	$id = $content->save();	
	
	$content = new VehicleDetails($id, false, true, 'vehicle_details');
	
	$desc = $content->data['year'].' '.$content->data['make'].' '.$content->data['model'].' '.@$content->data['badge'];
	$return_page = 'http://'.$_SERVER['HTTP_HOST'].'/confirm_sale.php';
	
	header('location: confirm_sale.php?auction_id='.$id);
	die();
	//$processor = $_SESSION['l10n']['processor'];
	/*
	if ($_SERVER['HTTP_HOST']=='motopublic'){
		$processor = 'paypal';
	} else {
		$processor = 'anz';
	}
	if($processor == 'anz')	{
		$credit_string = Credit::createCCString($_SESSION['l10n']['rate_public_list'], $id, $return_page, $desc);
		header('location:'.$credit_string);
	} elseif($processor == 'paypal') {
		 //CallShortcutExpressCheckout( $paymentAmount, $currencyCodeType, $paymentType, $returnURL, $cancelURL, $payerID) {
		$resArray = Credit::CallShortcutExpressCheckout($_SESSION['l10n']['rate_public_list'], $_SESSION['l10n']['currency'], 'sale', $return_page, $return_page.'&failure', $id.'-'.$user_id); 
		$ack = strtoupper($resArray["ACK"]);
		
		if($ack=="SUCCESS" || $ack=="SUCCESSWITHWARNING"){
			Credit::RedirectToPayPal ( $resArray["TOKEN"], $id );
		} else {
			header('location:/confirm_sale.php?auction_id='.$id.'&failure');
		}

	}
	
	*/
	
	
	die();
}


$main_content = new Template('register');
$miniform = new Template('basicvehicle');

$main_content->set('miniform', $miniform->fetch());
$template->set('content', $main_content->fetch());
echo $template->fetch();

?>