{* Smarty *}

{include file="auction_header_inner.tpl" title="$COMPANY_NAME :: Silent Auction -- My Account"}
{include file="auction_menu_inner.tpl}
<div id="pagebody">
	
	<div id="leftstatic">
	{include file="auction_sidebar_inner.tpl"}
	<div id="contents" class="wide"
		<span id="loggedin" >		
			{if $authorised == "valid"}
				You are logged in as {$user->fullname}
			{else}	
				You are not <a href="login.php">logged in</a>	
			{/if}
		</span>
		<h1>Silent Auction -- Submitting a new object</h1>
		{if $authorised == "valid"}
		{* Beginning of authorised Section *}
			{if $stage == "submission"}
				<p>Please enter the details of the item you want to offer for sale on this auction site.</p>
				<p id="message">{$message}</p>

				<form enctype="multipart/form-data" name="newitem" action="submititem.php" method="post">
				<input type="hidden" name="stage" value="submission" />
				<input type="hidden" name="userID" value="{$user->ID}" />
				<input type="hidden" name="ID" value="0">
				<input type="hidden" name="processed" value="no">
				<input type="hidden" name="formdata" value="submission" />
			<!--	<input type="hidden" name="debug" value="no">-->
				<table>
					<tr>
						<th>Category</th>
						<td>
							<select {if $error_field == "categoryID"}class="error"{/if} name="categoryID">
								<option value="{$listing.categoryID}">{$submit_categories[$listing.categoryID].name}</option>
							{foreach from=$submit_categories key=k item=v}
								<option value="{$k}">{$v.name}</option>
							{/foreach}
							</select>
						</td>
					</tr>
					<tr>
						<th>Name of item</th>
						<td>
							<input {if $error_field == "name"}class="error"{/if} type="text" name="name" value="{$listing.name}" />
						</td>
					</tr>
					<tr>
						<th>Image (50k max)</th>
						<td>
							<input type="hidden" name="MAX_FILE_SIZE" value="100000">
							<input {if $error_field == "image"}class="error"{/if} type="file" name="image" />
						</td>
					</tr>
					<tr>
						<th>Full description</th>
						<td>
							<textarea {if $error_field == "description"}class="error"{/if} name="description" cols="40" rows="12">{$listing.description}</textarea>
						</td>
					</tr>
					<tr>
						<th>Starting Price (in US$)</th>
						<td>
							{if $INCREMENT_TYPE == "proportion"}
                            <input {if $error_field == "startprice"}class="error"{/if} 
                                type="text" name="startprice" value="{$listing.startprice}" 
                                onchange="document.getElementById('increment').value=Math.ceil(this.value/{$INCREMENT_PROPORTION});"/>
                        {else}
                            <input {if $error_field == "startprice"}class="error"{/if} type="text" name="startprice" value="{$listing.startprice}" />
                        {/if}
						</td>
					</tr>					
                <tr>
						<th>Bid increment{if $INCREMENT_TYPE == "seller"} ({$INCREMENT_MIN} - {$INCREMENT_MAX}){/if}</th>
						<td>
							{if $INCREMENT_TYPE == "seller"}
                            <input {if $error_field == "increment"}class="error"{/if} type="text" name="increment" 
                            value="{$listing.increment}" 
                            onchange="checkIncValues(this, {$INCREMENT_MIN}, {$INCREMENT_MAX}); this.focus();" />
                        {elseif $INCREMENT_TYPE == "proportion"}                            
                            <input id="increment" type="text" readonly="readonly" name="increment" value="0" 
                            style="border:none;"/>
                        {elseif $INCREMENT_TYPE == "auction"}                            
                            <input type="text" readonly="readonly" name="increment" value="{$INCREMENT_VALUE}" 
                                style="border:none;" />
                        {/if}
						</td>
					</tr>
					{if $RESERVE == "on"}
                <tr>
						<th>Reserve Price (optional)</th>
						<td>
							<input {if $error_field == "reserve"}class="error"{/if} type="text" name="reserve" value="{$listing.reserve}" />
						</td>
					</tr>
                {/if}
					<tr>
						<th>Listing length</th>
						<td>
							<select {if $error_field == "auctionlength"}class="error"{/if} name="auctionlength">
								{if $listing.auctionlength > 0}<option selected="selected" value="{$listing.auctionlength}">{$listing.auctionlength} Days</option>{/if}
								<option value="3">3 Days</option>
								<option value="5">5 Days</option>
								<option value="7">7 Days</option>
								<option value="9">9 Days</option>
								<option value="11">11 Days</option>
							</select>
						</td>
					</tr>
					<tr>
						<td><input type="submit" value="Preview" /></td>
					</tr>
				</table>
				</form>	
			{elseif $stage == "preview"}
				<p>Here is a preview of your item listing.</p>
				<p id="message">{$message}</p>
				<h2>{$item->name}</h2>
				<form name="item" method="post" action="submititem.php">
				<input type="hidden" name="formdata" value="confirmation" />
				<input type="hidden" name="itemID" value="{$item->ID}" />
				<input type="submit" value="Confirm Listing" />
				<table summary="Item Details">
					<tr>
						<td rowspan="8"><img title="Image of {$item->name}" alt="Image of {$item->name}" src="{$item->image}" /></td>
						<th>Starting Price</th>
						<td>{curr}{$item->startprice}{/curr}</td>
					</tr>
					<tr>
						<th>Current Price</th>
						<td>{curr}{$item->getCurrentPrice()}{/curr}<br />
							<input type="submit" value="Place bid" disabled="disabled" />
						</td>
					</tr>
					<tr>
						<th>Number of bids</th>
						<td>{$item->getNumberOfBids()}</td>
					</tr>
					<tr>
						<th>Bid Increments</th>
						<td>{curr}{$item->increment}{/curr}</td>
					</tr>
					<tr>
						<th>Time left</th>
						<td>
							{timeleft}{$item->getSecondsLeft()}{/timeleft}<br />
							{$item->auctionlength}-day listing, ends {$item->auctionend|date_format:"%A, %B %e, %Y"}
						</td>
					</tr>
					<tr>
						<th>Start Date</th>
						<td>{$item->dateentered|date_format}</td>
					</tr>	
					<tr>
						<th>Location</th>
						<td>{$user->city}, {$user->state}, {$user->country}.</td>
					</tr>
					<tr>
						<td><a href="{$item->image}" target="_blank">Larger picture</a></td>
					</tr>	
				</table>
				<hr />
				<h2 style="background-color:#DDDDFF">Description</h2>
				<p>{$item->description}</p>
				<input type="submit" value="Confirm Listing" />
				</form>
			{elseif $stage == "confirmation"}
				<p id="message">{$message}</p>
			{else}
				<p id="message">There has been an error, please start the item submission process again.</p>
				<p id="message">{$message}</p>
			{/if}
			
		{* End of authorised Section *}
		{else}
			<p>Before you can submit an item for auction, you must be either <a href="login.php">logged in</a> or <a href="register.php">registered</a>.</p>
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
