<?php /* Smarty version 2.6.6, created on 2010-03-09 12:35:38
         compiled from auction_placebid.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('block', 'curr', 'auction_placebid.tpl', 34, false),)), $this); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "auction_header_inner.tpl", 'smarty_include_vars' => array('title' => ($this->_tpl_vars['COMPANY_NAME'])." :: Silent Auction -- Place a Bid")));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "auction_menu.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div id="pagebody" class="wide">
	<div id="grayborder">
	</div>
	<div id="leftstatic">
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "auction_sidebar.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	<div id="contents" class="wide">
		<span id="loggedin" >		
			<?php if ($this->_tpl_vars['authorised'] == 'valid'): ?>
				You are logged in as <?php echo $this->_tpl_vars['user']->fullname; ?>

			<?php else: ?>	
				You are not <a href="login.php">logged in</a>	
			<?php endif; ?>
		</span>
		<h1>Placing a Bid</h1>
		<p id="breadcrumb"><a href="index.php">Silent Auction</a> :: 
			<a href="categories.php?categoryID=<?php echo $this->_tpl_vars['category']->ID; ?>
"><?php echo $this->_tpl_vars['category']->name; ?>
</a> ::
			<a href="items.php?itemID=<?php echo $this->_tpl_vars['item']->ID; ?>
"><?php echo $this->_tpl_vars['item']->name; ?>
</a></p>
			
		<?php if (( $this->_tpl_vars['authorised'] == 'valid' ) && ( $this->_tpl_vars['submitted'] == FALSE ) && ( $this->_tpl_vars['itemokay'] == true )): ?>
		
			<p>Please review and confirm your bid.</p>
			
			<p id="message"><?php echo $this->_tpl_vars['message']; ?>
</p>
			
			<form name="placebid" method="post" action="placebid.php">
			<input type="hidden" name="itemID" value="<?php echo $this->_tpl_vars['item']->ID; ?>
" />
			<!-- <input type="hidden" name="debug" value="1" /> -->
			<input type="hidden" name="formdata" value="bid" />
			<table>
				<tr><th width="120px">Current price</th><td><?php $this->_tag_stack[] = array('curr', array()); smarty_block_curr($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start();  echo $this->_tpl_vars['item']->getCurrentPrice();  $this->_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_curr($this->_tag_stack[count($this->_tag_stack)-1][1], $this->_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></td></tr>
				<tr><th width="120px">Your bid</th><td><b><?php $this->_tag_stack[] = array('curr', array()); smarty_block_curr($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start();  echo $this->_tpl_vars['bidamount'];  $this->_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_curr($this->_tag_stack[count($this->_tag_stack)-1][1], $this->_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></b></td></tr>
				<tr>
					<td colspan="2">
						By clicking on the button below, you commit to buy this item from <?php echo $this->_tpl_vars['COMPANY_NAME']; ?>
 if you're the winning bidder.<br /><br />
						To leave this page without placing a bid, return to the <a href="items.php?itemID=<?php echo $this->_tpl_vars['item']->ID; ?>
"><?php echo $this->_tpl_vars['item']->name; ?>
</a> item listing page or navigate to another page on the site.<br /><br />
						<input type="submit" value="Confirm Bid" />
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<b>You are agreeing to a contract</b> -- You will enter into a legally binding contract 
						to purchase the item from <?php echo $this->_tpl_vars['COMPANY_NAME']; ?>
 if you're the winning bidder. 
						You are responsible for reading the full item listing, including Operation USA's 
						instructions and accepted payment methods. <?php echo $this->_tpl_vars['COMPANY_NAME']; ?>
 assumes all responsibility 
						for listing this item.
					</td>
				</tr>
			</table>
		<?php elseif ($this->_tpl_vars['submitted'] == TRUE): ?>
			<p id="message"><?php echo $this->_tpl_vars['message']; ?>
</p>
			<p>Please do NOT refresh this page, or your bid will be duplicated.</p>
			<p>You are welcome to continue browsing and bidding. 
				We also invite to <a href="submititem.php">contribute</a> your own items for auction.</p>
		<?php elseif ($this->_tpl_vars['itemokay'] == false): ?>
			<p id="message">You cannot place a bid on an item you are selling!</p>
		<?php elseif ($this->_tpl_vars['authorised'] != true): ?>
			<p id="message">You cannot place a bid unless you are <a href="loging.php">logged in</a>.</p>
		<?php endif; ?>					
	</div><!-- end contents -->
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "auction_footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>	
	</div><!-- end leftstatic -->
</div><!-- end pagebody -->
</body>
</html>