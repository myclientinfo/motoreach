<?php
/**
 * 
 * @package auction
 * 
 * These classes are a complete auction framework, ready to implement using a minimum amount of procedural PHP code, 
 * and a templating system like Smarty. The database abstraction layer AdoDB is used.
 * @version $Id: class_category.php,v 1.8 2005/06/21 07:54:35 nicolasconnault Exp $
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
 * Category
 * 
 * Represents a category of items
 * 
 * @package auction
 * @author nicolas 
 * @copyright Copyright (c) 2005
 * @version $Id: class_category.php,v 1.8 2005/06/21 07:54:35 nicolasconnault Exp $
 * @access public 
 */
class Category {
    /**
     * 
     * @var integer ID A unique ID number representing this category in the Database.
     */
    var $ID;
    /**
     * 
     * @var string name The name of the category.
     */
    var $name;

    /**
     * Constructor function : uses form data or sql results to create a new Category object
     * 
     * @param array $fields The Category's attributes
     */
    function Category($fields) {
        $myDB = &ADONewConnection(DSN);
        extract($fields);

        if ($ID == 0) {
            $this->name = "All items";
            $this->ID = 0;
        } else {
            if (!isset($name) AND !isset($ID)) {
                // Do not set member variables
            } elseif (!isset($name)) {
                $name = $this->getCategoryName($ID);
                $query = "SELECT * FROM auction_categories WHERE name= '$name'";
                $rs = &$myDB->Execute($query);
                if (!$rs) {
                    return AUCTION_NO_CATEGORY_FOUND;
                } else {
                    $ID = $rs->fields['ID'];
                } 
            } elseif (!isset($ID)) {
                $ID = $this->getCategoryID($name);
                $query = "SELECT * FROM auction_categories WHERE ID = $ID";
                $rs = &$myDB->Execute($query);
                if (!$rs) {
                    return AUCTION_NO_CATEGORY_FOUND;
                } else {
                    $name = $rs->fields['name'];
                } 
            } 
            $this->name = $name;
            $this->ID = $ID;
        } 
    } 

    /**
     * Enters the category in the database
     * 
     * @return boolean True if category was succesfully entered in DB, false if the category is already entered
     */
    function recordCategory() {
        // First check that category doesn't already exist. The name must be unique
        $myDB = &ADONewConnection(DSN);

        $query = "SELECT name FROM auction_categories WHERE name = '{$this->name}'";
        $rs = &$myDB->Execute($query);

        if ($rs->RecordCount() == 0) {
            $query = "INSERT INTO auction_categories (name) VALUES('{$this->name}')";

            $rs = &$myDB->Execute($query);
            if (!$rs) {
                return AUCTION_INSERT_CATEGORY_FAILURE;
            } else {
                $myDB->Close();
                return true;
            } 
        } else {
            $myDB->Close();
            return AUCTION_CATEGORY_ALREADY_EXISTS;
        } 
    } 

    /**
     * Using the given ID, retrieves a category name from the database.
     * 
     * @param integer $ID 
     * @return boolean true if category was successfully retrieved, error message if an error occurred.
     */
    function getCategoryName($ID) {
        $myDB = &ADONewConnection(DSN);
        $query = "SELECT * FROM auction_categories WHERE ID = $ID";
        $rs = &$myDB->Execute($query);
        if (!$rs || $rs->fields['name'] == "") {
            return AUCTION_NO_CATEGORY_FOUND;
        } else {
            $this->Category($rs->fields);
            return $rs->fields['name'];
        } 
    } 

    /**
     * Using the given name, retrieves a category ID from the database.
     * 
     * @param string $name 
     * @return boolean true if category was successfully retrieved, error message if an error occurred.
     */
    function getCategoryID($name) {
        $myDB = &ADONewConnection(DSN);
        $query = "SELECT * FROM auction_categories WHERE name = '$name'";
        $rs = &$myDB->Execute($query);
        if (!$rs || $rs->fields['ID'] == "") {
            return AUCTION_NO_CATEGORY_FOUND;
        } else {
            $this->Category($rs->fields);
            return $rs->fields['ID'];
        } 
    } 

    /**
     * Updates this category in the DB and updates this object accordingly
     * 
     * @param array $fields 
     * @return string TRUE if successfully updated, error message if not
     */
    function updateCategory($fields) {
        $myDB = &ADONewConnection(DSN);
        extract($fields);

        if (!isset($name) || !isset($ID)) {
            return AUCTION_UPDATE_CATEGORY_FAILURE;
        } 

        $query = "UPDATE auction_categories SET name = '$name' WHERE ID = $ID";
        $rs = &$myDB->Execute($query);
        if (!$rs) {
            return AUCTION_UPDATE_CATEGORY_FAILURE;
        } else {
            $this->Category($fields);
            return true;
        } 
    } 

    /**
     * Deletes this category from the database
     * 
     * @return boolean true if successful, error message if failure
     */
    function deleteCategory() {
        $myDB = &ADONewConnection(DSN);
        $query = "DELETE FROM auction_categories WHERE ID = {$this->ID}";
        $rs = &$myDB->Execute($query);
        if (!$rs) {
            return AUCTION_DELETE_CATEGORY_FAILURE;
        } else {
            return true;
        } 
    } 
} 

?>