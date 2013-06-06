<?php 
require_once '../include.php';
require_once '../classes/class.tasks.php';

if(!User::hasPermission('Admin')){
	header('location: /');
	die();
}
$content = new Task(false, true, true);
unset($content->data_listing['total']);

$GLOBALS['debug']->printr($content);

$gf = new Template('generic_form');
$gf->set('list', true);
$gf->set('type', false);

$gf->set('content', $content->data_listing);
$gf->set('table_fields', $content->table_fields);
$gf->set('table_field_mapping', $content->table_field_mapping);
$gf->set('list_header', $content->list_header);
$gf->set('no_nav', true);
$gf->set('no_container', true);
$gf->set('no_pages', true);

$main_content = new Template('admin_tasks');
$main_content->set('gf', $gf->fetch());

$template->set('content', $main_content->fetch());
echo $template->fetch();

?>