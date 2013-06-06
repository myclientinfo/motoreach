{* Smarty *}
{include file="auction_header.tpl" title="$COMPANY_NAME :: Silent Auction :: Search for items"}
{include file="auction_menu.tpl}

<h1>Silent Auction -- Search Results</h1>
<p>Searching for "{$searchitem}".</p>

{if $results == AUCTION_SEARCH_NO_MATCHES}
{* Need to show error message appropriately, rather than printing the string "No matches found." *}	
No matches found.{else}You might be interested in:
<br />	
	{foreach from=$results item=item}		
		{$item->name} (<a href="items.php?itemID={$item->ID}">view item</a>)<br />
	{/foreach}{/if}{include file="auction_footer.tpl"}
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