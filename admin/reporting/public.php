<?php 
require_once '../../include.php';
require_once '../../classes/class.extend_user.php';
require_once '../../classes/class.reporting.php';

if(!User::hasPermission('Admin')){
	header('location: /index.php');
	die();
}

if(!isset($_GET['ob'])) $_GET['ob'] = 'dealership_name';
if(!isset($_GET['od'])) $_GET['od'] = 'ASC';

$r = new Reporting();

$headers['vehicles_period'] = 'Vehicles Listed';
$headers['requests_period'] = 'Vehicle Details Requested';

$main_content = new Template('admin_reporting_public');

if(isset($_GET['from_date'])) $from = strtotime($_GET['from_date']);
else $from = mktime(0, 0, 0, date('n'), 1, date('Y'));

if(isset($_GET['to_date'])){
	$to = strtotime($_GET['to_date']);
	$to = mktime(23, 59, 59, date('n', $to), date('j', $to), date('Y', $to));
} else $to = false;

$main_content->set('vehicles', $r->getPublicListedVehicles(false, false, $from, $to, true));
$main_content->set('headers', $headers);
$main_content->set('to', $to);
$main_content->set('from', $from);

$template->set('content', $main_content->fetch());
echo $template->fetch();

?>