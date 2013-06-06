<?php
/**
* 
* @package auction
* 
* These classes are a complete auction framework, ready to implement using a minimum amount of procedural PHP code, 
* and a templating system like Smarty. The database abstraction layer AdoDB is used.
* @version $Id: seller.php,v 1.3 2005/06/15 07:57:47 nicolasconnault Exp $
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
* items.php
* 
* This page shows all the item on auction in the requested category
* 
* @version $Id: seller.php,v 1.3 2005/06/15 07:57:47 nicolasconnault Exp $
* @copyright 2005
*/ 
// This lets include.php know which file is calling it
$calling = "seller.php";

require_once('include.php');

$get = $_GET;
$userID = $get['userID'];

$category = new category(array("ID" => $get['categoryID']));
$item = $auction->getItem($get['itemID']);

$seller = $auction->getUserObject($userID);

$seller->getID(); //Added the user's ID to the user object
$smarty->assign("message", $message);

$smarty->assign("category", $category);
$smarty->assign("item", $item);
$smarty->assign("seller", $seller);
$smarty->assign("auction", $auction);
$smarty->display("auction_seller.tpl");

?>