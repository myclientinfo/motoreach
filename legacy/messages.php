<?php
/**
* 
* @package auction
* 
* These classes are a complete auction framework, ready to implement using a minimum amount of procedural PHP code, 
* and a templating system like Smarty. The database abstraction layer AdoDB is used.
* @version $Id: messages.php,v 1.1.1.1 2005/03/01 23:58:28 nicolasconnault Exp $
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
* This file sets up the messages that are sent to the templates in response to user events
* It could be used to set up a multi-lingual website
*/

define("AUCTION_ITEM_EXPIRED", _("This item has finished its auction time."));
define("AUCTION_ITEM_SUBMIT_SUCCESS", _("Your item has been successfully entered in the auction. Thank you for your contribution"));
define("AUCTION_ITEM_SUBMIT_FAILURE", _("There was an error in submitting your item for sale. Please verify that all fields have been correctly filled"));
define("AUCTION_ITEM_UNKNOWN", _("This item doesn't exist"));
define("AUCTION_LOGOUT_SUCCESS", _("You have successfully logged out. Thank you for your visit."));
define("AUCTION_NONMATCHING_PASSWORDS", _("The password fields do not match. Please re-enter the password in both fields"));
define("AUCTION_NOTICE_ITEM_WON_BODY", _("Congratulations!  You have won the auction for item"));
define("AUCTION_NOTICE_ITEM_WON_SUBJECT", _("Item won :"));
define("AUCTION_NOTICE_RESERVE_NOT_MET", _("Sorry, the reserve price for this item was not reached: "));
define("AUCTION_NOTICE_ITEM_SOLD", _("Congratulations! You have sold this item on our auction: "));
define("AUCTION_NO_ITEM_FOUND", _("The requested item doesn't exist in our records. Please select another one."));
define("AUCTION_NO_WINNING_ITEM_FOUND", _("No won items found."));
define("AUCTION_NO_LOST_ITEM_FOUND", _("No lost items found."));
define("AUCTION_NO_SOLD_ITEM_FOUND", _("No sold items found."));
define("AUCTION_NO_UNSOLD_ITEM_FOUND", _("No unsold items found."));
define("AUCTION_NO_USER_FOUND", _("This user doesn't exist in our records. Please register for a new account."));
define("AUCTION_NO_BID_FOUND", _("No bid was found for this item. Please place a bid or wait for the first bid."));
define("AUCTION_NO_AUCTION_FOUND", _("There is no auction currently running on this website. Please try again later."));
define("AUCTION_NO_CATEGORY_FOUND", _("Could not select any categories from the Database. Contact the administrator."));
define("AUCTION_SEARCH_NO_MATCHES", _("Your search returned no matches."));
define("AUCTION_UPDATE_USER_FAILURE", _("There was an error during the update of your personal details. Please try again or contact the administrator of this website."));
define("AUCTION_UPDATE_PASSWORD_FAILURE", _("There was an error during the processing of your new password. Please try again or contact the administrator of this website."));
define("AUCTION_UPDATE_BID_FAILURE", _("There was an error during the updating of the database. Please try again or contact the administrator of this website."));
define("AUCTION_UPLOAD_IMAGE_FAILURE", _("Could not save image file."));
define("AUCTION_UPLOAD_PARTIAL", _("There was en error during the file transfer, and it was only partially transfered. Please try again."));
define("AUCTION_UPLOAD_FAILURE", _("There was en error during the file transfer, and it was not transfered at all. Please try again."));
define("AUCTION_USER_REGISTER_SUCCESS", _("You have successfully registered as a user on this auction site. You may go to \"MyAccount\" to edit your details"));
define("AUCTION_USER_REGISTER_FAILURE", _("There was an error in the registration process: "));
define("AUCTION_USER_UNKNOWN", _("This user doesn't exist"));
define("AUCTION_USER_LOGIN_SUCCESS", _("You have been successfully logged in as "));
define("AUCTION_USER_LOGIN_FAILURE", _("There was an error in your login: "));
define("AUCTION_USER_UPDATE_SUCCESS", _("Your record has been successfully updated!"));
define("AUCTION_USER_UPDATE_FAILURE", _("There was an error in updating your record: "));
define("AUCTION_WRONG_ALIAS", _("This alias doesn't exist. Make sure you entered it correctly (it is case-sensitive)."));
define("AUCTION_WRONG_PASSWORD", _("The password you entered doesn't match the password associated with this alias. Make sure you entered it correctly (it is case-sensitive)."));

?>