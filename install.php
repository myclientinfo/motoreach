<?php

/**
 * Installation script for auction framework
 * 1. Set up the DSN
 * 2. Create database or use existing one
 * 3. Create tables
 * 4. Initialise auction settings and company info
 * 5. Create admin account
 * 6. Create test items, users and bids (optional)
 *
 * @version $Id: install.php,v 1.1 2005/06/28 02:44:36 nicolasconnault Exp $
 * @copyright 2005 
 **/

error_reporting(E_ALL);
// ini_set("display_errors", "0"); # do not echo any errors
// Set locale
setlocale (LC_ALL, 'en_US');

define('SMARTY_DIR', realpath('libs/Smarty-2.6.6/libs') . '/');
define('ADODB_DIR', realpath('libs/adodb/') . '/');
define('CSS_DIR', 'css/');
define('TEMPLATE_DIR', realpath('templates/') . '/');
define('COMPILE_DIR', realpath('templates_c/') . '/');
define('CONFIG_DIR', realpath('configs/') . '/');
define('CACHE_DIR', realpath('cache/') . '/');

require (SMARTY_DIR . 'Smarty.class.php');
$smarty = new Smarty;
$smarty->template_dir = TEMPLATE_DIR;
$smarty->compile_dir = COMPILE_DIR;
$smarty->config_dir = CONFIG_DIR;
$smarty->cache_dir = CACHE_DIR;
$smarty->debugging = false;
$smarty->debugging_ctrl = 'URL';
$smarty->caching = 0;
$smarty->assign('CSSDIR', CSS_DIR);

session_start();


$smarty->display("auction_install.tpl");
?>