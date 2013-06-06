<?php
/**
* 
* @package auction
* 
* These classes are a complete auction framework, ready to implement using a minimum amount of procedural PHP code, 
* and a templating system like Smarty. The database abstraction layer AdoDB is used.
* @version $Id: searchresults.php,v 1.1.1.1 2005/03/01 23:58:28 nicolasconnault Exp $
* @copyright 2005
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
// This lets include.php know which file is calling it
$calling = "searchresults.php";

require_once('include.php');

session_start();

$search_text = ($_POST['search']);
$search = new Search();
$items_array = $search->findItems($search_text);

// Searches without results are not working correctly right now.  Should be getting error from class_search.php
if ($items_array == AUCTION_SEARCH_NO_MATCHES) {
	$smarty->assign("results", AUCTION_SEARCH_NO_MATCHES);
} else {
	//$smarty->assign("results", $items_array[0]);
	$smarty->assign("results", $items_array);
}

$smarty->assign("searchitem", $search_text);
$smarty->display("auction_search.tpl");
?>