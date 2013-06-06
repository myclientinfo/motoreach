{* Smarty *}
<!-- BEGINNING MENU TEMPLATE -->
<div id="menu">	
	<ul>
		<li id="one"><a href="{$COMPANY_URL}" title="{$COMPANY_NAME} Silent Auction, HOME." accesskey="1">HOME</a></li>
		<li id="two"><a href="login.php" title="Log in to Silent auction." accesskey="2">log in</a></li>
		<li id="three"><a href="register.php" title="Registration page for OpUSA Silent Auction." accesskey="3">register</a></li>
		<li id="four"><a href="editaccount.php" title="My Account Information." accesskey="4">my account</a></li>
		<li id="five"><a href="submititem.php" title="Contribute an item to the auction." accesskey="5">contribute an item</a></li>
		<li id="six"><a href="{$COMPANY_URL}" title="{$COMPANY_NAME} Main Web Site." accesskey="6">{$COMPANY_NAME} Main</a></li>
		{if $authorised == "valid"}<li id="seven"><a href="index.php?logout" title="Log out" accesskey="7">Log out</a></li>{/if}
	</ul>		
</div>
<!-- END MENU TEMPLATE -->
<!-- BEGINNING OF BODY -->
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