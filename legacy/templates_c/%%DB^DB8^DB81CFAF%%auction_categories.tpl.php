<?php /* Smarty version 2.6.6, created on 2010-03-09 12:04:26
         compiled from auction_categories.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', 'auction_categories.tpl', 34, false),array('block', 'curr', 'auction_categories.tpl', 37, false),array('block', 'timeleft', 'auction_categories.tpl', 39, false),)), $this); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "auction_header_inner.tpl", 'smarty_include_vars' => array('title' => ($this->_tpl_vars['COMPANY_NAME'])." :: Silent Auction -- Category")));
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

<h1 id="auctionheader" title="<?php echo $this->_tpl_vars['COMPANY_NAME']; ?>
 Silent Auction">
					<span></span>
				</h1>

		<h2>Item Listing</h2>
		<p id="breadcrumb"><a href="index.php">Silent Auction</a>
			<?php if ($this->_tpl_vars['category']->ID != 0): ?> :: <a href="categories.php?categoryID=0">All items</a><?php endif; ?>
			:: <?php echo $this->_tpl_vars['category']->name; ?>
</p>
		
		<p>Items found in <i><?php echo $this->_tpl_vars['category']->name; ?>
</i>: <?php echo $this->_tpl_vars['numberOfItems']; ?>
</p>
		<table>
			<tr>
				<th>Thumbnail</th><th>Item Name</th><th>Price</th><th>Bids</th><th>Time left</th>
			</tr>
			<?php if ($this->_tpl_vars['items']): ?>
				<?php if (count($_from = (array)$this->_tpl_vars['items'])):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['v']):
?>
					<tr style="background-color:<?php echo smarty_function_cycle(array('values' => "#eeeeee,#d0d0d0"), $this);?>
">
						<td><img alt="Picture of <?php echo $this->_tpl_vars['v']->name; ?>
" height="50px" width="50px" src="<?php echo $this->_tpl_vars['v']->image; ?>
" /></td>
						<td><a href="items.php?itemID=<?php echo $this->_tpl_vars['v']->ID; ?>
"><?php echo $this->_tpl_vars['v']->name; ?>
</a></td>
						<td><?php $this->_tag_stack[] = array('curr', array()); smarty_block_curr($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start();  echo $this->_tpl_vars['v']->getCurrentPrice();  $this->_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_curr($this->_tag_stack[count($this->_tag_stack)-1][1], $this->_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></td>
						<td><?php echo $this->_tpl_vars['v']->getNumberOfBids(); ?>
</td>
						<td><?php $this->_tag_stack[] = array('timeleft', array()); smarty_block_timeleft($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start();  echo $this->_tpl_vars['v']->getSecondsLeft();  $this->_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_timeleft($this->_tag_stack[count($this->_tag_stack)-1][1], $this->_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></td>
					</tr>
				<?php endforeach; unset($_from); endif; ?>
			<?php endif; ?>
			<?php if ($this->_tpl_vars['items_error']): ?>
				<tr style="background-color:#eeeeee">
					<td colspan="5"><p><?php echo $this->_tpl_vars['items_error']; ?>
</p></td>
				</tr>
			<?php endif; ?>
		</table>						
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