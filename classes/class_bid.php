<?php

/**
 * 
 * @package auction
 * 
 * These classes are a complete auction framework, ready to implement using a minimum amount of procedural PHP code, 
 * and a templating system like Smarty. The database abstraction layer AdoDB is used.
 * @version $Id: class_bid.php,v 1.10 2005/07/09 01:06:55 nicolasconnault Exp $
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
 * Bid
 * 
 * Represents a bid put on an item
 * 
 * @package auction
 * @author nicolas 
 * @copyright Copyright (c) 2005
 * @version $Id: class_bid.php,v 1.10 2005/07/09 01:06:55 nicolasconnault Exp $
 * @access public 
 * @todo We often use an array $fields to update or create an object, but we rarely check that 
 * this array actually contains data that matches the object's structure. It would be handy to create
 * a method applicable to all classes, that checks the validity of this $field array based on the class' fields.
 */
 
class Bid {
    var $dummy;
    /**
     * 
     * @var int $ID This bid's unique ID
     */
    var $ID;
    /**
     * 
     * @var int $datesubmitted A timestamp of the date this bid was submitted
     */
    var $datesubmitted; 
    /**
     * 
     * @var int $itemID This bid's item's unique ID
     */
    var $itemID;
    /**
     * 
     * @var int $userID This bid's user's unique ID
     */
    var $userID;
    /**
     * 
     * @var int $result The result of this bid, either won or lost
     */
    var $result;

    /**
     * Constructor function. Takes the output from a form to create a new bid object
     * 
     * @param array $fields 
     */
    function Bid($fields) {
		extract($fields);
		   
        // If the bid is being created from the database, use the existing ID field
        if (isset($ID)) {
            $this->ID = $ID;
            $this->datesubmitted = $datesubmitted;
            $this->amount = $amount; 
        } else {
            $this->datesubmitted = time();
            // Do nothing about the ID, we will call getID() after the new bid has been recorded
        }
        
        $this->itemID = $itemID;
        $this->userID = $userID;        
    } 
	
	function getBid($id){
		
		$query = 'SELECT h.*, u.*, type, year, badge, model, make, c.colour FROM auction_bids AS h 
			JOIN auction_items AS i ON h.itemID = i.id
				LEFT JOIN auction_users AS u ON u.ID = h.userID
					JOIN auction_bid_type AS t ON h.typeID = t.id
					JOIN vehicle_details AS vd ON vd.auction_id = h.itemID
					LEFT JOIN type_colours AS c ON c.id = vd.colour_id
						LEFT JOIN '.$_SESSION['l10n']['table_prefix'].'models AS md ON md.id = vd.model_id
					LEFT JOIN '.$_SESSION['l10n']['table_prefix'].'makes AS mk ON mk.id = md.make_id
						LEFT JOIN '.$_SESSION['l10n']['table_prefix'].'badges AS bd ON bd.model_id = vd.badge_id
							WHERE h.ID = '.$id;
		
		return Site::getData($query, true);
	}
	
     /**
     * Retrieves the auction's last bid's unique ID from the database
     * @return int A unique ID number
     */
    function getID() {
        $myDB = &ADONewConnection(DSN);
        $query = "SELECT ID FROM auction_bids WHERE ID > 0 ORDER BY ID DESC LIMIT 1";
        $rs = &$myDB->Execute($query);
        $ID = $rs->fields['ID'];
        $this->ID = $ID;
        return $ID;
    } 
    
    /**
     * Records this bid object in the database
     * @return string TRUE if successful, error message if failure
     */
    function recordBid($type_id = 1) {
        $query = "INSERT INTO auction_bids (datesubmitted, itemID, userID, amount, typeID) 
            			VALUES ({$this->datesubmitted}, {$this->itemID}, {$this->userID}, 
            			'".@$_REQUEST['amount']."', '$type_id')";
        
        return Site::runQuery($query);
    } 

    /**
     * When an item expires, this function sets the bid as a win or a loss in the database
     * @param  $result "won" or "lost"
     * @return boolean true if success, error message if failure
     */
    function setResult($result) {
        //$myDB = &ADONewConnection(DSN);
        if ($result != "won" || $result != "lost") {
            return AUCTION_UPDATE_BID_FAILURE;
        } 
        $query = "UPDATE auction_bids SET result = '$result' WHERE ID = {$this->ID}";
        
        return Site::runQuery($query); 
    } 

    /**
     * Sets the information in this bid object to match the information passed in
     * @deprecated
     * @since 1.4
     * @param array $fields 
     */
    function setBid($fields) {
        extract($fields);
        $this->ID = $ID;
        $this->datesubmitted = $datesubmitted;
        $this->itemID = $itemID;
        $this->userID = $userID;
    } 

    /**
     * Deletes this bid from the database
     * @return boolean true if successful, error message if failure
     */
    function deleteBid() {
        $myDB = &ADONewConnection(DSN);
        $query = "DELETE FROM auction_bids WHERE ID = {$this->ID}";
        $rs = &$myDB->Execute($query);
        if (!$rs) {
            return AUCTION_DELETE_BID_FAILURE;
        } else {
            return true;
        } 
    } 

    /**
     * Updates the bid with the given field data
     * @param array $fields An associative array of fields to modify
     * @return boolean true if successful, error message if failure
     */
    function updateBid($fields) {
        extract($fields);
        $query = "UPDATE auction_bids SET itemID = $itemID, userID = $userID, result = '$result'";
        return Site::runQuery($query);
    } 
} 

?>