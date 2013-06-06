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

if(empty($_SESSION)) header('location:/index.php');

$main_content = new Template('search');


$items_array = $auction->getAllItems();

if(!empty($_POST)){
	$listing = new Template('listing');
	$listing->set('content', $auction->getSearch());
	$main_content->set('listing', $listing->fetch());
} else {
	$items_array = array();
	$main_content->set('listing', false);
}

$template->set('content', $main_content->fetch());

echo $template->fetch();

?>