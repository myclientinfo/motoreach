{* Smarty *}

{include file="auction_header_inner.tpl" title="$COMPANY_NAME :: Silent Auction -- Place a Bid"}
{include file="auction_menu.tpl}
<div id="pagebody" class="wide">
	<div id="grayborder">
	</div>
	<div id="leftstatic">
	{include file="auction_sidebar.tpl"}
	<div id="contents" class="wide">
		<span id="loggedin" >		
			{if $authorised == "valid"}
				You are logged in as {$user->fullname}
			{else}	
				You are not <a href="login.php">logged in</a>	
			{/if}
		</span>
		<h1>Placing a Bid</h1>
		<p id="breadcrumb"><a href="index.php">Silent Auction</a> :: 
			<a href="categories.php?categoryID={$category->ID}">{$category->name}</a> ::
			<a href="items.php?itemID={$item->ID}">{$item->name}</a></p>
			
		{if ($authorised == "valid") AND ($submitted == FALSE) AND ($itemokay == true)}
		
			<p>Please review and confirm your bid.</p>
			
			<p id="message">{$message}</p>
			
			<form name="placebid" method="post" action="placebid.php">
			<input type="hidden" name="itemID" value="{$item->ID}" />
			<!-- <input type="hidden" name="debug" value="1" /> -->
			<input type="hidden" name="formdata" value="bid" />
			<table>
				<tr><th width="120px">Current price</th><td>{curr}{$item->getCurrentPrice()}{/curr}</td></tr>
				<tr><th width="120px">Your bid</th><td><b>{curr}{$bidamount}{/curr}</b></td></tr>
				<tr>
					<td colspan="2">
						By clicking on the button below, you commit to buy this item from {$COMPANY_NAME} if you're the winning bidder.<br /><br />
						To leave this page without placing a bid, return to the <a href="items.php?itemID={$item->ID}">{$item->name}</a> item listing page or navigate to another page on the site.<br /><br />
						<input type="submit" value="Confirm Bid" />
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<b>You are agreeing to a contract</b> -- You will enter into a legally binding contract 
						to purchase the item from {$COMPANY_NAME} if you're the winning bidder. 
						You are responsible for reading the full item listing, including Operation USA's 
						instructions and accepted payment methods. {$COMPANY_NAME} assumes all responsibility 
						for listing this item.
					</td>
				</tr>
			</table>
		{elseif $submitted == TRUE}
			<p id="message">{$message}</p>
			<p>Please do NOT refresh this page, or your bid will be duplicated.</p>
			<p>You are welcome to continue browsing and bidding. 
				We also invite to <a href="submititem.php">contribute</a> your own items for auction.</p>
		{elseif $itemokay == false}
			<p id="message">You cannot place a bid on an item you are selling!</p>
		{elseif $authorised != true}
			<p id="message">You cannot place a bid unless you are <a href="loging.php">logged in</a>.</p>
		{/if}					
	</div><!-- end contents -->
	{include file="auction_footer.tpl"}	
	</div><!-- end leftstatic -->
</div><!-- end pagebody -->
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