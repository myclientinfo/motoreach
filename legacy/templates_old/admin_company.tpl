{* Smarty *}

{include file="admin_header.tpl" title="Auction -- Admin Panel -- Items"}

        <h1>Silent Auction -- Admin -- Company Info</h1>

        {if $authorised == "admin"}
        
        <p id="breadcrumb"><a href="admin.php">Admin Home</a>
        :: Company Info</p>
       
        <p id="message">{$message}</p>
        
        <p>Here you may edit information about your company. It is essential that
            you enter your paypal account address, otherwise bidders will not
            be able to pay for the items they win.
        </p>
        
        <form name="company_info" method="post" action="admin_company.php">
        <input type="hidden" name="formdata" value="company_info" />
        <table>
            <tr>
                <th>Company name</th><td><input type="text" name="COMPANY_NAME" value="{$COMPANY_NAME}" /></td>
            </tr>
            <tr>
                <th>Company email</th><td><input type="text" name="COMPANY_EMAIL" value="{$COMPANY_EMAIL}" /></td>
            </tr>
            <tr>
                <th>Company Paypal Address</th><td><input type="text" name="COMPANY_PAYPAL" value="{$COMPANY_PAYPAL}" /></td>
            </tr>
            <tr>
                <th>Base Auction URL</th><td><input type="text" name="COMPANY_URL" value="{$COMPANY_URL}" /></td>
            </tr>
            <tr>
                <td colspan="2"><input type="submit" value="submit" /></td>
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