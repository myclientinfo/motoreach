{* Smarty *} 

{include file="auction_header_inner.tpl" title="$COMPANY_NAME :: Silent Auction -- Bidder Information"} 

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
    <p id="breadcrumb"><a href="index.php">Silent Auction</a>
        :: <a href="categories.php?categoryID={$category->ID}">{$category->name}</a>
        :: <a href="items.php?itemID={$item->ID}">{$item->name}</a>
        :: Bidder Info</p>
		<h2>Silent Auction -- Bidder Information</h2>
			
			<p id="message">{$message}</p>

			<table>
				{if $SELLER_BIDDER_FULLNAME == "on"}
            <tr>
					<th>Full Name</th>
					<td>{$bidder->fullname}</td>
				</tr>
            {/if}
            {if $SELLER_BIDDER_ALIAS == "on"}
				<tr>
					<th>Alias (username)</th>
					<td>{$bidder->alias}</td>
				</tr>
            {/if}
				{if $SELLER_BIDDER_STREETADDRESS == "on"}
            <tr>
					<th>Street Address</th>
					<td>{$bidder->streetaddress}</td>
				</tr>
            {/if}
            {if $SELLER_BIDDER_CITY == "on"}
            <tr>
					<th>City</th>
					<td>{$bidder->city}</td>
				</tr>
            {/if}				
            {if $SELLER_BIDDER_STATE == "on"}
            <tr>
					<th>State</th>
					<td>{$bidder->state}</td>
				</tr>
            {/if}
				{if $SELLER_BIDDER_ZIP == "on"}
            <tr>
					<th>Zip code</th>
					<td>{$bidder->zip}</td>
				</tr>
            {/if}
				{if $SELLER_BIDDER_COUNTRY == "on"}
            <tr>
					<th>Country</th>
					<td>{$bidder->country}</td>
				</tr>
            {/if}
            {if $SELLER_BIDDER_EMAIL == "on"}
            <tr>
					<th>Email</th>
					<td><a href="mailto:{$bidder->email}">{$bidder->email}</a></td>
				</tr>
            {/if}
            {if $SELLER_BIDDER_PHONE == "on"}
            <tr>
					<th>Phone number</th>
					<td>{$bidder->phone}</td>
				</tr>
            {/if}            
			</table>
			
	</div><!-- end contents -->
<div class="clearer">&nbsp;</div>	
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