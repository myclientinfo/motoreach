{* Smarty *}
{include file="auction_header.tpl" title="$COMPANY_NAME :: Silent Auction -- Home"}

<div id="container">
{include file="auction_menu.tpl"}

<div id="rightstatic">
</div><!-- close rightstatic -->  
	<div id="pagebody">
		
		<div id="leftstatic">
			{include file="auction_sidebar.tpl"}
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
				<p>
					{* EDIT THIS TEXT *}
                Welcome to {$COMPANY_NAME}'s Silent Auction site.  
					Here you can contribute to many great relief efforts
					throughout the world by donating items to the auction, or
					by placing bids on the items.  All proceeds will go to 
					aiding the poor, the homeless, and the suffering.
				</p>

				<p id="message">{$message}</p>
				<div id="start">					
					<div class="button">
						<a href="categories.php?categoryID=0">view items</a>
					</div><!-- close button -->
					<img alt="Picture of wheat crops" src="img/crops.jpg" />
				</div><!-- close start -->
			</div><!-- end contents -->
			
		</div><!-- end leftstatic -->
{include file="auction_footer.tpl"}
<div class="clearer">&nbsp;</div>		
	</div><!-- end pagebody -->
</div><!-- end container -->
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