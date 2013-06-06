<?php

require_once '../include.php';

$main_content = new Template('user_credit_add');
$sidebar = new Template('user_sidebar');
$main_content->set('sidebar', $sidebar->fetch());

//$credit_array = array();
//$credit_array['user_id'] = User::isLoggedIn();

if(!empty($_POST)){
	
	$credit_array = array();
	$credit_array['user_id'] = User::isLoggedIn();
	$credit_array['type_id'] = 1;
	$credit_array['amount'] = $_POST['amount'];
	
	$credit = new Credit();
	$credit_id = $credit->createTransaction($credit_array);
	
	$_POST['vpc_MerchTxnRef'] = $credit_id;
	$_POST['vpc_OrderInfo'] = $credit_id.'-'.User::isLoggedIn(); 
	$_POST['vpc_Amount'] = $_POST['amount'] * 100;
	$_POST['vpc_Version'] = '1';
	$_POST['vpc_Locale'] = 'en';
	$_POST['vpc_Command'] = 'pay';
	$_POST['vpc_AccessCode'] = '87FD53B8';
	$_POST['vpc_Merchant'] = 'TESTANZVISIONNET';
	$_POST['vpc_ReturnURL'] = 'http://www.motoreachbeta.com/user/credit_confirm.php';
	
	$SECURE_SECRET = "283E57719EB4F712F9603742FD711EDC";
	$vpcURL = 'https://migs.mastercard.com.au/vpcpay?';
	unset($_POST['SubButL'], $_POST['user_id'], $_POST['first_name'], $_POST['last_name'], $_POST['email'], $_POST['personal_country_id'],  
				$_POST['personal_state_id'], $_POST['personal_address_1'], $_POST['order_details'], $_POST['personal_postcode'], 
					$_POST['period_id'], $_POST['state'], $_POST['submit_credit'], $_POST['AgainLink'], $_POST['amount']);
	
	$md5HashData = $SECURE_SECRET;
	ksort($_POST); 
	$appendAmp = 0;
	echo $md5HashData.'<br>';
	
	foreach($_POST as $key => $value) {
	    if (strlen($value) > 0) {
	        
	        if ($appendAmp == 0) {
	            $vpcURL .= urlencode($key) . '=' . urlencode($value);
	            $appendAmp = 1;
	        } else {
	            $vpcURL .= '&' . urlencode($key) . "=" . urlencode($value);
	        }
	        echo $key.' - '.$value.'<br>';
	        $md5HashData .= $value;
	        
	    }
	}
	
	if (strlen($SECURE_SECRET) > 0) {
	    $vpcURL .= "&vpc_SecureHash=" . strtoupper(md5($md5HashData));
	}
	
	header("Location: ".$vpcURL);
	die();
}
function insensitive_uksort($a,$b) {
    return strtolower($a)>strtolower($b);
}

$template->set('content', $main_content->fetch());
echo $template->fetch();
?>