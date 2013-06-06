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
		<h1>Silent Auction -- My Account</h1>
		{if $authorised == "valid"}
			<p>On this page you may edit and view your user details, and view your bids and items on auction.</p>
			<p id="message">{$message}</p>
			<form name="changedetails" action="editaccount.php" method="post">
			<input type="hidden" name="formdata" value="update" />
			<input type="hidden" name="alias" value="{$user->alias}" />
			<!--<input type="hidden" name="debug" value="1" />-->
			<table>
				<caption>Your details</caption>
				<tr>
					<th>Full Name</th>
					<td>{$user->fullname}</td>
				</tr>
				<tr>
					<th>Alias</th>
					<td>{$user->alias}</td>
				</tr>
				<tr>
					<th>New Password</th>
					<td>
						<input {if $error_field == "password"}class="error"{/if} type="password" name="password" />
					</td>
				</tr>
				<tr>
					<th>Confirm New Password</th>
					<td>
						<input {if $error_field == "confirmpassword"}class="error"{/if} type="password" name="confirmpassword" />
					</td>
				</tr>
				<tr>
					<th>Street Address</th>
					<td>
						<input {if $error_field == "streetaddress"}class="error"{/if} type="text" name="streetaddress" value="{$user->streetaddress}" />
					</td>
				</tr>
				<tr>
					<th>City</th>
					<td>
						<input {if $error_field == "city"}class="error"{/if} type="text" name="city" value="{$user->city}" />
					</td>
				</tr>
				<tr>
					<th>State</th>
					<td>
						<input {if $error_field == "state"}class="error"{/if} type="text" name="state" value="{$user->state}" />
					</td>
				</tr>
				<tr>
					<th>Zip/Postal Code</th>
					<td>
						<input {if $error_field == "zip"}class="error"{/if} type="text" name="zip" value="{$user->zip}" />
					</td>
				</tr>
				<tr>
					<th>E-mail</th>
					<td>
						<input {if $error_field == "email"}class="error"{/if} size="60" type="text" name="email" value="{$user->email}" />
					</td>
				</tr>
				<tr>
					<th>Country</th>
					<td><select name="country">{include file="auction_countries.tpl" country=$user->country}</select></td>
				</tr>
				<tr>
					<th>Phone Number</th>
					<td>
						<input {if $error_field == "phone"}class="error"{/if} type="text" name="phone" value="{$user->phone}" />
					</td>
				</tr>
				<tr>
					<td><input type="submit" value="Update" /></td></tr>
			</table>
			</form>
				
			</table>
			
			<table class="items">
				<caption>Items you are bidding on (<span class="winning">winning bids</span>)</caption>
				<tr>			
					<th class="name">Name</th>
					<th>Starting Price</th>
					<th>Current Price</th>
					<th>Number of Bids</th>
					<th>Date Entered</th>
					<th>End date</th>
					<th>Time Left</th>
				</tr>
				{foreach from=$items_user_is_buying key=k item=v}
					<tr class="{if $v->winning == true}winning{else}losing{/if}">				
						<td><a href="items.php?itemID={$v->ID}">{$v->name}</a></td>
						<td>{curr}{$v->startprice}{/curr}</td>
						<td>{curr}{$v->getCurrentPrice()}{/curr}</td>
						<td>{$v->getNumberOfBids()}</td>
						<td>{$v->dateentered|date_format}</td>
						<td>{$v->auctionend|date_format}</td>
						<td>{timeleft}{$v->getSecondsLeft()}{/timeleft}</td>
					</tr>
				{/foreach}
			</table>
			<br />
			<table class="items">
				<caption>Items you are selling</caption>
				<tr>			
					<th class="name">Name</th>
					<th>Starting Price</th>
					<th>Current Price</th>
					<th>Number of Bids</th>
					<th>Date Entered</th>
					<th>End date</th>
					<th>Time Left</th>
				</tr>
				{foreach from=$items_user_is_selling key=k item=v}
					<tr>				
						<td><a href="items.php?itemID={$v->ID}">{$v->name}</a></td>
						<td>{curr}{$v->startprice}{/curr}</td>
						<td>{curr}{$v->getCurrentPrice()}{/curr}</td>
						<td>{$v->getNumberOfBids()}</td>
						<td>{$v->dateentered|date_format}</td>
						<td>{$v->auctionend|date_format}</td>
						<td>{timeleft}{$v->getSecondsLeft()}{/timeleft}</td>
					</tr>
				{/foreach}
			</table>
			<br />
			<table class="items">
				<caption>Items you have won</caption>
				<tr>			
					<th class="name">Name</th>
					<th>Final Price</th>
					<th>Number of Bids</th>
					<th>Date Won</th>			
				</tr>
				{foreach from=$items_user_has_won key=k item=v}
					<tr>				
						<td><a href="items.php?itemID={$v->ID}">{$v->name}</a></td>				
						<td>{curr}{$v->getCurrentPrice()}{/curr}</td>
						<td>{$v->getNumberOfBids()}</td>
						<td>{$v->auctionend|date_format}</td>
					</tr>
				{/foreach}
			</table>
			<br />
			<table class="items">
				<caption>Items you have lost</caption>
				<tr>			
					<th class="name">Name</th>
					<th>Final Price</th>
					<th>Number of Bids</th>
					<th>Date Ended</th>			
				</tr>
				{foreach from=$items_user_has_lost key=k item=v}
					<tr>				
						<td><a href="items.php?itemID={$v->ID}">{$v->name}</a></td>				
						<td>{curr}{$v->getCurrentPrice()}{/curr}</td>
						<td>{$v->getNumberOfBids()}</td>
						<td>{$v->auctionend|date_format}</td>
					</tr>
				{/foreach}
			</table>
			<br />
			<table class="items">
				<caption>Items you have sold</caption>
				<tr>			
					<th class="name">Name</th>
					<th>Final Price</th>
					<th>Number of Bids</th>
					<th>Date Sold</th>			
				</tr>
				{foreach from=$items_user_has_sold key=k item=v}
					<tr>				
						<td><a href="items.php?itemID={$v->ID}">{$v->name}</a></td>				
						<td>{curr}{$v->getCurrentPrice()}{/curr}</td>
						<td>{$v->getNumberOfBids()}</td>
						<td>{$v->auctionend|date_format}</td>
					</tr>
				{/foreach}
			</table>
			<br />
			<table class="items">
				<caption>Items you have not sold</caption>
				<tr>			
					<th class="name">Name</th>
					<th>Final Price</th>
					<th>Number of Bids</th>
					<th>Date Ended</th>			
				</tr>
				{foreach from=$items_user_has_not_sold key=k item=v}
					<tr>				
						<td><a href="items.php?itemID={$v->ID}">{$v->name}</a></td>				
						<td>{curr}{$v->getCurrentPrice()}{/curr}</td>
						<td>{$v->getNumberOfBids()}</td>
						<td>{$v->auctionend|date_format}</td>
					</tr>
				{/foreach}
			</table>
		{else}
			<p>Before you can use this page, you must be either <a href="login.php">logged in</a> or <a href="register.php">registered</a>.</p>
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