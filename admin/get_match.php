<?php

require_once '../include.php';

if(!User::hasPermission('Admin')){
	header('location: /index.php');
	die();
}

$main_content = new Template('admin_match');

$data = Auction::getItem($_GET['itemID']);

$main_content->set('data', $data);
$main_content->set('matches', Auction::getVehicleMatches($data, 1, 1));
$main_content->set('log', Message::getMatchLog($_GET['itemID']));
$main_content->set('main_user', User::getCurrentUser($data->data['userID']));
$main_content->set('main_user_permissions', User::loadUserPermissions($data->data['userID']));

$template->set('content', $main_content->fetch());
echo $template->fetch();


?>
