{* Smarty *}

{include file="auction_header_inner.tpl" title="$COMPANY_NAME :: Silent Auction -- Items"}
{include file="auction_menu_inner.tpl}
<div id="pagebody">
    
    <div id="leftstatic">
    {include file="auction_sidebar_inner.tpl"}
    <div id="contents">
    <span id="loggedin" >		
        {if $authorised == "valid"}
            You are logged in as {$user->fullname}
        {else}
            You are not <a href="login.php">logged in</a>	
        {/if}
    </span>
    <h1>Items</h1>
    <p id="breadcrumb"><a href="index.php">Silent Auction</a>
        :: <a href="categories.php?categoryID=0">All items</a>
        :: <a href="categories.php?categoryID={$category->ID}">{$category->name}</a></p>

    {if $message}<p id="message">{$message}</p>{/if}
    {if $message != $AUCTION_NO_ITEM_FOUND}
        <h2>{$item->name}</h2>
        <form name="item" method="post" action="placebid.php">
        <input type="hidden" name="itemID" value="{$item->ID}" />
        <table summary="Item Details">                
        <tr>            
            <td rowspan="9">{if $BIDDER_ITEM_IMAGE == "on"}<img alt="Image of {$item->name}" src="{$item->image}" />{/if}</td>        
        {if $BIDDER_ITEM_STARTPRICE == "on"}    
            <th>Starting Price</th>
            <td>{curr}{$item->startprice}{/curr}</td>
        {/if}
        </tr>
        {if $BIDDER_ITEM_CURRENTPRICE == "on"}
        <tr>
            <th>Current Price</th>
            <td>{curr}{$item->getCurrentPrice()}{/curr}</td>
        </tr>
        {/if}

            {if $itemokay AND ($authorised == "valid")}
        <tr>
            <td>
                <input type="submit" value="Place bid >" />
            </td>
        </tr>
            {elseif $authorised != "valid"}
        <tr>
            <td>
                <a href="login.php{if $calling_page}?ref={$calling_page}{/if}">Login to bid</a>
            </td>
        </tr>
            {/if}

        {if $BIDDER_ITEM_BIDS == "on"}
        <tr>
            <th>Number of bids</th>
            <td>{$item->getNumberOfBids()}</td>
        </tr>
        {/if}

        {if $BIDDER_ITEM_INCREMENT == "on"}
        <tr>
            <th>Bid Increments</th>
            <td>{curr}{$item->increment}{/curr}</td>
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
                <th>Start Date</th>
                <td>{$item->dateentered|date_format}</td>
            </tr>
        {/if}
        
        {if $BIDDER_SELLER_INFO == "on"}
            <tr>
                <th>Seller</th>
                <td><a href="seller.php?categoryID={$category->ID}&itemID={$item->ID}&userID={$seller->ID}">{$seller->alias}</a></td>
            </tr>
        {/if}
        
        {if ($user->BIDDER_SELLER_CITY == "on") or ($user->bidder_seller_state == "on") or ($user->bidder_seller_country == "on")}
            <tr>
                <th>Location</th>
                <td>
                    {if $user->bidder_seller_city == "on"}{$seller->city}, {/if}
                    {if $user->bidder_seller_city == "on"}{$seller->state}, {/if}
                    {if $user->bidder_seller_city == "on"}{$seller->country}.{/if}
                </td>
            </tr>
        {/if}
        
        <tr>        
            {if $item->processed == "yes" AND !$no_winner}
                <th>Winner</th>
                <td>{$winning_user->fullname}</td>
            {elseif $no_winner}
                <th>Winner</th>
                <td>{$no_winner}</td>
            {else}
                {if $item->winning}
                    <td colspan="2">You are winning this item!</td>
                {/if}
            {/if}
        </tr>
        
        {if $BIDDER_ITEM_IMAGE == "on"}
            <tr>
                <td><a href="{$item->image}">Larger picture</a></td>
            </tr>
        {/if}
        </table>

        {if $BIDDER_ITEM_DESCRIPTION == "on"}
            <hr />
            <h2 style="background-color:#DDDDFF">Description</h2>
            {$item->description}
        {/if}
        </form>
		
		{* Need to check auction config before displaying bidding history *}
		<hr />
        <h2 style="background-color:#DDDDFF">Bidding History</h2>

		{* If the $bid_history variable is set, then display the bidding history in an ordered list. *}
		{if $bid_history}
		<ol>
		{foreach from=$bid_history item=specific_bid}
			<li><a href="bidder.php?categoryID={$category->ID}&itemID={$item->ID}&userID={$specific_bid.bid->userID}">{$specific_bid.user->fullname}</a>
			bid on {$specific_bid.bid->datesubmitted|date_format}</li>
		{/foreach}
		</ol>
		{/if}
		
		{* If the $bid_history_error variable is set, then there is an error message.  Display it next to a bullet. *}
		{if $bid_history_error}
			<ul>
			<li>{$bid_history_error}</li>
			</ul>
		{/if}
    {/if}
    </div><!-- end contents -->
    	
    </div><!-- end leftstatic -->	
</div><!-- end pagebody -->
{include file="auction_footer_inner.tpl"}
</body>
</html>
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