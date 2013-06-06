<?php

require_once '../include.php';
//$GLOBALS['debug']->printr($_POST);
if($_SESSION['authorised'] == "valid"){
    $data = $auction->refreshBids($_REQUEST['itemID'], 10);
	if(empty($data)) die();
	//$GLOBALS['debug']->printr($data);
	
	$tpl = new Template('history_line');
	$tpl->set('content', $data);

	$return['data'] = $data[0];
	$return['html'] = $tpl->fetch();
	
	echo json_encode($return);
}

?>