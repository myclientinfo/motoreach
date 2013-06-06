<?php
/**
 * 
 * @package auction
 * 
 * These classes are a complete auction framework, ready to implement using a minimum amount of procedural PHP code, 
 * and a templating system like Smarty. The database abstraction layer AdoDB is used.
 * @version $Id: class_mailman.php,v 1.11 2005/07/09 01:26:40 woostachris Exp $
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
 * Mailman
 * 
 * @todo consider sending HTML/plain text multipart email messages
 * 
 * Automatic Emailer
 * @package auction
 * @author nicolas 
 * @copyright Copyright (c) 2005
 * @version $Id: class_mailman.php,v 1.11 2005/07/09 01:26:40 woostachris Exp $
 * @access public 
 */

class Mailman {
    /**
     * 
     * @var string auction_url complete URL ending in slash which identifies the 
     * root folder for the auction software.  This variable should be deprecated by a 
     * config file option to set the URL.
     * @access private 
     */

    /**
     * Constructor function
     */
    function Mailman() {
    } 

    /**
     * Sends the buyer a notice that his bid has been registered, and that he is the current
     * winner of the item. Can also send the seller a notice that his item has received a bid
     * 
     * @param object $bid 
     * @return boolean TRUE if success, string error message if not
     */
    function noticeBid($bid) {
        // subject of email
        $subject = AUCTION_NOTICE_WINNING_BIDDING_SUBJECT . ' "[notice_item_name]"'; 
        // email message body
        $message = "<p>" . AUCTION_GREETING . " [notice_fullname]</p>"
. "<p>You are winning the bidding for item \"<a href=\"" . COMPANY_URL . "items.php?itemID={$bid->itemID}\">[notice_item_name]</a>\".</p>";

        return $this->noticePrivateMailer($bid, $subject, $message);
    } 

    /**
     * Sends the buyer a notice that he has been outbid by another user
     * 
     * @param object $bid 
     * @return success message
     */
    function noticeOutbid($bid) {
        // subject of email
        $subject = AUCTION_NOTICE_OUTBID_SUBJECT . ' "[notice_item_name]"'; 
        // email message body
        $message = "<p>" . AUCTION_GREETING . " [notice_fullname]</p>"
. "<p>You have been outbid by another user for item \"<a href=\"" . COMPANY_URL . "items.php?itemID={$bid->itemID}\">[notice_item_name]</a>\".</p>";

        return $this->noticePrivateMailer($bid, $subject, $message);
    } 

    /**
     * Sends a user a notice that he has lost his bid on a given item
     * 
     * @param object $bid 
     * @return success message
     */
    function noticeLose($bid) {
        // subject of email
        $subject = AUCTION_NOTICE_LOST_AUCTION_SUBJECT . ' "[notice_item_name]"'; 
        // email message body
        $message = "<p>" . AUCTION_GREETING . " [notice_fullname]</p>
<p>We're sorry, but the auction for item \"<a href=\"" . COMPANY_URL . "items.php?itemID={$bid->itemID}\">[notice_item_name]</a>\" has closed.  You did not win the auction.</p>";

        return $this->noticePrivateMailer($bid, $subject, $message);
    } 

    /**
     * Sends a user a notice that he has win an item on auction
     * 
     * @param object $bid 
     * @return success message
     */
    function noticeWin($bid) {
        // Retrieve item from bid
        $auction = new Auction();
        $item = $auction->getItem($bid->itemID);
        $item_price = $item->getCurrentPrice();
        // subject of email
        $subject = AUCTION_NOTICE_ITEM_WON_SUBJECT . '"[notice_item_name]"'; 
        // email message body
        $message = "<p>" . AUCTION_GREETING . " [notice_fullname]</p><p>"
            . AUCTION_NOTICE_ITEM_WON_BODY . " \"<a href=\"" . COMPANY_URL . "items.php?itemID={$bid->itemID}\">[notice_item_name]</a>\".</p>";
        
        /* ALTERNATIVE METHOD: HTML FORM WITH IMAGE LINK TO PAYPAL */
//        $message .= "
//            <form action=\"https://www.paypal.com/cgi-bin/webscr\" method=\"post\">
//            <input type=\"hidden\" name=\"cmd\" value=\"_xclick\">
//            <input type=\"hidden\" name=\"business\" value=\"" . AUCTION_COMPANY_PAYPAL . "\">
//            <input type=\"hidden\" name=\"item_name\" value=\"{$item->name}\">
//            <input type=\"hidden\" name=\"item_number\" value=\"{$item->ID}\">
//            <input type=\"hidden\" name=\"amount\" value=\"{$item_price}\">
//            <input type=\"hidden\" name=\"no_note\" value=\"1\">
//            <input type=\"hidden\" name=\"currency_code\" value=\"USD\">
//            <input type=\"hidden\" name=\"lc\" value=\"US\">
//            <input type=\"image\" src=\"https://www.paypal.com/en_US/i/btn/x-click-but6.gif\" border=\"0\" name=\"submit\" alt=\"Make payments with PayPal - it's fast, free and secure!\">
//            </form>";
        
        /* ALTERNATIVE METHOD: URL LINK TO PAYPAL (MORE FILTER-FRIENDLY) */
        $business = urlencode(AUCTION_COMPANY_PAYPAL);
        $item_name = urlencode($item->name);
        $item_price = urlencode($item->getCurrentPrice());
        $message .= "<p>Please pay by following this link: <a href=\"";
        $message .= "https://www.paypal.com/cgi-bin/webscr?cmd=_xclick&business={$business}&item_name={$item_name}&item_number={$item->ID}&amount={$item_price}&no_shipping=0&no_note=1&currency_code=USD&lc=US&charset=UTF%2d8";
        $message .= "\">Pay with PayPal</a>";
        return $this->noticePrivateMailer($bid, $subject, $message);
    } 

    /**
     * Sends a user a notice that the item he has bid on has expired and not met its reserve
     * 
     * @param object $bid 
     * @return success message
     */
    function noticeReserveNotMet($bid) {
        // subject of email
        $subject = AUCTION_NOTICE_RESERVE_NOT_MET . ' "[notice_item_name]"'; 
        // email message body
        $message = "<p>" . AUCTION_GREETING . " [notice_fullname]</p><p>" .
        AUCTION_NOTICE_RESERVE_NOT_MET . " \"<a href=\"" . COMPANY_URL . "items.php?itemID={$bid->itemID}\">[notice_item_name]</a>\".</p>";

        return $this->noticePrivateMailer($bid, $subject, $message);
    } 

    /**
     * Sends a seller a notice that one of his items on auction has been sold
     * 
     * @param object $bid 
     * @return success message
     */
    function noticeItemSold($bid) {
        // subject of email
        $subject = AUCTION_NOTICE_ITEM_SOLD . ' "[notice_item_name]"'; 
        // email message body
        $message = "<p>" . AUCTION_GREETING . " [notice_fullname]</p><p>" .
        AUCTION_NOTICE_ITEM_SOLD . " \"<a href=\"" . COMPANY_URL . "items.php?itemID={$bid->itemID}\">[notice_item_name]</a>\".</p>";

        return $this->noticePrivateMailer($bid, $subject, $message);
    } 

    /**
     * Sends an email to the user associates with this bid.
     * 
     * @param object $bid the bidding object passed in
     * @param object $theSubject subject of the email to send
     * @param object $theMessage contents of the message to send
     * @return boolean TRUE if success, string error message if not
     * @access private 
     */
    function noticePrivateMailer($bid, $the_subject, $the_message) {
        // get $userID from $bid object
        $notice_userID = $bid->userID;
        $notice_itemID = $bid->itemID; 
        // MySQL to get email address
        $myDB = &ADONewConnection(DSN);
        $query = "SELECT email, fullname FROM auction_users WHERE ID = $notice_userID";
        $rs = &$myDB->Execute($query);

        if (!$rs) {
            return AUCTION_USER_UNKNOWN;
        } elseif ($rs->RecordCount() == 1) {
            $notice_email = $rs->fields[0];
            $notice_fullname = $rs->fields[1];
        } 
        
        $item_query = "SELECT name FROM auction_items WHERE ID = $notice_itemID";
        $rs = &$myDB->Execute($item_query);

        if (!$rs) {
            return AUCTION_ITEM_UNKNOWN;
        } elseif ($rs->RecordCount() == 1) {
            $notice_item_name = $rs->fields[0];
        }
                
        // Email user to tell them that they their bid has been registered.
        // recipients
        $to = $notice_email; 
        // Fill variables retrieved from SQL query into email template defined in the called method
        $the_subject = preg_replace("/\[(\S+)\]/e", "\$\\1", $the_subject);
        $the_message = preg_replace("/\[(\S+)\]/e", "\$\\1", $the_message); 
        // To send HTML mail, the Content-type header can be set to "Content-type: text/html; charset=iso-8859-1\n"
        $headers = "MIME-Version: 1.0\n";
        $headers .= "Content-type: text/html; charset=iso-8859-1\n"; 
        // Additional headers
        $headers .= "From: " . COMPANY_NAME . " <" . COMPANY_EMAIL . ">\n";
        $headers .= "To: $notice_fullname <$notice_email>\n"; 
        // and now mail it
        // Edited by Nick: report error message if mail is unsuccessful
        // We don't have any output to browser from within classes or php files: all from templates
        if (mail($to, $the_subject, $the_message, $headers)) {
            return true;
        } else {
            return AUCTION_EMAIL_FAILURE . $notice_fullname . $notice_email;
        } 
    } 
} 

?>