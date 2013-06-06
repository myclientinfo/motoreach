{* Smarty *}

{include file="admin_header.tpl" title="Auction -- Admin Panel -- Items"}

		<h1>Silent Auction -- Admin -- Items</h1>
		{if $authorised == "admin"}
			
			<p id="breadcrumb"><a href="admin.php">Admin Home</a> 
			{* If there is a category set (ID isn't 0), then show the All Items link *}
			{if $category->ID != 0} :: <a href="admin_items.php?categoryID=0">All Items</a>{/if}
			:: {$category->name}</p>
			
			{if $message}
				<p id="message">{$message}</p>
			{/if}
			
			<p>Items found in <i>{$category->name}</i>: {$numberOfItems}</p>
			<table>
				<tr>
					<th>Thumbnail</th><th>Item Name</th><th>Seller</th></th><th>Category</th><th>Price</th><th>Bids</th><th>Time left</th><th>Administrative</th>
				</tr>
				{if $items}
					{foreach from=$items item=v}

						{* append category ID to form action to keep current category being viewed after item removal. *}
						<form name="edit_messages_{$k}" method="post" action="admin_items.php?categoryID={$category->ID}">
						<input type="hidden" name="formdata" value="update" />
						<input type="hidden" name="ID" value="{$v.item->ID}" />
						<tr style="background-color:{cycle values="#eeeeee,#d0d0d0"}">
							<td><img alt="Picture of {$v.item->name}" height="50px" width="50px" src="{$v.item->image}" /></td>
							<td><a href="items.php?itemID={$v.item->ID}">{$v.item->name}</a></td>
							<td>{$v.seller->fullname} ({$v.seller->alias}, ID {$v.seller->ID})</td>
							<td><a href="admin_items.php?categoryID={$v.category->ID}">{$v.category->name}</a></td>
							<td>{curr}{$v.item->getCurrentPrice()}{/curr}</td>
							<td>{$v.item->getNumberOfBids()}</td>
							<td>{timeleft}{$v.item->getSecondsLeft()}{/timeleft}</td>
							<td><a href="admin_edititem.php?itemID={$v.item->ID}">Edit Item {$v.item->ID}</a><br>
							<input type="submit" name="action" value="delete" /></td>
						</tr>
						</form>
					{/foreach}
				{/if}
				{if $items_error}
					<tr style="background-color:#eeeeee">
						<td colspan="8"><p>{$items_error}</p></td>
					</tr>
				{/if}
			</table>
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