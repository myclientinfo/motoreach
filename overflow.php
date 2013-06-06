<?php
include_once 'include.php';

$file_requested = $_GET['file'];
$file_title = ucwords(str_replace('_', ' ', $file_requested));

if(!file_exists($_SERVER['DOCUMENT_ROOT'].'/templates/'.$file_requested.'.tpl.php')){
	header("HTTP/1.0 404 Not Found");
	die();
}

if(substr($file_requested, 0, 5) == 'admin'||substr($file_requested, 0, 4) == 'user'){
	header("HTTP/1.0 404 Not Found");
	die();
}

$main_content = new Template($file_requested);
$main_content->set('title', $file_title);
$template->set('content', $main_content->fetch());

echo $template->fetch();
?>