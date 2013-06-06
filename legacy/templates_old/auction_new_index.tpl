{* Smarty *}
{include file="new_header.tpl" title="$COMPANY_NAME :: Silent Auction -- Home"}

<div id="container">
{include file="new_menu.tpl"}

<div id="rightstatic">
</div><!-- close rightstatic -->  

	<div id="pagebody">

		<div id="grayborder">
		</div><!-- close grayborder -->	

		<div id="leftstatic">
			{include file="new_sidebar.tpl"}
			<div id="contents">

<span style="text-align: left; font-size: 85%; color:#849396; font-weight:normal; padding-left:10px; font-family: sans-serif;">		
		{if $authorised == "valid"}
			You are logged in as {$user->fullname}
		{else}	
			You are not <a href="login.php">logged in</a>	
		{/if}
	</span>
				<h1 id="auctionheader" title="{$COMPANY_NAME} Silent Auction">
					<span></span>
				</h1>
				<p>
					Welcome to {$COMPANY_NAME}'s Silent Auction site.  
					Here you can contribute to many great relief efforts
					throughout the world by donating items to the auction, or
					by placing bids on the items.  All proceeds will go to 
					aiding the poor, the homeless, and the suffering.
				</p>

				<p id="message">{$message}</p>

				<div id="start">
					This auction started {$auction->startdate|date_format}
					<div class="button">
						<a href="categories_new.php">view items</a>
					</div><!-- close button -->
					<img src="img/crops.jpg" />
				</div><!-- close start -->
			</div><!-- end contents -->
		{include file="new_footer.tpl"}
		</div><!-- end leftstatic -->		
	</div><!-- end pagebody -->
</div><!-- end container -->
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