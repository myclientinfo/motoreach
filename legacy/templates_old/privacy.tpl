{* Smarty *}

{include file="auction_header_inner.tpl" title="$COMPANY_NAME :: Silent Auction -- Privacy Policy"}
{include file="auction_menu_inner.tpl}
<div id="pagebody">
	<div id="continner">
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
		<h2>Silent Auction -- Privacy Policy</h2>
		<br /><br />
		<p><strong>We do not to give out any donor information.  We never sell or share our mailing list.  Our donors are never solicited by phone.</strong></p>
<p><strong>Please refer any questions to: {$COMPANY_EMAIL}.</strong></p>
	</div><!-- end contents -->
	<div class="clearer">&nbsp;</div>		
	</div><!-- end leftstatic -->
<div class="clearer">&nbsp;</div>	
</div><!-- end pagebody -->

{include file="auction_footer.tpl"}
</div><!-- end continner -->
</body>
</html>
{*
 * Copyright (C) 2005 Vickie Comrie, Nicolas Connault, Christopher Vance
 * 
 * Vickie Comrie: <http://www.indiconv.com>
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