<?php /* Smarty version 2.6.6, created on 2010-03-09 12:35:34
         compiled from auction_items.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('block', 'curr', 'auction_items.tpl', 32, false),array('block', 'timeleft', 'auction_items.tpl', 77, false),array('modifier', 'date_format', 'auction_items.tpl', 79, false),)), $this); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "auction_header_inner.tpl", 'smarty_include_vars' => array('title' => ($this->_tpl_vars['COMPANY_NAME'])." :: Silent Auction -- Items")));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "auction_menu_inner.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div id="pagebody">
    
    <div id="leftstatic">
    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "auction_sidebar_inner.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    <div id="contents">
    <span id="loggedin" >		
        <?php if ($this->_tpl_vars['authorised'] == 'valid'): ?>
            You are logged in as <?php echo $this->_tpl_vars['user']->fullname; ?>

        <?php else: ?>
            You are not <a href="login.php">logged in</a>	
        <?php endif; ?>
    </span>
    <h1>Items</h1>
    <p id="breadcrumb"><a href="index.php">Silent Auction</a>
        :: <a href="categories.php?categoryID=0">All items</a>
        :: <a href="categories.php?categoryID=<?php echo $this->_tpl_vars['category']->ID; ?>
"><?php echo $this->_tpl_vars['category']->name; ?>
</a></p>

    <?php if ($this->_tpl_vars['message']): ?><p id="message"><?php echo $this->_tpl_vars['message']; ?>
</p><?php endif; ?>
    <?php if ($this->_tpl_vars['message'] != $this->_tpl_vars['AUCTION_NO_ITEM_FOUND']): ?>
        <h2><?php echo $this->_tpl_vars['item']->name; ?>
</h2>
        <form name="item" method="post" action="placebid.php">
        <input type="hidden" name="itemID" value="<?php echo $this->_tpl_vars['item']->ID; ?>
" />
        <table summary="Item Details">                
        <tr>            
            <td rowspan="9"><?php if ($this->_tpl_vars['BIDDER_ITEM_IMAGE'] == 'on'): ?><img alt="Image of <?php echo $this->_tpl_vars['item']->name; ?>
" src="<?php echo $this->_tpl_vars['item']->image; ?>
" /><?php endif; ?></td>        
        <?php if ($this->_tpl_vars['BIDDER_ITEM_STARTPRICE'] == 'on'): ?>    
            <th>Starting Price</th>
            <td><?php $this->_tag_stack[] = array('curr', array()); smarty_block_curr($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start();  echo $this->_tpl_vars['item']->startprice;  $this->_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_curr($this->_tag_stack[count($this->_tag_stack)-1][1], $this->_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></td>
        <?php endif; ?>
        </tr>
        <?php if ($this->_tpl_vars['BIDDER_ITEM_CURRENTPRICE'] == 'on'): ?>
        <tr>
            <th>Current Price</th>
            <td><?php $this->_tag_stack[] = array('curr', array()); smarty_block_curr($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start();  echo $this->_tpl_vars['item']->getCurrentPrice();  $this->_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_curr($this->_tag_stack[count($this->_tag_stack)-1][1], $this->_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></td>
        </tr>
        <?php endif; ?>

            <?php if ($this->_tpl_vars['itemokay'] && ( $this->_tpl_vars['authorised'] == 'valid' )): ?>
        <tr>
            <td>
                <input type="submit" value="Place bid >" />
            </td>
        </tr>
            <?php elseif ($this->_tpl_vars['authorised'] != 'valid'): ?>
        <tr>
            <td>
                <a href="login.php<?php if ($this->_tpl_vars['calling_page']): ?>?ref=<?php echo $this->_tpl_vars['calling_page'];  endif; ?>">Login to bid</a>
            </td>
        </tr>
            <?php endif; ?>

        <?php if ($this->_tpl_vars['BIDDER_ITEM_BIDS'] == 'on'): ?>
        <tr>
            <th>Number of bids</th>
            <td><?php echo $this->_tpl_vars['item']->getNumberOfBids(); ?>
</td>
        </tr>
        <?php endif; ?>

        <?php if ($this->_tpl_vars['BIDDER_ITEM_INCREMENT'] == 'on'): ?>
        <tr>
            <th>Bid Increments</th>
            <td><?php $this->_tag_stack[] = array('curr', array()); smarty_block_curr($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start();  echo $this->_tpl_vars['item']->increment;  $this->_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_curr($this->_tag_stack[count($this->_tag_stack)-1][1], $this->_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></td>
        </tr>
        <?php endif; ?>
    
        <?php if ($this->_tpl_vars['BIDDER_ITEM_TIMELEFT'] == 'on'): ?>
        <tr>
            <th>Time left</th>
            <?php if ($this->_tpl_vars['item']->processed == 'yes'): ?>
            <td><?php echo $this->_tpl_vars['AUCTION_ITEM_EXPIRED']; ?>
</td>
            <?php else: ?>
            <td>
                <?php $this->_tag_stack[] = array('timeleft', array()); smarty_block_timeleft($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start();  echo $this->_tpl_vars['item']->getSecondsLeft();  $this->_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_timeleft($this->_tag_stack[count($this->_tag_stack)-1][1], $this->_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?><br />
                <?php echo $this->_tpl_vars['item']->auctionlength; ?>
-day listing
                <?php if ($this->_tpl_vars['BIDDER_ITEM_ENDDATE'] == 'on'): ?>, ends <?php echo ((is_array($_tmp=$this->_tpl_vars['item']->auctionend)) ? $this->_run_mod_handler('date_format', true, $_tmp, "%A, %B %e, %Y") : smarty_modifier_date_format($_tmp, "%A, %B %e, %Y"));  endif; ?>
            </td>
            <?php endif; ?>
        </tr>
        <?php endif; ?>
        
        <?php if ($this->_tpl_vars['BIDDER_ITEM_STARTDATE'] == 'on'): ?>
            <tr>
                <th>Start Date</th>
                <td><?php echo ((is_array($_tmp=$this->_tpl_vars['item']->dateentered)) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)); ?>
</td>
            </tr>
        <?php endif; ?>
        
        <?php if ($this->_tpl_vars['BIDDER_SELLER_INFO'] == 'on'): ?>
            <tr>
                <th>Seller</th>
                <td><a href="seller.php?categoryID=<?php echo $this->_tpl_vars['category']->ID; ?>
&itemID=<?php echo $this->_tpl_vars['item']->ID; ?>
&userID=<?php echo $this->_tpl_vars['seller']->ID; ?>
"><?php echo $this->_tpl_vars['seller']->alias; ?>
</a></td>
            </tr>
        <?php endif; ?>
        
        <?php if (( $this->_tpl_vars['user']->BIDDER_SELLER_CITY == 'on' ) || ( $this->_tpl_vars['user']->bidder_seller_state == 'on' ) || ( $this->_tpl_vars['user']->bidder_seller_country == 'on' )): ?>
            <tr>
                <th>Location</th>
                <td>
                    <?php if ($this->_tpl_vars['user']->bidder_seller_city == 'on'):  echo $this->_tpl_vars['seller']->city; ?>
, <?php endif; ?>
                    <?php if ($this->_tpl_vars['user']->bidder_seller_city == 'on'):  echo $this->_tpl_vars['seller']->state; ?>
, <?php endif; ?>
                    <?php if ($this->_tpl_vars['user']->bidder_seller_city == 'on'):  echo $this->_tpl_vars['seller']->country; ?>
.<?php endif; ?>
                </td>
            </tr>
        <?php endif; ?>
        
        <tr>        
            <?php if ($this->_tpl_vars['item']->processed == 'yes' && ! $this->_tpl_vars['no_winner']): ?>
                <th>Winner</th>
                <td><?php echo $this->_tpl_vars['winning_user']->fullname; ?>
</td>
            <?php elseif ($this->_tpl_vars['no_winner']): ?>
                <th>Winner</th>
                <td><?php echo $this->_tpl_vars['no_winner']; ?>
</td>
            <?php else: ?>
                <?php if ($this->_tpl_vars['item']->winning): ?>
                    <td colspan="2">You are winning this item!</td>
                <?php endif; ?>
            <?php endif; ?>
        </tr>
        
        <?php if ($this->_tpl_vars['BIDDER_ITEM_IMAGE'] == 'on'): ?>
            <tr>
                <td><a href="<?php echo $this->_tpl_vars['item']->image; ?>
">Larger picture</a></td>
            </tr>
        <?php endif; ?>
        </table>

        <?php if ($this->_tpl_vars['BIDDER_ITEM_DESCRIPTION'] == 'on'): ?>
            <hr />
            <h2 style="background-color:#DDDDFF">Description</h2>
            <?php echo $this->_tpl_vars['item']->description; ?>

        <?php endif; ?>
        </form>
		
				<hr />
        <h2 style="background-color:#DDDDFF">Bidding History</h2>

				<?php if ($this->_tpl_vars['bid_history']): ?>
		<ol>
		<?php if (count($_from = (array)$this->_tpl_vars['bid_history'])):
    foreach ($_from as $this->_tpl_vars['specific_bid']):
?>
			<li><a href="bidder.php?categoryID=<?php echo $this->_tpl_vars['category']->ID; ?>
&itemID=<?php echo $this->_tpl_vars['item']->ID; ?>
&userID=<?php echo $this->_tpl_vars['specific_bid']['bid']->userID; ?>
"><?php echo $this->_tpl_vars['specific_bid']['user']->fullname; ?>
</a>
			bid on <?php echo ((is_array($_tmp=$this->_tpl_vars['specific_bid']['bid']->datesubmitted)) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)); ?>
</li>
		<?php endforeach; unset($_from); endif; ?>
		</ol>
		<?php endif; ?>
		
				<?php if ($this->_tpl_vars['bid_history_error']): ?>
			<ul>
			<li><?php echo $this->_tpl_vars['bid_history_error']; ?>
</li>
			</ul>
		<?php endif; ?>
    <?php endif; ?>
    </div><!-- end contents -->
    	
    </div><!-- end leftstatic -->	
</div><!-- end pagebody -->
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "auction_footer_inner.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</body>
</html>