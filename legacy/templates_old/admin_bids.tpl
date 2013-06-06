{* Smarty *}

{include file="admin_header.tpl" title="Auction -- Admin Panel -- Bids"}

		<h1>Silent Auction -- Admin -- Bids</h1>
		{if $authorised == "admin"}
        <p>Here you can review bids that have been listed in this auction, modify and delete them.
        Be cautious in doing so, because such modifications could cause serious problems
        among sellers and bidders. Modifications and deletions should only be performed if
        there are obvious and serious issues created by these bids, such as fake bids or
        mistaken bids for which a bidder has contacted you or the seller.</p>
        
        <table summary="All bids are shown here and can be edited">
				<tr>
					<th>ID</th>
					<th>Date submitted</th>
					<th>Item</th>
					<th>User</th>
                <th>Amount</th>
                <!--<th>Update</th>-->
					<th>Delete</th>
				</tr>
				{foreach from=$bids key=k item=v}
                {assign var=itemID value=$v->itemID}
                {assign var=userID value=$v->userID}
					<form name="edit_bids_{$k}" method="post" action="admin_bids.php">
					<input type="hidden" name="formdata" value="update" />
					<input type="hidden" name="ID" value="{$v->ID}" />
					<tr style="background-color:{cycle values="#eeeeee,#d0d0d0"}">
						<td>{$v->ID}</td>
                    <td>{$v->datesubmitted|date_format}</td>
						<td><a href="admin_items.php?itemID={$v->itemID}">{$items[$itemID]->name} </a></td>
						<td><a href="admin_users.php?userID={$v->userID}">{$users[$userID]->alias}</a></td>
						<td>${$items[$itemID]->increment}</td>
                    <!--<td><input type="submit" name="action" value="update" /></td>-->
						<td><input type="submit" name="action" value="delete" /></td>
					</tr>
					</form>
				{/foreach}
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
