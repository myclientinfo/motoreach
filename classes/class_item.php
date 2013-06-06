<?php
/**
 * These classes are a complete auction framework, ready to implement using a minimum amount of procedural PHP code, 
 * and a templating system like Smarty. The database abstraction layer AdoDB is used.
 * 
 * @package auction
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
 * Item
 * 
 * Represents an item put for auction
 * 
 * @package auction
 * @author nicolas 
 * @copyright Copyright (c) 2005
 * @version $Id: class_item.php,v 1.21 2005/07/27 22:55:18 woostachris Exp $
 * @access public 
 */
class Item {
    /**
     * 
     * @var integer ID item unique Identification Number.
     */
    var $ID;
    /**
     * 
     * @var integer categoryID The category's ID to which this item belongs.
     */
    var $categoryID;
    /**
     * 
     * @var string image The relative path to the image representing this item.
    */
    var $image;
    /**
     * 
     * @var string name The descriptive name of this item.
     */
    var $name;
    /**
     * 
     * @var string description A long description of this item (blob).
     */
    var $description;
    /**
     * 
     * @var float startprice The price at which this item started the auction.
     */
    var $startprice;
    /**
     * 
     * @var float reserve The reserve price set by the contributor (optional).
     */
    var $reserve;
    /**
     * 
     * @var float increment The value in dollars by which each bid increments the item's price.
     */
    var $increment;
    /**
     * 
     * @var integer dateentered The date (timestamp) at which this item was entered in the auction.
     */
    var $dateentered;
    /**
     * 
     * @var integer auctionlength The total length during which this item is on auction (in seconds).
     */
    var $auctionlength;
    /**
     * 
     * @var integer userID The unique ID of this item's contributor/seller.
     */
    var $userID;
    /**
     * 
     * @var array bids An array of Bid objects attached to this item.
     */
    var $bids = array();
    /**
     * 
     * @var integer auctionend Timestamp obtained by adding auctionlength to dateentered.
     */
    var $auctionend;
    /**
     * 
     * @var boolean $winning "true" if user is winning this bid, "false" if not.
     */

  var $winning;

   /**
     * 
     * @var string $processed "yes" if item's auction time is finished and it has been processed in consequence.
     */
    var $processed;

    /**
     * Constructor function
     * 
     * @todo There is no error checking for missing fields. This makes this class
     * depend on the validation class. It needs its own "empty field" checking
     * @param array $fields The attributes of this item, pulled either implicitely through a 
     * query to the database, or explicitely by a user input form
     */
    function Item($fields) {
        $myDB = &ADONewConnection(DSN);
        extract($fields); 
        $this->data = $fields;
        
        
		$name = '';
        $this->categoryID = $categoryID;
        //$this->image = $image;
        $this->name = $name;
        $this->description = mysql_real_escape_string($description);
        $this->startprice = $startprice;
        $this->currentprice = $startprice;
        $this->buyoutprice = $buyoutprice;
        if(isset($increment))$this->increment = $increment;
		
		if(isset($is_lot)) $this->is_lot = $is_lot;
		else $this->is_lot = 0;
		
		if(isset($lot_amount)) $this->lot_amount = $lot_amount;
		
        if (isset($dateentered)) {
            $this->dateentered = $dateentered;
        } else {
            $this->dateentered = time();
        } 

        $this->auctionlength = $auctionlength;
        $this->userID = $userID;
		
        $this->auctionend = $this->dateentered + $this->auctionlength * 86400; #86400 is the number of seconds in a day
        $this->ID = $ID;
        $this->processed = $processed; 
        // Search the database to see if bids already exist for this item
        /*
		$query = "SELECT auction_bids.* FROM auction_items, auction_bids WHERE auction_bids.itemID = auction_items.ID AND auction_items.ID = {$this->ID}";
        
		$rs = &$myDB->Execute($query);
        if (!$rs || $rs->RecordCount() < 1) {
            // A constructor cannot return a value, so we can't send an error message here.
        } else {
            for($i = 0; $i < $rs->RecordCount(); $i++) {
                $this->bids[] = new Bid($rs->fields);
                $rs->MoveNext();
            } 
        } 
        $myDB->Close();
		*/
    } 

    /**
     * Retrieves the auction's last item's unique ID from the database
     * @return int A unique ID number
     */
    function getID() {
        $myDB = &ADONewConnection(DSN);
        $query = "SELECT ID FROM auction_items WHERE ID > 0 ORDER BY ID DESC LIMIT 1";
        $rs = &$myDB->Execute($query);
        if (!$rs) {
            return AUCTION_NO_ITEM_FOUND;
        } else {
            $itemID = (int) $rs->fields[0];
            $this->ID = $itemID;
            $myDB->Close();
            return $itemID;
        } 
    } 
    
    /**
     * Updates the item with the given field data
     * 
     * @param array $fields which should be updated in the DB
     * @return boolean true if successful, error message if failure
     * @author Chris Vance
     * @todo see if there's a more elegant way to handle missing fields
    */
    function updateItem($fields) {
        /**
         * Other fields we can update
         */
        /**
         * '$processed'";
         */
        /**
         * $increment,
         */
        /**
         * $reserve,
         */
        /**
         * image = '$image',
         */
        /**
         * dateentered = $dateentered,
         */

        $myDB = &ADONewConnection(DSN);
        extract($fields);

        /* Check to make sure that we only set fields that are passed in.  If the variable is set,
         * add the appropriate SQL to the $updatedfields variable */
        $updatedfields = "";
        if (isset($name)) { $updatedfields .= "name = '$name', "; }
        if (isset($categoryID)) { $updatedfields .= "categoryID = $categoryID, "; }
        if (isset($auctionlength)) { $updatedfields .= "auctionlength = $auctionlength, "; }
        if (isset($description)) { $updatedfields .= "description = '$description', "; }

        /* Trim the last ", " off the end of the string so that it is valid in the SQL. */
        if ($updatedfields != "") {
            $updatedfields = rtrim($updatedfields, ", ");
        }

        $query = "UPDATE auction_items SET 
            $updatedfields
            WHERE ID = $this->ID";
        $rs = &$myDB->Execute($query);
        if (!$rs) {
            return AUCTION_UPDATE_ITEM_FAILURE;
        } else {
            // Internally update information in the object
            if (isset($name)) { $this->name = $name; }
            if (isset($categoryID)) { $this->categoryID = $categoryID; }
            if (isset($auctionlength)) {
                $this->auctionlength = $auctionlength; 
                // Update the end of the auction because the auctionlength might have changed.
                $this->auctionend = $this->dateentered + $this->auctionlength * 86400; #86400 is the number of seconds in a day
            }
            if (isset($description)) { $this->description = $description; }


            return true;
        }
    } 
    
    /**
    * Checks that this item is ready for insertion in the database
    * @return boolean TRUE if ready, false if not
    */
    function isReadyForDB() {
        $retVal = true;        
        foreach (get_object_vars($this) as $k => $v) {
            if ($k == "categoryID" || 
                $k == "image" ||
                $k == "name" ||
                $k == "startprice" ||
                $k == "userID" ||
                $k == "dateentered" ||
                $k == "auctionlength" ) {
                if (!isset($v) || $v == "") {
                    $retVal = false;
                    
                    return true;
                }
            }
        }
        
        return $retVal;
    }
    
    /**
     * Records this bid object in the database
     * @return string TRUE if successful, error message if failure
     */
    function recordItem() {
      if ($this->isReadyForDB()) {
		  
		   $lis = Auction::getAuctionLength($_POST['auctionlength']);
		   
		  
           $query = "INSERT INTO auction_items (
               categoryID,
               image,
               name,
               description,
               startprice,
               buyoutprice,
               increment,
			   is_lot,
			   lot_amount,
               dateentered,
			   auction_end,
               auctionlength,
               userID
               )
               VALUES(
               '{$this->categoryID}',
                '{$this->image}',
                '{$this->name}',
                '{$this->description}',
                '".Site::numbersOnly($this->startprice)."',
                '".Site::numbersOnly($this->buyoutprice)."',
                '{$this->increment}',
				'{$this->is_lot}',
				'{$this->lot_amount}',
                '{$this->dateentered}',
				'".($this->dateentered + $lis)."',
                '{$this->auctionlength}',
                '{$this->userID}')";
            //$GLOBALS['debug']->printr($query);
			return Site::runQuery($query);
       }
    } 
    
    /**
     * Deletes this item from the database
     * 
     * @return boolean true if successful, error message if failure
     */
    function deleteItem() {
        $myDB = &ADONewConnection(DSN);
        $query = "DELETE FROM auction_items WHERE ID = {$this->ID}";
        $rs = &$myDB->Execute($query);
        if (!$rs) {
            return AUCTION_DELETE_ITEM_FAILURE;
        } else {
            return true;
        } 
    } 



    /**
     * Can be used to disable and re-enable this item in the database rather than outright deleting it
     * 
     * @param boolean $ TRUE for item processed, FALSE for item not processed (not processed means the items is biddable in the auction)
     * @return boolean true if successful, error message if failure
     * @author Chris Vance 
     */
    function setProcessed($booleanFlag) {
        if ($booleanFlag) {
            $proc = "yes";
        } else {
            $proc = "no";
        } 
       $myDB = &ADONewConnection(DSN);
        $query = "UPDATE auction_items SET processed = '{$proc}' WHERE ID = {$this->ID}";
        $rs = &$myDB->Execute($query);
        if (!$rs) {
            return ADMIN_DELETE_ITEM_FAILURE;
        } else {
            return true;
        } 
    } 

    /**
     * Returns the item's current price (startprice + all bid increments)
     * 
     * @return float the current price of the item
     */
    function getCurrentPrice() {
        $current_price = $this->startprice;
        $current_price += $this->increment * count($this->bids);

        return $current_price;
    } 

    /**
     * Returns the number of bids on this item
     * 
     * @return integer Number of bids on this item
     */
    function getNumberOfBids() {
        return count($this->bids);
    } 

    /**
     * Returns the number of seconds left before the end of this auction
     * 
     * @return integer Number of seconds left for this item
     */
    function getSecondsLeft() {
        return ($this->auctionend - time());
    } 

    /**
     * Item::getSeller()
     * Returns an object with the attributes of the seller of this item (a User object)
     * 
     * @return object User object: the contributor/seller
     */
    function getSeller() {
        $myDB = &ADONewConnection(DSN);
        $query = "SELECT * FROM auction_users WHERE ID = {$this->userID}";        
        $rs = &$myDB->Execute($query);
        if (!$rs || $rs->RecordCount() < 1) {
            return AUCTION_NO_USER_FOUND;
        } else {
            $seller = new User($rs->fields);
            return $seller;
        } 
    } 

    /**
     * Checks whether the item shown for auction has been submitted by the same person who is browsing it.
     * If that is the case, we disable the "Place bid >" button for this item.
     * 
     * @param integer $userID 
     * @return boolean True if the user is different from the contributor, otherwise false
     */
    function checkUser($userID) {
        return $this->userID != $userID;
    } 

    /**
     * Returns bidding history for the item being viewed.
     * 
     * @return array of bid objects if successful, error message if failure
     * @author Chris Vance 
     */
    function getBidHistory() {
        $myDB = &ADONewConnection(DSN);
        $query = "SELECT b.* FROM auction_bids AS b
            WHERE b.itemID = {$this->ID}
            ORDER BY b.datesubmitted DESC";
        
		$myDB->SetFetchMode(ADODB_FETCH_ASSOC);

        
		$rs = &$myDB->Execute($query);
        if (!$rs || $rs->RecordCount() < 1) {
            return AUCTION_NO_BID_FOUND;
        } else {
            $return_array = array(); // array initialized to the size of the records
            for($i = 0; $i < $rs->RecordCount(); $i++) {
            	
            	
                $bid = new Bid($rs->fields);
                $return_array[$i] = $bid;
                $rs->MoveNext();
            } 
            return $this->_getBidHistoryUsers($return_array);
        } 
    } 
    /**
     * Private function to build an array of bids with the user and bid information tied together
     * 
     * @param array $bid_array 
     * @return array 2D array of bids with bid and user objects for each bid if successful, error message if failure
     * @access private 
     * @author Chris Vance 
     */
    function _getBidHistoryUsers($bid_array) {
        $myDB = &ADONewConnection(DSN); 
        // Start the array iterator at 1, so that the first bidder is number 1.  First item in $return_array[1].  The array DOES NOT start at 0.
        $i = 0;
        foreach($bid_array as $bid) {
            // This query will only return one row, because IDs are unique
            $query = "SELECT auction_users.* FROM auction_users
                WHERE ID = {$bid->userID}";
            $rs = &$myDB->Execute($query);
            if (!$rs || $rs->RecordCount() < 1) {
                // userID should exist in the database, otherwise we have a problem.
                return AUCTION_NO_BID_USER_FOUND;
            } else {
                // There will only be one user per ID, so we don't need to iterate across the records
                $user = new User($rs->fields);
                $return_array[$i] = array('bid' => $bid, 'user' => $user);
            } 
            $i++;
        } 
        return $return_array;
    } 
    /**
     * Sets the $winning variable of this item: the boolean of whether the user provided is winning this item or not
     * 
     * @param integer $userID 
     * @param boolean True if successful, false if not.
     */
    function setWinning($userID) {
        global $myDB;
        $query = "SELECT userID FROM auction_bids WHERE
            itemID = {$this->ID}
            ORDER BY datesubmitted DESC
            LIMIT 1";
        $rs = &$myDB->Execute($query);
        if (!$rs || $rs->RecordCount() < 1) {
            return 'AUCTION_NO_USER_FOUND';
        } else {
            $this->winning = ($userID == $rs->fields['userID']);
            return true;
        } 
    } 
    /**
     * After validating the image file (size, name etc..), this method sets the image attribute of this item,
     * and saves the uploaded file from its temporary location to the images folder
     * 
     * @param array $file An uploaded file
     * @return boolean TRUE if success, error message from validation class if not
     */
    function setImage($file) {
	
       $validate = new Validate();
        $result = $validate->checkImagefile($file);
        if ($result === true OR $result['message'] == "duplicate") {
            $num = 1;
            while (file_exists($this->image) AND $result['message'] == "duplicate") {
                $num ++;
                $file_name = $num . "_" . $file['name'];
                $this->image = "images/uploads/" . $file_name;
            }
            
            $upload_location = $_SERVER['DOCUMENT_ROOT'].'/images/uploads/'.$file['name'];
            
            if (move_uploaded_file($file['tmp_name'], $upload_location)) {
                $this->image = $validate->checkImageDimensions($upload_location);
                return true;
            } else {
                return array("message" => AUCTION_UPLOAD_IMAGE_FAILURE, "field" => "image");
            } 
        } else {
            return $result;
        } 
    } 
    /**
     * Set this item as processed in the database, meaning it has expired, and may have been won
     * 
     * @return boolean true if success, error message if failure.
     */
    function setAsProcessed() {
        $myDB = &ADONewConnection(DSN);
        $query = "UPDATE auction_items SET processed = 'yes' WHERE ID = {$this->ID}";
        $rs = &$myDB->Execute($query);
        if (!$rs) {
            return AUCTION_UPDATE_ITEM_FAILURE;
        } else {
            return true;
        } 
    } 
    /**
     * Returns the winning bid for this item
     * 
     * @return object Winning bid, or error message if no winner found
     */
    function getWinningBid() {
        $myDB = &ADONewConnection(DSN);
        $query = "SELECT * FROM auction_bids WHERE
            itemID = {$this->ID}
            ORDER BY datesubmitted DESC
            LIMIT 1";
        $rs = &$myDB->Execute($query);
        if (!$rs || $rs->RecordCount() < 1) {
            return AUCTION_NO_BID_FOUND;
        } else {
            $bid = new Bid($rs->fields);
            return $bid;
        } 
    } 
    /**
     * Returns an array of losing bids for this expired item
     * 
     * @return array Bid objects of losers, or FALSE if no loser found
     */
    function getLosingBids() {
        $myDB = &ADONewConnection(DSN);
        $bids = array();
        $query = "SELECT * FROM auction_bids WHERE
            itemID = {$this->ID}
            GROUP BY userID
            ORDER BY datesubmitted DESC
            LIMIT 1,-1";
        $rs = &$myDB->Execute($query);
        if (!$rs || $rs->RecordCount() < 1) {
            return AUCTION_NO_BID_FOUND;
        } else {
            for($i = 0; $i < $rs->RecordCount(); $i++) {
                $bids[] = new Bid($rs->fields);
                $rs->MoveNext();
            } 
            return $bids;
        } 
    } 
    function getDistinctBids() {
        // NOT YET IMPLEMENTED
        return array();
    } 
} 

?>