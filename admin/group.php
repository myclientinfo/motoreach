<?php 
require_once '../include.php';
require_once '../classes/class.group.php';

if(!User::hasPermission('Admin')){
	header('location: /index.php');
	die();
}

$id = isset($_REQUEST['id'])? (int)$_REQUEST['id'] : false;
$list = $id!==false ? false : true;

if(!isset($_GET['ob'])) $_GET['ob'] = 'group_name';
if(!isset($_GET['od'])) $_GET['od'] = 'ASC';

$content = new Group($id, $list);

if(!empty($_POST)){
    $id = $content->save();
	Site::deleteCache();
    $content = new Group($id, $list);
    if($_POST['id']=='0'||$_POST['id']=='') header('location: '.basename($_SERVER['PHP_SELF']).'?id='.$id);
}

$main_content = new Template('generic_form');

$main_content->set('list', $list);
$main_content->set('type', 'Group');
$main_content->set('content', $list ? $content->data_listing : $content->data);
$main_content->set('table_fields', $content->table_fields);
$main_content->set('table_field_mapping', $content->table_field_mapping);

if($list){
	$main_content->set('list_header', $content->list_header);
} 

$template->set('content', $main_content->fetch());
echo $template->fetch();

?>