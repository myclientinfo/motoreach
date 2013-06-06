<?php

/**

* 

* @package auction

* 

* These classes are a complete auction framework, ready to implement using a minimum amount of procedural PHP code, 

* and a templating system like Smarty. The database abstraction layer AdoDB is used.

* @version $Id: editaccount.php,v 1.2 2005/07/28 04:02:29 woostachris Exp $

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
* On this page you may edit and view your user details, and view your bids and items on auction.
*/ 
require_once '../include.php';

$main_content = new Template('user_bids');
$sidebar = new Template('user_sidebar');
$main_content->set('sidebar', $sidebar->fetch());


if (isset($_SESSION['authorised'])) {
    if($_SESSION['authorised'] == "valid"){ 
        
    }
} else {
	header('location: /login.php');
}

$listing = new Template('listing');
$user_items = $auction->getUserItems($user->ID);

//$main_content->set('items_user_is_selling', $auction->getItemsUserIsSelling($user->ID, 'selling'));
//$main_content->set('items_user_is_buying', $auction->getItemsUserIsBuying($user->ID, 'bidding'));
//$main_content->set('items_user_has_won', $auction->getItemsUserHasWon($user->ID, 'won'));



$listing->set('content', @$user_items['Sold']);
$main_content->set('sold', $listing->fetch());




$listing->set('content', @$user_items['Active']);
$main_content->set('active', $listing->fetch());

$history = new Template('history');

$history_array_recv = $user->getRecentHistory($user->ID);
$history_array_made = $user->getRecentHistory($user->ID, true);

$history_array = array_merge($history_array_made, $history_array_recv);


//$GLOBALS['debug']->printr($history_array);
$history->set('content', $history_array);
$main_content->set('history', $history->fetch());

$history->set('content', $history_array_made);
$main_content->set('bids_made', $history->fetch());

$template->set('content', $main_content->fetch());
echo $template->fetch();
?>