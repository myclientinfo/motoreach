{* Smarty *}
<!-- BEGINNING MENU TEMPLATE -->
<div id="adminmenu">	
	<ul>	
	{if $authorised == "admin"}
	<li id="one"><a href="index.php" title="Back to auction website" accesskey="9">Auction Website</a></li>
	<li id="aa"><a href="admin.php" title="Admin panel main page">ADMIN HOME</a></li>
	<li id="bb"><a href="admin_users.php" title="View and edit user accounts">users</a>
	<li id="cc"><a href="admin_items.php" title="View and edit items on auction">items</a>
	<li id="dd"><a href="admin_bids.php" title="View and edit bids">bids</a>
	<li id="ee"><a href="admin_auction.php" title="View and edit auction settings">auction</a>
	<li id="ff"><a href="admin_messages.php" title="Add and edit message constants">messages</a>
	<li id="gg"><a href="admin.php?logout" title="Log out">log out</a>
	{else}
		<li id="hh"><a href="admin_login.php" title="Log in as an administrator" accesskey="1">log in</a></li>
		<li id="ii"><a href="index.php" title="Back to auction website" >Auction Website</a></li>
	{/if}
	</ul>
</div>
<!-- END MENU TEMPLATE -->
{*
 * Copyright (C) 2005 Vickie Comrie, Nicolas Connault, Christopher Vance
 * 
 * Vickie Comrie: <http://www.indiconv.com>
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