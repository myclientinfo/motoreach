<?php

if(!isset($_GET['auth_by_matt'])) die();

include_once '../include.php';
include_once '../classes/class.site.php';

//print_r($GLOBALS);
Site::mysqlConnect();
//die();
$queries = array();
//batch one -> server only


$queries[] = "ALTER TABLE `states`  ADD COLUMN `state_short` VARCHAR(5) NULL AFTER `state`;";
$queries[] = "UPDATE `states` SET `state_short` = 'NSW' WHERE `states`.`id` =2;";
$queries[] = "UPDATE `states` SET `state_short` = 'VIC' WHERE `states`.`id` =3;";
$queries[] = "UPDATE `states` SET `state_short` = 'QLD' WHERE `states`.`id` =4;";
$queries[] = "UPDATE `states` SET `state_short` = 'SA' WHERE `states`.`id` =5;";
$queries[] = "UPDATE `states` SET `state_short` = 'WA' WHERE `states`.`id` =6;";
$queries[] = "UPDATE `states` SET `state_short` = 'TAS' WHERE `states`.`id` =7;";
$queries[] = "UPDATE `states` SET `state_short` = 'NT' WHERE `states`.`id` =8;";
$queries[] = "UPDATE `states` SET `state_short` = 'NT' WHERE `states`.`id` =9;";

/*
$queries[] = "ALTER TABLE `auction_users`  ADD COLUMN `location_pref` TINYINT(1) NOT NULL DEFAULT '0' AFTER `longitude`;";
$queries[] = "ALTER TABLE `auction_users`  ADD COLUMN `ob_hidden` TINYINT(1) NOT NULL DEFAULT '0' AFTER `location_pref`,  ADD COLUMN `approved` TINYINT(1) NOT NULL DEFAULT '0' AFTER `ob_hidden`;";
$queries[] = "ALTER TABLE `auction_users`  ADD COLUMN `location_id` TINYINT(1) NOT NULL AFTER `location_pref`;";

// batch two -> laptop and server
$queries[] = "ALTER TABLE `states`  CHANGE COLUMN `state` `state` VARCHAR(50) NULL DEFAULT '0' AFTER `id`;";
$queries[] = "ALTER TABLE `states`  ADD COLUMN `active` TINYINT(1) NOT NULL DEFAULT '1' AFTER `state`;";
$queries[] = "INSERT INTO `states` (`state`, active) VALUES ('NULL',0), ('New South Wales', 1), ('Victoria', 1), ('Queensland', 1), ('South Australia', 1), ('Western Australia', 1), ('Tasmania', 1), ('Northern Territory', 1), ('Northern Territory', 0);";
$queries[] = "ALTER TABLE `notification_item`  ADD COLUMN `active` TINYINT(1) NOT NULL DEFAULT '1' AFTER `item_name`;";
*/
foreach($queries as $query){
	$result = mysql_query($query);
	if(!$result) echo mysql_error();
	else echo $query."<br>";
}

?>