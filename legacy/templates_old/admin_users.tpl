{* Smarty *}

{include file="admin_header.tpl" title="Auction -- Admin Panel -- Users"}

		<h1>Silent Auction -- Admin -- Users</h1>
    
		{if $authorised == "admin"}
        <p>{$message}</p>
        <table summary="users">
        <caption>Users</caption>
            <tr>
                <th>ID</th><th>Name</th><th>email</th><th>Details</th><th>Items won</th><th>Items sold</th><th>Delete</th>
            </tr>
            {foreach from=$usersArray key=k item=v}
                <tr>
                    <td>{$v.ID}</td>
                    <td>{$v.fullname}</td>
                    <td><a href="mailto:{$v.email}">{$v.email}</a></td>
                    <td>
                        <a href="seller.php?userID={$v.ID}" onMouseOver="showDetails({$v.ID})" onMouseOut="showDetails({$v.ID})"">See Details</a>
                        <div style="background-color: #DDDDFF; position:absolute; visibility: hidden;
                            margin-top: -95px; padding-left: 10px; border: 1px black solid; margin-left: 70px;" 
                            id="details{$v.ID}">
                            <b>alias: </b>{$v.alias}<br />
                            <b>address: </b>{$v.streetaddress}<br />
                            <b>city: </b>{$v.city}<br />
                            <b>state: </b>{$v.state}<br />
                            <b>zip: </b>{$v.zip}<br />
                            <b>country: </b>{$v.country}<br />
                            <b>phone: </b>{$v.phone}<br />
                        </div></td>
                    <td>
                    <ul>
                        {foreach from=$v.won key=k2 item=item}
                            <li><a href="items.php?itemID={$item->ID}">{$item->name}</a></li>
                        {/foreach}
                    </ul>    
                    </td>
                    <td>
                    <ul>
                        {foreach from=$v.sold key=k2 item=item}
                            <li><a href="items.php?itemID={$item->ID}">{$item->name}</a></li>
                        {/foreach}
                    </ul>    
                    </td>
                    <td>
                        <button type="button" onClick="window.location='admin_users.php?remove={$v.ID}'">Delete</button>
                    </td>
                </tr>
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