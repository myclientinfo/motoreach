{* Smarty *}

{include file="admin_header.tpl" title="Auction -- Admin Panel -- Messages"}

		<h1>Silent Auction -- Admin -- Messages</h1>
		{if $authorised == "admin"}			
			<p>Use this form to enter new message constants into the database. By 
			default all messages are saved under the locale en_US, which is US English.
			However, you can enter messages in a different language, but you need to
			make sure that you enter the correct locale code.</p>
			{if $message}
				<p id="message">{$message}</p>
			{/if}
			
			<form name="messages" action="admin_messages.php" method="post">
			<input type="hidden" name="formdata" value="submission" />
			<!--<input type="hidden" name="debug" value="1" />-->
			<table>		
				<tr>
					<th>Locale</th>
					<td>
						<input {if $error_field == "locale"}class="error"{/if} type="text" name="locale" value="en_US" />
					</td>
				</tr>		
				<tr>
					<th>Constant</th>
					<td>
						<input size="40" {if $error_field == "constant"}class="error"{/if} type="text" name="constant" value="{$post.constant}" />
					</td>
				</tr>		
				<tr>
					<th>Message</th>
					<td>
						<textarea rows="10" cols="40" {if $error_field == "message"}class="error"{/if} name="message" value="">{$post.message}</textarea>
					</td>
				</tr>	
				<tr>
					<td><input type="submit" value="Enter Message" /></td>
				</tr>
			</table>
			</form>
			
			<p>Here you can see all the message already entered in the database, and you can edit them.</p>			
			
			<table summary="All message constants are shown here and can be edited">
				<tr>
					<th>Locale</th>
					<th>Constant</th>
					<th>Message</th>
					<th>Update</th>
					<th>Delete</th>
				</tr>
				{foreach from=$messages key=k item=v}
					<form name="edit_messages_{$k}" method="post" action="admin_messages.php">
					<input type="hidden" name="formdata" value="update" />
					<input type="hidden" name="ID" value="{$v.ID}" />
					<tr style="background-color:{cycle values="#eeeeee,#d0d0d0"}">
						<td><input type="text" size="6" name="locale" value="{$v.locale}" /></td>
						<td><input type="text" size="50" name="constant" value="{$v.constant}" /></td>
						<td><textarea cols="35" rows="4" name="message">{$v.message}</textarea></td>
						<td><input type="submit" name="action" value="update" /></td>
						<td><input type="submit" name="action" value="delete" /></td>
					</tr>
					</form>
				{/foreach} 
			</table>
		{else}
			<p>You are not logged in as an administrator. Please <a href="admin_login.php">login</a> now.</p>	
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