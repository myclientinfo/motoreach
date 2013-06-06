<?php
/**
* 
* @package auction
* 
* These classes are a complete auction framework, ready to implement using a minimum amount of procedural PHP code, 
* and a templating system like Smarty. The database abstraction layer AdoDB is used.
* @version $Id: placebid.php,v 1.2 2005/07/28 04:02:29 woostachris Exp $
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

require_once 'include.php';
//$main_content = new Template('placebid');


// A user could enter the itemID in the URL, which means he could bid on his own item.
// This must be prevented
if($_SESSION['authorised'] == "valid"){
    $item = $auction->getItem($_REQUEST['itemID']);
    $category = new Category(array("ID" =>$item->categoryID));
    $bidamount = $item->getCurrentPrice() + $item->increment;
    $user = $_SESSION['auction']->user;
    $user->getID();
    $submitted = false;
    $itemokay = $item->checkUser($user->ID);
}
// If user has placed bid, process form data, unless the page has been refreshed
if(isset($_POST['formdata'])){
    $bid = new Bid(array("itemID" => $_REQUEST['itemID'], "userID" => $user->ID));
    $result = $bid->recordBid();
    if($result === true){
        $message = AUCTION_BID_SUBMIT_SUCCESS;
        $submitted = true;
        echo $_POST['amount'];
    }else{
        $message = AUCTION_BID_SUBMIT_FAILURE . $result['message'];
        $error_field = $result['field'];
        $submitted = false;
    }
}

if (isset($error_field)) {
    //$main_content->set("error_field", $error_field);
}
die();
$main_content->set("itemokay", $itemokay);
$main_content->set("submitted", $submitted);
$main_content->set("bidamount", $bidamount);
$main_content->set("item", $item);
$main_content->set("message", @$message);
$main_content->set("category", $category);
$template->set('content', $main_content->fetch());
echo $template->fetch();

?>