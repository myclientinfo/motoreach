{* Smarty *}
{include file="admin_header.tpl" title="$AUCTION_TITLE_AUCTION -- $ADMIN_TITLE_PANEL -- $ADMIN_TITLE_AUCTION"}

		<h1>{$AUCTION_TITLE_AUCTION} -- {$ADMIN_TITLE_PANEL} -- {$ADMIN_TITLE_AUCTION}</h1>
		{if $authorised == "admin"}
			<p>{$ADMIN_INTRO_SETTINGS}</p>
			<p id="message">{$message}</p>
			<form name="settings" method="post" action="admin_auction.php">
			<input type="hidden" name="formdata" value="update" />
			<!--<input type="hidden" name="debug" value="1" />-->
			<!-- OTHER SETTINGS -->
			<table style="float:left" summary="{$AUCTION_LABEL_SETTINGS}">
				<caption>{$AUCTION_LABEL_SETTINGS}</caption>
				<tr><th>{$AUCTION_LABEL_NAME}</th><th>{$AUCTION_LABEL_VALUES}</th><th>{$AUCTION_LABEL_INFO}</th></tr>
				
				<tr style="background-color:{cycle values="#eeeeee,#d0d0d0"}">
					<td class="name">{$ADMIN_NAME_AUCTION_TYPE}</td>
					<td class="options">						
						<input type="radio" {if $AUCTION_TYPE == "regular"}checked="checked" {/if} name="AUCTION_TYPE" value="regular" /> 
						{$AUCTION_LABEL_REGULAR}<br />
						<input type="radio" {if $AUCTION_TYPE == "oneseller"}checked="checked" {/if} name="AUCTION_TYPE" value="oneseller" /> 
						{$AUCTION_LABEL_ONESELLER}
					</td>
					<td>{$ADMIN_INFO_AUCTION_TYPE}</td>
				</tr>
				
				<tr style="background-color:{cycle values="#eeeeee,#d0d0d0"}">
					<td class="name">{$ADMIN_NAME_AUCTION_LOCALE}</td>
					<td class="value">
						<input size="5" maxlength="5" type="text" name="LOCALE"
							{if $error_field == "LOCALE"}class="error"{/if} 
							value="{$LOCALE}" />
					</td>
					<td>{$ADMIN_INFO_AUCTION_LOCALE}</td>
				</tr>
				
				<tr style="background-color:{cycle values="#eeeeee,#d0d0d0"}">
					<td class="name">{$ADMIN_NAME_AUCTION_RESERVE}</td>
					<td class="options">						
						<input type="radio" {if $RESERVE == "on"}checked="checked" {/if} name="RESERVE" value="on" /> 
						{$AUCTION_LABEL_ON}<br />
						<input type="radio" {if $RESERVE == "off"}checked="checked" {/if} name="RESERVE" value="off" /> 
						{$AUCTION_LABEL_OFF}
					</td>
					<td>{$ADMIN_INFO_AUCTION_RESERVE}</td>
				</tr>
				
				<tr style="background-color:{cycle values="#eeeeee,#d0d0d0"}">
					<td class="name">{$ADMIN_NAME_AUCTION_INCREMENT_TYPE}</td>
					<td class="options">						
						<input type="radio" {if $INCREMENT_TYPE == "auction"}checked="checked" {/if} name="INCREMENT_TYPE" value="auction" /> 
						{$AUCTION_LABEL_AUCTION}<br />
						<input type="radio" {if $INCREMENT_TYPE == "seller"}checked="checked" {/if} name="INCREMENT_TYPE" value="seller" /> 
						{$AUCTION_LABEL_SELLER}<br />
						<input type="radio" {if $INCREMENT_TYPE == "proportion"}checked="checked" {/if} name="INCREMENT_TYPE" value="proportion" /> 
						{$AUCTION_LABEL_PROPORTION}
					</td>
					<td>{$ADMIN_INFO_AUCTION_INCREMENT_TYPE}</td>
				</tr>
				
				<tr style="background-color:{cycle values="#eeeeee,#d0d0d0"}">
					<td class="name">{$ADMIN_NAME_AUCTION_INCREMENT_VALUE}</td>
					<td class="value">
						<input size="4" maxlength="4" type="text" name="INCREMENT_VALUE" 
							{if $error_field == "INCREMENT_VALUE"}class="error"{/if}
							value="{$INCREMENT_VALUE}" />							
					</td>
					<td>{$ADMIN_INFO_AUCTION_INCREMENT_VALUE}</td>
				</tr>
				
				<tr style="background-color:{cycle values="#eeeeee,#d0d0d0"}">
					<td class="name">{$ADMIN_NAME_AUCTION_INCREMENT_MIN}</td>
					<td class="value">
						<input size="4" maxlength="4" type="text" name="INCREMENT_MIN" 
							{if $error_field == "INCREMENT_MIN"}class="error"{/if}
							value="{$INCREMENT_MIN}" />
					</td>
					<td>{$ADMIN_INFO_AUCTION_INCREMENT_MIN}</td>
				</tr>
				
				<tr style="background-color:{cycle values="#eeeeee,#d0d0d0"}">
					<td class="name">{$ADMIN_NAME_AUCTION_INCREMENT_MAX}</td>
					<td class="value">
						<input size="4" maxlength="4" type="text" name="INCREMENT_MAX" 
							{if $error_field == "INCREMENT_MAX"}class="error"{/if}
							value="{$INCREMENT_MAX}" />
					</td>
					<td>{$ADMIN_INFO_AUCTION_INCREMENT_MAX}</td>
				</tr>
				
				<tr style="background-color:{cycle values="#eeeeee,#d0d0d0"}">
					<td class="name">{$ADMIN_NAME_AUCTION_INCREMENT_PROPORTION}</td>
					<td class="value">
						<input size="3" maxlength="3" type="text" name="INCREMENT_PROPORTION"
							{if $error_field == "INCREMENT_PROPORTION"}class="error"{/if} 
							value="{$INCREMENT_PROPORTION}" />
					</td>
                <td>{$ADMIN_INFO_AUCTION_INCREMENT_PROPORTION}</td>
				</tr>
            <tr><td colspan="3"><input type="submit" value="Update Settings" /></td></tr>
			</table>
        
			<table style="float:left; margin-right:40px" summary="{$AUCTION_LABEL_SWITCHES}">
				<caption>{$AUCTION_LABEL_INFO_BIDDERS}</caption>
				<!-- INFO DISPLAYED TO BIDDERS -->
				<tr><th>{$AUCTION_LABEL_NAME}</th><th>{$AUCTION_LABEL_OPTIONS}</th></tr>				
				<tr style="background-color:{cycle values="#eeeeee,#d0d0d0"}">
					<td class="name">{$ADMIN_NAME_BIDDER_SELLER_INFO}</td>
					<td class="options">						 
						<input type="radio" {if $BIDDER_SELLER_INFO == "on"}checked="checked" {/if} name="BIDDER_SELLER_INFO" value="on" /> 
						{$AUCTION_LABEL_ON}<br />
						<input type="radio" {if $BIDDER_SELLER_INFO == "off"}checked="checked" {/if} name="BIDDER_SELLER_INFO" value="off" />						
						{$AUCTION_LABEL_OFF} 
					</td>
                <td>{$ADMIN_INFO_BIDDER_SELLER_INFO}</td>				
				</tr>
            <tr style="background-color:{cycle values="#eeeeee,#d0d0d0"}">
					<td class="name">{$ADMIN_NAME_BIDDER_SELLER_FULLNAME}</td>
					<td class="options">						 
						<input type="radio" {if $BIDDER_SELLER_FULLNAME == "on"}checked="checked" {/if} name="BIDDER_SELLER_FULLNAME" value="on" /> 
						{$AUCTION_LABEL_ON}<br />
						<input type="radio" {if $BIDDER_SELLER_FULLNAME == "off"}checked="checked" {/if} name="BIDDER_SELLER_FULLNAME" value="off" />						
						{$AUCTION_LABEL_OFF} 
					</td>					
				</tr>
            <tr style="background-color:{cycle values="#eeeeee,#d0d0d0"}">
					<td class="name">{$ADMIN_NAME_BIDDER_SELLER_ALIAS}</td>
					<td class="options">						 
						<input type="radio" {if $BIDDER_SELLER_ALIAS == "on"}checked="checked" {/if} name="BIDDER_SELLER_ALIAS" value="on" /> 
						{$AUCTION_LABEL_ON}<br />
						<input type="radio" {if $BIDDER_SELLER_ALIAS == "off"}checked="checked" {/if} name="BIDDER_SELLER_ALIAS" value="off" />						
						{$AUCTION_LABEL_OFF} 
					</td>					
				</tr>
				<tr style="background-color:{cycle values="#eeeeee,#d0d0d0"}">
					<td class="name">{$ADMIN_NAME_BIDDER_SELLER_EMAIL}</td>
					<td class="options">						 
						<input type="radio" {if $BIDDER_SELLER_EMAIL == "on"}checked="checked" {/if} name="BIDDER_SELLER_EMAIL" value="on" /> 
						{$AUCTION_LABEL_ON}<br />
						<input type="radio" {if $BIDDER_SELLER_EMAIL == "off"}checked="checked" {/if} name="BIDDER_SELLER_EMAIL" value="off" />						
						{$AUCTION_LABEL_OFF} 
					</td>					
				</tr>
            <tr style="background-color:{cycle values="#eeeeee,#d0d0d0"}">
					<td class="name">{$ADMIN_NAME_BIDDER_SELLER_PHONE}</td>
					<td class="options">						 
						<input type="radio" {if $BIDDER_SELLER_PHONE == "on"}checked="checked" {/if} name="BIDDER_SELLER_PHONE" value="on" /> 
						{$AUCTION_LABEL_ON}<br />
						<input type="radio" {if $BIDDER_SELLER_PHONE == "off"}checked="checked" {/if} name="BIDDER_SELLER_PHONE" value="off" />						
						{$AUCTION_LABEL_OFF} 
					</td>					
				</tr>            
            <tr style="background-color:{cycle values="#eeeeee,#d0d0d0"}">
					<td class="name">{$ADMIN_NAME_BIDDER_SELLER_STREETADDRESS}</td>
					<td class="options">						
						<input type="radio" {if $BIDDER_SELLER_STREETADDRESS == "on"}checked="checked" {/if} name="BIDDER_SELLER_STREETADDRESS" value="on" /> 
						{$AUCTION_LABEL_ON}<br />
						<input type="radio" {if $BIDDER_SELLER_STREETADDRESS == "off"}checked="checked" {/if} name="BIDDER_SELLER_STREETADDRESS" value="off" />						
						{$AUCTION_LABEL_OFF} 
					</td>					
				</tr>
            <tr style="background-color:{cycle values="#eeeeee,#d0d0d0"}">
					<td class="name">{$ADMIN_NAME_BIDDER_SELLER_CITY}</td>
					<td class="options">						 
						<input type="radio" {if $BIDDER_SELLER_CITY == "on"}checked="checked" {/if} name="BIDDER_SELLER_CITY" value="on" /> 
						{$AUCTION_LABEL_ON}<br />
						<input type="radio" {if $BIDDER_SELLER_CITY == "off"}checked="checked" {/if} name="BIDDER_SELLER_CITY" value="off" />						
						{$AUCTION_LABEL_OFF} 
					</td>					
				</tr>
            <tr style="background-color:{cycle values="#eeeeee,#d0d0d0"}">
					<td class="name">{$ADMIN_NAME_BIDDER_SELLER_STATE}</td>
					<td class="options">						 
						<input type="radio" {if $BIDDER_SELLER_STATE == "on"}checked="checked" {/if} name="BIDDER_SELLER_STATE" value="on" /> 
						{$AUCTION_LABEL_ON}<br />
						<input type="radio" {if $BIDDER_SELLER_STATE == "off"}checked="checked" {/if} name="BIDDER_SELLER_STATE" value="off" />						
						{$AUCTION_LABEL_OFF} 
					</td>					
				</tr>
            <tr style="background-color:{cycle values="#eeeeee,#d0d0d0"}">
					<td class="name">{$ADMIN_NAME_BIDDER_SELLER_ZIP}</td>
					<td class="options">						 
						<input type="radio" {if $BIDDER_SELLER_ZIP == "on"}checked="checked" {/if} name="BIDDER_SELLER_ZIP" value="on" /> 
						{$AUCTION_LABEL_ON}<br />
						<input type="radio" {if $BIDDER_SELLER_ZIP == "off"}checked="checked" {/if} name="BIDDER_SELLER_ZIP" value="off" />						
						{$AUCTION_LABEL_OFF} 
					</td>					
				</tr>
            <tr style="background-color:{cycle values="#eeeeee,#d0d0d0"}">
					<td class="name">{$ADMIN_NAME_BIDDER_SELLER_COUNTRY}</td>
					<td class="options">						 
						<input type="radio" {if $BIDDER_SELLER_COUNTRY == "on"}checked="checked" {/if} name="BIDDER_SELLER_COUNTRY" value="on" /> 
						{$AUCTION_LABEL_ON}<br />
						<input type="radio" {if $BIDDER_SELLER_COUNTRY == "off"}checked="checked" {/if} name="BIDDER_SELLER_COUNTRY" value="off" />						
						{$AUCTION_LABEL_OFF} 
					</td>					
				</tr>
            <tr><td colspan="3"><hr /></td></tr>
				<tr style="background-color:{cycle values="#eeeeee,#d0d0d0"}">
					<td class="name">{$ADMIN_NAME_BIDDER_ITEM_STARTPRICE}</td>
					<td class="options">						
						<input type="radio" {if $BIDDER_ITEM_STARTPRICE == "on"}checked="checked" {/if} name="BIDDER_ITEM_STARTPRICE" value="on" /> 
						{$AUCTION_LABEL_ON}<br />  
						<input type="radio" {if $BIDDER_ITEM_STARTPRICE == "off"}checked="checked" {/if} name="BIDDER_ITEM_STARTPRICE" value="off" />						
						{$AUCTION_LABEL_OFF}
					</td>
				</tr>
				<tr style="background-color:{cycle values="#eeeeee,#d0d0d0"}">
					<td class="name">{$ADMIN_NAME_BIDDER_ITEM_CURRENTPRICE}</td>
					<td class="options">						
						<input type="radio" {if $BIDDER_ITEM_CURRENTPRICE == "on"}checked="checked" {/if} name="BIDDER_ITEM_CURRENTPRICE" value="on" /> 
						{$AUCTION_LABEL_ON}<br /> 
						<input type="radio" {if $BIDDER_ITEM_CURRENTPRICE == "off"}checked="checked" {/if} name="BIDDER_ITEM_CURRENTPRICE" value="off" />						
						{$AUCTION_LABEL_OFF}
					</td>
				</tr>
				<tr style="background-color:{cycle values="#eeeeee,#d0d0d0"}">
					<td class="name">{$ADMIN_NAME_BIDDER_ITEM_BIDS}</td>
					<td class="options">						 
						<input type="radio" {if $BIDDER_ITEM_BIDS == "on"}checked="checked" {/if} name="BIDDER_ITEM_BIDS" value="on" /> 
						{$AUCTION_LABEL_ON}<br />
						<input type="radio" {if $BIDDER_ITEM_BIDS == "off"}checked="checked" {/if} name="BIDDER_ITEM_BIDS" value="off" />						
						{$AUCTION_LABEL_OFF} 
					</td>
				</tr>
				<tr style="background-color:{cycle values="#eeeeee,#d0d0d0"}">
					<td class="name">{$ADMIN_NAME_BIDDER_ITEM_RESERVE}</td>
					<td class="options">						 
						<input type="radio" {if $BIDDER_ITEM_RESERVE == "on"}checked="checked" {/if} name="BIDDER_ITEM_RESERVE" value="on" /> 
						{$AUCTION_LABEL_ON}<br />
						<input type="radio" {if $BIDDER_ITEM_RESERVE == "off"}checked="checked" {/if} name="BIDDER_ITEM_RESERVE" value="off" />						
						{$AUCTION_LABEL_OFF} 
					</td>
				</tr>
				<tr style="background-color:{cycle values="#eeeeee,#d0d0d0"}">
					<td class="name">{$ADMIN_NAME_BIDDER_ITEM_INCREMENT}</td>
					<td class="options">						
						<input type="radio" {if $BIDDER_ITEM_INCREMENT == "on"}checked="checked" {/if} name="BIDDER_ITEM_INCREMENT" value="on" /> 
						{$AUCTION_LABEL_ON}<br />  
						<input type="radio" {if $BIDDER_ITEM_INCREMENT == "off"}checked="checked" {/if} name="BIDDER_ITEM_INCREMENT" value="off" />						
						{$AUCTION_LABEL_OFF}
					</td>
				</tr>
				<tr style="background-color:{cycle values="#eeeeee,#d0d0d0"}">
					<td class="name">{$ADMIN_NAME_BIDDER_ITEM_STARTDATE}</td>
					<td class="options">						 
						<input type="radio" {if $BIDDER_ITEM_STARTDATE == "on"}checked="checked" {/if} name="BIDDER_ITEM_STARTDATE" value="on" /> 
						{$AUCTION_LABEL_ON}<br />
						<input type="radio" {if $BIDDER_ITEM_STARTDATE == "off"}checked="checked" {/if} name="BIDDER_ITEM_STARTDATE" value="off" />						
						{$AUCTION_LABEL_OFF}
					</td>
				</tr>
            <tr style="background-color:{cycle values="#eeeeee,#d0d0d0"}">
					<td class="name">{$ADMIN_NAME_BIDDER_ITEM_ENDDATE}</td>
					<td class="options">						 
						<input type="radio" {if $BIDDER_ITEM_ENDDATE == "on"}checked="checked" {/if} name="BIDDER_ITEM_ENDDATE" value="on" /> 
						{$AUCTION_LABEL_ON}<br />
						<input type="radio" {if $BIDDER_ITEM_ENDDATE == "off"}checked="checked" {/if} name="BIDDER_ITEM_ENDDATE" value="off" />						
						{$AUCTION_LABEL_OFF}
					</td>
				</tr>
            <tr style="background-color:{cycle values="#eeeeee,#d0d0d0"}">
					<td class="name">{$ADMIN_NAME_BIDDER_ITEM_TIMELEFT}</td>
					<td class="options">						 
						<input type="radio" {if $BIDDER_ITEM_TIMELEFT == "on"}checked="checked" {/if} name="BIDDER_ITEM_TIMELEFT" value="on" /> 
						{$AUCTION_LABEL_ON}<br />
						<input type="radio" {if $BIDDER_ITEM_TIMELEFT == "off"}checked="checked" {/if} name="BIDDER_ITEM_TIMELEFT" value="off" />						
						{$AUCTION_LABEL_OFF}
					</td>
				</tr>
            <tr style="background-color:{cycle values="#eeeeee,#d0d0d0"}">
					<td class="name">{$ADMIN_NAME_BIDDER_ITEM_DESCRIPTION}</td>
					<td class="options">						 
						<input type="radio" {if $BIDDER_ITEM_DESCRIPTION == "on"}checked="checked" {/if} name="BIDDER_ITEM_DESCRIPTION" value="on" /> 
						{$AUCTION_LABEL_ON}<br />
						<input type="radio" {if $BIDDER_ITEM_DESCRIPTION == "off"}checked="checked" {/if} name="BIDDER_ITEM_DESCRIPTION" value="off" />						
						{$AUCTION_LABEL_OFF}
					</td>
				</tr>
            <tr style="background-color:{cycle values="#eeeeee,#d0d0d0"}">
					<td class="name">{$ADMIN_NAME_BIDDER_ITEM_IMAGE}</td>
					<td class="options">						 
						<input type="radio" {if $BIDDER_ITEM_IMAGE == "on"}checked="checked" {/if} name="BIDDER_ITEM_IMAGE" value="on" /> 
						{$AUCTION_LABEL_ON}<br />
						<input type="radio" {if $BIDDER_ITEM_IMAGE == "off"}checked="checked" {/if} name="BIDDER_ITEM_IMAGE" value="off" />						
						{$AUCTION_LABEL_OFF}
					</td>
				</tr>
            <tr><td colspan="2"><input type="submit" value="Update Settings" /></td></tr>
			</table>
        
			<table style="float:left; margin-left:40px" summary="{$AUCTION_LABEL_INFO_SELLERS}">
				<caption>{$AUCTION_LABEL_INFO_SELLERS}</caption>
				<!-- INFO DISPLAYED TO SELLERS -->				
				<tr><th>{$AUCTION_LABEL_NAME}</th><th>{$AUCTION_LABEL_OPTIONS}</th></tr>
				
				<tr style="background-color:{cycle values="#eeeeee,#d0d0d0"}">
					<td class="name">{$ADMIN_NAME_SELLER_BIDDER_FULLNAME}</td>
					<td class="options">						 
						<input type="radio" {if $SELLER_BIDDER_FULLNAME == "on"}checked="checked" {/if} name="SELLER_BIDDER_FULLNAME" value="on" /> 
						{$AUCTION_LABEL_ON}<br />
						<input type="radio" {if $SELLER_BIDDER_FULLNAME == "off"}checked="checked" {/if} name="SELLER_BIDDER_FULLNAME" value="off" />						
						{$AUCTION_LABEL_OFF} 
					</td>					
				</tr>
            <tr style="background-color:{cycle values="#eeeeee,#d0d0d0"}">
					<td class="name">{$ADMIN_NAME_SELLER_BIDDER_ALIAS}</td>
					<td class="options">						 
						<input type="radio" {if $SELLER_BIDDER_ALIAS == "on"}checked="checked" {/if} name="SELLER_BIDDER_ALIAS" value="on" /> 
						{$AUCTION_LABEL_ON}<br />
						<input type="radio" {if $SELLER_BIDDER_ALIAS == "off"}checked="checked" {/if} name="SELLER_BIDDER_ALIAS" value="off" />						
						{$AUCTION_LABEL_OFF} 
					</td>					
				</tr>
				<tr style="background-color:{cycle values="#eeeeee,#d0d0d0"}">
					<td class="name">{$ADMIN_NAME_SELLER_BIDDER_EMAIL}</td>
					<td class="options">						 
						<input type="radio" {if $SELLER_BIDDER_EMAIL == "on"}checked="checked" {/if} name="SELLER_BIDDER_EMAIL" value="on" /> 
						{$AUCTION_LABEL_ON}<br />
						<input type="radio" {if $SELLER_BIDDER_EMAIL == "off"}checked="checked" {/if} name="SELLER_BIDDER_EMAIL" value="off" />						
						{$AUCTION_LABEL_OFF} 
					</td>					
				</tr>
            <tr style="background-color:{cycle values="#eeeeee,#d0d0d0"}">
					<td class="name">{$ADMIN_NAME_SELLER_BIDDER_PHONE}</td>
					<td class="options">						 
						<input type="radio" {if $SELLER_BIDDER_PHONE == "on"}checked="checked" {/if} name="SELLER_BIDDER_PHONE" value="on" /> 
						{$AUCTION_LABEL_ON}<br />
						<input type="radio" {if $SELLER_BIDDER_PHONE == "off"}checked="checked" {/if} name="SELLER_BIDDER_PHONE" value="off" />						
						{$AUCTION_LABEL_OFF} 
					</td>					
				</tr>            
            <tr style="background-color:{cycle values="#eeeeee,#d0d0d0"}">
					<td class="name">{$ADMIN_NAME_SELLER_BIDDER_STREETADDRESS}</td>
					<td class="options">						
						<input type="radio" {if $SELLER_BIDDER_STREETADDRESS == "on"}checked="checked" {/if} name="SELLER_BIDDER_STREETADDRESS" value="on" /> 
						{$AUCTION_LABEL_ON}<br />
						<input type="radio" {if $SELLER_BIDDER_STREETADDRESS == "off"}checked="checked" {/if} name="SELLER_BIDDER_STREETADDRESS" value="off" />						
						{$AUCTION_LABEL_OFF} 
					</td>					
				</tr>
            <tr style="background-color:{cycle values="#eeeeee,#d0d0d0"}">
					<td class="name">{$ADMIN_NAME_SELLER_BIDDER_CITY}</td>
					<td class="options">						 
						<input type="radio" {if $SELLER_BIDDER_CITY == "on"}checked="checked" {/if} name="SELLER_BIDDER_CITY" value="on" /> 
						{$AUCTION_LABEL_ON}<br />
						<input type="radio" {if $SELLER_BIDDER_CITY == "off"}checked="checked" {/if} name="SELLER_BIDDER_CITY" value="off" />						
						{$AUCTION_LABEL_OFF} 
					</td>					
				</tr>
            <tr style="background-color:{cycle values="#eeeeee,#d0d0d0"}">
					<td class="name">{$ADMIN_NAME_SELLER_BIDDER_STATE}</td>
					<td class="options">						 
						<input type="radio" {if $SELLER_BIDDER_STATE == "on"}checked="checked" {/if} name="SELLER_BIDDER_STATE" value="on" /> 
						{$AUCTION_LABEL_ON}<br />
						<input type="radio" {if $SELLER_BIDDER_STATE == "off"}checked="checked" {/if} name="SELLER_BIDDER_STATE" value="off" />						
						{$AUCTION_LABEL_OFF} 
					</td>					
				</tr>
            <tr style="background-color:{cycle values="#eeeeee,#d0d0d0"}">
					<td class="name">{$ADMIN_NAME_SELLER_BIDDER_ZIP}</td>
					<td class="options">						 
						<input type="radio" {if $SELLER_BIDDER_ZIP == "on"}checked="checked" {/if} name="SELLER_BIDDER_ZIP" value="on" /> 
						{$AUCTION_LABEL_ON}<br />
						<input type="radio" {if $SELLER_BIDDER_ZIP == "off"}checked="checked" {/if} name="SELLER_BIDDER_ZIP" value="off" />						
						{$AUCTION_LABEL_OFF} 
					</td>					
				</tr>
            <tr style="background-color:{cycle values="#eeeeee,#d0d0d0"}">
					<td class="name">{$ADMIN_NAME_SELLER_BIDDER_COUNTRY}</td>
					<td class="options">						 
						<input type="radio" {if $SELLER_BIDDER_COUNTRY == "on"}checked="checked" {/if} name="SELLER_BIDDER_COUNTRY" value="on" /> 
						{$AUCTION_LABEL_ON}<br />
						<input type="radio" {if $SELLER_BIDDER_COUNTRY == "off"}checked="checked" {/if} name="SELLER_BIDDER_COUNTRY" value="off" />						
						{$AUCTION_LABEL_OFF} 
					</td>
				</tr>
            <tr><td colspan="3"><hr /></td></tr>
				<tr style="background-color:{cycle values="#eeeeee,#d0d0d0"}">
					<td class="name">{$ADMIN_NAME_SELLER_ITEM_CURRENTPRICE}</td>
					<td class="options">						 
						<input type="radio" {if $SELLER_ITEM_CURRENTPRICE == "on"}checked="checked" {/if} name="SELLER_ITEM_CURRENTPRICE" value="on" /> 
						{$AUCTION_LABEL_ON}<br /> 
						<input type="radio" {if $SELLER_ITEM_CURRENTPRICE == "off"}checked="checked" {/if} name="SELLER_ITEM_CURRENTPRICE" value="off" />						
						{$AUCTION_LABEL_OFF}
					</td>
				</tr>
				<tr style="background-color:{cycle values="#eeeeee,#d0d0d0"}">
					<td class="name">{$ADMIN_NAME_SELLER_ITEM_BIDS}</td>
					<td class="options">						
						<input type="radio" {if $SELLER_ITEM_BIDS == "on"}checked="checked" {/if} name="SELLER_ITEM_BIDS" value="on" /> 
						{$AUCTION_LABEL_ON}<br />
						<input type="radio" {if $SELLER_ITEM_BIDS == "off"}checked="checked" {/if} name="SELLER_ITEM_BIDS" value="off" />						
						{$AUCTION_LABEL_OFF}
					</td>
				</tr>				
				<tr style="background-color:{cycle values="#eeeeee,#d0d0d0"}">
					<td class="name">{$ADMIN_NAME_SELLER_ITEM_INCREMENT}</td>
					<td class="options">						 
						<input type="radio" {if $SELLER_ITEM_INCREMENT == "on"}checked="checked" {/if} name="SELLER_ITEM_INCREMENT" value="on" /> 
						{$AUCTION_LABEL_ON}<br /> 
						<input type="radio" {if $SELLER_ITEM_INCREMENT == "off"}checked="checked" {/if} name="SELLER_ITEM_INCREMENT" value="off" />						
						{$AUCTION_LABEL_OFF}
					</td>
				</tr>
				<tr style="background-color:{cycle values="#eeeeee,#d0d0d0"}">
					<td class="name">{$ADMIN_NAME_SELLER_ITEM_WINNER}</td>
					<td class="options">						 
						<input type="radio" {if $SELLER_ITEM_WINNER == "on"}checked="checked" {/if} name="SELLER_ITEM_WINNER" value="on" /> 
						{$AUCTION_LABEL_ON}<br /> 
						<input type="radio" {if $SELLER_ITEM_WINNER == "off"}checked="checked" {/if} name="SELLER_ITEM_WINNER" value="off" />						
						{$AUCTION_LABEL_OFF}
					</td>
				</tr>
            <tr><td colspan="2"><input type="submit" value="Update Settings" /></td></tr>
			</table>
        
			</form>
		{else}
			<p>{$ADMIN_NOT_LOGGED_IN}</p>	
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