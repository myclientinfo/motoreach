<?php
/**
* 
* @package auction
* 
* These classes are a complete auction framework, ready to implement using a minimum amount of procedural PHP code, 
* and a templating system like Smarty. The database abstraction layer AdoDB is used.
* @version $Id: categories.php,v 1.5 2005/07/28 04:02:29 woostachris Exp $
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

/**
* categories.php
* 
* This page shows all the item on auction in the requested category
* 
* @version $Id: categories.php,v 1.5 2005/07/28 04:02:29 woostachris Exp $
* @copyright 2005
*/ 
// This lets include.php know which file is calling it
$calling = "categories.php";

require_once('include.php');

$get = $_GET;
$categoryID = $get['categoryID'];

$items = $auction->getItems($categoryID); // Will return an error if no items in the category
$users = $auction->getUsers();
$numberOfItems = count($items);
$category = new Category(array("ID" => $categoryID));

// print_a($items);

// If there are no items in the category, Auction::getItems() will return a string error.
// If the $items variable is an array, it's full of bids.
if (is_array($items)) {
    $smarty->assign("items", $items);
} else {
    $smarty->assign("items_error", $items);

    // Handle the situation where $items returns an error and count($items) counts the error string as 1
    $numberOfItems = 0;
}
$smarty->assign("category", $category);
$smarty->assign("numberOfItems", $numberOfItems);
$smarty->assign("users", $users);
$smarty->display("auction_categories.tpl");

?>