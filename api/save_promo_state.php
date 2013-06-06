<?php

require_once '../include.php';
if($_SESSION['authorised'] == "valid"){
	
	//$GLOBALS['debug']->printr($_POST);
	
	User::setOrangeBox((int)$_POST['action']);
	
}
?>