{* Smarty *}

{include file="admin_header.tpl" title="Auction -- Admin Panel -- Log In"}

		<h1>Silent Auction -- Admin -- Log In</h1>
		{if $authorised == "admin"}
			{if $message}<p id="message">{$message}</p>
                        {else}You are now logged in as an administrator.  Return to the <a href="admin.php">admin panel</a> to view and edit auction settings.
                        {/if}
		{else}	
			<p>Use this form to login as an administrator.</p>
			<p id="message">{$message}</p>
			<p>Please enter your alias and password:</p>
			
			<form name="login" action="admin_login.php" method="post">
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

{include file="admin_footer.tpl"}	

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