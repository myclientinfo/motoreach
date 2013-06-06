<?php
/**
* 
* @package auction
* 
* These classes are a complete auction framework, ready to implement using a minimum amount of procedural PHP code, 
* and a templating system like Smarty. The database abstraction layer AdoDB is used.
* @version $Id: admin.php,v 1.2 2005/07/28 01:38:02 woostachris Exp $
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
// This lets include.php know which file is calling it
$calling = "admin_index.php";

require_once('include.php');

$smarty->display("admin.tpl");

?>