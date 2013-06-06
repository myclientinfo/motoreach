<?php 
require_once '../../include.php';
require_once '../../classes/class.extend_user.php';
require_once '../../classes/class.reporting.php';
require_once '../../classes/class.phpmailer.php';

if(!User::hasPermission('Admin')){
	header('location: /index.php');
	die();
}

if(!isset($_GET['ob'])) $_GET['ob'] = 'dealership_name';
if(!isset($_GET['od'])) $_GET['od'] = 'ASC';

$r = new Reporting();

$headers['vehicles_period'] = 'Vehicles Listed';
$headers['requests_period'] = 'Vehicle Details Requested';

$main_content = new Template('email_daily_stats');

if(!isset($_GET['time'])){
	$from = mktime(9, 0, 0, date('n'), date('j')-2, date('Y'));
	$to = time();
}

$main_content->set('vehicles', $r->getPublicListedVehicles(false, false, $from, $to));
$main_content->set('dealer_vehicles', $r->getPublicListedVehicles(false, false, $from, $to, false));
$main_content->set('headers', $headers);
$main_content->set('to', $to);
$main_content->set('from', $from);

$html_content = $main_content->fetch();

$mail = new PHPMailer(true); //New instance, with exceptions enabled
//$mail->IsMail();  // tell the class to use Sendmail
$mail->AddReplyTo("noreply@motoreach.com", "MotoReach");
$mail->From       = "noreply@motoreach.com";
$mail->FromName   = "MotoReach";
$mail->AddAddress('matt@motoreach.com', 'Matt Burgess');
$mail->AddAddress('chris@motoreach.com', 'Chris Kirk');
$mail->Subject  = 'Reporting from'. date('d M - h:i ', $from) . ' - ' . date('d M - h:i ', $to);
$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
$mail->WordWrap   = 80; // set word wrap

$mail->MsgHTML($html_content);

$mail->IsHTML(true); // send as HTML
$mail->send();

//@mail('matt@motoreach.com', , $html_content);
die($html_content);

$template->set('content', $html_content);
echo $template->fetch();

?>