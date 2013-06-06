{* Smarty *}

{include file="auction_header_inner.tpl" title="$COMPANY_NAME :: Silent Auction -- Register"}
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
		<h2>Silent Auction -- Registration</h2>
		{if $authorised == "valid"}
			<p>You have now been registered, and you are logged in as {$user->fullname}.</p>	
		{else}
			<p class="nobold">This is registration form which will allow you to create an account with us, submit items for sale
			and purchase items on auction. Please read the <a href="terms.php">terms and conditions</a> carefully,
			as well as the <a href="privacy.php">Privacy Statement</a> before going any further. You are held 
			responsible for your knowledge of these terms, and we will expect you to abide by them from the moment 
			your account is created.</p>
			
			<p id="message">{$message}</p>
			<p>Please note that all fields are required.</p>
			
			<form name="newuser" action="register.php" method="post">
			<input type="hidden" name="formdata" value="register" />
			<table>
				<tr>
					<th>Full Name</th>
					<td>
						<input {if $error_field == "fullname"}class="error"{/if} type="text" name="fullname" value="{$session.fullname}" />
					</td>
				</tr>
				<tr>
					<th>Alias (Username)</th>
					<td>
						<input {if $error_field == "alias"}class="error"{/if} type="text" name="alias" value="{$session.alias}" />
					</td>
				</tr>
				<tr>
					<th>Email Address</th>
					<td>
						<input {if $error_field == "email"}class="error"{/if} type="text" name="email" value="{$session.email}" />
					</td>
				</tr>
				<tr>
					<th>Password</th>
					<td>
						<input {if $error_field == "password"}class="error"{/if} type="password" name="password" value="" /> (6-15 alphanumeric characters)
					</td>
				</tr>
				<tr>
					<th>Confirm Password</th>
					<td>
						<input {if $error_field == "confirmpassword"}class="error"{/if} type="password" name="confirmpassword" value="" />
					</td>
				</tr>
				<tr>
					<th>Street Address</th>
					<td>
						<input {if $error_field == "streetaddress"}class="error"{/if} type="text" name="streetaddress" value="{$session.streetaddress}" />
					</td>
				</tr>
				<tr>
					<th>City</th>
					<td>
						<input {if $error_field == "city"}class="error"{/if} type="text" name="city" value="{$session.city}" />
					</td>
				</tr>
				<tr>
					<th>State</th>
					<td>
						<input {if $error_field == "state"}class="error"{/if} type="text" name="state" value="{$session.state}" />
					</td>
				</tr>
				<tr>
					<th>Zip Code</th>
					<td>
						<input {if $error_field == "zip"}class="error"{/if} type="text" name="zip" value="{$session.zip}" />
					</td>
				</tr>
				<tr>
					<th>Country</th>
					<td>
						<select  {if $error_field == "country"}class="error"{/if}name="country">{include file="auction_countries.tpl" country=$session.country}</select>
					</td>
				</tr>
				<tr>
					<th>Phone Number</th>
					<td>
						<input {if $error_field == "phone"}class="error"{/if} type="text" name="phone" value="{$session.phone}" />
					</td>
				</tr>
				<tr><td><input type="submit" value="Register" /></td></tr>
			</table>
			
			</form>
		{/if}
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