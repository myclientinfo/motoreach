<?php 
//echo time() +  518400;

require_once '../../include.php';
require_once '../../classes/class.extend_user.php';
require_once '../../classes/class.reporting.php';

if(!User::hasPermission('Admin')){
	header('location: /index.php');
	die();
}

$user_id = isset($_GET['id'])?$_GET['id']:false;

$content = new Extend_User($user_id, false, true, 'auction_users');
//$GLOBALS['debug']->printr($content->data);
if(!isset($_GET['ob'])) $_GET['ob'] = 'dealership_name';
if(!isset($_GET['od'])) $_GET['od'] = 'ASC';

$r = new Reporting();

$headers['vehicles_period'] = 'Vehicles Listed';
$headers['requests_period'] = 'Vehicle Details Requested';

$main_content = new Template('admin_reporting_activity');

if(isset($_GET['from_date'])) $from = strtotime($_GET['from_date']);
else $from = mktime(0, 0, 0, date('n'), 1, date('Y'));

if(isset($_GET['to_date'])){
	$to = strtotime($_GET['to_date']);
	$to = mktime(23, 59, 59, date('n', $to), date('j', $to), date('Y', $to));
} else $to = false;



if($user_id){
	$vehicles = $r->getDealerVehicles($user_id, $from, $to);
	
} else $vehicles = $r->getStats($from, $to);



$main_content->set('vehicles', $vehicles);
$main_content->set('headers', $headers);
$main_content->set('to', $to);
$main_content->set('from', $from);



$template->set('content', $main_content->fetch());
echo $template->fetch();

?>