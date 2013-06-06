<?php 
require_once '../../include.php';
require_once '../../classes/class.extend_user.php';
require_once '../../classes/class.reporting.php';

if(!User::hasPermission('Admin')){
	header('location: /index.php');
	die();
}

$main_content = new Template('admin_reporting_index');

$template->set('content', $main_content->fetch());
echo $template->fetch();

?>