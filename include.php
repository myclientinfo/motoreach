<?php

/**
 * 
 * @package auction
 * @access private 
 */

/**
 * Copyright (C) 2005 Vickie Comrie, Nicolas Connault, Christopher Vance
 * 
 * Vickie Comrie: <vrcomrie@myway.com>
 * Nicolas Connault: <nicou@sweetpeadesigns.com.au>
 * Christopher Vance: <christopher.vance@gmail.com>
 * 
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License

* along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 */
 
 if($_SERVER['HTTP_HOST']=='motoreach'||$_SERVER['HTTP_HOST']=='motopublic'||isset($_GET['warnings'])){
	error_reporting(E_ALL);
} else {
	error_reporting(0);
}

// ini_set("display_errors", "0"); # do not echo any errors
// Set locale
setlocale (LC_ALL, 'en_US');



//echo $_SERVER['HTTP_HOST'];
$GLOBALS['project'] = (in_array($_SERVER['HTTP_HOST'], array('motoreach', 'www.motoreach.com', 'motoreach.com'))?'motoreach':'public');

define('ONLINE_PATH', 'http://www.motoreach.com/');

//define('SMARTY_DIR', realpath('libs/Smarty-2.6.6/libs') . '/');
define('ADODB_DIR', $_SERVER['DOCUMENT_ROOT'].'/libs/adodb/');
define('CSS_DIR', 'css/');
define('TEMPLATE_DIR', realpath('templates/') . '/');
define('COMPILE_DIR', realpath('templates_c/') . '/');
define('CONFIG_DIR', realpath('configs/') . '/');
define('CACHE_DIR', realpath('cache/') . '/');

define('DATE_TIME', 'd M @ g:ia');

//prices for specific types of actions
// prices are all in CENTS to avoid decimals and simplify mathematics.
define('PRICE_LIST', 500);
define('PRICE_EXTEND', 500);
define('PRICE_NOTIFY_5', 125);
define('PRICE_NOTIFY_10', 250);
define('PRICE_PUBLIC_LIST', 95);
define('PRICE_SMS', 25);
define('SALT', 'Auto2m');

require_once 'classes/class.template.php';
require_once 'classes/class.site.php';
require_once 'classes/class.debug.php';
require (ADODB_DIR . 'adodb.inc.php');
require (ADODB_DIR . 'adodb-errorhandler.inc.php');
require (ADODB_DIR . 'tohtml.inc.php');
require (ADODB_DIR . 'toexport.inc.php');
require ('libs/function_arrayStripSlashes.php');


if( get_magic_quotes_gpc() ){
    stripslashes_deep($_GET);
    stripslashes_deep($_POST);
    stripslashes_deep($_COOKIE);
}



$GLOBALS['debug'] = new Debug(false);



define('ADODB_ERROR_LOG_TYPE', 3);
define('ADODB_ERROR_LOG_DEST', $_SERVER['DOCUMENT_ROOT'].'/logs/error.log');

if ($_SERVER['HTTP_HOST']=='motopublic'||$_SERVER['HTTP_HOST']=='motoreach') {
	define('MYSQL_USER', 'motoreach');
	define('MYSQL_PASS', 'motoreach');
	define('MYSQL_DB', 'motoreach');
	$GLOBALS['debug']->debugStatus(true);
} else {
	define('MYSQL_USER', 'mtreach_moto');
	define('MYSQL_PASS', 'm0t0r34ch');
	define('MYSQL_DB', 'mtreach_moto');
	$GLOBALS['debug']->debugStatus(false);
}

//define('MYSQL_DB', 'mtreach_moto');
define('DSN', 'mysql://'.MYSQL_USER.':'.MYSQL_PASS.'@localhost/'.MYSQL_DB);


// Set up AdoDB
$myDB = ADONewConnection(DSN);


$myDB->debug = false;
$GLOBALS['db'] = &$myDB;


// Application-specific includes:
require_once "classes/class_auction.php";
require_once "classes/class_bid.php";
require_once "classes/class_category.php";
require_once "classes/class_item.php";
require_once "classes/class_mailman.php";
require_once "classes/class_search.php";
require_once "classes/class_user.php";
require_once "classes/class.credit.php";
require_once "classes/class.message.php";
require_once "classes/class_validate.php";
require_once "libs/debuglib.phps";

$GLOBALS['messages'] = Auction::getMessages();

$validate = new Validate();

session_start();

//$GLOBALS['country'] = User::getCountry();

Auction::loadLocation();

if($_SESSION['l10n']['country_code']=='IE') date_default_timezone_set('Europe/Dublin');
else date_default_timezone_set('Australia/Brisbane');


//echo date('Y-m-d H:i:s', time());

//die('Test Thing');
$auction = new Auction();
$user = User::checkLogin();

$GLOBALS['make_models'] = Site::getMakeModel();
$GLOBALS['model_badges'] = Site::getModelBadge();
$GLOBALS['model_series'] = Site::getModelSeries();
$ADODB_COUNTRECS = true;

$auction->user = $user;

if(!isset($_SESSION['authorised']) || $_SESSION['authorised'] != "valid"){
	$protected = Site::isProtected();
	if($protected){
		header('location: /login.php?loc='.$protected);
		die();
	}
}

foreach ($auction->auction_settings as $setting => $value) {
   define ($setting, $value);
}

$template = new Template('index');
$tpl_menu = new Template('menu');
$template->set('menu', $tpl_menu->fetch());


?>