<?php



require_once '../include.php';


$main_content = new Template('user_credit_confirm');
$sidebar = new Template('user_sidebar');
$main_content->set('sidebar', $sidebar->fetch());



if(!empty($_GET)){
	
	
	$result = false;
	switch($_GET['vpc_TxnResponseCode']){
		case 0: $result = true; $message = 'Transaction Approved'; $status_id = 9; break;
		case 1: $message = 'Transaction could not be processed';$status_id = $_GET['vpc_TxnResponseCode']; break;
		case 'E': $message = 'Transaction Declined'; $status_id = 6; break;
		case 2: $message = 'Transaction Declined';$status_id = $_GET['vpc_TxnResponseCode']; break;
		case 3: $message = 'No reply from Processor';$status_id = $_GET['vpc_TxnResponseCode']; break;
		case 4: $message = 'Card Expired';$status_id = $_GET['vpc_TxnResponseCode']; break;
		case 5: $message = 'Insufficient Credit'; $status_id = $_GET['vpc_TxnResponseCode']; break;
	}

	
	$credit = new Credit();
	$id = $_GET['vpc_MerchTxnRef'];

	$credit->updateTransaction($id, array('gateway_response' => $status_id));
	
	if ($result) {
		list($credit_id, $user_id) = explode('-', $_GET['vpc_OrderInfo']);
		
		$credit->approveTransaction($id);
		$credit->addUserBalance($user_id, $_GET['vpc_Amount']);
	}
	
	
} else {
	$message = 'No order was placed';
}


$template->set('content', $main_content->fetch());
echo $template->fetch();
?>