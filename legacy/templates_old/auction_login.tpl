{* Smarty *}

{include file="auction_header_inner.tpl" title="$COMPANY_NAME :: Silent Auction -- Login"}
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
		<h1>Silent Auction -- Login</h1>
		{if $authorised == "valid"}
			<p>You are now logged in as {$user->fullname}.{if $calling_page}
				Return to the <a href="{$calling_page}">auction page</a> you previously visited.
			{/if}</p>	
		{else}	
			<p>Use this form to login as an existing user. Alternatively, you can <a href="register.php">register</a> as a new user.</p>
			<p id="message">{$message}</p>
			<p>Please enter your alias and password:</p>
			
			<form name="login" action="login.php{if $calling_page}?ref={$calling_page}{/if}" method="post">
			<input type="hidden" name="formdata" value="1" />
			<!--<input type="hidden" name="debug" value="1" />-->
			<table>		
				<tr>
					<th>Alias (username)</th>
					<td>
						<input {if $error_field == "alias"}class="error"{/if} type="text" name="alias" value="" />
					</td>
				</tr>		
				<tr>
					<th>Password</th>
					<td>
						<input {if $error_field == "password"}class="error"{/if} type="password" name="password" value="" />
					</td>
				</tr>		
				<tr>
					<td><input type="submit" value="Login" /></td>
				</tr>
			</table>
			</form>
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