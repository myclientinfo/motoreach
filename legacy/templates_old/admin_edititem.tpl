{* Smarty *}

{include file="admin_header.tpl" title="Auction -- Admin Panel -- Edit Items"}

	<h1>Silent Auction -- Admin -- Edit Item</h1>
	{if $authorised == "admin"}

    <p id="breadcrumb"><a href="admin.php">Admin Home</a> 
    {* If there is a category set (ID isn't either 0 or 32, which both represent "all items"), then show the All Items link *}
    {if $category->ID != 0 AND $category->ID != 32} :: <a href="admin_items.php?categoryID=0">All Items</a>{/if}
    :: <a href="admin_items.php?categoryID={$category->ID}">{$category->name}</a></p>

    {if $message}<p id="message">{$message}</p>{/if}

    {if $message != $AUCTION_NO_ITEM_FOUND}
        <form name="item" id="item" method="post" action="admin_edititem.php?itemID={$item->ID}">
        <input type="hidden" name="itemID" value="{$item->ID}" />
        <input type="hidden" name="userID" value="{$item->userID}" />
        <table summary="Item Details">
	<tr>
	  <td><input type="submit" name="action" value="Update" /></td>
	  <td colspan="2"></td>
	</tr>
        <tr>            
            <td rowspan="9" align="center">{if $bidder_item_image == "on"}<a href="{$item->image}" target="_blank"><img alt="Image of {$item->name}" src="{$item->image}" /><br />
            Larger picture</a>{/if}</td>
        <th>Item Name</th>
        <td><input type="text" name="name" value="{$item->name|stripslashes}" /></td>
        </tr>
        <tr>
          <th>Category</th>
          <td>
            <select name="categoryID">
            <option value="{$listing.categoryID}">{$submit_categories[$listing.categoryID].name}</option>
            {foreach from=$submit_categories key=k item=v}
              <option value="{$k}"{if $k == $item->categoryID} selected="selected"{/if}>{$v.name}</option>
            {/foreach}
            </select>
          </td>
        </tr>
        <tr>
        {if $BIDDER_ITEM_STARTPRICE == "on"}    
            <th>Starting Price</th>
            <td>{$item->startprice}</td>
        {/if}
        </tr>
        {if $BIDDER_ITEM_CURRENTPRICE == "on"}
        <tr>
            <th>Current Price</th>
            <td>{curr}{$item->getCurrentPrice()}{/curr}</td>
        </tr>
        {/if}

        {if $BIDDER_ITEM_INCREMENT == "on"}
        <tr>
            <th>Bid Increments</th>
            <td>{$item->increment}</td>
        </tr>
        {/if}

        {if $BIDDER_ITEM_STARTDATE == "on"}
            <tr>
                <th>Start Date</th>
                <td>{$item->dateentered|date_format}</td>
            </tr>
        {/if}

        {if $BIDDER_ITEM_TIMELEFT == "on"}
        <tr>
            <th>Time left</th>
            {if $item->processed == "yes"}
            <td>{$AUCTION_ITEM_EXPIRED}</td>
            {else}
            <td>
                {timeleft}{$item->getSecondsLeft()}{/timeleft}<br />
                {$item->auctionlength}-day listing
                {if $BIDDER_ITEM_ENDDATE == "on"}, ends {$item->auctionend|date_format:"%A, %B %e, %Y"}{/if}
            </td>
            {/if}
        </tr>
        {/if}

        {if $BIDDER_ITEM_STARTDATE == "on"}
            <tr>
                <th>Auction Length</th>
                <td><input type="text" name="auctionlength" value="{$item->auctionlength}" /> days</td>
            </tr>
        {/if}
        
        {if $BIDDER_SELLER_INFO == "on"}
            <tr>
                <th>Seller</th>
                <td><a href="seller.php?userID={$seller->ID}" target="_blank">{$seller->alias}</a></td>
            </tr>
        {/if}
        
        {if ($user->bidder_seller_city == "on") or ($user->bidder_seller_state == "on") or ($user->bidder_seller_country == "on")}
            <tr>
                <th>Location</th>
                <td>
                    {if $user->bidder_seller_city == "on"}{$seller->city}, {/if}
                    {if $user->bidder_seller_city == "on"}{$seller->state}, {/if}
                    {if $user->bidder_seller_city == "on"}{$seller->country}.{/if}
                </td>
            </tr>
        {/if}
        </table>
        {if $BIDDER_ITEM_DESCRIPTION == "on"}
            <hr />
            <h2 style="background-color:#DDDDFF">Description</h2>
            <textarea name="description" rows="20" cols="80">{$item->description|stripslashes}</textarea>
        {/if}
        <input type="submit" name="action" value="Update" />
        </form>

    {/if}
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