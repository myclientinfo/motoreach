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
require_once '../include.php';

if($_SESSION['authorised'] == "valid" && User::hasPermission('Admin')){
    
	list($action, $type) = explode('_', $_POST['action']);
	
	$make_id_list = Site::getLookupTable($_SESSION['l10n']['table_prefix'].'makes', 'id', 'make', 'make', false, false, false);
	
	$make_id_list = array_flip($make_id_list);
	$_POST['make_id'] = $make_id_list[$_POST['make_id']];
	
	$id = @$_POST[$type.'_id'];
	$value = $_POST['edit_'.$type.'_text'];
	
	$table = $type == 'series' ? $type : $type.'s';
	$table = $_SESSION['l10n']['table_prefix'].$table;
	
	$parent_field = $type == 'model' ? 'make_id' : 'model_id';
	$parent_value = $_POST[$parent_field];
	
	if($action != 'delete' && $value == '') die('FAILED');
	
	if($action == 'edit'){
		$query = 'UPDATE '.$table.' SET '.$type . ' = "'.  $value . '" WHERE id = '  . $id;
	} else if($action == 'delete') {
		$query = 'DELETE FROM '.$table.' WHERE id = '  . $id . ' LIMIT 1';
	} else {
		if($type == 'make') $query = 'INSERT INTO '.$table.'('.$type.') VALUES("'.$value.'")';
		else $query = 'INSERT INTO '.$table.'('.$type.', '.$parent_field.') VALUES("'.$value.'", "'.$parent_value.'")';
	}
	
	Site::runQuery($query);
	
	if($action == 'delete' && $type == 'make'){
		$query = 'DELETE FROM '.$_SESSION['l10n']['table_prefix'].'models WHERE make_id = '.$id;
		Site::runQuery($query);
	}
	
//	Site::deleteCache();
}

?>