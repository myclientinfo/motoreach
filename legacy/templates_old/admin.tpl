{* Smarty *}

{include file="admin_header.tpl" title="Auction -- Admin Panel -- Home"}

		<h1>Silent Auction -- Admin -- Home</h1>
		{if $authorised == "admin"}
			<p>You are now logged in as an administrator. Auction tasks:</p>
			<ul>
			  <li><a href="admin_users.php">View, edit, and delete user accounts</a></li>
			  <li><a href="admin_items.php">View, edit, and delete items on auction</a></li>
			  <li><a href="admin_bids.php">View and edit bids</a></li>
			  <li><a href="admin_auction.php">View and edit auction settings</a></li>
			  <li><a href="admin_messages.php">Add and edit message constants</a></li>
			</ul>
			<ul>
			  <li><a href="admin.php?logout">Log out</a></li>
			</ul>
		{else}
			<p>You are not logged in as an administrator. Please <a href="admin_login.php">login</a> now.</p>
		{/if}
{include file="admin_footer.tpl"}	

{*
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
*}