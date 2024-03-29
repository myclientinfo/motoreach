<?php
/**
 * 
 * @package auction
 * 
 * These classes are a complete auction framework, ready to implement using a minimum amount of procedural PHP code, 
 * and a templating system like Smarty. The database abstraction layer AdoDB is used.
 * @version $Id: items.php,v 1.12 2005/07/28 04:29:33 woostachris Exp $
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
 * @version $Id: items.php,v 1.12 2005/07/28 04:29:33 woostachris Exp $
 * @copyright 2005
 */ 
require_once 'include.php';
//$GLOBALS['debug']->printr($_SESSION);
if(empty($_SESSION)) header('location:/index.php');
$main_content = new Template('items');

$itemID = (int)$_GET['itemID'];

$item = Auction::getItem($itemID);

		
// If the returned item is not an object, an error occurred in the query
if (is_object($item)) {
    if ($item->processed == "yes") {
        $message = AUCTION_ITEM_EXPIRED;

        // Return a bid object if there was a winning bid, or the constant AUCTION_NO_BID_FOUND if not
        $winning_bid = $item->getWinningBid();
        if ($winning_bid != AUCTION_NO_BID_FOUND) {
            $winning_user = $auction->getUserObject($winning_bid->userID);
            $winning_user->getID();
            $main_content->set("winning_user", $winning_user);
        } else {
            // Assign the constant to the $no_winner variable
            $main_content->set("no_winner", $winning_bid);
        }
    } else {
        if (isset($_SESSION['authorised'])) {
            if ($_SESSION['authorised'] == "valid") {
                //$itemokay = $item->checkUser($user->ID);
                //$item->setWinning($user->ID);
            }
        } 
    }
    $category = new Category(array("ID" => $item->categoryID));
    $seller = $item->getSeller();
    $seller->getID(); //Added the user's ID to the seller object


    // Since the $item exists and is an object, set it for the template page here.
    $main_content->set("item", $item);
    $main_content->set("seller", $seller);
    $main_content->set("itemokay", true);
    
	$history = Auction::getHistory($itemID);
	$history_tpl = new Template('history');
	$history_tpl->set('content', $history);
	$main_content->set('history', $history);
	$main_content->set('history_block', $history_tpl->fetch());
	
    
} else {
    $message = $item;
    $main_content->set("itemokay", false);
}

$main_content->set('authorised', 'valid');
$main_content->set('category', @$category);
$main_content->set('message', @$message);
$main_content->set("auction", $auction);

$template->set('content', $main_content->fetch());
if(User::getSD('ID') == $item->userID){
	$template->set('is_owner', true);
	$template->set("item", $item);
}
echo $template->fetch();

?>