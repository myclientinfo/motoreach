<?php
/**
 * 
 * @package auction
 * 
 * These classes are a complete auction framework, ready to implement using a minimum amount of procedural PHP code, 
 * and a templating system like Smarty. The database abstraction layer AdoDB is used.
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

class Search {
    function Search() {
    } 

    function findItems($search_term) {
        $myDB = &ADONewConnection(DSN);
        $query = "SELECT * FROM auction_items WHERE name like '%{$search_term}%' OR description LIKE '%{$search_term}%'";
        $rs = &$myDB->Execute($query);

        $return_array = array(); // array could be initialized to the size of the records
        $i = 0; // used as an index into the array $return_array 
        // Code isn't catching no matching results.
        // ## Then try to catch an empty recordset: ###
        if (!$rs || $rs->RecordCount() == 0) {
            return AUCTION_SEARCH_NO_MATCHES;
        } else {
            while (!$rs->EOF) {
                $item = new Item($rs->fields);
                $return_array[$i] = $item;
                $i++; // increment counter for $return_array
                $rs->MoveNext();
            } 
        } 
        $rs->Close(); // optional
        return $return_array; 
        // Alternative method: using a for loop
        for($i = 0; $i < $rs->RecordCount(); $i++) {
            $item = new Item($rs->fields);
            $return_array[$i] = $item;
            $rs->MoveNext();
        } 
        return $return_array;
    } 
} 

?>