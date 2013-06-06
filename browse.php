<?php

require_once 'include.php';

if(!User::hasPermission('Login')){
	header('location:/index.php');
	die();
}

if(isset($_GET['warnings'])){
	echo '<pre>before';
	print_r($_SERVER);
}
if(!User::hasPermission('Browse')){
	header('location:/user/index.php');
	die();
}


if(isset($_GET['warnings'])){
	echo 'after';
}
$main_content = new Template('browse');
$listing = new Template('listing');


$items_array = Auction::getAllItems();

$main_content->set('content', $items_array);

$template->set('content', $main_content->fetch());

$listing->set('content', $items_array);
$main_content->set('sold', $listing->fetch());

echo $template->fetch();

?>