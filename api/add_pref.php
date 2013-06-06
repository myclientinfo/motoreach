<?php

require_once '../include.php';
if($_SESSION['authorised'] == "valid"){
	
	if(!isset($_POST['delete'])){
		echo User::addPref(false, $_POST['user_id']);
	} else {
		User::deletePref((int)$_POST['delete']);
	}
	
}
?>