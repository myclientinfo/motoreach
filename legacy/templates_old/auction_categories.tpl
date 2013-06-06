{* Smarty *}

{include file="auction_header_inner.tpl" title="$COMPANY_NAME :: Silent Auction -- Category"}
{include file="auction_menu_inner.tpl"}
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

<h1 id="auctionheader" title="{$COMPANY_NAME} Silent Auction">
					<span></span>
				</h1>

		<h2>Item Listing</h2>
		<p id="breadcrumb"><a href="index.php">Silent Auction</a>
			{if $category->ID != 0} :: <a href="categories.php?categoryID=0">All items</a>{/if}
			:: {$category->name}</p>
		
		<p>Items found in <i>{$category->name}</i>: {$numberOfItems}</p>
		<table>
			<tr>
				<th>Thumbnail</th><th>Item Name</th><th>Price</th><th>Bids</th><th>Time left</th>
			</tr>
			{if $items}
				{foreach from=$items key=k item=v}
					<tr style="background-color:{cycle values="#eeeeee,#d0d0d0"}">
						<td><img alt="Picture of {$v->name}" height="50px" width="50px" src="{$v->image}" /></td>
						<td><a href="items.php?itemID={$v->ID}">{$v->name}</a></td>
						<td>{curr}{$v->getCurrentPrice()}{/curr}</td>
						<td>{$v->getNumberOfBids()}</td>
						<td>{timeleft}{$v->getSecondsLeft()}{/timeleft}</td>
					</tr>
				{/foreach}
			{/if}
			{if $items_error}
				<tr style="background-color:#eeeeee">
					<td colspan="5"><p>{$items_error}</p></td>
				</tr>
			{/if}
		</table>						
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